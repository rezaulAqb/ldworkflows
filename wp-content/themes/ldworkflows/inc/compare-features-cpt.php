<?php
/**
 * "Comparison Feature" custom post type — one post per table row.
 *
 * Each row is a feature name plus one value per plan column. The three
 * plan columns are named in Theme Content > Comparison Section; the rows
 * are posts here so the admin controls how many there are and in what
 * order (repeaters are ACF PRO only — same reason as flow_card).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'compare_feature',
			array(
				'label'           => 'Comparison Features',
				'labels'          => array(
					'name'          => 'Comparison Features',
					'singular_name' => 'Comparison Feature',
					'add_new_item'  => 'Add Comparison Feature',
					'edit_item'     => 'Edit Comparison Feature',
					'menu_name'     => 'Comparison Rows',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-editor-table',
				'supports'        => array( 'title', 'page-attributes' ),
				'capability_type' => 'post',
			)
		);
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'compare_feature' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'menu_order title' );
			$query->set( 'order', 'ASC' );
		}
	}
);

add_action(
	'acf/init',
	function () {
		$plan_field = function ( $n, $label, $hint ) {
			return array(
				'key'          => "field_compare_plan_{$n}",
				'label'        => $label,
				'name'         => "plan_{$n}",
				'type'         => 'text',
				'instructions' => $hint,
			);
		};

		acf_add_local_field_group(
			array(
				'key'      => 'group_compare_feature',
				'title'    => 'Values per plan',
				'fields'   => array(
					$plan_field( 1, 'Column 1 (your plan)', 'Enter a tick with "yes" or "✓", or short text like "Days".' ),
					$plan_field( 2, 'Column 2', 'e.g. "Add-on", "Basic", "Months", or "yes" for a tick.' ),
					$plan_field( 3, 'Column 3', 'e.g. "Partial", "Not included", or "yes" for a tick.' ),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'compare_feature',
						),
					),
				),
			)
		);
	}
);

/**
 * True when a cell value should render as a tick rather than as text.
 */
function ldw_compare_is_tick( $value ) {
	return in_array( strtolower( trim( (string) $value ) ), array( 'yes', 'y', 'true', '✓', 'tick', 'check' ), true );
}

/**
 * All comparison rows in admin-defined order.
 */
function ldw_get_compare_features() {
	$posts = get_posts(
		array(
			'post_type'      => 'compare_feature',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);

	$rows = array();
	foreach ( $posts as $post ) {
		$rows[] = array(
			'label'  => get_the_title( $post ),
			'values' => array(
				get_field( 'plan_1', $post->ID ),
				get_field( 'plan_2', $post->ID ),
				get_field( 'plan_3', $post->ID ),
			),
		);
	}
	return $rows;
}
