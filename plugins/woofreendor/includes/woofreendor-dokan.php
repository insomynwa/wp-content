<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Dokan{

	public function __construct( ) {
		
	}

	// public function woofreendor_load_admin_settings( $paramCapability, $paramMenuPosition ){
	// 	remove_submenu_page( 'dokan', 'dokan-pro-features' );
	// 	remove_submenu_page( 'dokan', 'dokan-addons' );

	// 	add_submenu_page( 'dokan', __( 'Tenant Listing', 'woofreendor' ), __( 'All Tenants', 'woofreendor' ), 'manage_options', 'woofreendor-tenants', array( $this, 'tenant_listing' ) );
	// }

	// public function woofreendor_remove_actions(){
	// 	remove_action( 'dokan_render_product_listing_template', array(Dokan_Template_Products::init(),'render_product_listing_template'), 11 );
	// 	remove_action( 'dokan_render_product_edit_template', array(Dokan_Template_Products::init(),'load_product_edit_template'), 11 );
	// 	remove_action( 'dokan_render_new_product_template', array(Dokan_Template_Products::init(),'render_new_product_template'), 10 );
	// 	remove_action( 'dokan_after_listing_product', array(Dokan_Template_Products::init(),'load_add_new_product_popup'), 10 );
	// }

	// public function woofreendor_render_new_product_template( $paramQueryVars ) {
 //        if ( isset( $paramQueryVars['new-product'] ) && !WeDevs_Dokan::init()->is_pro_exists() ) {
 //            Woofreendor_Template_Utility::GetTemplatePart( 'products/new-product' );
 //        }
 //    }

    // public function woofreendor_render_product_listing_template( $action ){//var_dump("FUCK");die;
    // 	Woofreendor_Template_Utility::GetTemplatePart( 'products/products-listing' );
    // }

    // public function woofreendor_load_add_new_product_popup(){
    // 	Woofreendor_Template_Utility::GetTemplatePart( 'products/tmpl-add-product-popup' );
    // }

    // public function woofreendor_product_content_inside_area_after(){
    // 	Woofreendor_Template_Utility::GetTemplatePart( 'products/tmpl-update-batch-popup' );
    // 	Woofreendor_Template_Utility::GetTemplatePart( 'products/tmpl-delete-batch-popup' );
    // }

    // public function woofreendor_dokan_dashboard_nav($paramUrls){
    // 	$paramUrls['products']['title'] = 'Produk';
    // 	$paramUrls['orders']['title'] = 'Pemesanan';
    // 	$paramUrls['settings']['title'] = 'Pengaturan';
    // 	unset( $paramUrls['withdraw'] );

    // 	return $paramUrls;
    // }

    // public function woofreendor_load_product_edit_template(){
    // 	Woofreendor_Template_Utility::GetTemplatePart( 'products/new-product-single' );
    // }

    // public function product_edit_template($template){
    // 	if ( ! self::_is_woo_installed() ) {
    //         return $template;
    //     }

    //     if ( ! ( get_query_var( 'edit' ) && is_singular( 'product' ) ) ) {
    //         return $template;
    //     }

    //     $edit_product_url = Woofreendor_Template_Utility::LocateTemplate( 'products/new-product-single.php' );

    //     return apply_filters( 'dokan_get_product_edit_template', $edit_product_url );
    // }

    // public function tenant_template($template){
    //     $tenant_name = get_query_var( $this->custom_store_url );

    //     if ( ! self::_is_woo_installed() ) {
    //         return $template;
    //     }

    //     if ( !empty( $tenant_name ) ) {
    //         $tenant_user = get_user_by( 'slug', $tenant_name );

    //         // no user found
    //         if ( ! $tenant_user ) {
    //             return get_404_template();
    //         }

    //         // check if the user is seller
    //         if ( !user_can( $user_id, 'woofreendor_tenant' ) ) {
    //             return get_404_template();
    //         }

    //         return dokan_locate_template( 'tenant.php' );
    //     }

    //     return $template;
    // }

    // public function woofreendor_set_default_product_types( $paramProductTypes){
    	
    // 	$paramProductTypes = array(
    //         'simple' => __( 'Simple', 'dokan' ),
    //         'variable' => __( 'Variable', 'dokan' ),
    //     );

    //     return $paramProductTypes;
    // }

    // public static function _dokan_product_listing_filter(){
    // 	Woofreendor_Template_Utility::GetTemplatePart( 'products/listing-filter' );
    // }

    // private function _is_woo_installed(){
    // 	return function_exists( 'WC' );
    // }

	// function tenant_listing() {
 //        include plugin_dir_path( __FILE__ ).'admin/html-woofreendor-tenant.php';
 //    }
}