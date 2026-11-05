<?php
/**
 * Reporting page template — WP's template hierarchy auto-selects this
 * file for the page with slug "reporting". Fourth page under the
 * Solutions menu; same shape as the rest so both menus read consistently.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * other landing pages' markup and CSS while reading its own ACF Options
 * and its own Reporting Benefit CPT. The benefits block hides itself
 * until that CPT has cards, so the page reads correctly while it's empty.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'reporting_hero', 'label' => 'Reporting hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'reporting_dashboards', 'label' => 'Reporting dashboards', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'reporting_reports', 'label' => 'Reporting reports', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'reporting_source', 'label' => 'Reporting single source', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'reporting_benefits', 'post_type' => 'reporting_benefit', 'label' => 'Reporting benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'reporting_final_cta' ) );

get_footer();
