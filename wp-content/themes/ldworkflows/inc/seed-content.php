<?php
/**
 * One-time seed of the original final-all.html copy into ACF options,
 * so the site matches the source design immediately after activation
 * instead of showing empty fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ldw_seed_content() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}
	if ( get_option( 'ldw_content_seeded' ) ) {
		return;
	}

	update_field( 'hero_heading', 'One ERP at the centre. Every flow', 'option' );
	update_field( 'hero_heading_highlight', 'around it', 'option' );
	update_field( 'hero_subtext', 'CRM, order to cash, procure to pay, warehouse fulfilment and e-commerce all run on one platform. No connectors, no bridging software, no spreadsheet at quarter end.', 'option' );
	update_field( 'hero_cta_primary_text', 'Book a 20-minute demo', 'option' );
	update_field( 'hero_cta_primary_url', '#contact', 'option' );
	update_field( 'hero_cta_secondary_text', 'See pricing', 'option' );
	update_field( 'hero_cta_secondary_url', '/pricing/', 'option' );
	update_field( 'orbit_core_title', 'ERP', 'option' );
	update_field( 'orbit_core_subtitle', 'One platform', 'option' );

	update_field( 'hero_trust_items', "Live in days, not months\nHMRC-recognised for MTD\nFree migration from Xero or QuickBooks", 'option' );

	update_option( 'ldw_content_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_content' );
add_action( 'admin_init', 'ldw_seed_content' ); // also catch activation via wp-cli, which skips after_switch_theme's usual admin context in some setups.

/**
 * One-time seed of the Sale to VAT section — separate flag since it was
 * added after the theme's first activation (ldw_content_seeded already
 * fired by then).
 */
