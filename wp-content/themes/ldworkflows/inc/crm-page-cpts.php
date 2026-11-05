<?php
/**
 * CPTs for the CRM page's two repeating sections:
 *  - crm_client   : client logos for the "Trusted and loved…" strip.
 *  - crm_flow_card: the "Check out more" workflow cross-link cards.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'crm_client',
			array(
				'label'           => 'CRM Clients',
				'labels'          => array(
					'name'          => 'CRM Clients',
					'singular_name' => 'CRM Client',
					'add_new_item'  => 'Add CRM Client',
					'edit_item'     => 'Edit CRM Client',
					'menu_name'     => 'CRM Clients',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-awards',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);

		register_post_type(
			'crm_flow_card',
			array(
				'label'           => 'CRM Workflow Cards',
				'labels'          => array(
					'name'          => 'CRM Workflow Cards',
					'singular_name' => 'CRM Workflow Card',
					'add_new_item'  => 'Add Workflow Card',
					'edit_item'     => 'Edit Workflow Card',
					'menu_name'     => 'CRM Workflow Cards',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-randomize',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() ) {
			return;
		}
		if ( in_array( $query->get( 'post_type' ), array( 'crm_client', 'crm_flow_card' ), true ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_crm_client',
				'title'    => 'Logo',
				'fields'   => array(
					array(
						'key'           => 'field_crm_client_logo',
						'label'         => 'Logo image',
						'name'          => 'logo',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown in the client strip. The post title is used as the alt text.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'crm_client',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_flow_card',
				'title'    => 'Card Details',
				'fields'   => array(
					array(
						'key'           => 'field_crm_flow_image',
						'label'         => 'Card image',
						'name'          => 'image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
					),
					array(
						'key'   => 'field_crm_flow_text',
						'label' => 'Description',
						'name'  => 'text',
						'type'  => 'textarea',
						'rows'  => 4,
					),
					array(
						'key'           => 'field_crm_flow_cta_text',
						'label'         => 'Button label',
						'name'          => 'cta_text',
						'type'          => 'text',
						'default_value' => 'View Flow',
					),
					array(
						'key'   => 'field_crm_flow_cta_url',
						'label' => 'Button URL',
						'name'  => 'cta_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'crm_flow_card',
						),
					),
				),
			)
		);
	}
);

/**
 * Client logos in admin order. Entries without an image are skipped, so a
 * half-filled CPT never renders a gap in the strip.
 *
 * @return array List of array{name:string,url:string}.
 */
function ldw_get_crm_clients() {
	$out = array();
	foreach ( get_posts(
		array(
			'post_type'      => 'crm_client',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	) as $post ) {
		$logo = get_field( 'logo', $post->ID );
		if ( ! $logo || empty( $logo['url'] ) ) {
			continue;
		}
		$out[] = array(
			'name' => get_the_title( $post ),
			'url'  => $logo['url'],
		);
	}
	return $out;
}

/**
 * "Check out more" workflow cards in admin order.
 *
 * @return array List of array{title:string,text:string,cta_text:string,cta_url:string}.
 */
function ldw_get_crm_flow_cards() {
	$out = array();
	foreach ( get_posts(
		array(
			'post_type'      => 'crm_flow_card',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	) as $post ) {
		$out[] = array(
			'title'    => get_the_title( $post ),
			'text'     => (string) get_field( 'text', $post->ID ),
			'cta_text' => (string) get_field( 'cta_text', $post->ID ),
			'cta_url'  => (string) get_field( 'cta_url', $post->ID ),
			'image'    => get_field( 'image', $post->ID ),
		);
	}
	return $out;
}
