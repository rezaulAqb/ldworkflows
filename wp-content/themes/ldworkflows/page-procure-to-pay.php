<?php
/**
 * Procure to Pay page template — WP's template hierarchy auto-selects this
 * file for the page with slug "procure-to-pay". Third page under the
 * Solutions menu, and the mirror image of page-order-to-cash.php: the
 * same walk along a flow, but the buying side rather than the selling
 * one — Quotes › Purchase orders › Bills › Payables, as the home page's
 * orbit names it.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * other landing pages' markup and CSS while reading its own ACF Options
 * and its own Procure to Pay Benefit CPT. The benefits block hides itself
 * until that CPT has cards, so the page reads correctly while it's empty.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'p2p_hero', 'label' => 'Procure to pay hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'p2p_orders', 'label' => 'Procure to pay orders', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'p2p_goodsin', 'label' => 'Procure to pay goods in', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'p2p_payables', 'label' => 'Procure to pay payables', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'p2p_benefits', 'post_type' => 'p2p_benefit', 'label' => 'Procure to pay benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'p2p_final_cta' ) );

get_footer();
