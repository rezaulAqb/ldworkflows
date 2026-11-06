<?php
/**
 * Per-page SEO: the tags printed into <head>, and the admin screens that
 * fill them.
 *
 * Every section's copy already lives in ACF, so its search and social
 * metadata lives there too rather than in an SEO plugin: one less
 * dependency to install on the server, and the fields sit on the page
 * being edited instead of in a separate tool.
 *
 * The data sits in two places, because the site has two kinds of "page":
 *
 *  - Pages and posts carry their own fields, in an "SEO" box under the
 *    editor. This is where the per-page title and description go, and
 *    every page needs its own.
 *  - The home page is rendered by front-page.php with no page behind it
 *    (show_on_front is "posts"), so there is no post to attach fields
 *    to. Its metadata, and the fallbacks the whole site shares, live on
 *    Theme Content > SEO.
 *
 * Nothing here invents copy. A description left blank falls back to the
 * site-wide default and then to the tagline; it is never scraped out of
 * the page body, which on these ACF-built pages is empty anyway. That
 * keeps a forgotten field visible as a repeated description rather than
 * hidden behind a machine-written one.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Reading the values
 * ---------------------------------------------------------------------- */

/**
 * A field from Theme Content > SEO. Safe before ACF loads, so the head
 * still renders on a site where the plugin is missing.
 */
function ldw_seo_option( $name ) {
	return function_exists( 'get_field' ) ? get_field( $name, 'option' ) : '';
}

/**
 * A field from one page or post.
 */
function ldw_seo_post_field( $name, $post_id ) {
	if ( ! $post_id || ! function_exists( 'get_field' ) ) {
		return '';
	}
	return get_field( $name, $post_id );
}

/**
 * Normalise whatever an image field holds into url/width/height/alt.
 * Accepts the ACF array format and a bare attachment ID, so the same
 * helper handles the SEO fields and a page's featured image.
 */
function ldw_seo_image( $value ) {
	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return array(
			'url'    => $value['url'],
			'width'  => isset( $value['width'] ) ? (int) $value['width'] : 0,
			'height' => isset( $value['height'] ) ? (int) $value['height'] : 0,
			'alt'    => isset( $value['alt'] ) ? (string) $value['alt'] : '',
		);
	}

	if ( is_numeric( $value ) ) {
		$src = wp_get_attachment_image_src( (int) $value, 'full' );
		if ( $src ) {
			return array(
				'url'    => $src[0],
				'width'  => (int) $src[1],
				'height' => (int) $src[2],
				'alt'    => (string) get_post_meta( (int) $value, '_wp_attachment_image_alt', true ),
			);
		}
	}

	return null;
}

/**
 * Everything this request should output, resolved once.
 *
 * Cached in a static because wp_head, the title filter and the robots
 * filter all ask for it within the same request, and each ACF read is a
 * database hit.
 */
function ldw_seo_context() {
	static $ctx = null;

	if ( null !== $ctx ) {
		return $ctx;
	}

	$is_front = is_front_page();
	$post_id  = ( ! $is_front && is_singular() ) ? get_queried_object_id() : 0;

	if ( $is_front ) {
		$title = ldw_seo_option( 'seo_home_title' );
		$desc  = ldw_seo_option( 'seo_home_description' );
		$keys  = ldw_seo_option( 'seo_home_keywords' );
		$image = ldw_seo_image( ldw_seo_option( 'seo_home_og_image' ) );
	} else {
		$title = ldw_seo_post_field( 'seo_title', $post_id );
		$desc  = ldw_seo_post_field( 'seo_description', $post_id );
		$keys  = ldw_seo_post_field( 'seo_keywords', $post_id );
		$image = ldw_seo_image( ldw_seo_post_field( 'seo_og_image', $post_id ) );
	}

	// Description: the page's own, then a blog post's excerpt, then the
	// site default, then the tagline.
	if ( ! $desc && $post_id && has_excerpt( $post_id ) ) {
		$desc = get_the_excerpt( $post_id );
	}
	if ( ! $desc ) {
		$desc = ldw_seo_option( 'seo_default_description' );
	}
	if ( ! $desc ) {
		$desc = get_bloginfo( 'description', 'display' );
	}

	// Share image: the page's own, then its featured image, then the
	// site default.
	if ( ! $image && $post_id && has_post_thumbnail( $post_id ) ) {
		$image = ldw_seo_image( get_post_thumbnail_id( $post_id ) );
	}
	if ( ! $image ) {
		$image = ldw_seo_image( ldw_seo_option( 'seo_default_og_image' ) );
	}

	$ctx = array(
		'is_front'  => $is_front,
		'title'     => is_string( $title ) ? trim( $title ) : '',
		'desc'      => $desc ? trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $desc ) ) ) : '',
		'keywords'  => is_string( $keys ) ? trim( $keys ) : '',
		'image'     => $image,
		'canonical' => $post_id ? (string) ldw_seo_post_field( 'seo_canonical', $post_id ) : '',
		'noindex'   => $post_id ? (bool) ldw_seo_post_field( 'seo_noindex', $post_id ) : false,
		'url'       => $is_front ? home_url( '/' ) : ( $post_id ? get_permalink( $post_id ) : '' ),
		'type'      => ( $post_id && 'post' === get_post_type( $post_id ) ) ? 'article' : 'website',
	);

	return $ctx;
}

