<?php
/**
 * Field service page template — WP's template hierarchy auto-selects this
 * file for the page with slug "service". Same shape as page-erp.php: hero,
 * alternating image/checklist blocks, numbered benefits, closing CTA.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * CRM and ERP markup and CSS while reading its own ACF Options and its
 * own Service Benefit CPT.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'service_hero', 'label' => 'Service hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'service_resources', 'label' => 'Service resources', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'service_warehouse', 'label' => 'Service warehouse', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'service_accounting', 'label' => 'Service accounting', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'service_comms', 'label' => 'Service communications', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'service_logistics', 'label' => 'Service logistics', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'service_benefits', 'post_type' => 'service_benefit', 'label' => 'Service benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'service_final_cta' ) );

get_footer();
