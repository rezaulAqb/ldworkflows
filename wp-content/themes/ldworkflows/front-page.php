<?php
/**
 * Front page template. Sections are added incrementally — remaining
 * sections of the final-all.html design (sale-to-VAT flow, testimonials,
 * integrations, pricing comparison, resources, demo CTA, full footer)
 * will be appended here as they're built.
 */

get_header();
get_template_part( 'template-parts/hero-orbit' );
get_template_part( 'template-parts/sale-to-vat' );
get_template_part( 'template-parts/cta-band' );
get_template_part( 'template-parts/features-journey' );
get_template_part( 'template-parts/integrations' );
get_template_part( 'template-parts/comparison' );
get_template_part( 'template-parts/crm-comparison' );
get_template_part( 'template-parts/case-study' );
get_template_part( 'template-parts/resources' );
get_template_part( 'template-parts/demo-cta' );
get_footer();
