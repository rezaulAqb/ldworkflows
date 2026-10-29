<?php
/**
 * "AI Benefit" custom post type — one post per card in the AI Integration
 * page's "Key benefits" list. Mirrors the Benefit CPTs on the other
 * landing pages so each keeps an independent set of cards; all are read
 * through ldw_get_benefit_cards().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'ai_benefit',
			array(
				'label'           => 'AI Benefits',
				'labels'          => array(
					'name'          => 'AI Benefits',
					'singular_name' => 'AI Benefit',
					'add_new_item'  => 'Add AI Benefit',
					'edit_item'     => 'Edit AI Benefit',
					'menu_name'     => 'AI Benefits',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-superhero-alt',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'ai_benefit' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_ai_benefit',
				'title'    => 'Benefit Details',
				'fields'   => array(
					array(
						'key'           => 'field_ai_benefit_image',
						'label'         => 'Number image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_ai_benefit_text',
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
							'value'    => 'ai_benefit',
						),
					),
				),
			)
		);
	}
);
