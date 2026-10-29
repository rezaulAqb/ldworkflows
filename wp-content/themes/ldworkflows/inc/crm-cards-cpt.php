<?php
/**
 * "CRM Card" custom post type — one post per plan column in the
 * "A CRM that can actually see your money." comparison.
 *
 * Each card holds its own list of label/value rows. That's a nested list,
 * which would need a repeater (ACF PRO), so the rows are stored as one
 * "Label | Value" line per row in a textarea instead. The card count and
 * each card's row count are both admin-controlled.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'crm_card',
			array(
				'label'           => 'CRM Cards',
				'labels'          => array(
					'name'          => 'CRM Cards',
					'singular_name' => 'CRM Card',
					'add_new_item'  => 'Add CRM Card',
					'edit_item'     => 'Edit CRM Card',
					'menu_name'     => 'CRM Cards',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-id-alt',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'crm_card' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_crm_card',
				'title'    => 'Card Details',
				'fields'   => array(
					array(
						'key'           => 'field_crm_badge',
						'label'         => 'Badge',
						'name'          => 'badge',
						'type'          => 'text',
						'default_value' => 'Competitor',
					),
					array(
						'key'          => 'field_crm_subtitle',
						'label'        => 'Subtitle',
						'name'         => 'subtitle',
						'type'         => 'text',
						'instructions' => 'e.g. "Marketing-heavy CRM suite"',
					),
					array(
						'key'           => 'field_crm_theme',
						'label'         => 'Style',
						'name'          => 'theme',
						'type'          => 'select',
						'instructions'  => '"Your platform" gets the green border and green ticked values; "Competitor" gets the plain border and red values.',
						'choices'       => array(
							'own'        => 'Your platform',
							'competitor' => 'Competitor',
						),
						'default_value' => 'competitor',
					),
					array(
						'key'          => 'field_crm_rows',
						'label'        => 'Rows',
						'name'         => 'rows',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One row per line, as <code>Label | Value</code>. For example: <code>Invoice status | Real-time</code>. Add or remove lines freely — every card can have a different number of rows.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'crm_card',
						),
					),
				),
			)
		);
	}
);

/**
 * All CRM cards in admin-defined order, with their rows parsed out of the
 * "Label | Value" textarea.
 */
function ldw_get_crm_cards() {
	$posts = get_posts(
		array(
			'post_type'      => 'crm_card',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);

	$cards = array();
	foreach ( $posts as $post ) {
		$rows = array();
		foreach ( explode( "\n", (string) get_field( 'rows', $post->ID ) ) as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			$parts  = array_map( 'trim', explode( '|', $line, 2 ) );
			$rows[] = array(
				'label' => $parts[0],
				'value' => isset( $parts[1] ) ? $parts[1] : '',
			);
		}

		$cards[] = array(
			'title'    => get_the_title( $post ),
			'badge'    => get_field( 'badge', $post->ID ),
			'subtitle' => get_field( 'subtitle', $post->ID ),
			'theme'    => get_field( 'theme', $post->ID ) ?: 'competitor',
			'rows'     => $rows,
		);
	}
	return $cards;
}
