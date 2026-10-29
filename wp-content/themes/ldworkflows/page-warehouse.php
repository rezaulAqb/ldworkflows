<?php
/**
 * Warehouse page template — WP's template hierarchy auto-selects this file
 * for the page with slug "warehouse". Same shape as page-service.php:
 * hero, alternating image/checklist blocks, numbered benefits, closing CTA.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * CRM, ERP and Service markup and CSS while reading its own ACF Options
 * and its own Warehouse Benefit CPT. The benefits block hides itself
 * until that CPT has cards, so the page reads correctly while it's empty.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'warehouse_hero', 'label' => 'Warehouse hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'warehouse_goods', 'label' => 'Warehouse goods in', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'warehouse_picking', 'label' => 'Warehouse picking', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'warehouse_stock', 'label' => 'Warehouse stock', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'warehouse_benefits', 'post_type' => 'warehouse_benefit', 'label' => 'Warehouse benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'warehouse_final_cta' ) );

get_footer();