function ldw_seed_sale_to_vat() {
	if ( get_option( 'ldw_vat_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'vat_heading', 'From a sale to a VAT return, with no human intervention', 'option' );
	update_field( 'vat_subtext', 'One order moves through the whole business on its own. Nobody re-keys it, nobody reconciles it at quarter end.', 'option' );
	update_field( 'vat_step_1', 'E-Commerce sale', 'option' );
	update_field( 'vat_step_2', 'Warehouse fulfilment', 'option' );
	update_field( 'vat_step_3', 'Invoicing', 'option' );
	update_field( 'vat_step_4', 'Finance', 'option' );
	update_field( 'vat_step_5', 'VAT Return', 'option' );

	update_option( 'ldw_vat_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_sale_to_vat' );
add_action( 'admin_init', 'ldw_seed_sale_to_vat' );

/**
 * One-time seed of the 10 Flow Card posts (the orbit cards), in order.
 * Runs independently of ldw_seed_content() / its own flag, since this
 * CPT-based approach replaced an earlier (non-functional) repeater
 * field approach after the theme had already been activated once.
 */
function ldw_seed_flow_cards() {
	if ( get_option( 'ldw_flow_cards_seeded' ) ) {
		return;
	}
	if ( ! post_type_exists( 'flow_card' ) ) {
		return;
	}

	$cards = array(
		array( 'title' => 'CRM', 'steps' => 'Leads, contacts and pipeline', 'tint' => '#E15A58', 'icon' => 'crm' ),
		array( 'title' => 'Order to Cash', 'steps' => 'Quotes › Sales orders › Invoices › Receivables', 'tint' => '#EC956C', 'icon' => 'order-to-cash' ),
		array( 'title' => 'Procure to Pay', 'steps' => 'Quotes › Purchase orders › Bills › Payables', 'tint' => '#65BB99', 'icon' => 'procure-to-pay' ),
		array( 'title' => 'Warehouse Management', 'steps' => 'Order fulfilment: pick, pack, dispatch', 'tint' => '#59ADA8', 'icon' => 'warehouse' ),
		array( 'title' => 'E-commerce', 'steps' => 'Native Shopify and WooCommerce sync', 'tint' => '#E15A58', 'icon' => 'ecommerce' ),
		array( 'title' => 'Accounting', 'steps' => 'Ledger, banking and MTD VAT', 'tint' => '#234C5A', 'icon' => 'accounting' ),
		array( 'title' => 'Reporting', 'steps' => 'Live dashboards across every flow', 'tint' => '#EC956C', 'icon' => 'reporting' ),
		array( 'title' => 'AI integration', 'steps' => 'Gemini-assisted data and insight', 'tint' => '#3E9994', 'icon' => 'ai' ),
		array( 'title' => 'Field Service', 'steps' => 'Jobs, engineers and scheduling', 'tint' => '#65BB99', 'icon' => 'field-service' ),
		array( 'title' => 'Recycling', 'steps' => 'Purchase › Collection › Packaging › Shipping › Tracking', 'tint' => '#3E9994', 'icon' => 'recycling' ),
	);

	foreach ( $cards as $i => $card ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'flow_card',
				'post_title'  => $card['title'],
				'post_status' => 'publish',
				'menu_order'  => $i,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_field( 'steps', $card['steps'], $post_id );
			update_field( 'tint', $card['tint'], $post_id );
			update_field( 'icon', $card['icon'], $post_id );
		}
	}

	update_option( 'ldw_flow_cards_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_flow_cards' );
add_action( 'admin_init', 'ldw_seed_flow_cards' );

/**
 * One-time seed of the CTA band ("Don't just take our word for it").
 */
function ldw_seed_cta_band() {
	if ( get_option( 'ldw_cta_band_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'cta_badge', '5.0 rated on Trustist', 'option' );
	update_field( 'cta_heading', "Don't just take our word for it.", 'option' );
	update_field( 'cta_subtext', 'Contact us for a free 14 day trial.', 'option' );
	update_field( 'cta_button_text', 'Book a no obligations demo', 'option' );
	update_field( 'cta_button_url', '#', 'option' );
	update_field( 'cta_trust_items', "14-day free trial\nNo card required\nNo obligations", 'option' );

	update_option( 'ldw_cta_band_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_cta_band' );
add_action( 'admin_init', 'ldw_seed_cta_band' );

/**
 * One-time seed of the features journey ("Tailored flows...") section.
 */
function ldw_seed_features_journey() {
	if ( get_option( 'ldw_journey_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'journey_heading', "Tailored flows for every part\nof your teams' day", 'option' );
	update_field( 'journey_subtext', 'Keep your business organised and connected. Plan, structure and track remote work with one full-service platform.', 'option' );

	update_field( 'journey_card_1_label', 'Step 01 · Oversee', 'option' );
	update_field( 'journey_card_1_title', 'We take care of the little things so you can focus on the big picture', 'option' );
	update_field( 'journey_card_1_text', "A mid-flight overview of your business' activity and performance, in real time.", 'option' );
	update_field( 'journey_card_1_items', "Improved communication\nIncreased efficiency\nData insights", 'option' );
	update_field( 'journey_card_1_theme', 'dark', 'option' );

	update_field( 'journey_card_2_label', 'Step 02 · Streamline', 'option' );
	update_field( 'journey_card_2_title', 'Streamline work for maximum productivity', 'option' );
	update_field( 'journey_card_2_text', "Unlike traditional CRM software, it's a completely mobile application, with better sales management, smarter production planning, richer reporting.", 'option' );
	update_field( 'journey_card_2_items', "Better sales management\nSmarter production planning\nRicher reporting", 'option' );
	update_field( 'journey_card_2_theme', 'peach', 'option' );

	update_field( 'journey_card_3_label', 'Step 03 · Secure', 'option' );
	update_field( 'journey_card_3_title', 'Your best work, on a secure platform', 'option' );
	update_field( 'journey_card_3_text', "Built on Amazon's cloud services so your data is backed up securely, all activity end-to-end encrypted, with flexibility and control.", 'option' );
	update_field( 'journey_card_3_items', "Enhanced flexibility and control\nTime-Saving\nGreater Transparency", 'option' );
	update_field( 'journey_card_3_theme', 'mint', 'option' );

	update_option( 'ldw_journey_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_features_journey' );
add_action( 'admin_init', 'ldw_seed_features_journey' );

/**
 * One-time seed of the integrations section: heading/subtext plus the
 * five tiles from the source design. Logos are left empty so each tile
 * falls back to its name until the admin uploads artwork.
 */
function ldw_seed_integrations() {
	if ( get_option( 'ldw_integrations_seeded' ) ) {
		return;
	}
	if ( ! post_type_exists( 'integration' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'int_heading', 'Integrates with the systems you already run on', 'option' );
	update_field( 'int_subtext', 'Two-way sync for products, customers, suppliers, invoices and warehouse management. Set it up once and the data stays in step.', 'option' );

	foreach ( array( 'NetSuite', 'Xero', 'Intuit QuickBooks', 'WooCommerce', 'Shopify' ) as $i => $name ) {
		wp_insert_post(
			array(
				'post_type'   => 'integration',
				'post_title'  => $name,
				'post_status' => 'publish',
				'menu_order'  => $i,
			)
		);
	}

	update_option( 'ldw_integrations_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_integrations' );
add_action( 'admin_init', 'ldw_seed_integrations' );

/**
 * One-time seed of the comparison section: chrome plus the seven rows
 * from the source design.
 */
function ldw_seed_comparison() {
	if ( get_option( 'ldw_comparison_seeded' ) ) {
		return;
	}
	if ( ! post_type_exists( 'compare_feature' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'compare_eyebrow', 'How the platforms compare', 'option' );
	update_field( 'compare_heading', 'NetSuite capability. Xero-level price.', 'option' );
	update_field( 'compare_col_label', 'Feature coverage', 'option' );
	update_field( 'compare_plan_1_name', 'LD Workflows', 'option' );
	update_field( 'compare_plan_2_name', 'NetSuite', 'option' );
	update_field( 'compare_plan_3_name', 'Xero + apps', 'option' );
	update_field( 'compare_summary_label', 'The honest summary', 'option' );
	update_field( 'compare_summary_text', "Xero is cheaper, but it's accounting software, not an ERP. You'll still need a separate inventory tool, a Shopify connector and a manual MTD process. NetSuite does everything we do, but costs 10 to 30× more and takes months to implement.", 'option' );
	update_field( 'compare_summary_highlight', "We're the only platform purpose-built for UK Shopify merchants that closes the full loop.", 'option' );

	$rows = array(
		array( 'MTD VAT native', 'yes', 'Add-on', 'Partial' ),
		array( 'Shopify deep sync', 'yes', '3rd party', 'Basic' ),
		array( 'Inventory management', 'yes', 'yes', 'Not included' ),
		array( 'CRM included', 'yes', 'Basic', 'Not included' ),
		array( 'Order → invoice automation', 'yes', 'Config', 'Not included' ),
		array( 'Go-live time', 'Days', 'Months', 'Hours' ),
	);

	foreach ( $rows as $i => $row ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'compare_feature',
				'post_title'  => $row[0],
				'post_status' => 'publish',
				'menu_order'  => $i,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_field( 'plan_1', $row[1], $post_id );
			update_field( 'plan_2', $row[2], $post_id );
			update_field( 'plan_3', $row[3], $post_id );
		}
	}

	update_option( 'ldw_comparison_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_comparison' );
add_action( 'admin_init', 'ldw_seed_comparison' );

/**
 * One-time seed of the CRM comparison section and its three plan cards.
 */
function ldw_seed_crm_cards() {
	if ( get_option( 'ldw_crm_seeded' ) ) {
		return;
	}
	if ( ! post_type_exists( 'crm_card' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'crm_eyebrow', 'CRM: you vs HubSpot & Pipedrive', 'option' );
	update_field( 'crm_heading', 'A CRM that can actually see your money.', 'option' );
	update_field( 'crm_quote_lead', 'HubSpot and Pipedrive see contacts.', 'option' );
	update_field( 'crm_quote_text', 'We see contacts and their order history, outstanding invoices and inventory availability, in one place, in real time. No integrations, no sync delays.', 'option' );

	$cards = array(
		array(
			'title'    => 'Your ERP CRM',
			'badge'    => 'Your platform',
			'subtitle' => 'CRM with live financial context',
			'theme'    => 'own',
			'rows'     => "Order history in CRM | Live from ERP ✓
Invoice status | Real-time ✓
Inventory visibility | Native ✓
Single platform | No integration ✓
Shopify data in CRM | Automatic ✓
Pricing | Bundled ✓",
		),
		array(
			'title'    => 'HubSpot',
			'badge'    => 'Competitor',
			'subtitle' => 'Marketing-heavy CRM suite',
			'theme'    => 'competitor',
			'rows'     => "Order history in CRM | Integration needed
Invoice status | 3rd-party sync
Inventory visibility | Not native
Single platform | Stack required
Shopify data in CRM | App available
Pricing | £400 to £3k+/mo",
		),
		array(
			'title'    => 'Pipedrive',
			'badge'    => 'Competitor',
			'subtitle' => 'Sales pipeline CRM',
			'theme'    => 'competitor',
			'rows'     => "Order history in CRM | Integration needed
Invoice status | Xero / QB sync req.
Inventory visibility | Not available
Single platform | Stack required
Shopify data in CRM | Manual / Zapier
Pricing | £15 to £60/user/mo",
		),
	);

	foreach ( $cards as $i => $card ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'crm_card',
				'post_title'  => $card['title'],
				'post_status' => 'publish',
				'menu_order'  => $i,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_field( 'badge', $card['badge'], $post_id );
			update_field( 'subtitle', $card['subtitle'], $post_id );
			update_field( 'theme', $card['theme'], $post_id );
			update_field( 'rows', $card['rows'], $post_id );
		}
	}

	update_option( 'ldw_crm_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_crm_cards' );
add_action( 'admin_init', 'ldw_seed_crm_cards' );

/**
 * One-time seed of the case study section.
 */
function ldw_seed_case_study() {
	if ( get_option( 'ldw_case_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'case_heading', 'Real teams, real results', 'option' );
	update_field( 'case_subtext', 'How one customer transformed their daily operations.', 'option' );
	update_field( 'case_quote', '“We cut manual VAT work by [62%] and doubled the order volume our team can handle, without adding headcount.”', 'option' );
	update_field( 'case_attribution', 'Operations Director, Harbour & Co.', 'option' );
	update_field( 'case_cta_text', 'Read the case study', 'option' );
	update_field( 'case_cta_url', '#', 'option' );
	update_field( 'case_stats', "62% | less manual VAT work
3.5h | saved per day
2× | order capacity
0 | extra headcount", 'option' );

	update_option( 'ldw_case_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_case_study' );
add_action( 'admin_init', 'ldw_seed_case_study' );

/**
 * One-time seed of the Resources section chrome. The cards themselves
 * are blog posts, written by the editor.
 */
function ldw_seed_resources() {
	if ( get_option( 'ldw_resources_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'res_heading', 'Resources', 'option' );
	update_field( 'res_subtext', "We'll get you up and running in no time.", 'option' );
	update_field( 'res_count', 8, 'option' );

	update_option( 'ldw_resources_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_resources' );
add_action( 'admin_init', 'ldw_seed_resources' );

/**
 * One-time seed of the demo CTA section.
 */
function ldw_seed_demo_cta() {
	if ( get_option( 'ldw_demo_cta_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'demo_heading', 'See LD Workflows [in action].', 'option' );
	update_field( 'demo_subtext', 'Contact us for a free 14-day trial. No obligations, no card required. Just your workflows, running smoother.', 'option' );
	update_field( 'demo_primary_text', 'Book a no-obligations demo', 'option' );
	update_field( 'demo_primary_url', '#contact', 'option' );
	update_field( 'demo_secondary_text', 'Start free trial', 'option' );
	update_field( 'demo_secondary_url', '#', 'option' );
	update_field( 'demo_stats', "5.0★ | Rated on Trustist by teams who run on our flows
14 | Days of full access, free. No card, no obligations
1:1 | Guided walkthrough with a workflow specialist", 'option' );

	update_option( 'ldw_demo_cta_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_demo_cta' );
add_action( 'admin_init', 'ldw_seed_demo_cta' );

/**
 * One-time seed of the footer.
 */
function ldw_seed_footer() {
	if ( get_option( 'ldw_footer_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'footer_heading', 'Ready to run everything on one flow?', 'option' );
	update_field( 'footer_primary_text', 'Book a demo', 'option' );
	update_field( 'footer_primary_url', '#contact', 'option' );
	update_field( 'footer_secondary_text', 'Start free trial', 'option' );
	update_field( 'footer_secondary_url', '#contact', 'option' );
	update_field( 'footer_copyright', 'All rights reserved © 2026 LD Workflows', 'option' );
	update_field( 'footer_legal', "Terms of Service | #\nCookies Policy | #\nPrivacy Policy | #", 'option' );
	update_field( 'footer_wordmark', 'ldworkflows', 'option' );

	update_option( 'ldw_footer_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_footer' );
add_action( 'admin_init', 'ldw_seed_footer' );

/**
 * One-time seed of the pricing page: hero, plans section chrome + the
 * three plan cards, "You vs NetSuite" section + its two cards, and the
 * FAQ section + its seven questions.
 */
function ldw_seed_pricing_page() {
	if ( get_option( 'ldw_pricing_page_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'pricing_hero_eyebrow', 'Pricing & plans', 'option' );
	update_field( 'pricing_hero_heading', 'Everything from Shopify order to VAT return.', 'option' );
	update_field( 'pricing_hero_highlight', 'No enterprise price tag.', 'option' );
	update_field( 'pricing_hero_subtext', 'One platform: full ERP, accounting, inventory, CRM and MTD VAT filing, built for UK merchants.', 'option' );
	update_field( 'pricing_hero_primary_text', 'Start free trial', 'option' );
	update_field( 'pricing_hero_primary_url', '#plans', 'option' );
	update_field( 'pricing_hero_secondary_text', 'Book a demo', 'option' );
	update_field( 'pricing_hero_secondary_url', '#contact', 'option' );

	update_field( 'plans_intro', 'Choose monthly for flexibility, or annual to get two months free. Switch whenever you like.', 'option' );
	update_field( 'plans_monthly_label', 'Monthly', 'option' );
	update_field( 'plans_annual_label', 'Annual', 'option' );
	update_field( 'plans_annual_badge', '2 months free', 'option' );
	update_field( 'plans_price_note_monthly', 'per month, billed monthly', 'option' );
	update_field( 'plans_price_note_annual', 'per month, billed annually · {badge}', 'option' );
	update_field( 'plans_footnote', 'All plans include a <strong>14-day free trial</strong> and <strong>free migration</strong> from Xero, QuickBooks or spreadsheets. No credit card required.', 'option' );

	update_field( 'vs_eyebrow', 'You vs NetSuite', 'option' );
	update_field( 'final_cta_heading', "Don't just take our word for it.", 'option' );
	update_field( 'final_cta_accent', 'Try it free for 14 days.', 'option' );
	update_field( 'final_cta_primary_text', 'Start free trial', 'option' );
	update_field( 'final_cta_primary_url', '#plans', 'option' );
	update_field( 'final_cta_secondary_text', 'Book a demo', 'option' );
	update_field( 'final_cta_secondary_url', '#contact', 'option' );
	update_field( 'vs_heading', 'Live in days, not months, for a fraction of the cost.', 'option' );
	update_field( 'vs_quote_text', "<strong>NetSuite does everything we do</strong>, but costs 10 to 30× more and takes months to implement. We're live in days, for a fraction of the cost. No consultants, no connectors.", 'option' );

	update_field( 'faq_heading', 'Frequently asked questions', 'option' );

	if ( post_type_exists( 'pricing_plan' ) ) {
		$plans = array(
			array(
				'title'         => 'Starter',
				'badge'         => 'Starter',
				'subtitle'      => 'Shopify merchants outgrowing spreadsheets',
				'price_monthly' => '£130',
				'price_annual'  => '£108',
				'cta_text'      => 'Start free trial',
				'cta_url'       => '#',
				'featured'      => false,
				'features'      => "Shopify sync: orders, refunds, products\nAutomated invoicing\nInventory management\nMTD VAT filing to HMRC\nCore accounting & P&L\nUp to 500 orders / month\n3 users included\n✕ CRM\n✕ Multi-warehouse",
			),
			array(
				'title'         => 'Growth',
				'badge'         => 'Most popular',
				'subtitle'      => 'The complete platform for scaling merchants',
				'price_monthly' => '£299',
				'price_annual'  => '£249',
				'cta_text'      => 'Start free trial',
				'cta_url'       => '#',
				'featured'      => true,
				'features'      => "Everything in Starter\nFull CRM with order history\nMulti-warehouse inventory\nAdvanced reporting & dashboards\nPurchase orders & supplier management\nUp to 2,000 orders / month\n8 users included\nEmail & chat support",
			),
			array(
				'title'         => 'Scale',
				'badge'         => 'Scale',
				'subtitle'      => 'High-volume & multi-entity businesses',
				'price_monthly' => '£599',
				'price_annual'  => '£499',
				'cta_text'      => 'Talk to sales',
				'cta_url'       => '#',
				'featured'      => false,
				'features'      => "Everything in Growth\nMulti-entity & multi-currency\nUnlimited orders\nAPI access & webhooks\nCustom roles & permissions\nDedicated onboarding manager\nUnlimited users\nPhone & priority support",
			),
		);

		foreach ( $plans as $i => $plan ) {
			$post_id = wp_insert_post(
				array(
					'post_type'   => 'pricing_plan',
					'post_title'  => $plan['title'],
					'post_status' => 'publish',
					'menu_order'  => $i,
				)
			);
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_field( 'badge', $plan['badge'], $post_id );
				update_field( 'subtitle', $plan['subtitle'], $post_id );
				update_field( 'price_monthly', $plan['price_monthly'], $post_id );
				update_field( 'price_annual', $plan['price_annual'], $post_id );
				update_field( 'cta_text', $plan['cta_text'], $post_id );
				update_field( 'cta_url', $plan['cta_url'], $post_id );
				update_field( 'featured', $plan['featured'], $post_id );
				update_field( 'features', $plan['features'], $post_id );
			}
		}
	}

	if ( post_type_exists( 'vs_card' ) ) {
		$vs_cards = array(
			array(
				'title'    => 'LD Workflows',
				'badge'    => 'Your platform',
				'subtitle' => 'UK-native ERP for Shopify merchants',
				'theme'    => 'own',
				'rows'     => "Go-live time | Days\nTypical annual cost | £3k to £10k\nMTD VAT filing | Native\nShopify sync | Native, real-time\nImplementation consultants | Not needed\nBuilt for | UK Shopify SMEs",
			),
			array(
				'title'    => 'NetSuite',
				'badge'    => 'Competitor',
				'subtitle' => 'Enterprise ERP suite',
				'theme'    => 'competitor',
				'rows'     => "Go-live time | 3 to 12 months\nTypical annual cost | £30k to £100k+\nMTD VAT filing | Add-on module\nShopify sync | 3rd-party connector\nImplementation consultants | Required\nBuilt for | Large enterprises",
			),
		);

		foreach ( $vs_cards as $i => $card ) {
			$post_id = wp_insert_post(
				array(
					'post_type'   => 'vs_card',
					'post_title'  => $card['title'],
					'post_status' => 'publish',
					'menu_order'  => $i,
				)
			);
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_field( 'badge', $card['badge'], $post_id );
				update_field( 'subtitle', $card['subtitle'], $post_id );
				update_field( 'theme', $card['theme'], $post_id );
				update_field( 'rows', $card['rows'], $post_id );
			}
		}
	}

	if ( post_type_exists( 'pricing_faq' ) ) {
		$faqs = array(
			array( 'q' => 'Can I switch plans as I grow?', 'a' => 'Yes, upgrade or downgrade at any time from your account settings. Upgrades apply immediately and we pro-rate the difference; downgrades take effect at your next billing date.' ),
			array( 'q' => 'What happens if I exceed my order limit?', 'a' => "Nothing breaks. We'll keep processing your orders and simply get in touch to move you to the right plan. You'll never lose data or have orders blocked mid-month." ),
			array( 'q' => 'How does the free migration work?', 'a' => 'Our onboarding team imports your products, customers, open orders and account balances from Xero, QuickBooks or spreadsheets, typically within a few days, at no cost on any plan.' ),
			array( 'q' => 'Is MTD VAT filing really included?', 'a' => 'Yes. HMRC-recognised Making Tax Digital VAT filing is built into every plan, including Starter, with no bridging software or add-ons needed.' ),
			array( 'q' => 'Do I need a separate accounting tool?', 'a' => "No. Core accounting, P&L and VAT are part of the platform. Most customers replace Xero or QuickBooks entirely; if you'd rather keep them, we can run alongside during transition." ),
			array( 'q' => "What's the difference from Xero or QuickBooks?", 'a' => "They're accounting software. LD Workflows is a full ERP: accounting plus live inventory, order automation, CRM and Shopify sync in one system, with no connectors or app stack required." ),
			array( 'q' => 'Can my accountant access the platform?', 'a' => 'Yes, accountant seats are free on every plan, with role-based access to the reports and VAT records they need.' ),
		);

		foreach ( $faqs as $i => $faq ) {
			wp_insert_post(
				array(
					'post_type'    => 'pricing_faq',
					'post_title'   => $faq['q'],
					'post_content' => $faq['a'],
					'post_status'  => 'publish',
					'menu_order'   => $i,
				)
			);
		}
	}

	// Create the Pricing page itself, if it doesn't already exist.
	if ( ! get_page_by_path( 'pricing' ) ) {
		wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_title'  => 'Pricing',
				'post_name'   => 'pricing',
				'post_status' => 'publish',
			)
		);
	}

	update_option( 'ldw_pricing_page_seeded', 1 );
}
add_action( 'after_switch_theme', 'ldw_seed_pricing_page' );
add_action( 'admin_init', 'ldw_seed_pricing_page' );