/* -------------------------------------------------------------------------
 * Output
 * ---------------------------------------------------------------------- */

/**
 * Replace the generated <title> when the page sets its own. An SEO title
 * is written whole, including any brand suffix, so it is returned as
 * typed rather than run through the separator logic.
 */
function ldw_seo_document_title( $title ) {
	if ( is_admin() || is_feed() ) {
		return $title;
	}

	$ctx = ldw_seo_context();

	return $ctx['title'] ? $ctx['title'] : $title;
}
add_filter( 'pre_get_document_title', 'ldw_seo_document_title' );

/**
 * Honour the per-page noindex toggle. "follow" is left alone: hiding a
 * page from results is not a reason to stop crawling the links on it.
 */
function ldw_seo_robots( $robots ) {
	if ( is_admin() ) {
		return $robots;
	}

	$ctx = ldw_seo_context();

	if ( $ctx['noindex'] ) {
		$robots['noindex'] = true;
		unset( $robots['max-image-preview'], $robots['max-snippet'], $robots['max-video-preview'] );
	}

	return $robots;
}
add_filter( 'wp_robots', 'ldw_seo_robots' );

/**
 * The tags themselves. Priority 1 so they sit at the top of <head>, and
 * so the canonical override lands before core's rel_canonical runs at 10.
 */
function ldw_seo_meta_tags() {
	if ( is_admin() || is_feed() ) {
		return;
	}

	$ctx   = ldw_seo_context();
	$lines = array();

	if ( $ctx['desc'] ) {
		$lines[] = sprintf( '<meta name="description" content="%s">', esc_attr( $ctx['desc'] ) );
	}
	if ( $ctx['keywords'] ) {
		$lines[] = sprintf( '<meta name="keywords" content="%s">', esc_attr( $ctx['keywords'] ) );
	}

	// Search Console verifies the home page, so the tag only goes there.
	$verify = $ctx['is_front'] ? ldw_seo_option( 'seo_google_verification' ) : '';
	if ( $verify ) {
		$lines[] = sprintf( '<meta name="google-site-verification" content="%s">', esc_attr( $verify ) );
	}

	if ( $ctx['canonical'] ) {
		remove_action( 'wp_head', 'rel_canonical' );
		$lines[] = sprintf( '<link rel="canonical" href="%s">', esc_url( $ctx['canonical'] ) );
	}

	// Open Graph and Twitter share the title and description, so the
	// document title is resolved once and reused.
	$share_title = $ctx['title'] ? $ctx['title'] : wp_get_document_title();

	$lines[] = sprintf( '<meta property="og:type" content="%s">', esc_attr( $ctx['type'] ) );
	$lines[] = sprintf( '<meta property="og:site_name" content="%s">', esc_attr( get_bloginfo( 'name' ) ) );
	$lines[] = sprintf( '<meta property="og:title" content="%s">', esc_attr( $share_title ) );
	if ( $ctx['desc'] ) {
		$lines[] = sprintf( '<meta property="og:description" content="%s">', esc_attr( $ctx['desc'] ) );
	}
	if ( $ctx['url'] ) {
		$lines[] = sprintf( '<meta property="og:url" content="%s">', esc_url( $ctx['url'] ) );
	}
	if ( $ctx['image'] ) {
		$lines[] = sprintf( '<meta property="og:image" content="%s">', esc_url( $ctx['image']['url'] ) );
		if ( $ctx['image']['width'] && $ctx['image']['height'] ) {
			$lines[] = sprintf( '<meta property="og:image:width" content="%d">', $ctx['image']['width'] );
			$lines[] = sprintf( '<meta property="og:image:height" content="%d">', $ctx['image']['height'] );
		}
		if ( $ctx['image']['alt'] ) {
			$lines[] = sprintf( '<meta property="og:image:alt" content="%s">', esc_attr( $ctx['image']['alt'] ) );
		}
	}

	$lines[] = sprintf( '<meta name="twitter:card" content="%s">', $ctx['image'] ? 'summary_large_image' : 'summary' );
	$handle  = ldw_seo_option( 'seo_twitter_site' );
	if ( $handle ) {
		$lines[] = sprintf( '<meta name="twitter:site" content="%s">', esc_attr( '@' . ltrim( (string) $handle, '@' ) ) );
	}
	$lines[] = sprintf( '<meta name="twitter:title" content="%s">', esc_attr( $share_title ) );
	if ( $ctx['desc'] ) {
		$lines[] = sprintf( '<meta name="twitter:description" content="%s">', esc_attr( $ctx['desc'] ) );
	}
	if ( $ctx['image'] ) {
		$lines[] = sprintf( '<meta name="twitter:image" content="%s">', esc_url( $ctx['image']['url'] ) );
	}

	echo "\n<!-- LD Workflows SEO -->\n" . implode( "\n", $lines ) . "\n<!-- /LD Workflows SEO -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- every value escaped above.
}
add_action( 'wp_head', 'ldw_seo_meta_tags', 1 );

