<?php
/**
 * "VS Card" custom post type — one post per column in the "You vs
 * NetSuite" comparison (same label/value row shape as CRM Cards, see
 * inc/crm-cards-cpt.php, just a separate CPT so this section's cards
 * stay independent of the CRM comparison's).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'vs_card',
			array(
				'label'           => 'VS Cards',
				'labels'          => array(
					'name'          => 'VS Cards',
					'singular_name' => 'VS Card',
					'add_new_item'  => 'Add VS Card',
					'edit_item'     => 'Edit VS Card',
					'menu_name'     => 'VS Cards',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-chart-bar',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'vs_card' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_vs_card',
				'title'    => 'Card Details',
				'fields'   => array(
					array(
						'key'           => 'field_vs_badge',
						'label'         => 'Badge',
						'name'          => 'badge',
						'type'          => 'text',
						'default_value' => 'Competitor',
					),
					array(
						'key'   => 'field_vs_subtitle',
						'label' => 'Subtitle',
						'name'  => 'subtitle',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_vs_theme',
						'label'         => 'Style',
						'name'          => 'theme',
						'type'          => 'select',
						'instructions'  => '"Your platform" gets the dark card and tinted values; "Competitor" gets the plain card.',
						'choices'       => array(
							'own'        => 'Your platform',
							'competitor' => 'Competitor',
						),
						'default_value' => 'competitor',
					),
					array(
						'key'          => 'field_vs_rows',
						'label'        => 'Rows',
						'name'         => 'rows',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One row per line, as <code>Label | Value</code>. For example: <code>Go-live time | Days</code>.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'vs_card',
						),
					),
				),
			)
		);
	}
);

/**
 * All VS cards in admin-defined order, with their rows parsed out of the
 * "Label | Value" textarea.
 */
function ldw_get_vs_cards() {
	$posts = get_posts(
		array(
			'post_type'      => 'vs_card',
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
