<?php
/**
 * LD Workflows theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LDW_THEME_VERSION', '1.0.0' );
define( 'LDW_THEME_DIR', get_stylesheet_directory() );
define( 'LDW_THEME_URI', get_stylesheet_directory_uri() );

/**
 * Theme setup.
 */
function ldw_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'ldworkflows' ),
			'footer'  => __( 'Footer Navigation', 'ldworkflows' ),
		)
	);
}
add_action( 'after_setup_theme', 'ldw_setup' );

/**
 * Enqueue styles and scripts.
 */
function ldw_assets() {
	wp_enqueue_style(
		'ldw-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'ldw-main', LDW_THEME_URI . '/assets/css/main.css', array(), LDW_THEME_VERSION );
	wp_enqueue_style( 'ldw-components', LDW_THEME_URI . '/assets/css/theme-components.css', array( 'ldw-main' ), LDW_THEME_VERSION );
	wp_enqueue_style( 'ldw-style', get_stylesheet_uri(), array( 'ldw-components' ), LDW_THEME_VERSION );

	wp_enqueue_script( 'ldw-main', LDW_THEME_URI . '/assets/js/main.js', array(), LDW_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'ldw_assets' );

require LDW_THEME_DIR . '/inc/helpers.php';
require LDW_THEME_DIR . '/inc/flow-cards-cpt.php';
require LDW_THEME_DIR . '/inc/integrations-cpt.php';
require LDW_THEME_DIR . '/inc/compare-features-cpt.php';
require LDW_THEME_DIR . '/inc/crm-cards-cpt.php';
require LDW_THEME_DIR . '/inc/pricing-plans-cpt.php';
require LDW_THEME_DIR . '/inc/vs-cards-cpt.php';
require LDW_THEME_DIR . '/inc/pricing-faq-cpt.php';
require LDW_THEME_DIR . '/inc/crm-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/crm-page-cpts.php';
require LDW_THEME_DIR . '/inc/erp-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/service-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/warehouse-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/ecommerce-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/ai-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/o2c-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/p2p-benefits-cpt.php';
require LDW_THEME_DIR . '/inc/resources.php';
require LDW_THEME_DIR . '/inc/acf-fields.php';
require LDW_THEME_DIR . '/inc/seed-content.php';
