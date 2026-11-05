<?php
/**
 * Resources page template — WP's template hierarchy auto-selects this
 * file for the page with slug "resources".
 *
 * Resources are the WordPress blog (see inc/resources.php), so there is
 * nothing page-specific to manage here beyond the chrome: editors add a
 * post, set a featured image and a card size, and it appears in the grid
 * on this page and in the teaser strip on the home page.
 *
 * The grid itself is the same template part the home page uses, called
 * with 'paged' so this copy runs through every post rather than the
 * first handful.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'resources_hero', 'label' => 'Resources hero' ) );
get_template_part( 'template-parts/resources', null, array( 'prefix' => 'resp', 'paged' => true, 'label' => 'Resources grid' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'resources_final_cta' ) );

get_footer();
