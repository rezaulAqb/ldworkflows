<?php
/**
 * "Pricing Plan" custom post type — one post per plan column (Starter,
 * Growth, Scale). Each plan carries its own monthly/annual price and
 * feature list, so the admin controls how many plans there are, their
 * order, and whether one is marked as "featured" (highlighted card).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'pricing_plan',
			array(
				'label'           => 'Pricing Plans',
				'labels'          => array(
					'name'          => 'Pricing Plans',
					'singular_name' => 'Pricing Plan',
					'add_new_item'  => 'Add Pricing Plan',
					'edit_item'     => 'Edit Pricing Plan',
					'menu_name'     => 'Pricing Plans',
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
		if ( is_admin() && $query->is_main_query() && 'pricing_plan' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
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
				'key'      => 'group_pricing_plan',
				'title'    => 'Plan Details',
				'fields'   => array(
					array(
						'key'   => 'field_plan_badge',
						'label' => 'Badge',
						'name'  => 'badge',
						'type'  => 'text',
						'instructions' => 'e.g. "Starter", "Most popular", "Scale".',
					),
					array(
						'key'   => 'field_plan_subtitle',
						'label' => 'Subtitle',
						'name'  => 'subtitle',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_plan_price_monthly',
						'label'         => 'Price — monthly billing',
						'name'          => 'price_monthly',
						'type'          => 'text',
						'instructions'  => 'e.g. "£130" — shown with "/mo" appended.',
					),
					array(
						'key'           => 'field_plan_price_annual',
						'label'         => 'Price — annual billing',
						'name'          => 'price_annual',
						'type'          => 'text',
						'instructions'  => 'Per-month rate when billed annually, e.g. "£108".',
					),
					array(
						'key'           => 'field_plan_cta_text',
						'label'         => 'CTA button text',
						'name'          => 'cta_text',
						'type'          => 'text',
						'default_value' => 'Start free trial',
					),
					array(
						'key'           => 'field_plan_cta_url',
						'label'         => 'CTA button link',
						'name'          => 'cta_url',
						'type'          => 'text',
						'default_value' => '#',
					),
					array(
						'key'           => 'field_plan_featured',
						'label'         => 'Featured plan',
						'name'          => 'featured',
						'type'          => 'true_false',
						'instructions'  => 'Highlights this card with the dark "most popular" styling.',
						'ui'            => 1,
					),
					array(
						'key'          => 'field_plan_features',
						'label'        => 'Features',
						'name'         => 'features',
						'type'         => 'textarea',
						'rows'         => 10,
						'instructions' => 'One feature per line. Start a line with <code>✕</code> to show it struck through as not included; everything else shows ticked.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'pricing_plan',
						),
					),
				),
			)
		);
	}
);

/**
 * All pricing plans in admin-defined order, with features parsed out of
 * the one-per-line textarea.
 */
function ldw_get_pricing_plans() {
	$posts = get_posts(
		array(
			'post_type'      => 'pricing_plan',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);

	$plans = array();
	foreach ( $posts as $post ) {
		$features = array();
		foreach ( explode( "\n", (string) get_field( 'features', $post->ID ) ) as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			$excluded   = 0 === strpos( $line, '✕' );
			$features[] = array(
				'label'   => trim( ltrim( $line, "✕✓ \t" ) ),
				'excluded' => $excluded,
			);
		}

		$plans[] = array(
			'title'         => get_the_title( $post ),
			'badge'         => get_field( 'badge', $post->ID ),
			'subtitle'      => get_field( 'subtitle', $post->ID ),
			'price_monthly' => get_field( 'price_monthly', $post->ID ),
			'price_annual'  => get_field( 'price_annual', $post->ID ),
			'cta_text'      => get_field( 'cta_text', $post->ID ) ?: 'Start free trial',
			'cta_url'       => get_field( 'cta_url', $post->ID ) ?: '#',
			'featured'      => (bool) get_field( 'featured', $post->ID ),
			'features'      => $features,
		);
	}
	return $plans;
}
