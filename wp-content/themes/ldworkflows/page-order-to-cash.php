<?php
/**
 * Order to Cash page template — WP's template hierarchy auto-selects this
 * file for the page with slug "order-to-cash". Second page under the
 * Solutions menu; same shape as the Product pages so both menus read
 * consistently.
 *
 * The three checklist blocks follow the flow the home page's orbit names
 * for this solution — Quotes › Sales orders › Invoices › Receivables — so
 * the page walks an order from raising it to being paid for it.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * other landing pages' markup and CSS while reading its own ACF Options
 * and its own Order to Cash Benefit CPT. The benefits block hides itself
 * until that CPT has cards, so the page reads correctly while it's empty.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'o2c_hero', 'label' => 'Order to cash hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'o2c_quotes', 'label' => 'Order to cash quotes', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'o2c_fulfilment', 'label' => 'Order to cash fulfilment', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'o2c_receivables', 'label' => 'Order to cash receivables', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'o2c_benefits', 'post_type' => 'o2c_benefit', 'label' => 'Order to cash benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'o2c_final_cta' ) );

get_footer();
