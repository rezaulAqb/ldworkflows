<?php
/**
 * Shared template helpers: icon library + orbit geometry.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon slug => pipe-separated SVG path data (24x24 viewBox), ported from
 * the final-all.html design.
 */
function ldw_orbit_icon_library() {
	return array(
		'crm'          => 'M16 20v-1.6a3.4 3.4 0 0 0-3.4-3.4H6.4A3.4 3.4 0 0 0 3 18.4V20|M9.5 11.5a4 4 0 1 0 0-8 4 4 0 0 0 0 8|M21 20v-1.6a3.4 3.4 0 0 0-2.6-3.3|M16 3.7a4 4 0 0 1 0 7.6',
		'order-to-cash' => 'M6.5 2.5h11v19l-2.75-1.9-2.75 1.9-2.75-1.9L6.5 21.5v-19z|M9.5 7.5h5|M9.5 11.5h5|M9.5 15.5h3',
		'procure-to-pay' => 'M2.5 3.5h2.2l2.3 11.2h10.2L20 7.3H6.2|M9.2 20a1.3 1.3 0 1 0 0-2.6 1.3 1.3 0 0 0 0 2.6|M17.6 20a1.3 1.3 0 1 0 0-2.6 1.3 1.3 0 0 0 0 2.6',
		'warehouse'    => 'M3 21V9l9-6 9 6v12|M3 13h18|M9.5 21v-5.5h5V21',
		'ecommerce'    => 'M6.2 7.5h11.6l1 13.5H5.2l1-13.5z|M9.3 7.5V5.6a2.7 2.7 0 0 1 5.4 0v1.9',
		'accounting'   => 'M5.5 2.5h13v19h-13v-19z|M8.5 6.5h7|M8.5 11.5h2|M12.5 11.5h2|M8.5 15.5h2|M12.5 15.5h2',
		'reporting'    => 'M4 20.5V11|M10 20.5V4.5|M16 20.5v-6.5|M2 20.5h20',
		'ai'           => 'M9 8.5h6v6H9v-6z|M12 3v2.2|M12 18.8V21|M3 12h2.2|M18.8 12H21|M6 6l1.6 1.6|M16.4 16.4L18 18|M18 6l-1.6 1.6|M7.6 16.4L6 18',
		'field-service' => 'M3 16.5V7.5h10.5v9|M13.5 10.5h4L21 14v2.5h-7.5|M7 19.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3|M17.5 19.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3',
		'recycling'    => 'M23 4 23 10 17 10|M1 20 1 14 7 14|M3.51 9a9 9 0 0 1 14.85-3.36L23 10|M1 14l4.64 4.36a9 9 0 0 0 15.35-4.36',
	);
}

/**
 * ACF select-field choices for the icon picker.
 */
function ldw_orbit_icon_choices() {
	return array(
		'crm'            => 'CRM (person)',
		'order-to-cash'  => 'Order to Cash (invoice)',
		'procure-to-pay' => 'Procure to Pay (cart)',
		'warehouse'      => 'Warehouse (building)',
		'ecommerce'      => 'E-commerce (bag)',
		'accounting'     => 'Accounting (ledger)',
		'reporting'      => 'Reporting (bars)',
		'ai'             => 'AI integration (spark)',
		'field-service'  => 'Field Service (van)',
		'recycling'      => 'Recycling (loop)',
	);
}

/**
 * Echo an orbit glyph <svg> for the given icon slug.
 */
function ldw_the_orbit_icon( $slug, $size = 15 ) {
	$library = ldw_orbit_icon_library();
	$paths   = isset( $library[ $slug ] ) ? $library[ $slug ] : $library['crm'];
	$size    = (int) $size;

	echo '<svg viewBox="0 0 24 24" width="' . esc_attr( $size ) . '" height="' . esc_attr( $size ) . '" fill="none" stroke="#FFFFFF" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" style="display:block">';
	foreach ( explode( '|', $paths ) as $d ) {
		echo '<path d="' . esc_attr( $d ) . '"></path>';
	}
	echo '</svg>';
}

/**
 * Custom walker: renders a 2-level menu as the design's dropdown nav.
 * Top-level items with children get a chevron + hover/focus dropdown panel;
 * top-level items without children render as plain links.
 */
class LDW_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<div class="ldw-dropdown-panel">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</div>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( 0 === $depth ) {
			$has_children = in_array( 'menu-item-has-children', $item->classes, true );
			$classes      = $has_children ? ' ldw-has-dropdown' : '';
			$output      .= '<div class="ldw-nav-item' . $classes . '">';
			$output      .= '<a href="' . esc_url( $item->url ) . '" class="ldw-nav-link">' . esc_html( $item->title );
			if ( $has_children ) {
				$output .= '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="display:block"><path d="M6 9.5l6 6 6-6"></path></svg>';
			}
			$output .= '</a>';
		} else {
			$output .= '<a href="' . esc_url( $item->url ) . '" class="ldw-dropdown-link">' . esc_html( $item->title ) . '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '</div>';
		}
	}
}

