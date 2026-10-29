<?php
/**
 * "Flow Card" custom post type — one post per orbit card.
 *
 * Repeater fields are ACF PRO only (confirmed: 'repeater' is absent from
 * acf_get_field_types() on the free plugin, which silently rendered an
 * empty input with no error). A CPT gives the same "admin manages a list
 * of 10 items" capability using only core WordPress + free ACF: each
 * card is its own post, and WordPress's native "page-attributes" support
 * provides a plain numeric Order field editors use to reorder the set —
 * no drag-and-drop plugin or PRO license required.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'flow_card',
			array(
				'label'        => 'Flow Cards',
				'labels'       => array(
					'name'          => 'Flow Cards',
					'singular_name' => 'Flow Card',
					'add_new_item'  => 'Add Flow Card',
					'edit_item'     => 'Edit Flow Card',
					'menu_name'     => 'Flow Cards',
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => true,
				'menu_icon'    => 'dashicons-image-rotate',
				'supports'     => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

/**
 * Sort the admin list by the manual Order field by default, so editors
 * immediately see the orbit order rather than reverse-chron.
 */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'flow_card' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'menu_order title' );
			$query->set( 'order', 'ASC' );
		}
	}
);

/**
 * ACF field group for the card's non-title details.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'    => 'group_flow_card_details',
				'title'  => 'Card Details',
				'fields' => array(
					array(
						'key'          => 'field_flow_card_steps',
						'label'        => 'Steps / description',
						'name'         => 'steps',
						'type'         => 'text',
						'instructions' => 'e.g. "Quotes › Sales orders › Invoices › Receivables"',
					),
					array(
						'key'           => 'field_flow_card_tint',
						'label'         => 'Icon background colour',
						'name'          => 'tint',
						'type'          => 'color_picker',
						'default_value' => '#65BB99',
					),
					array(
						'key'           => 'field_flow_card_icon',
						'label'         => 'Icon',
						'name'          => 'icon',
						'type'          => 'select',
						'choices'       => ldw_orbit_icon_choices(),
						'default_value' => 'crm',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'flow_card',
						),
					),
				),
			)
		);
	}
);

/**
 * Fetch all flow cards in their admin-defined order, as plain arrays
 * matching the old repeater row shape ({title, steps, tint, icon}) so
 * the template loop didn't need to change shape.
 */
function ldw_get_flow_cards() {
	$posts = get_posts(
		array(
			'post_type'      => 'flow_card',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);

	$cards = array();
	foreach ( $posts as $post ) {
		$cards[] = array(
			'title' => get_the_title( $post ),
			'steps' => get_field( 'steps', $post->ID ),
			'tint'  => get_field( 'tint', $post->ID ) ?: '#65BB99',
			'icon'  => get_field( 'icon', $post->ID ) ?: 'crm',
		);
	}
	return $cards;
}
