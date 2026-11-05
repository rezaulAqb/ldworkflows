<?php
/**
 * AI Integration page template — WP's template hierarchy auto-selects this
 * file for the page with slug "ai-integration". First page under the
 * Solutions menu; same shape as the Product pages so the two menus read
 * consistently: hero, alternating image/checklist blocks, numbered
 * benefits, closing CTA.
 *
 * Every part here is shared and prefix-driven, so this page reuses the
 * other landing pages' markup and CSS while reading its own ACF Options
 * and its own AI Benefit CPT. The benefits block hides itself until that
 * CPT has cards, so the page reads correctly while it's empty.
 */

get_header();

get_template_part( 'template-parts/pricing-hero', null, array( 'prefix' => 'ai_hero', 'label' => 'AI hero' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'ai_insight', 'label' => 'AI insight', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'ai_data', 'label' => 'AI data', 'image_side' => 'left' ) );
get_template_part( 'template-parts/crm-checklist', null, array( 'prefix' => 'ai_security', 'label' => 'AI security', 'image_side' => 'right' ) );
get_template_part( 'template-parts/crm-benefits', null, array( 'prefix' => 'ai_benefits', 'post_type' => 'ai_benefit', 'label' => 'AI benefits' ) );
get_template_part( 'template-parts/final-cta', null, array( 'prefix' => 'ai_final_cta' ) );

get_footer();
