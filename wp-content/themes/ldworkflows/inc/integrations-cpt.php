<?php
/**
 * "Integration" custom post type — one post per logo tile.
 *
 * The logo count is admin-controlled, so this can't be a fixed set of
 * fields, and repeaters are ACF PRO only. Same approach as flow_card:
 * one post per tile, with core's page-attributes Order field for
 * sequencing.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'integration',
			array(
				'label'           => 'Integrations',
				'labels'          => array(
					'name'          => 'Integrations',
					'singular_name' => 'Integration',
					'add_new_item'  => 'Add Integration',
					'edit_item'     => 'Edit Integration',
					'menu_name'     => 'Integrations',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-networking',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'integration' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'menu_order title' );
			$query->set( 'order', 'ASC' );
		}
	}
);

add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_integration_details',
				'title'    => 'Integration Details',
				'fields'   => array(
					array(
						'key'           => 'field_integration_logo',
						'label'         => 'Logo',
						'name'          => 'logo',
						'type'          => 'image',
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'instructions'  => 'Transparent PNG or SVG works best. Leave empty to show the name as text instead.',
					),
					array(
						'key'          => 'field_integration_url',
						'label'        => 'Link (optional)',
						'name'         => 'url',
						'type'         => 'text',
						'instructions' => 'If set, the tile becomes clickable.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'integration',
						),
					),
				),
			)
		);
	}
);

/**
 * All integrations in admin-defined order.
 */
function ldw_get_integrations() {
	$posts = get_posts(
		array(
			'post_type'      => 'integration',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);

	$items = array();
	foreach ( $posts as $post ) {
		$items[] = array(
			'name' => get_the_title( $post ),
			'logo' => get_field( 'logo', $post->ID ),
			'url'  => get_field( 'url', $post->ID ),
		);
	}
	return $items;
}