/* -------------------------------------------------------------------------
 * Admin
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return; // ACF not active: the head above still renders, with no fields to read.
}

/**
 * Theme Content > SEO. Priority 11 so the "Theme Content" parent that
 * inc/acf-fields.php registers at the default priority already exists.
 */
add_action(
	'admin_menu',
	function () {
		$hook = add_submenu_page(
			'theme-content',
			'SEO',
			'SEO',
			'edit_posts',
			'theme-content-seo',
			'ldw_render_seo_page'
		);

		if ( $hook ) {
			add_action( "load-{$hook}", 'acf_form_head' );
		}
	},
	11
);

function ldw_render_seo_page() {
	?>
	<div class="wrap">
		<h1>SEO</h1>
		<p>
			The home page's own tags, plus the fallbacks every other page uses.
			Each page and post sets its own title and description in its editor,
			in the <strong>SEO</strong> box below the content &mdash; start at
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">Pages</a>,
			where the SEO column shows which ones are still blank.
		</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_seo_global' ),
				'submit_value'    => 'Save',
				'updated_message' => 'SEO settings updated.',
			)
		);
		?>
	</div>
	<?php
}

add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_seo_global',
				'title'    => 'SEO',
				'fields'   => array(
					array(
						'key'          => 'field_seo_home_title',
						'label'        => 'Home page title',
						'name'         => 'seo_home_title',
						'type'         => 'text',
						'instructions' => 'The browser tab and search result heading for the home page. Write it whole, including any "&ndash; LD Workflows" ending. Around 60 characters shows in full. Leave blank to use the site name.',
					),
					array(
						'key'          => 'field_seo_home_description',
						'label'        => 'Home page description',
						'name'         => 'seo_home_description',
						'type'         => 'textarea',
						'rows'         => 3,
						'instructions' => 'The grey text under the search result. Around 155 characters shows in full.',
					),
					array(
						'key'          => 'field_seo_home_keywords',
						'label'        => 'Home page keywords',
						'name'         => 'seo_home_keywords',
						'type'         => 'text',
						'instructions' => 'Comma separated. Google ignores this tag; it is here for other crawlers and internal search. Safe to leave blank.',
					),
					array(
						'key'           => 'field_seo_home_og_image',
						'label'         => 'Home page share image',
						'name'          => 'seo_home_og_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown when the home page is posted to LinkedIn, Facebook, X or WhatsApp. 1200&times;630 pixels works everywhere.',
					),
					array(
						'key'          => 'field_seo_default_description',
						'label'        => 'Fallback description',
						'name'         => 'seo_default_description',
						'type'         => 'textarea',
						'rows'         => 2,
						'instructions' => 'Used on any page whose own description is blank. A page with its own description always wins. If this is blank too, the site tagline is used.',
					),
					array(
						'key'           => 'field_seo_default_og_image',
						'label'         => 'Fallback share image',
						'name'          => 'seo_default_og_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Used on any page with no share image and no featured image of its own.',
					),
					array(
						'key'          => 'field_seo_twitter_site',
						'label'        => 'X / Twitter handle',
						'name'         => 'seo_twitter_site',
						'type'         => 'text',
						'instructions' => 'Without the @. Credits the account on shared links.',
					),
					array(
						'key'          => 'field_seo_google_verification',
						'label'        => 'Google Search Console verification code',
						'name'         => 'seo_google_verification',
						'type'         => 'text',
						'instructions' => 'The content value from the HTML tag Search Console gives you, not the whole tag. Added to the home page only, which is what Google checks.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-seo',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_seo_page',
				'title'                 => 'SEO',
				'fields'                => array(
					array(
						'key'          => 'field_seo_title',
						'label'        => 'Search title',
						'name'         => 'seo_title',
						'type'         => 'text',
						'instructions' => 'The browser tab and search result heading. Write it whole, including any "&ndash; LD Workflows" ending. Around 60 characters shows in full. Leave blank to use the page title.',
					),
					array(
						'key'          => 'field_seo_description',
						'label'        => 'Search description',
						'name'         => 'seo_description',
						'type'         => 'textarea',
						'rows'         => 3,
						'instructions' => 'The grey text under the search result, and the preview text on shared links. Around 155 characters shows in full. Leave blank to fall back to the site-wide description under Theme Content &rsaquo; SEO.',
					),
					array(
						'key'          => 'field_seo_keywords',
						'label'        => 'Keywords',
						'name'         => 'seo_keywords',
						'type'         => 'text',
						'instructions' => 'Comma separated. Google ignores this tag. Safe to leave blank.',
					),
					array(
						'key'           => 'field_seo_og_image',
						'label'         => 'Share image',
						'name'          => 'seo_og_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown when this page is posted to LinkedIn, Facebook, X or WhatsApp. 1200&times;630 pixels works everywhere. Falls back to the featured image, then to the site-wide one.',
					),
					array(
						'key'          => 'field_seo_canonical',
						'label'        => 'Canonical URL',
						'name'         => 'seo_canonical',
						'type'         => 'url',
						'instructions' => 'Only needed when this page duplicates another one and should not compete with it in search. Leave blank and the page points at itself, which is what you want nearly always.',
					),
					array(
						'key'           => 'field_seo_noindex',
						'label'         => 'Hide from search engines',
						'name'          => 'seo_noindex',
						'type'          => 'true_false',
						'ui'            => 1,
						'instructions'  => 'Adds noindex, so the page stays reachable by link but drops out of search results. Links on it are still followed.',
						'default_value' => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'page',
						),
					),
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'post',
						),
					),
				),
				'menu_order'            => 20,
				'position'              => 'normal',
				'hide_on_screen'        => array(),
				'description'           => 'How this page appears in search results and on shared links.',
			)
		);
	}
);

