<?php
/**
 * "Order to Cash Benefit" custom post type — one post per card in the
 * Order to Cash page's "Key benefits" list. Mirrors the Benefit CPTs on
 * the other landing pages so each keeps an independent set of cards; all
 * are read through ldw_get_benefit_cards().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'o2c_benefit',
			array(
				'label'           => 'Order to Cash Benefits',
				'labels'          => array(
					'name'          => 'Order to Cash Benefits',
					'singular_name' => 'Order to Cash Benefit',
					'add_new_item'  => 'Add Order to Cash Benefit',
					'edit_item'     => 'Edit Order to Cash Benefit',
					'menu_name'     => 'Order to Cash Benefits',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-money-alt',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'o2c_benefit' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_o2c_benefit',
				'title'    => 'Benefit Details',
				'fields'   => array(
					array(
						'key'           => 'field_o2c_benefit_image',
						'label'         => 'Number image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_o2c_benefit_text',
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
							'value'    => 'o2c_benefit',
						),
					),
				),
			)
		);
	}
);
