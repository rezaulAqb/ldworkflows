<?php
/**
 * "Warehouse Benefit" custom post type — one post per card in the
 * Warehouse page's "Key benefits" list. Mirrors the CRM, ERP and Service
 * Benefit CPTs so each page keeps an independent set of cards; all are
 * read through ldw_get_benefit_cards().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'warehouse_benefit',
			array(
				'label'           => 'Warehouse Benefits',
				'labels'          => array(
					'name'          => 'Warehouse Benefits',
					'singular_name' => 'Warehouse Benefit',
					'add_new_item'  => 'Add Warehouse Benefit',
					'edit_item'     => 'Edit Warehouse Benefit',
					'menu_name'     => 'Warehouse Benefits',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-archive',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'warehouse_benefit' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_warehouse_benefit',
				'title'    => 'Benefit Details',
				'fields'   => array(
					array(
						'key'           => 'field_warehouse_benefit_image',
						'label'         => 'Number image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_warehouse_benefit_text',
						'label' => 'Description',
						'name'  => 'text',
						'type'  => 'textarea',
						'rows'  => 4,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'warehouse_benefit',
						),
					),
				),
			)
		);
	}
);
