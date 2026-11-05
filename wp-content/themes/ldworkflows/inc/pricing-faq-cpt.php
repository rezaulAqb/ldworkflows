<?php
/**
 * "Pricing FAQ" custom post type — one post per question. Title is the
 * question, the built-in content editor is the answer, so admins use the
 * normal post editor rather than another ACF field group.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'pricing_faq',
			array(
				'label'           => 'Pricing FAQs',
				'labels'          => array(
					'name'          => 'Pricing FAQs',
					'singular_name' => 'Pricing FAQ',
					'add_new_item'  => 'Add FAQ',
					'edit_item'     => 'Edit FAQ',
					'menu_name'     => 'Pricing FAQs',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-editor-help',
				'supports'        => array( 'title', 'editor', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'pricing_faq' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'menu_order title' );
			$query->set( 'order', 'ASC' );
		}
	}
);

/**
 * All FAQs in admin-defined order.
 */
function ldw_get_pricing_faqs() {
	$posts = get_posts(
		array(
			'post_type'      => 'pricing_faq',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);

	$faqs = array();
	foreach ( $posts as $post ) {
		$faqs[] = array(
			'q' => get_the_title( $post ),
			'a' => $post->post_content,
		);
	}
	return $faqs;
}
