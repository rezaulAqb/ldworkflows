<?php
/**
 * Pricing page template — WP's template hierarchy auto-selects this file
 * for the page with slug "pricing". Reuses the homepage's Comparison and
 * CRM Comparison sections (same data, same CPTs) rather than duplicating
 * them; only the hero, plan cards, "You vs NetSuite" cards and FAQ are
 * specific to this page.
 */

get_header();
get_template_part( 'template-parts/pricing-hero' );
get_template_part( 'template-parts/pricing-plans' );
get_template_part( 'template-parts/comparison', null, array( 'show_eyebrow' => true ) );
get_template_part( 'template-parts/vs-netsuite' );
get_template_part( 'template-parts/crm-comparison', null, array( 'show_eyebrow' => true ) );
get_template_part( 'template-parts/pricing-faq' );
get_template_part( 'template-parts/final-cta' );
get_footer();
