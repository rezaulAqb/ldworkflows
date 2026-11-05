<?php
/**
 * "CRM Benefit" custom post type — one post per card in the CRM page's
 * "Key benefits" grid. Title is the benefit name; the body copy lives in
 * an ACF field so the card shape stays fixed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'crm_benefit',
			array(
				'label'           => 'CRM Benefits',
				'labels'          => array(
					'name'          => 'CRM Benefits',
					'singular_name' => 'CRM Benefit',
					'add_new_item'  => 'Add CRM Benefit',
					'edit_item'     => 'Edit CRM Benefit',
					'menu_name'     => 'CRM Benefits',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-groups',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'crm_benefit' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_crm_benefit',
				'title'    => 'Benefit Details',
				'fields'   => array(
					array(
						'key'           => 'field_crm_benefit_image',
						'label'         => 'Number image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_crm_benefit_text',
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
							'value'    => 'crm_benefit',
						),
					),
				),
			)
		);
	}
);

/**
 * Benefit cards in admin order.
 *
 * @return array List of array{title:string,text:string}.
 */
function ldw_get_crm_benefits() {
	return ldw_get_benefit_cards( 'crm_benefit' );
}

/**
 * Benefit cards for a given CPT, in admin order.
 *
 * @param string $post_type Benefit CPT name.
 * @return array List of array{title:string,text:string,image:mixed}.
 */
function ldw_get_benefit_cards( $post_type = 'crm_benefit' ) {
	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	);

	$cards = array();
	foreach ( $posts as $post ) {
		$cards[] = array(
			'title' => get_the_title( $post ),
			'text'  => (string) get_field( 'text', $post->ID ),
			'image' => get_field( 'image', $post->ID ),
		);
	}

	return $cards;
}
