<?php
/**
 * Resources = the WordPress blog.
 *
 * Each card in the Resources grid is a normal post, so editors write
 * articles the usual way and every card links to a real permalink. The
 * card's appearance is derived from the post itself:
 *   - has a featured image  -> dark image card with the photo behind it
 *   - no featured image     -> flat tinted card
 * Only the bento sizing and tint need extra fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'ldw-resource', 900, 700, true );
} );

/**
 * Card size presets. Keys are stored on the post; the grid spans and the
 * image card's text band are derived from them.
 */
function ldw_resource_sizes() {
	return array(
		'small' => array(
			'label' => 'Small (1 x 1)',
			'cols'  => 1,
			'rows'  => 1,
		),
		'wide'  => array(
			'label' => 'Wide (2 x 1)',
			'cols'  => 2,
			'rows'  => 1,
		),
		'large' => array(
			'label' => 'Large (2 x 2)',
			'cols'  => 2,
			'rows'  => 2,
		),
	);
}

add_action(
	'acf/init',
	function () {
		$choices = array();
		foreach ( ldw_resource_sizes() as $key => $size ) {
			$choices[ $key ] = $size['label'];
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_resource_card',
				'title'    => 'Resources grid',
				'fields'   => array(
					array(
						'key'           => 'field_resource_size',
						'label'         => 'Card size',
						'name'          => 'resource_size',
						'type'          => 'select',
						'instructions'  => 'How much of the Resources grid this post takes up.',
						'choices'       => $choices,
						'default_value' => 'small',
					),
					array(
						'key'           => 'field_resource_tint',
						'label'         => 'Card colour',
						'name'          => 'resource_tint',
						'type'          => 'select',
						'instructions'  => 'Only used when the post has no featured image. With one, the card shows the photo instead.',
						'choices'       => array(
							'#FDF3E8' => 'Cream',
							'#FBE6DD' => 'Peach',
							'#E3F1EF' => 'Mint',
							'#EEF2F1' => 'Grey',
						),
						'default_value' => '#FDF3E8',
					),
					array(
						'key'           => 'field_resource_cta',
						'label'         => 'Link text',
						'name'          => 'resource_cta',
						'type'          => 'text',
						'instructions'  => 'Shown on image cards only.',
						'default_value' => 'Read more',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'post',
						),
					),
				),
			)
		);
	}
);

/**
 * Posts shaped as resource cards.
 */
function ldw_get_resource_cards( $limit = 8 ) {
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
		)
	);

	$sizes = ldw_resource_sizes();
	$cards = array();

	foreach ( $posts as $post ) {
		$key  = get_field( 'resource_size', $post->ID );
		$size = isset( $sizes[ $key ] ) ? $sizes[ $key ] : $sizes['small'];

		$terms = get_the_category( $post->ID );
		$thumb = get_post_thumbnail_id( $post->ID );

		$cards[] = array(
			'title'   => get_the_title( $post ),
			'url'     => get_permalink( $post ),
			'excerpt' => get_the_excerpt( $post ),
			'tag'     => $terms ? $terms[0]->name : '',
			'image'   => $thumb ? $thumb : 0,
			'cols'    => $size['cols'],
			'rows'    => $size['rows'],
			'tint'    => get_field( 'resource_tint', $post->ID ) ?: '#FDF3E8',
			'cta'     => get_field( 'resource_cta', $post->ID ) ?: 'Read more',
			// Tall cards show the photo full-bleed; short ones reserve the
			// lower 42% so the title stays legible over the gradient.
			'band'    => 2 === $size['rows'] ? '0%' : '42%',
		);
	}

	return $cards;
}
