<?php
/**
 * ACF field group registration + admin UI.
 *
 * Hero section content is stored against the 'option' pseudo-post-id
 * (via get_field/update_field(..., 'option')) and edited through a
 * custom admin page built with acf_form(). We deliberately do NOT use
 * acf_add_options_page() — that helper is ACF PRO only and silently does
 * nothing on the free plugin, which would leave these fields with no
 * admin UI at all despite the data layer working.
 *
 * The orbit flow cards are NOT stored here — repeater fields are also
 * ACF PRO only (acf_get_field_types() confirms 'repeater' isn't
 * registered on the free plugin; it rendered an empty, non-functional
 * input with no error). They're managed instead as a "Flow Card" CPT —
 * see inc/flow-cards-cpt.php — which gives per-item management plus
 * ordering using only core WordPress + free ACF.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return; // ACF not active yet.
}

/**
 * "Theme Content" admin page for the hero section. acf_form_head() is
 * hooked to this page's 'load-{hook}' action, which is the correct/only
 * reliable place to call it (it must run before any HTML, including the
 * WP admin chrome, is sent).
 */
add_action(
	'admin_menu',
	function () {
		$hook = add_menu_page(
			'Theme Content',
			'Theme Content',
			'edit_posts',
			'theme-content',
			'ldw_render_hero_section_page',
			'dashicons-admin-customizer',
			3
		);
		add_action( "load-{$hook}", 'acf_form_head' );

		$vat_hook = add_submenu_page(
			'theme-content',
			'Sale to VAT Section',
			'Sale to VAT Section',
			'edit_posts',
			'theme-content-sale-to-vat',
			'ldw_render_sale_to_vat_page'
		);
		add_action( "load-{$vat_hook}", 'acf_form_head' );

		$cta_hook = add_submenu_page(
			'theme-content',
			'CTA Band Section',
			'CTA Band Section',
			'edit_posts',
			'theme-content-cta-band',
			'ldw_render_cta_band_page'
		);
		add_action( "load-{$cta_hook}", 'acf_form_head' );

		$journey_hook = add_submenu_page(
			'theme-content',
			'Features Journey Section',
			'Features Journey Section',
			'edit_posts',
			'theme-content-features-journey',
			'ldw_render_features_journey_page'
		);
		add_action( "load-{$journey_hook}", 'acf_form_head' );

		$int_hook = add_submenu_page(
			'theme-content',
			'Integrations Section',
			'Integrations Section',
			'edit_posts',
			'theme-content-integrations',
			'ldw_render_integrations_page'
		);
		add_action( "load-{$int_hook}", 'acf_form_head' );

		$cmp_hook = add_submenu_page(
			'theme-content',
			'Comparison Section',
			'Comparison Section',
			'edit_posts',
			'theme-content-comparison',
			'ldw_render_comparison_page'
		);
		add_action( "load-{$cmp_hook}", 'acf_form_head' );

		$crm_hook = add_submenu_page(
			'theme-content',
			'CRM Comparison Section',
			'CRM Comparison Section',
			'edit_posts',
			'theme-content-crm',
			'ldw_render_crm_page'
		);
		add_action( "load-{$crm_hook}", 'acf_form_head' );

		$case_hook = add_submenu_page(
			'theme-content',
			'Case Study Section',
			'Case Study Section',
			'edit_posts',
			'theme-content-case-study',
			'ldw_render_case_study_page'
		);
		add_action( "load-{$case_hook}", 'acf_form_head' );

		$res_hook = add_submenu_page(
			'theme-content',
			'Resources Section',
			'Resources Section',
			'edit_posts',
			'theme-content-resources',
			'ldw_render_resources_page'
		);
		add_action( "load-{$res_hook}", 'acf_form_head' );

		$demo_hook = add_submenu_page(
			'theme-content',
			'Demo CTA Section',
			'Demo CTA Section',
			'edit_posts',
			'theme-content-demo-cta',
			'ldw_render_demo_cta_page'
		);
		add_action( "load-{$demo_hook}", 'acf_form_head' );

		$footer_hook = add_submenu_page(
			'theme-content',
			'Footer',
			'Footer',
			'edit_posts',
			'theme-content-footer',
			'ldw_render_footer_page'
		);
		add_action( "load-{$footer_hook}", 'acf_form_head' );

		$pricing_hero_hook = add_submenu_page(
			'theme-content',
			'Pricing Hero',
			'Pricing Hero',
			'edit_posts',
			'theme-content-pricing-hero',
			'ldw_render_pricing_hero_page'
		);
		add_action( "load-{$pricing_hero_hook}", 'acf_form_head' );

		$pricing_plans_hook = add_submenu_page(
			'theme-content',
			'Pricing Plans Section',
			'Pricing Plans Section',
			'edit_posts',
			'theme-content-pricing-plans',
			'ldw_render_pricing_plans_page'
		);
		add_action( "load-{$pricing_plans_hook}", 'acf_form_head' );

		$vs_hook = add_submenu_page(
			'theme-content',
			'You vs NetSuite Section',
			'You vs NetSuite Section',
			'edit_posts',
			'theme-content-vs-netsuite',
			'ldw_render_vs_netsuite_page'
		);
		add_action( "load-{$vs_hook}", 'acf_form_head' );

		$pricing_faq_hook = add_submenu_page(
			'theme-content',
			'Pricing FAQ Section',
			'Pricing FAQ Section',
			'edit_posts',
			'theme-content-pricing-faq',
			'ldw_render_pricing_faq_page'
		);
		add_action( "load-{$pricing_faq_hook}", 'acf_form_head' );

		$final_cta_hook = add_submenu_page(
			'theme-content',
			'Final CTA',
			'Final CTA',
			'edit_posts',
			'theme-content-final-cta',
			'ldw_render_final_cta_page'
		);
		add_action( "load-{$final_cta_hook}", 'acf_form_head' );

		$crm_hero_hook = add_submenu_page(
			'theme-content',
			'CRM Hero',
			'CRM Hero',
			'edit_posts',
			'theme-content-crm-hero',
			'ldw_render_crm_hero_page'
		);
		add_action( "load-{$crm_hero_hook}", 'acf_form_head' );

		$crm_features_hook = add_submenu_page(
			'theme-content',
			'CRM Features',
			'CRM Features',
			'edit_posts',
			'theme-content-crm-features',
			'ldw_render_crm_features_page'
		);
		add_action( "load-{$crm_features_hook}", 'acf_form_head' );

		$crm_comms_hook = add_submenu_page(
			'theme-content',
			'CRM Communications',
			'CRM Communications',
			'edit_posts',
			'theme-content-crm-comms',
			'ldw_render_crm_comms_page'
		);
		add_action( "load-{$crm_comms_hook}", 'acf_form_head' );

		$crm_benefits_hook = add_submenu_page(
			'theme-content',
			'CRM Benefits Section',
			'CRM Benefits Section',
			'edit_posts',
			'theme-content-crm-benefits',
			'ldw_render_crm_benefits_page'
		);
		add_action( "load-{$crm_benefits_hook}", 'acf_form_head' );

		$crm_final_cta_hook = add_submenu_page(
			'theme-content',
			'CRM Final CTA',
			'CRM Final CTA',
			'edit_posts',
			'theme-content-crm-final-cta',
			'ldw_render_crm_final_cta_page'
		);
		add_action( "load-{$crm_final_cta_hook}", 'acf_form_head' );

		$crm_clients_hook = add_submenu_page(
			'theme-content',
			'CRM Social Proof',
			'CRM Social Proof',
			'edit_posts',
			'theme-content-crm-clients',
			'ldw_render_crm_clients_page'
		);
		add_action( "load-{$crm_clients_hook}", 'acf_form_head' );

		$crm_groups_hook = add_submenu_page(
			'theme-content',
			'CRM Customer Groups',
			'CRM Customer Groups',
			'edit_posts',
			'theme-content-crm-groups',
			'ldw_render_crm_groups_page'
		);
		add_action( "load-{$crm_groups_hook}", 'acf_form_head' );

		$crm_flows_hook = add_submenu_page(
			'theme-content',
			'CRM Workflow Links',
			'CRM Workflow Links',
			'edit_posts',
			'theme-content-crm-flows',
			'ldw_render_crm_flows_page'
		);
		add_action( "load-{$crm_flows_hook}", 'acf_form_head' );

		$erp_hero_hook = add_submenu_page(
			'theme-content',
			'ERP Hero',
			'ERP Hero',
			'edit_posts',
			'theme-content-erp-hero',
			'ldw_render_erp_hero_page'
		);
		add_action( "load-{$erp_hero_hook}", 'acf_form_head' );

		$erp_sales_hook = add_submenu_page(
			'theme-content',
			'ERP Sales',
			'ERP Sales',
			'edit_posts',
			'theme-content-erp-sales',
			'ldw_render_erp_sales_page'
		);
		add_action( "load-{$erp_sales_hook}", 'acf_form_head' );

		$erp_warehouse_hook = add_submenu_page(
			'theme-content',
			'ERP Warehouse',
			'ERP Warehouse',
			'edit_posts',
			'theme-content-erp-warehouse',
			'ldw_render_erp_warehouse_page'
		);
		add_action( "load-{$erp_warehouse_hook}", 'acf_form_head' );

		$erp_accounting_hook = add_submenu_page(
			'theme-content',
			'ERP Accounting',
			'ERP Accounting',
			'edit_posts',
			'theme-content-erp-accounting',
			'ldw_render_erp_accounting_page'
		);
		add_action( "load-{$erp_accounting_hook}", 'acf_form_head' );

		$erp_comms_hook = add_submenu_page(
			'theme-content',
			'ERP Communications',
			'ERP Communications',
			'edit_posts',
			'theme-content-erp-comms',
			'ldw_render_erp_comms_page'
		);
		add_action( "load-{$erp_comms_hook}", 'acf_form_head' );

		$erp_benefits_hook = add_submenu_page(
			'theme-content',
			'ERP Benefits Section',
			'ERP Benefits Section',
			'edit_posts',
			'theme-content-erp-benefits',
			'ldw_render_erp_benefits_page'
		);
		add_action( "load-{$erp_benefits_hook}", 'acf_form_head' );

		$erp_final_cta_hook = add_submenu_page(
			'theme-content',
			'ERP Final CTA',
			'ERP Final CTA',
			'edit_posts',
			'theme-content-erp-final-cta',
			'ldw_render_erp_final_cta_page'
		);
		add_action( "load-{$erp_final_cta_hook}", 'acf_form_head' );

		$service_hero_hook = add_submenu_page(
			'theme-content',
			'Service Hero',
			'Service Hero',
			'edit_posts',
			'theme-content-service-hero',
			'ldw_render_service_hero_page'
		);
		add_action( "load-{$service_hero_hook}", 'acf_form_head' );

		$service_resources_hook = add_submenu_page(
			'theme-content',
			'Service Resources',
			'Service Resources',
			'edit_posts',
			'theme-content-service-resources',
			'ldw_render_service_resources_page'
		);
		add_action( "load-{$service_resources_hook}", 'acf_form_head' );

		$service_warehouse_hook = add_submenu_page(
			'theme-content',
			'Service Warehouse',
			'Service Warehouse',
			'edit_posts',
			'theme-content-service-warehouse',
			'ldw_render_service_warehouse_page'
		);
		add_action( "load-{$service_warehouse_hook}", 'acf_form_head' );

		$service_accounting_hook = add_submenu_page(
			'theme-content',
			'Service Accounting',
			'Service Accounting',
			'edit_posts',
			'theme-content-service-accounting',
			'ldw_render_service_accounting_page'
		);
		add_action( "load-{$service_accounting_hook}", 'acf_form_head' );

		$service_comms_hook = add_submenu_page(
			'theme-content',
			'Service Communications',
			'Service Communications',
			'edit_posts',
			'theme-content-service-comms',
			'ldw_render_service_comms_page'
		);
		add_action( "load-{$service_comms_hook}", 'acf_form_head' );

		$service_logistics_hook = add_submenu_page(
			'theme-content',
			'Service Logistics',
			'Service Logistics',
			'edit_posts',
			'theme-content-service-logistics',
			'ldw_render_service_logistics_page'
		);
		add_action( "load-{$service_logistics_hook}", 'acf_form_head' );

		$service_benefits_hook = add_submenu_page(
			'theme-content',
			'Service Benefits Section',
			'Service Benefits Section',
			'edit_posts',
			'theme-content-service-benefits',
			'ldw_render_service_benefits_page'
		);
		add_action( "load-{$service_benefits_hook}", 'acf_form_head' );

		$service_final_cta_hook = add_submenu_page(
			'theme-content',
			'Service Final CTA',
			'Service Final CTA',
			'edit_posts',
			'theme-content-service-final-cta',
			'ldw_render_service_final_cta_page'
		);
		add_action( "load-{$service_final_cta_hook}", 'acf_form_head' );

		$warehouse_hero_hook = add_submenu_page(
			'theme-content',
			'Warehouse Hero',
			'Warehouse Hero',
			'edit_posts',
			'theme-content-warehouse-hero',
			'ldw_render_warehouse_hero_page'
		);
		add_action( "load-{$warehouse_hero_hook}", 'acf_form_head' );

		$warehouse_goods_hook = add_submenu_page(
			'theme-content',
			'Warehouse Goods In',
			'Warehouse Goods In',
			'edit_posts',
			'theme-content-warehouse-goods',
			'ldw_render_warehouse_goods_page'
		);
		add_action( "load-{$warehouse_goods_hook}", 'acf_form_head' );

		$warehouse_picking_hook = add_submenu_page(
			'theme-content',
			'Warehouse Picking',
			'Warehouse Picking',
			'edit_posts',
			'theme-content-warehouse-picking',
			'ldw_render_warehouse_picking_page'
		);
		add_action( "load-{$warehouse_picking_hook}", 'acf_form_head' );

		$warehouse_stock_hook = add_submenu_page(
			'theme-content',
			'Warehouse Stock & Sync',
			'Warehouse Stock & Sync',
			'edit_posts',
			'theme-content-warehouse-stock',
			'ldw_render_warehouse_stock_page'
		);
		add_action( "load-{$warehouse_stock_hook}", 'acf_form_head' );

		$warehouse_benefits_hook = add_submenu_page(
			'theme-content',
			'Warehouse Benefits Section',
			'Warehouse Benefits Section',
			'edit_posts',
			'theme-content-warehouse-benefits',
			'ldw_render_warehouse_benefits_page'
		);
		add_action( "load-{$warehouse_benefits_hook}", 'acf_form_head' );

		$warehouse_final_cta_hook = add_submenu_page(
			'theme-content',
			'Warehouse Final CTA',
			'Warehouse Final CTA',
			'edit_posts',
			'theme-content-warehouse-final-cta',
			'ldw_render_warehouse_final_cta_page'
		);
		add_action( "load-{$warehouse_final_cta_hook}", 'acf_form_head' );

		$ecommerce_hero_hook = add_submenu_page(
			'theme-content',
			'E-commerce Hero',
			'E-commerce Hero',
			'edit_posts',
			'theme-content-ecommerce-hero',
			'ldw_render_ecommerce_hero_page'
		);
		add_action( "load-{$ecommerce_hero_hook}", 'acf_form_head' );

		$ecommerce_storefront_hook = add_submenu_page(
			'theme-content',
			'E-commerce Storefront',
			'E-commerce Storefront',
			'edit_posts',
			'theme-content-ecommerce-storefront',
			'ldw_render_ecommerce_storefront_page'
		);
		add_action( "load-{$ecommerce_storefront_hook}", 'acf_form_head' );

		$ecommerce_orders_hook = add_submenu_page(
			'theme-content',
			'E-commerce Orders',
			'E-commerce Orders',
			'edit_posts',
			'theme-content-ecommerce-orders',
			'ldw_render_ecommerce_orders_page'
		);
		add_action( "load-{$ecommerce_orders_hook}", 'acf_form_head' );

		$ecommerce_finance_hook = add_submenu_page(
			'theme-content',
			'E-commerce Finance',
			'E-commerce Finance',
			'edit_posts',
			'theme-content-ecommerce-finance',
			'ldw_render_ecommerce_finance_page'
		);
		add_action( "load-{$ecommerce_finance_hook}", 'acf_form_head' );

		$ecommerce_benefits_hook = add_submenu_page(
			'theme-content',
			'E-commerce Benefits Section',
			'E-commerce Benefits Section',
			'edit_posts',
			'theme-content-ecommerce-benefits',
			'ldw_render_ecommerce_benefits_page'
		);
		add_action( "load-{$ecommerce_benefits_hook}", 'acf_form_head' );

		$ecommerce_final_cta_hook = add_submenu_page(
			'theme-content',
			'E-commerce Final CTA',
			'E-commerce Final CTA',
			'edit_posts',
			'theme-content-ecommerce-final-cta',
			'ldw_render_ecommerce_final_cta_page'
		);
		add_action( "load-{$ecommerce_final_cta_hook}", 'acf_form_head' );

		$ai_hero_hook = add_submenu_page(
			'theme-content',
			'AI Integration Hero',
			'AI Integration Hero',
			'edit_posts',
			'theme-content-ai-hero',
			'ldw_render_ai_hero_page'
		);
		add_action( "load-{$ai_hero_hook}", 'acf_form_head' );

		$ai_insight_hook = add_submenu_page(
			'theme-content',
			'AI Insight',
			'AI Insight',
			'edit_posts',
			'theme-content-ai-insight',
			'ldw_render_ai_insight_page'
		);
		add_action( "load-{$ai_insight_hook}", 'acf_form_head' );

		$ai_data_hook = add_submenu_page(
			'theme-content',
			'AI Data',
			'AI Data',
			'edit_posts',
			'theme-content-ai-data',
			'ldw_render_ai_data_page'
		);
		add_action( "load-{$ai_data_hook}", 'acf_form_head' );

		$ai_security_hook = add_submenu_page(
			'theme-content',
			'AI Security',
			'AI Security',
			'edit_posts',
			'theme-content-ai-security',
			'ldw_render_ai_security_page'
		);
		add_action( "load-{$ai_security_hook}", 'acf_form_head' );

		$ai_benefits_hook = add_submenu_page(
			'theme-content',
			'AI Benefits Section',
			'AI Benefits Section',
			'edit_posts',
			'theme-content-ai-benefits',
			'ldw_render_ai_benefits_page'
		);
		add_action( "load-{$ai_benefits_hook}", 'acf_form_head' );

		$ai_final_cta_hook = add_submenu_page(
			'theme-content',
			'AI Final CTA',
			'AI Final CTA',
			'edit_posts',
			'theme-content-ai-final-cta',
			'ldw_render_ai_final_cta_page'
		);
		add_action( "load-{$ai_final_cta_hook}", 'acf_form_head' );

		$o2c_hero_hook = add_submenu_page(
			'theme-content',
			'Order to Cash Hero',
			'Order to Cash Hero',
			'edit_posts',
			'theme-content-o2c-hero',
			'ldw_render_o2c_hero_page'
		);
		add_action( "load-{$o2c_hero_hook}", 'acf_form_head' );

		$o2c_quotes_hook = add_submenu_page(
			'theme-content',
			'Order to Cash Quotes',
			'Order to Cash Quotes',
			'edit_posts',
			'theme-content-o2c-quotes',
			'ldw_render_o2c_quotes_page'
		);
		add_action( "load-{$o2c_quotes_hook}", 'acf_form_head' );

		$o2c_fulfilment_hook = add_submenu_page(
			'theme-content',
			'Order to Cash Fulfilment',
			'Order to Cash Fulfilment',
			'edit_posts',
			'theme-content-o2c-fulfilment',
			'ldw_render_o2c_fulfilment_page'
		);
		add_action( "load-{$o2c_fulfilment_hook}", 'acf_form_head' );

		$o2c_receivables_hook = add_submenu_page(
			'theme-content',
			'Order to Cash Receivables',
			'Order to Cash Receivables',
			'edit_posts',
			'theme-content-o2c-receivables',
			'ldw_render_o2c_receivables_page'
		);
		add_action( "load-{$o2c_receivables_hook}", 'acf_form_head' );

		$o2c_benefits_hook = add_submenu_page(
			'theme-content',
			'Order to Cash Benefits Section',
			'Order to Cash Benefits Section',
			'edit_posts',
			'theme-content-o2c-benefits',
			'ldw_render_o2c_benefits_page'
		);
		add_action( "load-{$o2c_benefits_hook}", 'acf_form_head' );

		$o2c_final_cta_hook = add_submenu_page(
			'theme-content',
			'Order to Cash Final CTA',
			'Order to Cash Final CTA',
			'edit_posts',
			'theme-content-o2c-final-cta',
			'ldw_render_o2c_final_cta_page'
		);
		add_action( "load-{$o2c_final_cta_hook}", 'acf_form_head' );

		$p2p_hero_hook = add_submenu_page(
			'theme-content',
			'Procure to Pay Hero',
			'Procure to Pay Hero',
			'edit_posts',
			'theme-content-p2p-hero',
			'ldw_render_p2p_hero_page'
		);
		add_action( "load-{$p2p_hero_hook}", 'acf_form_head' );

		$p2p_orders_hook = add_submenu_page(
			'theme-content',
			'Procure to Pay Orders',
			'Procure to Pay Orders',
			'edit_posts',
			'theme-content-p2p-orders',
			'ldw_render_p2p_orders_page'
		);
		add_action( "load-{$p2p_orders_hook}", 'acf_form_head' );

		$p2p_goodsin_hook = add_submenu_page(
			'theme-content',
			'Procure to Pay Goods In',
			'Procure to Pay Goods In',
			'edit_posts',
			'theme-content-p2p-goodsin',
			'ldw_render_p2p_goodsin_page'
		);
		add_action( "load-{$p2p_goodsin_hook}", 'acf_form_head' );

		$p2p_payables_hook = add_submenu_page(
			'theme-content',
			'Procure to Pay Payables',
			'Procure to Pay Payables',
			'edit_posts',
			'theme-content-p2p-payables',
			'ldw_render_p2p_payables_page'
		);
		add_action( "load-{$p2p_payables_hook}", 'acf_form_head' );

		$p2p_benefits_hook = add_submenu_page(
			'theme-content',
			'Procure to Pay Benefits Section',
			'Procure to Pay Benefits Section',
			'edit_posts',
			'theme-content-p2p-benefits',
			'ldw_render_p2p_benefits_page'
		);
		add_action( "load-{$p2p_benefits_hook}", 'acf_form_head' );

		$p2p_final_cta_hook = add_submenu_page(
			'theme-content',
			'Procure to Pay Final CTA',
			'Procure to Pay Final CTA',
			'edit_posts',
			'theme-content-p2p-final-cta',
			'ldw_render_p2p_final_cta_page'
		);
		add_action( "load-{$p2p_final_cta_hook}", 'acf_form_head' );
	}
);

