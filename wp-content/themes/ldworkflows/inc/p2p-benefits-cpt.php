<?php
/**
 * "Procure to Pay Benefit" custom post type — one post per card in the
 * Procure to Pay page's "Key benefits" list. Mirrors the Benefit CPTs on
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
			'p2p_benefit',
			array(
				'label'           => 'Procure to Pay Benefits',
				'labels'          => array(
					'name'          => 'Procure to Pay Benefits',
					'singular_name' => 'Procure to Pay Benefit',
					'add_new_item'  => 'Add Procure to Pay Benefit',
					'edit_item'     => 'Edit Procure to Pay Benefit',
					'menu_name'     => 'Procure to Pay Benefits',
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
		if ( is_admin() && $query->is_main_query() && 'p2p_benefit' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_p2p_benefit',
				'title'    => 'Benefit Details',
				'fields'   => array(
					array(
						'key'           => 'field_p2p_benefit_image',
						'label'         => 'Number image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_p2p_benefit_text',
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
							'value'    => 'p2p_benefit',
						),
					),
				),
			)
		);
	}
);