/* -------------------------------------------------------------------------
 * "SEO" column on the Pages and Posts lists
 *
 * Per-page metadata is only useful once every page actually has some, and
 * a list of 15 pages gives no way to tell which were missed. This turns
 * that into one glance.
 * ---------------------------------------------------------------------- */

function ldw_seo_add_list_column( $columns ) {
	$date = isset( $columns['date'] ) ? $columns['date'] : null;
	unset( $columns['date'] );

	$columns['ldw_seo'] = 'SEO';

	if ( null !== $date ) {
		$columns['date'] = $date;
	}

	return $columns;
}
add_filter( 'manage_pages_columns', 'ldw_seo_add_list_column' );
add_filter( 'manage_posts_columns', 'ldw_seo_add_list_column' );

function ldw_seo_render_list_column( $column, $post_id ) {
	if ( 'ldw_seo' !== $column ) {
		return;
	}

	$has_title = (bool) ldw_seo_post_field( 'seo_title', $post_id );
	$has_desc  = (bool) ldw_seo_post_field( 'seo_description', $post_id );

	if ( $has_title && $has_desc ) {
		$mark  = '&#10003;';
		$text  = 'Set';
		$color = '#1a7f5a';
	} elseif ( $has_title || $has_desc ) {
		$mark  = '&#9679;';
		$text  = $has_title ? 'No description' : 'No title';
		$color = '#b26a00';
	} else {
		$mark  = '&ndash;';
		$text  = 'Not set';
		$color = '#b32d2e';
	}

	printf(
		'<span style="color:%s" title="%s">%s <span class="screen-reader-text">%s</span></span>',
		esc_attr( $color ),
		esc_attr( $text ),
		$mark, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literal entity.
		esc_html( $text )
	);
}
add_action( 'manage_pages_custom_column', 'ldw_seo_render_list_column', 10, 2 );
add_action( 'manage_posts_custom_column', 'ldw_seo_render_list_column', 10, 2 );

/* -------------------------------------------------------------------------
 * One-time seed
 *
 * Follows the pattern in inc/seed-content.php: its own flag, so it runs
 * once on a fresh install and never fights an editor afterwards. Each
 * field is only filled when it is currently empty, so re-running this
 * (or activating the theme again) cannot overwrite hand-written copy.
 *
 * The descriptions are drawn from each page's own hero and lead
 * paragraph rather than written fresh, so what search results promise
 * is what the page actually says.
 * ---------------------------------------------------------------------- */