function ldw_render_hero_section_page() {
	?>
	<div class="wrap">
		<h1>Hero Section</h1>
		<p>Manage the orbit flow cards under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=flow_card' ) ); ?>">Flow Cards</a> in the main menu.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_hero_section' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Hero section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_sale_to_vat_page() {
	?>
	<div class="wrap">
		<h1>Sale to VAT Section</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_sale_to_vat' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Sale to VAT section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_cta_band_page() {
	?>
	<div class="wrap">
		<h1>CTA Band Section</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_cta_band' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CTA band section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_features_journey_page() {
	?>
	<div class="wrap">
		<h1>Features Journey Section</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_features_journey' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Features journey section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_integrations_page() {
	?>
	<div class="wrap">
		<h1>Integrations Section</h1>
		<p>Add, remove, reorder and upload logos under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=integration' ) ); ?>">Integrations</a> in the main menu. The grid shows however many are published.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_integrations' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Integrations section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_comparison_page() {
	?>
	<div class="wrap">
		<h1>Comparison Section</h1>
		<p>Add, remove and reorder the table rows under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=compare_feature' ) ); ?>">Comparison Rows</a> in the main menu. Each row holds one value per plan column named below.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_comparison' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Comparison section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_page() {
	?>
	<div class="wrap">
		<h1>CRM Comparison Section</h1>
		<p>Add, remove and reorder the plan cards under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=crm_card' ) ); ?>">CRM Cards</a> in the main menu. Each card carries its own list of rows.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_section' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM comparison section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_case_study_page() {
	?>
	<div class="wrap">
		<h1>Case Study Section</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_case_study' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Case study section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_resources_page() {
	?>
	<div class="wrap">
		<h1>Resources Section</h1>
		<p>The Resources grid is your blog. Write them under <a href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>">Posts</a> &mdash; each post becomes a card and links to its own page. A post with a featured image renders as a photo card; without one it renders as a flat tinted card.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_resources' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Resources section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_demo_cta_page() {
	?>
	<div class="wrap">
		<h1>Demo CTA Section</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_demo_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Demo CTA section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_footer_page() {
	?>
	<div class="wrap">
		<h1>Footer</h1>
		<p>The footer link row is a WordPress menu &mdash; edit it under <a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">Appearance &rsaquo; Menus</a>, on the menu assigned to &ldquo;Footer Navigation&rdquo;.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_footer' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Footer updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_clients_page() {
	?>
	<div class="wrap">
		<h1>CRM Social Proof</h1>
		<p>Client logos are managed under CRM Clients in the main menu. The section stays hidden until at least one logo is added.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_clients' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM social proof updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_groups_page() {
	?>
	<div class="wrap">
		<h1>CRM Customer Groups</h1>
		<p>The "Grouping of customers" checklist. One item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_groups' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM customer groups updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_flows_page() {
	?>
	<div class="wrap">
		<h1>CRM Workflow Links</h1>
		<p>Heading only — add or reorder the cards under CRM Workflow Cards in the main menu.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_flows' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM workflow links updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_hero_page() {
	?>
	<div class="wrap">
		<h1>ERP Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_sales_page() {
	?>
	<div class="wrap">
		<h1>ERP Sales</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_sales' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Sales updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_warehouse_page() {
	?>
	<div class="wrap">
		<h1>ERP Warehouse</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_warehouse' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Warehouse updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_accounting_page() {
	?>
	<div class="wrap">
		<h1>ERP Accounting</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_accounting' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Accounting updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_comms_page() {
	?>
	<div class="wrap">
		<h1>ERP Communications</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_comms' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Communications updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_benefits_page() {
	?>
	<div class="wrap">
		<h1>ERP Benefits Section</h1>
		<p>Heading and intro only — add or reorder the cards under ERP Benefits in the main menu.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_erp_final_cta_page() {
	?>
	<div class="wrap">
		<h1>ERP Final CTA</h1>
		<p>The closing band at the foot of the ERP page.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_erp_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'ERP Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_hero_page() {
	?>
	<div class="wrap">
		<h1>Service Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_resources_page() {
	?>
	<div class="wrap">
		<h1>Service Resources</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_resources' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Resources updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_warehouse_page() {
	?>
	<div class="wrap">
		<h1>Service Warehouse</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_warehouse' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Warehouse updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_accounting_page() {
	?>
	<div class="wrap">
		<h1>Service Accounting</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_accounting' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Accounting updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_comms_page() {
	?>
	<div class="wrap">
		<h1>Service Communications</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_comms' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Communications updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_logistics_page() {
	?>
	<div class="wrap">
		<h1>Service Logistics</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_logistics' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Logistics updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_benefits_page() {
	?>
	<div class="wrap">
		<h1>Service Benefits Section</h1>
		<p>The cards themselves live under Service Benefits.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_service_final_cta_page() {
	?>
	<div class="wrap">
		<h1>Service Final CTA</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_service_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Service Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_warehouse_hero_page() {
	?>
	<div class="wrap">
		<h1>Warehouse Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_warehouse_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Warehouse Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_warehouse_goods_page() {
	?>
	<div class="wrap">
		<h1>Warehouse Goods In</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_warehouse_goods' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Warehouse Goods In updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_warehouse_picking_page() {
	?>
	<div class="wrap">
		<h1>Warehouse Picking</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_warehouse_picking' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Warehouse Picking updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_warehouse_stock_page() {
	?>
	<div class="wrap">
		<h1>Warehouse Stock & Sync</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_warehouse_stock' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Warehouse Stock & Sync updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_warehouse_benefits_page() {
	?>
	<div class="wrap">
		<h1>Warehouse Benefits Section</h1>
		<p>The cards themselves live under Warehouse Benefits.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_warehouse_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Warehouse Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_warehouse_final_cta_page() {
	?>
	<div class="wrap">
		<h1>Warehouse Final CTA</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_warehouse_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Warehouse Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ecommerce_hero_page() {
	?>
	<div class="wrap">
		<h1>E-commerce Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ecommerce_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'E-commerce Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ecommerce_storefront_page() {
	?>
	<div class="wrap">
		<h1>E-commerce Storefront</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ecommerce_storefront' ),
				'submit_value'    => 'Save',
				'updated_message' => 'E-commerce Storefront updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ecommerce_orders_page() {
	?>
	<div class="wrap">
		<h1>E-commerce Orders</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ecommerce_orders' ),
				'submit_value'    => 'Save',
				'updated_message' => 'E-commerce Orders updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ecommerce_finance_page() {
	?>
	<div class="wrap">
		<h1>E-commerce Finance</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ecommerce_finance' ),
				'submit_value'    => 'Save',
				'updated_message' => 'E-commerce Finance updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ecommerce_benefits_page() {
	?>
	<div class="wrap">
		<h1>E-commerce Benefits Section</h1>
		<p>The cards themselves live under E-commerce Benefits.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ecommerce_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'E-commerce Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ecommerce_final_cta_page() {
	?>
	<div class="wrap">
		<h1>E-commerce Final CTA</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ecommerce_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'E-commerce Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ai_hero_page() {
	?>
	<div class="wrap">
		<h1>AI Integration Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ai_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'AI Integration Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ai_insight_page() {
	?>
	<div class="wrap">
		<h1>AI Insight</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ai_insight' ),
				'submit_value'    => 'Save',
				'updated_message' => 'AI Insight updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ai_data_page() {
	?>
	<div class="wrap">
		<h1>AI Data</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ai_data' ),
				'submit_value'    => 'Save',
				'updated_message' => 'AI Data updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ai_security_page() {
	?>
	<div class="wrap">
		<h1>AI Security</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ai_security' ),
				'submit_value'    => 'Save',
				'updated_message' => 'AI Security updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ai_benefits_page() {
	?>
	<div class="wrap">
		<h1>AI Benefits Section</h1>
		<p>The cards themselves live under AI Benefits.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ai_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'AI Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_ai_final_cta_page() {
	?>
	<div class="wrap">
		<h1>AI Final CTA</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_ai_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'AI Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_o2c_hero_page() {
	?>
	<div class="wrap">
		<h1>Order to Cash Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_o2c_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Order to Cash Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_o2c_quotes_page() {
	?>
	<div class="wrap">
		<h1>Order to Cash Quotes</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_o2c_quotes' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Order to Cash Quotes updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_o2c_fulfilment_page() {
	?>
	<div class="wrap">
		<h1>Order to Cash Fulfilment</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_o2c_fulfilment' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Order to Cash Fulfilment updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_o2c_receivables_page() {
	?>
	<div class="wrap">
		<h1>Order to Cash Receivables</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_o2c_receivables' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Order to Cash Receivables updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_o2c_benefits_page() {
	?>
	<div class="wrap">
		<h1>Order to Cash Benefits Section</h1>
		<p>The cards themselves live under Order to Cash Benefits.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_o2c_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Order to Cash Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_o2c_final_cta_page() {
	?>
	<div class="wrap">
		<h1>Order to Cash Final CTA</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_o2c_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Order to Cash Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_p2p_hero_page() {
	?>
	<div class="wrap">
		<h1>Procure to Pay Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_p2p_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Procure to Pay Hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_p2p_orders_page() {
	?>
	<div class="wrap">
		<h1>Procure to Pay Orders</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_p2p_orders' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Procure to Pay Orders updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_p2p_goodsin_page() {
	?>
	<div class="wrap">
		<h1>Procure to Pay Goods In</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_p2p_goodsin' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Procure to Pay Goods In updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_p2p_payables_page() {
	?>
	<div class="wrap">
		<h1>Procure to Pay Payables</h1>
		<p>One checklist item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_p2p_payables' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Procure to Pay Payables updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_p2p_benefits_page() {
	?>
	<div class="wrap">
		<h1>Procure to Pay Benefits Section</h1>
		<p>The cards themselves live under Procure to Pay Benefits.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_p2p_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Procure to Pay Benefits Section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_p2p_final_cta_page() {
	?>
	<div class="wrap">
		<h1>Procure to Pay Final CTA</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_p2p_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Procure to Pay Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_hero_page() {
	?>
	<div class="wrap">
		<h1>CRM Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_features_page() {
	?>
	<div class="wrap">
		<h1>CRM Features</h1>
		<p>The main checklist block on the CRM page. One item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_features' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM features updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_comms_page() {
	?>
	<div class="wrap">
		<h1>CRM Communications</h1>
		<p>The email &amp; team communications checklist. One item per line.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_comms' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM communications updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_benefits_page() {
	?>
	<div class="wrap">
		<h1>CRM Benefits Section</h1>
		<p>Heading and intro only — add or reorder the cards under CRM Benefits in the main menu.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_benefits' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM benefits updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_crm_final_cta_page() {
	?>
	<div class="wrap">
		<h1>CRM Final CTA</h1>
		<p>The closing band at the foot of the CRM page.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_crm_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'CRM final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_final_cta_page() {
	?>
	<div class="wrap">
		<h1>Final CTA</h1>
		<p>The closing band at the foot of the Pricing page.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_final_cta' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Final CTA updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_pricing_hero_page() {
	?>
	<div class="wrap">
		<h1>Pricing Hero</h1>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_pricing_hero' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Pricing hero updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_pricing_plans_page() {
	?>
	<div class="wrap">
		<h1>Pricing Plans Section</h1>
		<p>Add, remove and reorder the plan cards under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=pricing_plan' ) ); ?>">Pricing Plans</a> in the main menu.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_pricing_plans_section' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Pricing plans section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_vs_netsuite_page() {
	?>
	<div class="wrap">
		<h1>You vs NetSuite Section</h1>
		<p>Add, remove and reorder the cards under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=vs_card' ) ); ?>">VS Cards</a> in the main menu.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_vs_netsuite_section' ),
				'submit_value'    => 'Save',
				'updated_message' => 'You vs NetSuite section updated.',
			)
		);
		?>
	</div>
	<?php
}

function ldw_render_pricing_faq_page() {
	?>
	<div class="wrap">
		<h1>Pricing FAQ Section</h1>
		<p>Add, remove and reorder questions under <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=pricing_faq' ) ); ?>">Pricing FAQs</a> in the main menu. Title is the question, the content editor is the answer.</p>
		<?php
		acf_form(
			array(
				'post_id'         => 'option',
				'field_groups'    => array( 'group_pricing_faq_section' ),
				'submit_value'    => 'Save',
				'updated_message' => 'Pricing FAQ section updated.',
			)
		);
		?>
	</div>
	<?php
}

/**
 * Hero section fields.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_hero_section',
				'title'    => 'Hero Section',
				'fields'   => array(
					array(
						'key'           => 'field_hero_heading',
						'label'         => 'Heading (before highlight)',
						'name'          => 'hero_heading',
						'type'          => 'text',
						'default_value' => 'One ERP at the centre. Every flow',
					),
					array(
						'key'           => 'field_hero_heading_highlight',
						'label'         => 'Heading highlight (gradient text)',
						'name'          => 'hero_heading_highlight',
						'type'          => 'text',
						'default_value' => 'around it',
					),
					array(
						'key'           => 'field_hero_subtext',
						'label'         => 'Subtext',
						'name'          => 'hero_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'CRM, order to cash, procure to pay, warehouse fulfilment and e-commerce all run on one platform. No connectors, no bridging software, no spreadsheet at quarter end.',
					),
					array(
						'key'           => 'field_hero_cta_primary_text',
						'label'         => 'Primary CTA text',
						'name'          => 'hero_cta_primary_text',
						'type'          => 'text',
						'default_value' => 'Book a 20-minute demo',
					),
					array(
						'key'           => 'field_hero_cta_primary_url',
						'label'         => 'Primary CTA URL',
						'name'          => 'hero_cta_primary_url',
						'type'          => 'text',
						'default_value' => '#contact',
					),
					array(
						'key'           => 'field_hero_cta_secondary_text',
						'label'         => 'Secondary CTA text',
						'name'          => 'hero_cta_secondary_text',
						'type'          => 'text',
						'default_value' => 'See pricing',
					),
					array(
						'key'           => 'field_hero_cta_secondary_url',
						'label'         => 'Secondary CTA URL',
						'name'          => 'hero_cta_secondary_url',
						'type'          => 'text',
						'default_value' => '/pricing/',
					),
					array(
						'key'          => 'field_hero_trust_items',
						'label'        => 'Trust strip items',
						'name'         => 'hero_trust_items',
						'type'         => 'textarea',
						'rows'         => 4,
						'instructions' => 'One item per line.',
						'default_value' => "Live in days, not months\nHMRC-recognised for MTD\nFree migration from Xero or QuickBooks",
					),
					array(
						'key'           => 'field_orbit_core_title',
						'label'         => 'Orbit centre title',
						'name'          => 'orbit_core_title',
						'type'          => 'text',
						'default_value' => 'ERP',
					),
					array(
						'key'           => 'field_orbit_core_subtitle',
						'label'         => 'Orbit centre subtitle',
						'name'          => 'orbit_core_subtitle',
						'type'          => 'text',
						'default_value' => 'One platform',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-hero-section',
						),
					),
				),
			)
		);
	}
);

/**
 * Sale-to-VAT section fields. The 5 steps are a fixed-choreography
 * animation (each has its own hardcoded CSS keyframe, ldw-rev0..4 /
 * ldw-dot0..4) rather than a variable-length list, so plain fields are
 * the right fit — not a repeater (PRO only) or a CPT (no real need for
 * a variable count here).
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'    => 'group_sale_to_vat',
				'title'  => 'Sale to VAT Section',
				'fields' => array(
					array(
						'key'           => 'field_vat_heading',
						'label'         => 'Heading',
						'name'          => 'vat_heading',
						'type'          => 'text',
						'default_value' => 'From a sale to a VAT return, with no human intervention',
					),
					array(
						'key'           => 'field_vat_subtext',
						'label'         => 'Subtext',
						'name'          => 'vat_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
						'default_value' => 'One order moves through the whole business on its own. Nobody re-keys it, nobody reconciles it at quarter end.',
					),
					array(
						'key'           => 'field_vat_step_1',
						'label'         => 'Step 1 label',
						'name'          => 'vat_step_1',
						'type'          => 'text',
						'default_value' => 'E-Commerce sale',
					),
					array(
						'key'           => 'field_vat_step_2',
						'label'         => 'Step 2 label',
						'name'          => 'vat_step_2',
						'type'          => 'text',
						'default_value' => 'Warehouse fulfilment',
					),
					array(
						'key'           => 'field_vat_step_3',
						'label'         => 'Step 3 label',
						'name'          => 'vat_step_3',
						'type'          => 'text',
						'default_value' => 'Invoicing',
					),
					array(
						'key'           => 'field_vat_step_4',
						'label'         => 'Step 4 label',
						'name'          => 'vat_step_4',
						'type'          => 'text',
						'default_value' => 'Finance',
					),
					array(
						'key'           => 'field_vat_step_5',
						'label'         => 'Step 5 label',
						'name'          => 'vat_step_5',
						'type'          => 'text',
						'default_value' => 'VAT Return',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-sale-to-vat',
						),
					),
				),
			)
		);
	}
);

/**
 * CTA band ("Don't just take our word for it"). The 3 trust-row items
 * are fixed count/position like hero_trust_items, so same pattern:
 * one plain-text line per item instead of a (PRO-only) repeater.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'    => 'group_cta_band',
				'title'  => 'CTA Band Section',
				'fields' => array(
					array(
						'key'           => 'field_cta_badge',
						'label'         => 'Badge text (after the stars)',
						'name'          => 'cta_badge',
						'type'          => 'text',
						'default_value' => '5.0 rated on Trustist',
					),
					array(
						'key'           => 'field_cta_heading',
						'label'         => 'Heading',
						'name'          => 'cta_heading',
						'type'          => 'text',
						'default_value' => "Don't just take our word for it.",
					),
					array(
						'key'           => 'field_cta_subtext',
						'label'         => 'Subtext',
						'name'          => 'cta_subtext',
						'type'          => 'text',
						'default_value' => 'Contact us for a free 14 day trial.',
					),
					array(
						'key'           => 'field_cta_button_text',
						'label'         => 'Button text',
						'name'          => 'cta_button_text',
						'type'          => 'text',
						'default_value' => 'Book a no obligations demo',
					),
					array(
						'key'           => 'field_cta_button_url',
						'label'         => 'Button URL',
						'name'          => 'cta_button_url',
						'type'          => 'text',
						'default_value' => '#',
					),
					array(
						'key'          => 'field_cta_trust_items',
						'label'        => 'Trust row items',
						'name'         => 'cta_trust_items',
						'type'         => 'textarea',
						'rows'         => 3,
						'instructions' => 'One item per line.',
						'default_value' => "14-day free trial\nNo card required\nNo obligations",
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-cta-band',
						),
					),
				),
			)
		);
	}
);

/**
 * Features journey ("Tailored flows...") fields. Three fixed cards —
 * see template-parts/features-journey.php for why this isn't a list.
 */
add_action(
	'acf/init',
	function () {
		$defaults = array(
			1 => array(
				'theme' => 'dark',
				'label' => 'Step 01 · Oversee',
				'title' => 'We take care of the little things so you can focus on the big picture',
				'text'  => "A mid-flight overview of your business' activity and performance, in real time.",
				'items' => "Improved communication\nIncreased efficiency\nData insights",
			),
			2 => array(
				'theme' => 'peach',
				'label' => 'Step 02 · Streamline',
				'title' => 'Streamline work for maximum productivity',
				'text'  => "Unlike traditional CRM software, it's a completely mobile application, with better sales management, smarter production planning, richer reporting.",
				'items' => "Better sales management\nSmarter production planning\nRicher reporting",
			),
			3 => array(
				'theme' => 'mint',
				'label' => 'Step 03 · Secure',
				'title' => 'Your best work, on a secure platform',
				'text'  => "Built on Amazon's cloud services so your data is backed up securely, all activity end-to-end encrypted, with flexibility and control.",
				'items' => "Enhanced flexibility and control\nTime-Saving\nGreater Transparency",
			),
		);

		$fields = array(
			array(
				'key'           => 'field_journey_heading',
				'label'         => 'Heading',
				'name'          => 'journey_heading',
				'type'          => 'textarea',
				'rows'          => 2,
				'instructions'  => 'Each line break becomes a new line in the heading.',
				'default_value' => "Tailored flows for every part\nof your teams' day",
			),
			array(
				'key'           => 'field_journey_subtext',
				'label'         => 'Subtext',
				'name'          => 'journey_subtext',
				'type'          => 'textarea',
				'rows'          => 2,
				'default_value' => 'Keep your business organised and connected. Plan, structure and track remote work with one full-service platform.',
			),
		);

		foreach ( $defaults as $i => $d ) {
			$fields[] = array(
				'key'   => "field_journey_tab_{$i}",
				'label' => "Card {$i}",
				'type'  => 'tab',
			);
			$fields[] = array(
				'key'           => "field_journey_card_{$i}_label",
				'label'         => 'Step label',
				'name'          => "journey_card_{$i}_label",
				'type'          => 'text',
				'default_value' => $d['label'],
			);
			$fields[] = array(
				'key'           => "field_journey_card_{$i}_title",
				'label'         => 'Title',
				'name'          => "journey_card_{$i}_title",
				'type'          => 'text',
				'instructions'  => 'Leave empty to hide this card.',
				'default_value' => $d['title'],
			);
			$fields[] = array(
				'key'           => "field_journey_card_{$i}_image",
				'label'         => 'Image',
				'name'          => "journey_card_{$i}_image",
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
			);
			$fields[] = array(
				'key'           => "field_journey_card_{$i}_text",
				'label'         => 'Description',
				'name'          => "journey_card_{$i}_text",
				'type'          => 'textarea',
				'rows'          => 3,
				'default_value' => $d['text'],
			);
			$fields[] = array(
				'key'           => "field_journey_card_{$i}_items",
				'label'         => 'Checklist items',
				'name'          => "journey_card_{$i}_items",
				'type'          => 'textarea',
				'rows'          => 3,
				'instructions'  => 'One item per line.',
				'default_value' => $d['items'],
			);
			$fields[] = array(
				'key'           => "field_journey_card_{$i}_theme",
				'label'         => 'Colour',
				'name'          => "journey_card_{$i}_theme",
				'type'          => 'select',
				'choices'       => array(
					'dark'  => 'Dark teal',
					'peach' => 'Peach',
					'mint'  => 'Mint',
				),
				'default_value' => $d['theme'],
			);
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_features_journey',
				'title'    => 'Features Journey Section',
				'fields'   => $fields,
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-features-journey',
						),
					),
				),
			)
		);
	}
);

/**
 * Integrations section heading/subtext. The logo tiles themselves are
 * the Integration CPT — see inc/integrations-cpt.php.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_integrations',
				'title'    => 'Integrations Section',
				'fields'   => array(
					array(
						'key'           => 'field_int_heading',
						'label'         => 'Heading',
						'name'          => 'int_heading',
						'type'          => 'text',
						'default_value' => 'Integrates with the systems you already run on',
					),
					array(
						'key'           => 'field_int_subtext',
						'label'         => 'Subtext',
						'name'          => 'int_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Two-way sync for products, customers, suppliers, invoices and warehouse management. Set it up once and the data stays in step.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-integrations',
						),
					),
				),
			)
		);
	}
);

/**
 * Comparison section chrome: heading, the three plan column names and
 * the closing summary panel. Rows live in the compare_feature CPT.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_comparison',
				'title'    => 'Comparison Section',
				'fields'   => array(
					array(
						'key'           => 'field_compare_eyebrow',
						'label'         => 'Eyebrow pill (pricing page only)',
						'name'          => 'compare_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Small pill above the heading. Shown on the Pricing page only — the home page design has no eyebrow here. Leave blank to hide it.',
						'default_value' => 'How the platforms compare',
					),
					array(
						'key'           => 'field_compare_heading',
						'label'         => 'Heading',
						'name'          => 'compare_heading',
						'type'          => 'text',
						'default_value' => 'NetSuite capability. Xero-level price.',
					),
					array(
						'key'           => 'field_compare_col_label',
						'label'         => 'Row-label column heading',
						'name'          => 'compare_col_label',
						'type'          => 'text',
						'default_value' => 'Feature coverage',
					),
					array(
						'key'           => 'field_compare_plan_1_name',
						'label'         => 'Plan 1 name (your product)',
						'name'          => 'compare_plan_1_name',
						'type'          => 'text',
						'instructions'  => 'This column is highlighted: dark header, tinted cells.',
						'default_value' => 'LD Workflows',
					),
					array(
						'key'           => 'field_compare_plan_2_name',
						'label'         => 'Plan 2 name',
						'name'          => 'compare_plan_2_name',
						'type'          => 'text',
						'default_value' => 'NetSuite',
					),
					array(
						'key'           => 'field_compare_plan_3_name',
						'label'         => 'Plan 3 name',
						'name'          => 'compare_plan_3_name',
						'type'          => 'text',
						'default_value' => 'Xero + apps',
					),
					array(
						'key'           => 'field_compare_summary_label',
						'label'         => 'Summary label',
						'name'          => 'compare_summary_label',
						'type'          => 'text',
						'default_value' => 'The honest summary',
					),
					array(
						'key'           => 'field_compare_summary_text',
						'label'         => 'Summary text',
						'name'          => 'compare_summary_text',
						'type'          => 'textarea',
						'rows'          => 4,
						'default_value' => "Xero is cheaper, but it's accounting software, not an ERP. You'll still need a separate inventory tool, a Shopify connector and a manual MTD process. NetSuite does everything we do, but costs 10 to 30× more and takes months to implement.",
					),
					array(
						'key'           => 'field_compare_summary_highlight',
						'label'         => 'Summary closing line (gold)',
						'name'          => 'compare_summary_highlight',
						'type'          => 'textarea',
						'rows'          => 2,
						'default_value' => "We're the only platform purpose-built for UK Shopify merchants that closes the full loop.",
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-comparison',
						),
					),
				),
			)
		);
	}
);

/**
 * CRM comparison section chrome. The plan cards are the crm_card CPT.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_section',
				'title'    => 'CRM Comparison Section',
				'fields'   => array(
					array(
						'key'           => 'field_crm_eyebrow',
						'label'         => 'Eyebrow pill (pricing page only)',
						'name'          => 'crm_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Small pill above the heading. Shown on the Pricing page only — the home page design has no eyebrow here. Leave blank to hide it.',
						'default_value' => 'CRM: you vs HubSpot & Pipedrive',
					),
					array(
						'key'           => 'field_crm_heading',
						'label'         => 'Heading',
						'name'          => 'crm_heading',
						'type'          => 'text',
						'default_value' => 'A CRM that can actually see your money.',
					),
					array(
						'key'           => 'field_crm_quote_lead',
						'label'         => 'Quote opening (bold)',
						'name'          => 'crm_quote_lead',
						'type'          => 'text',
						'default_value' => 'HubSpot and Pipedrive see contacts.',
					),
					array(
						'key'           => 'field_crm_quote_text',
						'label'         => 'Quote body',
						'name'          => 'crm_quote_text',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'We see contacts and their order history, outstanding invoices and inventory availability, in one place, in real time. No integrations, no sync delays.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm',
						),
					),
				),
			)
		);
	}
);

/**
 * Case study section. The stats are a "Value | Label" line each rather
 * than fixed fields, so the admin can run two, four or six of them —
 * the grid's dividers are written to suit any count.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_case_study',
				'title'    => 'Case Study Section',
				'fields'   => array(
					array(
						'key'           => 'field_case_heading',
						'label'         => 'Heading',
						'name'          => 'case_heading',
						'type'          => 'text',
						'default_value' => 'Real teams, real results',
					),
					array(
						'key'           => 'field_case_subtext',
						'label'         => 'Subtext',
						'name'          => 'case_subtext',
						'type'          => 'text',
						'default_value' => 'How one customer transformed their daily operations.',
					),
					array(
						'key'           => 'field_case_quote',
						'label'         => 'Quote',
						'name'          => 'case_quote',
						'type'          => 'textarea',
						'rows'          => 4,
						'instructions'  => 'Wrap a figure in square brackets to give it the navy highlight pill, e.g. <code>cut manual VAT work by [62%] and...</code>',
						'default_value' => '“We cut manual VAT work by [62%] and doubled the order volume our team can handle, without adding headcount.”',
					),
					array(
						'key'           => 'field_case_attribution',
						'label'         => 'Attribution',
						'name'          => 'case_attribution',
						'type'          => 'text',
						'default_value' => 'Operations Director, Harbour & Co.',
					),
					array(
						'key'           => 'field_case_cta_text',
						'label'         => 'Button text',
						'name'          => 'case_cta_text',
						'type'          => 'text',
						'default_value' => 'Read the case study',
					),
					array(
						'key'           => 'field_case_cta_url',
						'label'         => 'Button URL',
						'name'          => 'case_cta_url',
						'type'          => 'text',
						'default_value' => '#',
					),
					array(
						'key'           => 'field_case_stats',
						'label'         => 'Stats',
						'name'          => 'case_stats',
						'type'          => 'textarea',
						'rows'          => 6,
						'instructions'  => 'One stat per line, as <code>Value | Label</code>. For example: <code>62% | less manual VAT work</code>. They lay out two per row.',
						'default_value' => "62% | less manual VAT work\n3.5h | saved per day\n2× | order capacity\n0 | extra headcount",
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-case-study',
						),
					),
				),
			)
		);
	}
);

/**
 * Resources section chrome. The cards are posts — see inc/resources.php.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_resources',
				'title'    => 'Resources Section',
				'fields'   => array(
					array(
						'key'           => 'field_res_heading',
						'label'         => 'Heading',
						'name'          => 'res_heading',
						'type'          => 'text',
						'default_value' => 'Resources',
					),
					array(
						'key'           => 'field_res_subtext',
						'label'         => 'Subtext',
						'name'          => 'res_subtext',
						'type'          => 'text',
						'default_value' => "We'll get you up and running in no time.",
					),
					array(
						'key'           => 'field_res_count',
						'label'         => 'Posts to show',
						'name'          => 'res_count',
						'type'          => 'number',
						'instructions'  => 'How many of the most recent posts appear on the homepage.',
						'min'           => 1,
						'default_value' => 8,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-resources',
						),
					),
				),
			)
		);
	}
);

/**
 * Demo CTA section. Stat cards use the same "Value | Label" line format
 * as the case study, so the admin can run two, three or four of them.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_demo_cta',
				'title'    => 'Demo CTA Section',
				'fields'   => array(
					array(
						'key'           => 'field_demo_heading',
						'label'         => 'Heading',
						'name'          => 'demo_heading',
						'type'          => 'text',
						'instructions'  => 'Wrap words in square brackets to show them in gold italics, e.g. <code>See LD Workflows [in action].</code>',
						'default_value' => 'See LD Workflows [in action].',
					),
					array(
						'key'           => 'field_demo_subtext',
						'label'         => 'Subtext',
						'name'          => 'demo_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Contact us for a free 14-day trial. No obligations, no card required. Just your workflows, running smoother.',
					),
					array(
						'key'           => 'field_demo_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'demo_primary_text',
						'type'          => 'text',
						'default_value' => 'Book a no-obligations demo',
					),
					array(
						'key'           => 'field_demo_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'demo_primary_url',
						'type'          => 'text',
						'default_value' => '#contact',
					),
					array(
						'key'           => 'field_demo_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'demo_secondary_text',
						'type'          => 'text',
						'default_value' => 'Start free trial',
					),
					array(
						'key'           => 'field_demo_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'demo_secondary_url',
						'type'          => 'text',
						'default_value' => '#',
					),
					array(
						'key'           => 'field_demo_stats',
						'label'         => 'Side cards',
						'name'          => 'demo_stats',
						'type'          => 'textarea',
						'rows'          => 5,
						'instructions'  => 'One card per line, as <code>Value | Label</code>. For example: <code>14 | Days of full access, free.</code>',
						'default_value' => "5.0★ | Rated on Trustist by teams who run on our flows\n14 | Days of full access, free. No card, no obligations\n1:1 | Guided walkthrough with a workflow specialist",
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-demo-cta',
						),
					),
				),
			)
		);
	}
);

/**
 * Footer. Link row comes from the "Footer Navigation" menu location;
 * only the CTA band, legal line and wordmark live here.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_footer',
				'title'    => 'Footer',
				'fields'   => array(
					array(
						'key'           => 'field_footer_heading',
						'label'         => 'Heading',
						'name'          => 'footer_heading',
						'type'          => 'text',
						'default_value' => 'Ready to run everything on one flow?',
					),
					array(
						'key'           => 'field_footer_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'footer_primary_text',
						'type'          => 'text',
						'default_value' => 'Book a demo',
					),
					array(
						'key'           => 'field_footer_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'footer_primary_url',
						'type'          => 'text',
						'default_value' => '#contact',
					),
					array(
						'key'           => 'field_footer_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'footer_secondary_text',
						'type'          => 'text',
						'default_value' => 'Start free trial',
					),
					array(
						'key'           => 'field_footer_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'footer_secondary_url',
						'type'          => 'text',
						'default_value' => '#contact',
					),
					array(
						'key'           => 'field_footer_copyright',
						'label'         => 'Copyright line',
						'name'          => 'footer_copyright',
						'type'          => 'text',
						'default_value' => 'All rights reserved © 2026 LD Workflows',
					),
					array(
						'key'           => 'field_footer_legal',
						'label'         => 'Legal links',
						'name'          => 'footer_legal',
						'type'          => 'textarea',
						'rows'          => 4,
						'instructions'  => 'One per line, as <code>Label | URL</code>.',
						'default_value' => "Terms of Service | #\nCookies Policy | #\nPrivacy Policy | #",
					),
					array(
						'key'           => 'field_footer_wordmark',
						'label'         => 'Background wordmark',
						'name'          => 'footer_wordmark',
						'type'          => 'text',
						'instructions'  => 'The oversized faded word across the bottom. Leave empty to hide it.',
						'default_value' => 'ldworkflows',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-footer',
						),
					),
				),
			)
		);
	}
);

/**
 * Pricing page section fields: hero, plans intro/footnote, "You vs
 * NetSuite" heading/quote, and FAQ heading. The repeatable content for
 * each (plans, vs cards, faqs) lives in its own CPT — see
 * inc/pricing-plans-cpt.php, inc/vs-cards-cpt.php, inc/pricing-faq-cpt.php.
 */
add_action(
	'acf/init',
	function () {
		acf_add_local_field_group(
			array(
				'key'      => 'group_pricing_hero',
				'title'    => 'Pricing Hero',
				'fields'   => array(
					array(
						'key'           => 'field_pricing_hero_eyebrow',
						'label'         => 'Eyebrow',
						'name'          => 'pricing_hero_eyebrow',
						'type'          => 'text',
						'default_value' => 'Pricing & plans',
					),
					array(
						'key'           => 'field_pricing_hero_heading',
						'label'         => 'Heading',
						'name'          => 'pricing_hero_heading',
						'type'          => 'text',
						'default_value' => 'Everything from Shopify order to VAT return.',
					),
					array(
						'key'           => 'field_pricing_hero_highlight',
						'label'         => 'Highlight line (italic)',
						'name'          => 'pricing_hero_highlight',
						'type'          => 'text',
						'default_value' => 'No enterprise price tag.',
					),
					array(
						'key'           => 'field_pricing_hero_subtext',
						'label'         => 'Subtext',
						'name'          => 'pricing_hero_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'One platform: full ERP, accounting, inventory, CRM and MTD VAT filing, built for UK merchants.',
					),
					array(
						'key'           => 'field_pricing_hero_primary_text',
						'label'         => 'Primary CTA text',
						'name'          => 'pricing_hero_primary_text',
						'type'          => 'text',
						'default_value' => 'Start free trial',
					),
					array(
						'key'           => 'field_pricing_hero_primary_url',
						'label'         => 'Primary CTA link',
						'name'          => 'pricing_hero_primary_url',
						'type'          => 'text',
						'default_value' => '#plans',
					),
					array(
						'key'           => 'field_pricing_hero_secondary_text',
						'label'         => 'Secondary CTA text',
						'name'          => 'pricing_hero_secondary_text',
						'type'          => 'text',
						'default_value' => 'Book a demo',
					),
					array(
						'key'           => 'field_pricing_hero_secondary_url',
						'label'         => 'Secondary CTA link',
						'name'          => 'pricing_hero_secondary_url',
						'type'          => 'text',
						'default_value' => '#contact',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-pricing-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_hero',
				'title'    => 'ERP Hero',
				'fields'   => array(
					array(
						'key'           => 'field_erp_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'erp_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'ERP',
					),
					array(
						'key'           => 'field_erp_hero_heading',
						'label'         => 'Heading',
						'name'          => 'erp_hero_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_hero_highlight',
						'label'         => 'Accent line (italic)',
						'name'          => 'erp_hero_highlight',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
					),
					array(
						'key'           => 'field_erp_hero_subtext',
						'label'         => 'Subtext',
						'name'          => 'erp_hero_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
					),
					array(
						'key'           => 'field_erp_hero_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'erp_hero_primary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
					),
					array(
						'key'           => 'field_erp_hero_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'erp_hero_primary_url',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_hero_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'erp_hero_secondary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
					),
					array(
						'key'           => 'field_erp_hero_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'erp_hero_secondary_url',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_hero_image',
						'label'         => 'Hero image',
						'name'          => 'erp_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_sales',
				'title'    => 'ERP Sales',
				'fields'   => array(
					array(
						'key'           => 'field_erp_sales_heading',
						'label'         => 'Heading',
						'name'          => 'erp_sales_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_sales_subtext',
						'label'         => 'Subheading',
						'name'          => 'erp_sales_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_erp_sales_items',
						'label'         => 'Checklist items',
						'name'          => 'erp_sales_items',
						'type'          => 'textarea',
						'rows'          => 10,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_erp_sales_image',
						'label'         => 'Section image',
						'name'          => 'erp_sales_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-sales',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_warehouse',
				'title'    => 'ERP Warehouse',
				'fields'   => array(
					array(
						'key'           => 'field_erp_warehouse_heading',
						'label'         => 'Heading',
						'name'          => 'erp_warehouse_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_warehouse_subtext',
						'label'         => 'Subheading',
						'name'          => 'erp_warehouse_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_erp_warehouse_items',
						'label'         => 'Checklist items',
						'name'          => 'erp_warehouse_items',
						'type'          => 'textarea',
						'rows'          => 10,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_erp_warehouse_image',
						'label'         => 'Section image',
						'name'          => 'erp_warehouse_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-warehouse',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_accounting',
				'title'    => 'ERP Accounting',
				'fields'   => array(
					array(
						'key'           => 'field_erp_accounting_heading',
						'label'         => 'Heading',
						'name'          => 'erp_accounting_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_accounting_subtext',
						'label'         => 'Subheading',
						'name'          => 'erp_accounting_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_erp_accounting_items',
						'label'         => 'Checklist items',
						'name'          => 'erp_accounting_items',
						'type'          => 'textarea',
						'rows'          => 10,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_erp_accounting_image',
						'label'         => 'Section image',
						'name'          => 'erp_accounting_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-accounting',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_comms',
				'title'    => 'ERP Communications',
				'fields'   => array(
					array(
						'key'           => 'field_erp_comms_heading',
						'label'         => 'Heading',
						'name'          => 'erp_comms_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_comms_subtext',
						'label'         => 'Subheading',
						'name'          => 'erp_comms_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_erp_comms_items',
						'label'         => 'Checklist items',
						'name'          => 'erp_comms_items',
						'type'          => 'textarea',
						'rows'          => 10,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_erp_comms_image',
						'label'         => 'Section image',
						'name'          => 'erp_comms_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-comms',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_benefits',
				'title'    => 'ERP Benefits Section',
				'fields'   => array(
					array(
						'key'           => 'field_erp_benefits_heading',
						'label'         => 'Heading',
						'name'          => 'erp_benefits_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_benefits_subtext',
						'label'         => 'Intro',
						'name'          => 'erp_benefits_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_erp_final_cta',
				'title'    => 'ERP Final CTA',
				'fields'   => array(
					array(
						'key'           => 'field_erp_final_cta_heading',
						'label'         => 'Heading',
						'name'          => 'erp_final_cta_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_final_cta_accent',
						'label'         => 'Accent line (italic)',
						'name'          => 'erp_final_cta_accent',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
					),
					array(
						'key'           => 'field_erp_final_cta_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'erp_final_cta_primary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
					),
					array(
						'key'           => 'field_erp_final_cta_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'erp_final_cta_primary_url',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_erp_final_cta_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'erp_final_cta_secondary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
					),
					array(
						'key'           => 'field_erp_final_cta_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'erp_final_cta_secondary_url',
						'type'          => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-erp-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_hero',
				'title'    => 'Service Hero',
				'fields'   => array(
					array(
						'key'           => 'field_service_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'service_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'Field service',
					),
					array(
						'key'   => 'field_service_hero_heading',
						'label' => 'Heading',
						'name'  => 'service_hero_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_service_hero_highlight',
						'label'        => 'Accent line (italic)',
						'name'         => 'service_hero_highlight',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'   => 'field_service_hero_subtext',
						'label' => 'Subtext',
						'name'  => 'service_hero_subtext',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_service_hero_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'service_hero_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_service_hero_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'service_hero_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_service_hero_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'service_hero_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_service_hero_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'service_hero_secondary_url',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_service_hero_image',
						'label'         => 'Hero image',
						'name'          => 'service_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_resources',
				'title'    => 'Service Resources',
				'fields'   => array(
					array(
						'key'   => 'field_service_resources_heading',
						'label' => 'Heading',
						'name'  => 'service_resources_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_service_resources_subtext',
						'label' => 'Subheading',
						'name'  => 'service_resources_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_service_resources_items',
						'label'        => 'Checklist items',
						'name'         => 'service_resources_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_service_resources_image',
						'label'         => 'Section image',
						'name'          => 'service_resources_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-resources',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_warehouse',
				'title'    => 'Service Warehouse',
				'fields'   => array(
					array(
						'key'   => 'field_service_warehouse_heading',
						'label' => 'Heading',
						'name'  => 'service_warehouse_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_service_warehouse_subtext',
						'label' => 'Subheading',
						'name'  => 'service_warehouse_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_service_warehouse_items',
						'label'        => 'Checklist items',
						'name'         => 'service_warehouse_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_service_warehouse_image',
						'label'         => 'Section image',
						'name'          => 'service_warehouse_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-warehouse',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_accounting',
				'title'    => 'Service Accounting',
				'fields'   => array(
					array(
						'key'   => 'field_service_accounting_heading',
						'label' => 'Heading',
						'name'  => 'service_accounting_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_service_accounting_subtext',
						'label' => 'Subheading',
						'name'  => 'service_accounting_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_service_accounting_items',
						'label'        => 'Checklist items',
						'name'         => 'service_accounting_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_service_accounting_image',
						'label'         => 'Section image',
						'name'          => 'service_accounting_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-accounting',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_comms',
				'title'    => 'Service Communications',
				'fields'   => array(
					array(
						'key'   => 'field_service_comms_heading',
						'label' => 'Heading',
						'name'  => 'service_comms_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_service_comms_subtext',
						'label' => 'Subheading',
						'name'  => 'service_comms_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_service_comms_items',
						'label'        => 'Checklist items',
						'name'         => 'service_comms_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_service_comms_image',
						'label'         => 'Section image',
						'name'          => 'service_comms_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-comms',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_logistics',
				'title'    => 'Service Logistics',
				'fields'   => array(
					array(
						'key'   => 'field_service_logistics_heading',
						'label' => 'Heading',
						'name'  => 'service_logistics_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_service_logistics_subtext',
						'label' => 'Subheading',
						'name'  => 'service_logistics_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_service_logistics_items',
						'label'        => 'Checklist items',
						'name'         => 'service_logistics_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_service_logistics_image',
						'label'         => 'Section image',
						'name'          => 'service_logistics_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-logistics',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_benefits',
				'title'    => 'Service Benefits Section',
				'fields'   => array(
					array(
						'key'   => 'field_service_benefits_heading',
						'label' => 'Heading',
						'name'  => 'service_benefits_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_service_benefits_subtext',
						'label' => 'Subheading',
						'name'  => 'service_benefits_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_service_final_cta',
				'title'    => 'Service Final CTA',
				'fields'   => array(
					array(
						'key'   => 'field_service_final_cta_heading',
						'label' => 'Heading',
						'name'  => 'service_final_cta_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_service_final_cta_accent',
						'label'        => 'Accent line (italic)',
						'name'         => 'service_final_cta_accent',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'          => 'field_service_final_cta_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'service_final_cta_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_service_final_cta_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'service_final_cta_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_service_final_cta_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'service_final_cta_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_service_final_cta_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'service_final_cta_secondary_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-service-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_warehouse_hero',
				'title'    => 'Warehouse Hero',
				'fields'   => array(
					array(
						'key'           => 'field_warehouse_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'warehouse_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'Warehouse',
					),
					array(
						'key'   => 'field_warehouse_hero_heading',
						'label' => 'Heading',
						'name'  => 'warehouse_hero_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_warehouse_hero_highlight',
						'label'        => 'Accent line (italic)',
						'name'         => 'warehouse_hero_highlight',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'   => 'field_warehouse_hero_subtext',
						'label' => 'Subtext',
						'name'  => 'warehouse_hero_subtext',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_warehouse_hero_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'warehouse_hero_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_warehouse_hero_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'warehouse_hero_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_warehouse_hero_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'warehouse_hero_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_warehouse_hero_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'warehouse_hero_secondary_url',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_warehouse_hero_image',
						'label'         => 'Hero image',
						'name'          => 'warehouse_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-warehouse-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_warehouse_goods',
				'title'    => 'Warehouse Goods In',
				'fields'   => array(
					array(
						'key'   => 'field_warehouse_goods_heading',
						'label' => 'Heading',
						'name'  => 'warehouse_goods_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_warehouse_goods_subtext',
						'label' => 'Subheading',
						'name'  => 'warehouse_goods_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_warehouse_goods_items',
						'label'        => 'Checklist items',
						'name'         => 'warehouse_goods_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_warehouse_goods_image',
						'label'         => 'Section image',
						'name'          => 'warehouse_goods_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-warehouse-goods',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_warehouse_picking',
				'title'    => 'Warehouse Picking',
				'fields'   => array(
					array(
						'key'   => 'field_warehouse_picking_heading',
						'label' => 'Heading',
						'name'  => 'warehouse_picking_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_warehouse_picking_subtext',
						'label' => 'Subheading',
						'name'  => 'warehouse_picking_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_warehouse_picking_items',
						'label'        => 'Checklist items',
						'name'         => 'warehouse_picking_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_warehouse_picking_image',
						'label'         => 'Section image',
						'name'          => 'warehouse_picking_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-warehouse-picking',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_warehouse_stock',
				'title'    => 'Warehouse Stock & Sync',
				'fields'   => array(
					array(
						'key'   => 'field_warehouse_stock_heading',
						'label' => 'Heading',
						'name'  => 'warehouse_stock_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_warehouse_stock_subtext',
						'label' => 'Subheading',
						'name'  => 'warehouse_stock_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_warehouse_stock_items',
						'label'        => 'Checklist items',
						'name'         => 'warehouse_stock_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_warehouse_stock_image',
						'label'         => 'Section image',
						'name'          => 'warehouse_stock_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-warehouse-stock',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_warehouse_benefits',
				'title'    => 'Warehouse Benefits Section',
				'fields'   => array(
					array(
						'key'          => 'field_warehouse_benefits_heading',
						'label'        => 'Heading',
						'name'         => 'warehouse_benefits_heading',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the whole section.',
					),
					array(
						'key'   => 'field_warehouse_benefits_subtext',
						'label' => 'Subheading',
						'name'  => 'warehouse_benefits_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-warehouse-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_warehouse_final_cta',
				'title'    => 'Warehouse Final CTA',
				'fields'   => array(
					array(
						'key'   => 'field_warehouse_final_cta_heading',
						'label' => 'Heading',
						'name'  => 'warehouse_final_cta_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_warehouse_final_cta_accent',
						'label'        => 'Accent line (italic)',
						'name'         => 'warehouse_final_cta_accent',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'          => 'field_warehouse_final_cta_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'warehouse_final_cta_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_warehouse_final_cta_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'warehouse_final_cta_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_warehouse_final_cta_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'warehouse_final_cta_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_warehouse_final_cta_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'warehouse_final_cta_secondary_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-warehouse-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ecommerce_hero',
				'title'    => 'E-commerce Hero',
				'fields'   => array(
					array(
						'key'           => 'field_ecommerce_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'ecommerce_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'E-commerce',
					),
					array(
						'key'   => 'field_ecommerce_hero_heading',
						'label' => 'Heading',
						'name'  => 'ecommerce_hero_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ecommerce_hero_highlight',
						'label'        => 'Accent line (italic)',
						'name'         => 'ecommerce_hero_highlight',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'   => 'field_ecommerce_hero_subtext',
						'label' => 'Subtext',
						'name'  => 'ecommerce_hero_subtext',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_ecommerce_hero_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'ecommerce_hero_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ecommerce_hero_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'ecommerce_hero_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ecommerce_hero_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'ecommerce_hero_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ecommerce_hero_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'ecommerce_hero_secondary_url',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_ecommerce_hero_image',
						'label'         => 'Hero image',
						'name'          => 'ecommerce_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ecommerce-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ecommerce_storefront',
				'title'    => 'E-commerce Storefront',
				'fields'   => array(
					array(
						'key'   => 'field_ecommerce_storefront_heading',
						'label' => 'Heading',
						'name'  => 'ecommerce_storefront_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_ecommerce_storefront_subtext',
						'label' => 'Subheading',
						'name'  => 'ecommerce_storefront_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_ecommerce_storefront_items',
						'label'        => 'Checklist items',
						'name'         => 'ecommerce_storefront_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_ecommerce_storefront_image',
						'label'         => 'Section image',
						'name'          => 'ecommerce_storefront_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ecommerce-storefront',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ecommerce_orders',
				'title'    => 'E-commerce Orders',
				'fields'   => array(
					array(
						'key'   => 'field_ecommerce_orders_heading',
						'label' => 'Heading',
						'name'  => 'ecommerce_orders_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_ecommerce_orders_subtext',
						'label' => 'Subheading',
						'name'  => 'ecommerce_orders_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_ecommerce_orders_items',
						'label'        => 'Checklist items',
						'name'         => 'ecommerce_orders_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_ecommerce_orders_image',
						'label'         => 'Section image',
						'name'          => 'ecommerce_orders_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ecommerce-orders',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ecommerce_finance',
				'title'    => 'E-commerce Finance',
				'fields'   => array(
					array(
						'key'   => 'field_ecommerce_finance_heading',
						'label' => 'Heading',
						'name'  => 'ecommerce_finance_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_ecommerce_finance_subtext',
						'label' => 'Subheading',
						'name'  => 'ecommerce_finance_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_ecommerce_finance_items',
						'label'        => 'Checklist items',
						'name'         => 'ecommerce_finance_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_ecommerce_finance_image',
						'label'         => 'Section image',
						'name'          => 'ecommerce_finance_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ecommerce-finance',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ecommerce_benefits',
				'title'    => 'E-commerce Benefits Section',
				'fields'   => array(
					array(
						'key'          => 'field_ecommerce_benefits_heading',
						'label'        => 'Heading',
						'name'         => 'ecommerce_benefits_heading',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the whole section.',
					),
					array(
						'key'   => 'field_ecommerce_benefits_subtext',
						'label' => 'Subheading',
						'name'  => 'ecommerce_benefits_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ecommerce-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ecommerce_final_cta',
				'title'    => 'E-commerce Final CTA',
				'fields'   => array(
					array(
						'key'   => 'field_ecommerce_final_cta_heading',
						'label' => 'Heading',
						'name'  => 'ecommerce_final_cta_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ecommerce_final_cta_accent',
						'label'        => 'Accent line (italic)',
						'name'         => 'ecommerce_final_cta_accent',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'          => 'field_ecommerce_final_cta_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'ecommerce_final_cta_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ecommerce_final_cta_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'ecommerce_final_cta_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ecommerce_final_cta_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'ecommerce_final_cta_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ecommerce_final_cta_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'ecommerce_final_cta_secondary_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ecommerce-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ai_hero',
				'title'    => 'AI Integration Hero',
				'fields'   => array(
					array(
						'key'           => 'field_ai_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'ai_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'AI integration',
					),
					array(
						'key'   => 'field_ai_hero_heading',
						'label' => 'Heading',
						'name'  => 'ai_hero_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ai_hero_highlight',
						'label'        => 'Accent line (italic)',
						'name'         => 'ai_hero_highlight',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'   => 'field_ai_hero_subtext',
						'label' => 'Subtext',
						'name'  => 'ai_hero_subtext',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_ai_hero_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'ai_hero_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ai_hero_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'ai_hero_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ai_hero_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'ai_hero_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ai_hero_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'ai_hero_secondary_url',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_ai_hero_image',
						'label'         => 'Hero image',
						'name'          => 'ai_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ai-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ai_insight',
				'title'    => 'AI Insight',
				'fields'   => array(
					array(
						'key'   => 'field_ai_insight_heading',
						'label' => 'Heading',
						'name'  => 'ai_insight_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_ai_insight_subtext',
						'label' => 'Subheading',
						'name'  => 'ai_insight_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_ai_insight_items',
						'label'        => 'Checklist items',
						'name'         => 'ai_insight_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_ai_insight_image',
						'label'         => 'Section image',
						'name'          => 'ai_insight_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ai-insight',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ai_data',
				'title'    => 'AI Data',
				'fields'   => array(
					array(
						'key'   => 'field_ai_data_heading',
						'label' => 'Heading',
						'name'  => 'ai_data_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_ai_data_subtext',
						'label' => 'Subheading',
						'name'  => 'ai_data_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_ai_data_items',
						'label'        => 'Checklist items',
						'name'         => 'ai_data_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_ai_data_image',
						'label'         => 'Section image',
						'name'          => 'ai_data_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ai-data',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ai_security',
				'title'    => 'AI Security',
				'fields'   => array(
					array(
						'key'   => 'field_ai_security_heading',
						'label' => 'Heading',
						'name'  => 'ai_security_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_ai_security_subtext',
						'label' => 'Subheading',
						'name'  => 'ai_security_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_ai_security_items',
						'label'        => 'Checklist items',
						'name'         => 'ai_security_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_ai_security_image',
						'label'         => 'Section image',
						'name'          => 'ai_security_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ai-security',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ai_benefits',
				'title'    => 'AI Benefits Section',
				'fields'   => array(
					array(
						'key'          => 'field_ai_benefits_heading',
						'label'        => 'Heading',
						'name'         => 'ai_benefits_heading',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the whole section.',
					),
					array(
						'key'   => 'field_ai_benefits_subtext',
						'label' => 'Subheading',
						'name'  => 'ai_benefits_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ai-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_ai_final_cta',
				'title'    => 'AI Final CTA',
				'fields'   => array(
					array(
						'key'   => 'field_ai_final_cta_heading',
						'label' => 'Heading',
						'name'  => 'ai_final_cta_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ai_final_cta_accent',
						'label'        => 'Accent line (italic)',
						'name'         => 'ai_final_cta_accent',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'          => 'field_ai_final_cta_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'ai_final_cta_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ai_final_cta_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'ai_final_cta_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_ai_final_cta_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'ai_final_cta_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_ai_final_cta_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'ai_final_cta_secondary_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-ai-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_o2c_hero',
				'title'    => 'Order to Cash Hero',
				'fields'   => array(
					array(
						'key'           => 'field_o2c_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'o2c_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'Order to cash',
					),
					array(
						'key'   => 'field_o2c_hero_heading',
						'label' => 'Heading',
						'name'  => 'o2c_hero_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_o2c_hero_highlight',
						'label'        => 'Accent line (italic)',
						'name'         => 'o2c_hero_highlight',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'   => 'field_o2c_hero_subtext',
						'label' => 'Subtext',
						'name'  => 'o2c_hero_subtext',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_o2c_hero_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'o2c_hero_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_o2c_hero_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'o2c_hero_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_o2c_hero_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'o2c_hero_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_o2c_hero_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'o2c_hero_secondary_url',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_o2c_hero_image',
						'label'         => 'Hero image',
						'name'          => 'o2c_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-o2c-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_o2c_quotes',
				'title'    => 'Order to Cash Quotes',
				'fields'   => array(
					array(
						'key'   => 'field_o2c_quotes_heading',
						'label' => 'Heading',
						'name'  => 'o2c_quotes_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_o2c_quotes_subtext',
						'label' => 'Subheading',
						'name'  => 'o2c_quotes_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_o2c_quotes_items',
						'label'        => 'Checklist items',
						'name'         => 'o2c_quotes_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_o2c_quotes_image',
						'label'         => 'Section image',
						'name'          => 'o2c_quotes_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-o2c-quotes',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_o2c_fulfilment',
				'title'    => 'Order to Cash Fulfilment',
				'fields'   => array(
					array(
						'key'   => 'field_o2c_fulfilment_heading',
						'label' => 'Heading',
						'name'  => 'o2c_fulfilment_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_o2c_fulfilment_subtext',
						'label' => 'Subheading',
						'name'  => 'o2c_fulfilment_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_o2c_fulfilment_items',
						'label'        => 'Checklist items',
						'name'         => 'o2c_fulfilment_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_o2c_fulfilment_image',
						'label'         => 'Section image',
						'name'          => 'o2c_fulfilment_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-o2c-fulfilment',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_o2c_receivables',
				'title'    => 'Order to Cash Receivables',
				'fields'   => array(
					array(
						'key'   => 'field_o2c_receivables_heading',
						'label' => 'Heading',
						'name'  => 'o2c_receivables_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_o2c_receivables_subtext',
						'label' => 'Subheading',
						'name'  => 'o2c_receivables_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_o2c_receivables_items',
						'label'        => 'Checklist items',
						'name'         => 'o2c_receivables_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_o2c_receivables_image',
						'label'         => 'Section image',
						'name'          => 'o2c_receivables_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-o2c-receivables',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_o2c_benefits',
				'title'    => 'Order to Cash Benefits Section',
				'fields'   => array(
					array(
						'key'          => 'field_o2c_benefits_heading',
						'label'        => 'Heading',
						'name'         => 'o2c_benefits_heading',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the whole section.',
					),
					array(
						'key'   => 'field_o2c_benefits_subtext',
						'label' => 'Subheading',
						'name'  => 'o2c_benefits_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-o2c-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_o2c_final_cta',
				'title'    => 'Order to Cash Final CTA',
				'fields'   => array(
					array(
						'key'   => 'field_o2c_final_cta_heading',
						'label' => 'Heading',
						'name'  => 'o2c_final_cta_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_o2c_final_cta_accent',
						'label'        => 'Accent line (italic)',
						'name'         => 'o2c_final_cta_accent',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'          => 'field_o2c_final_cta_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'o2c_final_cta_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_o2c_final_cta_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'o2c_final_cta_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_o2c_final_cta_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'o2c_final_cta_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_o2c_final_cta_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'o2c_final_cta_secondary_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-o2c-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_p2p_hero',
				'title'    => 'Procure to Pay Hero',
				'fields'   => array(
					array(
						'key'           => 'field_p2p_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'p2p_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'Procure to pay',
					),
					array(
						'key'   => 'field_p2p_hero_heading',
						'label' => 'Heading',
						'name'  => 'p2p_hero_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_p2p_hero_highlight',
						'label'        => 'Accent line (italic)',
						'name'         => 'p2p_hero_highlight',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'   => 'field_p2p_hero_subtext',
						'label' => 'Subtext',
						'name'  => 'p2p_hero_subtext',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_p2p_hero_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'p2p_hero_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_p2p_hero_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'p2p_hero_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_p2p_hero_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'p2p_hero_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_p2p_hero_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'p2p_hero_secondary_url',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_p2p_hero_image',
						'label'         => 'Hero image',
						'name'          => 'p2p_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-p2p-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_p2p_orders',
				'title'    => 'Procure to Pay Orders',
				'fields'   => array(
					array(
						'key'   => 'field_p2p_orders_heading',
						'label' => 'Heading',
						'name'  => 'p2p_orders_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_p2p_orders_subtext',
						'label' => 'Subheading',
						'name'  => 'p2p_orders_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_p2p_orders_items',
						'label'        => 'Checklist items',
						'name'         => 'p2p_orders_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_p2p_orders_image',
						'label'         => 'Section image',
						'name'          => 'p2p_orders_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-p2p-orders',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_p2p_goodsin',
				'title'    => 'Procure to Pay Goods In',
				'fields'   => array(
					array(
						'key'   => 'field_p2p_goodsin_heading',
						'label' => 'Heading',
						'name'  => 'p2p_goodsin_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_p2p_goodsin_subtext',
						'label' => 'Subheading',
						'name'  => 'p2p_goodsin_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_p2p_goodsin_items',
						'label'        => 'Checklist items',
						'name'         => 'p2p_goodsin_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_p2p_goodsin_image',
						'label'         => 'Section image',
						'name'          => 'p2p_goodsin_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-p2p-goodsin',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_p2p_payables',
				'title'    => 'Procure to Pay Payables',
				'fields'   => array(
					array(
						'key'   => 'field_p2p_payables_heading',
						'label' => 'Heading',
						'name'  => 'p2p_payables_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_p2p_payables_subtext',
						'label' => 'Subheading',
						'name'  => 'p2p_payables_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_p2p_payables_items',
						'label'        => 'Checklist items',
						'name'         => 'p2p_payables_items',
						'type'         => 'textarea',
						'rows'         => 8,
						'instructions' => 'One per line.',
					),
					array(
						'key'           => 'field_p2p_payables_image',
						'label'         => 'Section image',
						'name'          => 'p2p_payables_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-p2p-payables',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_p2p_benefits',
				'title'    => 'Procure to Pay Benefits Section',
				'fields'   => array(
					array(
						'key'          => 'field_p2p_benefits_heading',
						'label'        => 'Heading',
						'name'         => 'p2p_benefits_heading',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the whole section.',
					),
					array(
						'key'   => 'field_p2p_benefits_subtext',
						'label' => 'Subheading',
						'name'  => 'p2p_benefits_subtext',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-p2p-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_p2p_final_cta',
				'title'    => 'Procure to Pay Final CTA',
				'fields'   => array(
					array(
						'key'   => 'field_p2p_final_cta_heading',
						'label' => 'Heading',
						'name'  => 'p2p_final_cta_heading',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_p2p_final_cta_accent',
						'label'        => 'Accent line (italic)',
						'name'         => 'p2p_final_cta_accent',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide it.',
					),
					array(
						'key'          => 'field_p2p_final_cta_primary_text',
						'label'        => 'Primary button text',
						'name'         => 'p2p_final_cta_primary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_p2p_final_cta_primary_url',
						'label' => 'Primary button URL',
						'name'  => 'p2p_final_cta_primary_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_p2p_final_cta_secondary_text',
						'label'        => 'Secondary button text',
						'name'         => 'p2p_final_cta_secondary_text',
						'type'         => 'text',
						'instructions' => 'Leave blank to hide the button.',
					),
					array(
						'key'   => 'field_p2p_final_cta_secondary_url',
						'label' => 'Secondary button URL',
						'name'  => 'p2p_final_cta_secondary_url',
						'type'  => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-p2p-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_groups',
				'title'    => 'CRM Customer Groups',
				'fields'   => array(
					array(
						'key'           => 'field_crm_groups_heading',
						'label'         => 'Heading',
						'name'          => 'crm_groups_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_groups_subtext',
						'label'         => 'Subheading',
						'name'          => 'crm_groups_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_crm_groups_items',
						'label'         => 'Checklist items',
						'name'          => 'crm_groups_items',
						'type'          => 'textarea',
						'rows'          => 8,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_crm_groups_image',
						'label'         => 'Section image',
						'name'          => 'crm_groups_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-groups',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_clients',
				'title'    => 'CRM Social Proof',
				'fields'   => array(
					array(
						'key'           => 'field_crm_clients_heading',
						'label'         => 'Heading',
						'name'          => 'crm_clients_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_clients_subtext',
						'label'         => 'Subtext',
						'name'          => 'crm_clients_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-clients',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_flows',
				'title'    => 'CRM Workflow Links',
				'fields'   => array(
					array(
						'key'           => 'field_crm_flows_heading',
						'label'         => 'Heading',
						'name'          => 'crm_flows_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_flows_subtext',
						'label'         => 'Subheading',
						'name'          => 'crm_flows_subtext',
						'type'          => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-flows',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_hero',
				'title'    => 'CRM Hero',
				'fields'   => array(
					array(
						'key'           => 'field_crm_hero_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'crm_hero_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
						'default_value' => 'CRM',
					),
					array(
						'key'           => 'field_crm_hero_heading',
						'label'         => 'Heading',
						'name'          => 'crm_hero_heading',
						'type'          => 'text',
						'default_value' => 'Turn Contacts into Customers',
					),
					array(
						'key'           => 'field_crm_hero_highlight',
						'label'         => 'Accent line (italic)',
						'name'          => 'crm_hero_highlight',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
					),
					array(
						'key'           => 'field_crm_hero_subtext',
						'label'         => 'Subtext',
						'name'          => 'crm_hero_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
					),
					array(
						'key'           => 'field_crm_hero_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'crm_hero_primary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
						'default_value' => 'Start free trial now',
					),
					array(
						'key'           => 'field_crm_hero_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'crm_hero_primary_url',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_hero_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'crm_hero_secondary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
						'default_value' => 'Book a free demo now',
					),
					array(
						'key'           => 'field_crm_hero_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'crm_hero_secondary_url',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_hero_image',
						'label'         => 'Hero image',
						'name'          => 'crm_hero_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown below the buttons. Leave empty to hide.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-hero',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_features',
				'title'    => 'CRM Features',
				'fields'   => array(
					array(
						'key'           => 'field_crm_features_heading',
						'label'         => 'Heading',
						'name'          => 'crm_features_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_features_subtext',
						'label'         => 'Subheading',
						'name'          => 'crm_features_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_crm_features_items',
						'label'         => 'Checklist items',
						'name'          => 'crm_features_items',
						'type'          => 'textarea',
						'rows'          => 8,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_crm_features_image',
						'label'         => 'Section image',
						'name'          => 'crm_features_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-features',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_comms',
				'title'    => 'CRM Communications',
				'fields'   => array(
					array(
						'key'           => 'field_crm_comms_heading',
						'label'         => 'Heading',
						'name'          => 'crm_comms_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_comms_subtext',
						'label'         => 'Subheading',
						'name'          => 'crm_comms_subtext',
						'type'          => 'textarea',
						'rows'          => 2,
					),
					array(
						'key'           => 'field_crm_comms_items',
						'label'         => 'Checklist items',
						'name'          => 'crm_comms_items',
						'type'          => 'textarea',
						'rows'          => 8,
						'instructions'  => 'One per line.',
					),
					array(
						'key'           => 'field_crm_comms_image',
						'label'         => 'Section image',
						'name'          => 'crm_comms_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'instructions'  => 'Sits beside the checklist. Leave empty for a centred, full-width list.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-comms',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_benefits',
				'title'    => 'CRM Benefits Section',
				'fields'   => array(
					array(
						'key'           => 'field_crm_benefits_heading',
						'label'         => 'Heading',
						'name'          => 'crm_benefits_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_benefits_subtext',
						'label'         => 'Intro',
						'name'          => 'crm_benefits_subtext',
						'type'          => 'textarea',
						'rows'          => 3,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-benefits',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_crm_final_cta',
				'title'    => 'CRM Final CTA',
				'fields'   => array(
					array(
						'key'           => 'field_crm_final_cta_heading',
						'label'         => 'Heading',
						'name'          => 'crm_final_cta_heading',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_final_cta_accent',
						'label'         => 'Accent line (italic)',
						'name'          => 'crm_final_cta_accent',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide it.',
					),
					array(
						'key'           => 'field_crm_final_cta_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'crm_final_cta_primary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
					),
					array(
						'key'           => 'field_crm_final_cta_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'crm_final_cta_primary_url',
						'type'          => 'text',
					),
					array(
						'key'           => 'field_crm_final_cta_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'crm_final_cta_secondary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
					),
					array(
						'key'           => 'field_crm_final_cta_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'crm_final_cta_secondary_url',
						'type'          => 'text',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-crm-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_final_cta',
				'title'    => 'Final CTA',
				'fields'   => array(
					array(
						'key'           => 'field_final_cta_heading',
						'label'         => 'Heading',
						'name'          => 'final_cta_heading',
						'type'          => 'text',
						'default_value' => "Don't just take our word for it.",
					),
					array(
						'key'           => 'field_final_cta_accent',
						'label'         => 'Accent line (italic)',
						'name'          => 'final_cta_accent',
						'type'          => 'text',
						'instructions'  => 'Shown under the heading in the accent colour. Leave blank to hide it.',
						'default_value' => 'Try it free for 14 days.',
					),
					array(
						'key'           => 'field_final_cta_primary_text',
						'label'         => 'Primary button text',
						'name'          => 'final_cta_primary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
						'default_value' => 'Start free trial',
					),
					array(
						'key'           => 'field_final_cta_primary_url',
						'label'         => 'Primary button URL',
						'name'          => 'final_cta_primary_url',
						'type'          => 'text',
						'default_value' => '#plans',
					),
					array(
						'key'           => 'field_final_cta_secondary_text',
						'label'         => 'Secondary button text',
						'name'          => 'final_cta_secondary_text',
						'type'          => 'text',
						'instructions'  => 'Leave blank to hide the button.',
						'default_value' => 'Book a demo',
					),
					array(
						'key'           => 'field_final_cta_secondary_url',
						'label'         => 'Secondary button URL',
						'name'          => 'final_cta_secondary_url',
						'type'          => 'text',
						'default_value' => '#contact',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-final-cta',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_pricing_plans_section',
				'title'    => 'Pricing Plans Section',
				'fields'   => array(
					array(
						'key'           => 'field_plans_intro',
						'label'         => 'Intro text (above toggle)',
						'name'          => 'plans_intro',
						'type'          => 'text',
						'default_value' => 'Choose monthly for flexibility, or annual to get two months free. Switch whenever you like.',
					),
					array(
						'key'           => 'field_plans_monthly_label',
						'label'         => 'Monthly toggle label',
						'name'          => 'plans_monthly_label',
						'type'          => 'text',
						'default_value' => 'Monthly',
					),
					array(
						'key'           => 'field_plans_annual_label',
						'label'         => 'Annual toggle label',
						'name'          => 'plans_annual_label',
						'type'          => 'text',
						'default_value' => 'Annual',
					),
					array(
						'key'           => 'field_plans_annual_badge',
						'label'         => 'Annual badge',
						'name'          => 'plans_annual_badge',
						'type'          => 'text',
						'default_value' => '2 months free',
					),
					array(
						'key'           => 'field_plans_price_note_monthly',
						'label'         => 'Price caption — monthly',
						'name'          => 'plans_price_note_monthly',
						'type'          => 'text',
						'instructions'  => 'Small line under each price while the toggle is set to Monthly.',
						'default_value' => 'per month, billed monthly',
					),
					array(
						'key'           => 'field_plans_price_note_annual',
						'label'         => 'Price caption — annual',
						'name'          => 'plans_price_note_annual',
						'type'          => 'text',
						'instructions'  => 'Small line under each price while the toggle is set to Annual. Use <code>{badge}</code> to insert the Annual badge above, so the two stay in step.',
						'default_value' => 'per month, billed annually · {badge}',
					),
					array(
						'key'           => 'field_plans_footnote',
						'label'         => 'Footnote (below cards)',
						'name'          => 'plans_footnote',
						'type'          => 'textarea',
						'rows'          => 3,
						'instructions'  => 'The <code>&lt;strong&gt;</code> tag is allowed for emphasis.',
						'default_value' => 'All plans include a <strong>14-day free trial</strong> and <strong>free migration</strong> from Xero, QuickBooks or spreadsheets. No credit card required.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-pricing-plans',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_vs_netsuite_section',
				'title'    => 'You vs NetSuite Section',
				'fields'   => array(
					array(
						'key'           => 'field_vs_eyebrow',
						'label'         => 'Eyebrow pill',
						'name'          => 'vs_eyebrow',
						'type'          => 'text',
						'instructions'  => 'Small pill above the heading. Leave blank to hide it.',
						'default_value' => 'You vs NetSuite',
					),
					array(
						'key'           => 'field_vs_heading',
						'label'         => 'Heading',
						'name'          => 'vs_heading',
						'type'          => 'text',
						'default_value' => 'Live in days, not months, for a fraction of the cost.',
					),
					array(
						'key'           => 'field_vs_quote_text',
						'label'         => 'Quote',
						'name'          => 'vs_quote_text',
						'type'          => 'textarea',
						'instructions'  => 'The <code>&lt;strong&gt;</code> tag is allowed for emphasis.',
						'rows'          => 3,
						'default_value' => "NetSuite does everything we do, but costs 10 to 30× more and takes months to implement. We're live in days, for a fraction of the cost. No consultants, no connectors.",
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-vs-netsuite',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_pricing_faq_section',
				'title'    => 'Pricing FAQ Section',
				'fields'   => array(
					array(
						'key'           => 'field_faq_heading',
						'label'         => 'Heading',
						'name'          => 'faq_heading',
						'type'          => 'text',
						'default_value' => 'Frequently asked questions',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-content-pricing-faq',
						),
					),
				),
			)
		);
	}
);
