<?php
/**
 * CRM page template — WP's template hierarchy auto-selects this file for
 * the page with slug "crm". Mirrors page-pricing.php's structure: hero,
 * content sections, then the closing CTA.
 *
 * The hero, checklist blocks and final CTA are shared template parts
 * driven by a field prefix, so this page reuses the pricing page's markup
 * and CSS while reading its own ACF Options.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'crm_hero', 'label' => 'CRM hero' ) );
get_template_part( 'template-parts/crm-clients' );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'crm_groups', 'label' => 'CRM customer groups', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'crm_features', 'label' => 'CRM features', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'crm_comms', 'label' => 'CRM communications', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-benefits' );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'crm_final_cta' ) );

get_footer();