function ldw_seed_seo() {
	if ( get_option( 'ldw_seo_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$globals = array(
		'seo_home_title'          => 'ERP, CRM, Inventory & MTD VAT in One Platform | LD Workflows',
		'seo_home_description'    => 'One platform for UK merchants: sales, warehouse, logistics and finance connected end to end, from a Shopify order to the VAT return, with no re-keying.',
		'seo_default_description' => 'Full ERP, accounting, inventory, CRM and MTD VAT filing on one platform, built for UK merchants. Live in days, not months.',
	);

	foreach ( $globals as $name => $value ) {
		if ( ! get_field( $name, 'option' ) ) {
			update_field( $name, $value, 'option' );
		}
	}

	$pages = array(
		'crm'              => array(
			'CRM Software for UK Businesses | LD Workflows',
			'Turn contacts into loyal customers. Leads, opportunities, quotes and follow-ups in one place, connected to your stock, orders and accounts.',
		),
		'erp'              => array(
			'ERP Software: One Connected Platform | LD Workflows',
			'Sales, warehouse, logistics and finance connected end to end. One system, no connectors, and nothing to reconcile between separate tools at month end.',
		),
		'service'          => array(
			'Field Service Management Software | LD Workflows',
			'Scheduling, stock, quotes and team comms for engineers on the road, all running on the same platform as your CRM, inventory and accounts.',
		),
		'warehouse'        => array(
			'Warehouse & Inventory Management | LD Workflows',
			'Goods in, put-away, picking and despatch run against live stock, with no separate warehouse system to reconcile against your accounts at month end.',
		),
		'ecommerce'        => array(
			'Shopify & WooCommerce ERP Integration | LD Workflows',
			'Native Shopify and WooCommerce sync. One order moves through the whole business on its own: nobody re-keys it, nobody reconciles it at quarter end.',
		),
		'ai-integration'   => array(
			'AI That Already Knows Your Business | LD Workflows',
			'Gemini-assisted insight running on the same platform as your CRM, orders, stock and finance, so it answers from live data rather than last month\'s export.',
		),
		'order-to-cash'    => array(
			'Order to Cash: Quote to Payment | LD Workflows',
			'From quote to cash on one platform. Raise an order once against stock you actually have, then follow it through fulfilment to the receivables ledger.',
		),
		'procure-to-pay'   => array(
			'Procure to Pay: PO to Payment | LD Workflows',
			'Buying, goods in and the purchase ledger on one system, so what you ordered, what arrived and what you owe always agree.',
		),
		'reporting'        => array(
			'Live Business Reporting & Dashboards | LD Workflows',
			'Live dashboards across every flow: a real-time view of your activity and performance, with nothing to export or reconcile first.',
		),
		'pricing'          => array(
			'Pricing: Full ERP from One Monthly Fee | LD Workflows',
			'One platform covering ERP, accounting, inventory, CRM and MTD VAT filing. Choose monthly for flexibility, or annual to get two months free.',
		),
		'resources'        => array(
			'Resources: Guides, Playbooks & Product News | LD Workflows',
			'How teams run sales, stock and finance on one platform. Guides, playbooks and product news, written by the people who build it.',
		),
		'contact'          => array(
			'Contact Us | LD Workflows',
			'Tell us what you need and the right person will come back to you. We answer every enquiry within one working day.',
		),
		'terms-of-service' => array(
			'Terms of Service | LD Workflows',
			'The terms covering your use of the LD Workflows platform and website, including accounts, payment, acceptable use, data and liability.',
		),
		'cookies-policy'   => array(
			'Cookies Policy | LD Workflows',
			'How this website uses cookies, what each one is for, and how to control or remove them in your browser.',
		),
		'privacy-policy'   => array(
			'Privacy Policy | LD Workflows',
			'How we collect, use and protect your personal data, how long we keep it, and the rights you have over it.',
		),
	);

	foreach ( $pages as $slug => $copy ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			continue;
		}
		if ( ! get_field( 'seo_title', $page->ID ) ) {
			update_field( 'seo_title', $copy[0], $page->ID );
		}
		if ( ! get_field( 'seo_description', $page->ID ) ) {
			update_field( 'seo_description', $copy[1], $page->ID );
		}
	}

	update_option( 'ldw_seo_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_seo' );
add_action( 'admin_init', 'ldw_seed_seo' );
