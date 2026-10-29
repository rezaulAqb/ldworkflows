<?php
/**
 * "E-commerce Benefit" custom post type — one post per card in the
 * E-commerce page's "Key benefits" list. Mirrors the Benefit CPTs on the
 * other landing pages so each keeps an independent set of cards; all are
 * read through ldw_get_benefit_cards().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'ecommerce_benefit',
			array(
				'label'           => 'E-commerce Benefits',
				'labels'          => array(
					'name'          => 'E-commerce Benefits',
					'singular_name' => 'E-commerce Benefit',
					'add_new_item'  => 'Add E-commerce Benefit',
					'edit_item'     => 'Edit E-commerce Benefit',
					'menu_name'     => 'E-commerce Benefits',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-cart',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'ecommerce_benefit' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_ecommerce_benefit',
				'title'    => 'Benefit Details',
				'fields'   => array(
					array(
						'key'           => 'field_ecommerce_benefit_image',
						'label'         => 'Number image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_ecommerce_benefit_text',
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
							'value'    => 'ecommerce_benefit',
						),
					),
				),
			)
		);
	}
);
