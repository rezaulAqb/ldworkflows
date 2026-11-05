<?php
/**
 * ERP page template — WP's template hierarchy auto-selects this file for
 * the page with slug "erp". Same shape as page-crm.php: hero, alternating
 * image/checklist blocks, numbered benefits, closing CTA.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * CRM page's markup and CSS while reading its own ACF Options and its own
 * ERP Benefit CPT.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'erp_hero', 'label' => 'ERP hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'erp_sales', 'label' => 'ERP sales', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'erp_warehouse', 'label' => 'ERP warehouse', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'erp_accounting', 'label' => 'ERP accounting', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'erp_comms', 'label' => 'ERP communications', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'erp_benefits', 'post_type' => 'erp_benefit', 'label' => 'ERP benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'erp_final_cta' ) );

get_footer();
