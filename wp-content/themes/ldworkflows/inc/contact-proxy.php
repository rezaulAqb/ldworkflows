<?php
/**
 * Contact form proxy.
 *
 * The enquiry form lives in the CRM on another domain. Embedding it in an
 * iframe renders correctly but can never submit: the CRM's CSRF cookie is
 * SameSite=Lax, so the browser refuses to store or send it from a
 * cross-site frame and Django rejects every POST. (Verified: the cookie is
 * dropped with reason SchemefulSameSiteLax inside a frame, and stored
 * normally when the form is opened directly.)
 *
 * So the form is fetched server-side and rendered inline instead. The CSRF
 * cookie never reaches the browser — WordPress keeps it in a transient and
 * replays it when forwarding the submission — which makes the exchange
 * same-origin from the visitor's point of view and sidesteps SameSite
 * entirely.
 *
 * Only ever talks to the single URL configured in Theme Content, so this
 * is not a general-purpose open proxy.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const LDW_CONTACT_TRANSIENT = 'ldw_contact_csrf_';

/**
 * The configured form URL, or '' when unset or not https.
 */
function ldw_contact_form_url() {
	$url = trim( (string) get_field( 'contact_embed_url', 'option' ) );
	return preg_match( '#^https://#i', $url ) ? $url : '';
}

/**
 * GET the form and keep its CSRF cookie.
 *
 * @return array|WP_Error array{html:string,csrf:string}
 */
function ldw_contact_fetch( $url ) {
	$res = wp_remote_get(
		$url,
		array(
			'timeout'     => 20,
			'redirection' => 3,
			'headers'     => array( 'Accept' => 'text/html' ),
		)
	);

	if ( is_wp_error( $res ) ) {
		return $res;
	}
	if ( 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
		return new WP_Error( 'ldw_contact_http', 'The form could not be loaded.' );
	}

	$csrf = '';
	foreach ( wp_remote_retrieve_cookies( $res ) as $cookie ) {
		if ( 'csrftoken' === $cookie->name ) {
			$csrf = $cookie->value;
		}
	}

	return array(
		'html' => wp_remote_retrieve_body( $res ),
		'csrf' => $csrf,
	);
}

/**
 * Forward a submission, replaying the CSRF cookie we were issued.
 *
 * Django's HTTPS CSRF check also compares Referer/Origin against its own
 * host, so both are set to the form's own origin rather than this site's.
 *
 * @return array|WP_Error array{html:string,csrf:string}
 */
function ldw_contact_submit( $url, $csrf, $fields ) {
	$origin = wp_parse_url( $url, PHP_URL_SCHEME ) . '://' . wp_parse_url( $url, PHP_URL_HOST );

	$res = wp_remote_post(
		$url,
		array(
			'timeout'     => 25,
			'redirection' => 0,
			'headers'     => array(
				'Cookie'       => 'csrftoken=' . $csrf,
				'Referer'      => $url,
				'Origin'       => $origin,
				'Content-Type' => 'application/x-www-form-urlencoded',
				'Accept'       => 'text/html',
			),
			'body'        => $fields,
		)
	);

	if ( is_wp_error( $res ) ) {
		return $res;
	}

	$code = (int) wp_remote_retrieve_response_code( $res );

	// A redirect after POST is the success path; follow it for the
	// thank-you page so the visitor sees the CRM's own confirmation.
	if ( in_array( $code, array( 301, 302, 303, 307, 308 ), true ) ) {
		$location = wp_remote_retrieve_header( $res, 'location' );
		if ( $location ) {
			$next = ldw_contact_fetch( ldw_contact_absolute( $location, $url ) );
			if ( ! is_wp_error( $next ) ) {
				return $next;
			}
		}
	}

	return array(
		'html' => wp_remote_retrieve_body( $res ),
		'csrf' => $csrf,
	);
}

/**
 * Resolve a possibly-relative URL against the form's URL.
 */
function ldw_contact_absolute( $maybe_relative, $base ) {
	$maybe_relative = trim( (string) $maybe_relative );

	if ( '' === $maybe_relative || preg_match( '#^(https?:)?//#i', $maybe_relative ) ) {
		return $maybe_relative;
	}
	if ( preg_match( '#^(data:|mailto:|tel:|javascript:|\#)#i', $maybe_relative ) ) {
		return $maybe_relative;
	}

	$parts  = wp_parse_url( $base );
	$origin = $parts['scheme'] . '://' . $parts['host'];

	if ( 0 === strpos( $maybe_relative, '/' ) ) {
		return $origin . $maybe_relative;
	}

	$dir = rtrim( dirname( isset( $parts['path'] ) ? $parts['path'] : '/' ), '/' );
	return $origin . $dir . '/' . $maybe_relative;
}

