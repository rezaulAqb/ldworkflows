<?php
/**
 * E-commerce page template — WP's template hierarchy auto-selects this
 * file for the page with slug "ecommerce". Same shape as
 * page-warehouse.php: hero, alternating image/checklist blocks, numbered
 * benefits, closing CTA.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * other landing pages' markup and CSS while reading its own ACF Options
 * and its own E-commerce Benefit CPT. The benefits block hides itself
 * until that CPT has cards, so the page reads correctly while it's empty.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'ecommerce_hero', 'label' => 'E-commerce hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'ecommerce_storefront', 'label' => 'E-commerce storefront', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'ecommerce_orders', 'label' => 'E-commerce orders', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'ecommerce_finance', 'label' => 'E-commerce finance', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'ecommerce_benefits', 'post_type' => 'ecommerce_benefit', 'label' => 'E-commerce benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'ecommerce_final_cta' ) );

get_footer();