/**
 * Create the default primary + footer menus on first activation, matching
 * the original design, so navigation isn't empty out of the box.
 */
function ldw_seed_menus() {
	if ( get_option( 'ldw_menus_seeded' ) ) {
		return;
	}

	$menu_id = wp_create_nav_menu( 'Primary Menu' );
	if ( is_wp_error( $menu_id ) ) {
		$existing = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
		$menu_id  = $existing ? $existing->term_id : 0;
	}

	if ( $menu_id ) {
		$product = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Product',
			'menu-item-url'    => '#',
			'menu-item-status' => 'publish',
		) );
		foreach ( array( 'ERP', 'CRM', 'Field Service', 'Warehouse', 'E-commerce' ) as $i => $label ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => $label,
				'menu-item-url'       => '#',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $product,
			) );
		}

		$solutions = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Solutions',
			'menu-item-url'    => '#',
			'menu-item-status' => 'publish',
		) );
		foreach ( array( 'Order to Cash', 'Procure to Pay', 'Accounting and MTD VAT', 'Reporting', 'AI integration' ) as $label ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => $label,
				'menu-item-url'       => '#',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $solutions,
			) );
		}

		foreach ( array(
			'Integrations' => '#integrations',
			'Pricing'      => '/pricing/',
			'Resources'    => '#resources',
			'Contact'      => '#contact',
		) as $label => $url ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => $label,
				'menu-item-url'    => $url,
				'menu-item-status' => 'publish',
			) );
		}

		$locations             = get_theme_mod( 'nav_menu_locations' );
		$locations['primary']  = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'ldw_menus_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_menus' );
add_action( 'admin_init', 'ldw_seed_menus' );

/**
 * Compute the absolute left/top offsets (in px, relative to the orbit's
 * own centre) for item $index of $total items evenly spaced around a
 * circle of radius $radius, starting at 12 o'clock and going clockwise.
 *
 * Returns array( 'left' => float, 'top' => float ) — these are OFFSETS
 * to add to "50%", matching the original design's calc(50% + Npx) scheme.
 */
function ldw_orbit_point( $index, $total, $radius ) {
	if ( $total < 1 ) {
		return array(
			'left' => 0,
			'top'  => 0,
		);
	}
	$angle = ( $index * 360 / $total ) * ( M_PI / 180 );
	return array(
		'left' => round( $radius * sin( $angle ), 1 ),
		'top'  => round( -1 * $radius * cos( $angle ), 1 ),
	);
}

/**
 * Footer menu, seeded separately from ldw_seed_menus() because that one's
 * flag had already been set before the footer location existed.
 */
function ldw_seed_footer_menu() {
	if ( get_option( 'ldw_footer_menu_seeded' ) ) {
		return;
	}

	$menu_id = wp_create_nav_menu( 'Footer Menu' );
	if ( is_wp_error( $menu_id ) ) {
		$existing = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
		$menu_id  = $existing ? $existing->term_id : 0;
	}

	if ( $menu_id ) {
		foreach ( array(
			'ERP Flow'                => '#flows',
			'Field Service Team Flow' => '#flows',
			'CRM Flow'                => '#flows',
			'Pricing'                 => '/pricing/',
			'Contact'                 => '#contact',
			'Login'                   => '#',
		) as $label => $url ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => $label,
				'menu-item-url'    => $url,
				'menu-item-status' => 'publish',
			) );
		}

		$locations           = get_theme_mod( 'nav_menu_locations' );
		$locations['footer'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'ldw_footer_menu_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_footer_menu' );
add_action( 'admin_init', 'ldw_seed_footer_menu' );

/**
 * Attributes for a CTA link: send off-site URLs to a new tab, leave
 * in-page anchors and internal paths alone. Derived from the URL rather
 * than hardcoded per button, so an external URL pasted into any CTA
 * field in admin gets the right behaviour without a template change.
 *
 * @param string $url Link URL.
 * @return string Attribute string, pre-escaped, or '' when internal.
 */
function ldw_link_target_attrs( $url ) {
	$url = trim( (string) $url );

	// Anchors, relative paths and mailto/tel are never "off-site".
	if ( '' === $url || ! preg_match( '#^https?://#i', $url ) ) {
		return '';
	}

	$host = wp_parse_url( $url, PHP_URL_HOST );
	$home = wp_parse_url( home_url(), PHP_URL_HOST );

	if ( ! $host || strtolower( $host ) === strtolower( (string) $home ) ) {
		return '';
	}

	return ' target="_blank" rel="noopener noreferrer"';
}