/**
 * Reduce the fetched page to the part worth showing: its own masthead and
 * footer come off (this site supplies those), as do its scripts — one of
 * which is the CRM's Google Analytics, which has no business running on
 * this domain. The behaviour worth keeping from the other is
 * reimplemented in the template part.
 *
 * @return string Inner HTML of .ldcf-page, or '' if the shape is unfamiliar.
 */
function ldw_contact_fragment( $html, $url, $action ) {
	if ( ! class_exists( 'DOMDocument' ) || '' === trim( $html ) ) {
		return '';
	}

	$doc = new DOMDocument();
	$prev = libxml_use_internal_errors( true );
	$doc->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );

	$xpath = new DOMXPath( $doc );

	$drop = $xpath->query(
		"//header[contains(concat(' ',normalize-space(@class),' '),' ldcf-masthead ')]"
		. " | //footer[contains(concat(' ',normalize-space(@class),' '),' ldcf-footer ')]"
		. ' | //script | //noscript'
	);
	foreach ( $drop as $node ) {
		$node->parentNode->removeChild( $node );
	}

	foreach ( array( 'src', 'href', 'action', 'poster' ) as $attr ) {
		foreach ( $xpath->query( '//*[@' . $attr . ']' ) as $node ) {
			$node->setAttribute( $attr, ldw_contact_absolute( $node->getAttribute( $attr ), $url ) );
		}
	}

	// Point the form back here so WordPress can forward it.
	$form = $xpath->query( '//form' )->item( 0 );
	if ( $form ) {
		$form->setAttribute( 'action', $action );
		$form->setAttribute( 'method', 'post' );
		$form->removeAttribute( 'enctype' ); // no file inputs; urlencoded forwards cleanly
	}

	$page = $xpath->query( "//*[contains(concat(' ',normalize-space(@class),' '),' ldcf-page ')]" )->item( 0 );
	if ( ! $page ) {
		return '';
	}

	$out = '';
	foreach ( $page->childNodes as $child ) {
		$out .= $doc->saveHTML( $child );
	}

	return $out;
}

/**
 * Build what the Contact page should render this request: the blank form,
 * or the CRM's response to a submission.
 *
 * @return array{fragment:string,error:string}
 */
function ldw_contact_state() {
	static $state = null;
	if ( null !== $state ) {
		return $state;
	}

	$state = array(
		'fragment' => '',
		'error'    => '',
	);

	$url = ldw_contact_form_url();
	if ( ! $url ) {
		return $state;
	}

	$action = get_permalink();

	// A submission coming back through this page.
	if ( 'POST' === ( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : '' )
		&& isset( $_POST['ldw_contact_key'] ) ) {

		$key  = sanitize_key( wp_unslash( $_POST['ldw_contact_key'] ) );
		$csrf = get_transient( LDW_CONTACT_TRANSIENT . $key );

		if ( ! $csrf ) {
			$state['error'] = 'That form had been open too long. It has been reloaded — please send your message again.';
		} else {
			$fields = array();
			foreach ( $_POST as $name => $value ) {
				if ( 'ldw_contact_key' === $name || is_array( $value ) ) {
					continue;
				}
				$fields[ sanitize_text_field( $name ) ] = wp_unslash( $value );
			}

			$sent = ldw_contact_submit( $url, $csrf, $fields );
			if ( is_wp_error( $sent ) ) {
				$state['error'] = 'The message could not be sent just now. Please try again shortly.';
			} else {
				delete_transient( LDW_CONTACT_TRANSIENT . $key );
				$state['fragment'] = ldw_contact_fragment( $sent['html'], $url, $action );
				if ( $state['fragment'] ) {
					$state['fragment'] = ldw_contact_rekey( $state['fragment'], $sent['csrf'] );
					return $state;
				}
			}
		}
	}

	$got = ldw_contact_fetch( $url );
	if ( is_wp_error( $got ) ) {
		$state['error'] = $state['error'] ? $state['error'] : 'The form could not be loaded just now.';
		return $state;
	}

	$state['fragment'] = ldw_contact_rekey(
		ldw_contact_fragment( $got['html'], $url, $action ),
		$got['csrf']
	);

	return $state;
}

/**
 * Stash this render's CSRF cookie server-side and drop its lookup key into
 * the form, so the cookie value itself never travels to the browser.
 */
function ldw_contact_rekey( $fragment, $csrf ) {
	if ( ! $fragment || ! $csrf ) {
		return $fragment;
	}

	$key = wp_generate_password( 20, false, false );
	set_transient( LDW_CONTACT_TRANSIENT . $key, $csrf, HOUR_IN_SECONDS );

	$hidden = '<input type="hidden" name="ldw_contact_key" value="' . esc_attr( $key ) . '">';

	// After the opening <form ...> tag.
	return preg_replace( '#(<form\b[^>]*>)#i', '$1' . $hidden, $fragment, 1 );
}
