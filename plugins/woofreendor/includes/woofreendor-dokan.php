<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Dokan{

	public function __construct( ) {
		
	}

	public function woofreendor_load_admin_settings( $paramCapability, $paramMenuPosition ){
		remove_submenu_page( 'dokan', 'dokan-pro-features' );
		remove_submenu_page( 'dokan', 'dokan-addons' );

		add_submenu_page( 'dokan', __( 'Tenant Listing', 'woofreendor' ), __( 'All Tenants', 'woofreendor' ), 'manage_options', 'woofreendor-tenants', array( $this, 'tenant_listing' ) );
	}

	public function woofreendor_remove_actions(){
		remove_action( 'dokan_render_product_listing_template', array(Dokan_Template_Products::init(),'render_product_listing_template'), 11 );
		remove_action( 'dokan_render_product_edit_template', array(Dokan_Template_Products::init(),'load_product_edit_template'), 11 );
		remove_action( 'dokan_after_listing_product', array(Dokan_Template_Products::init(),'load_add_new_product_popup'), 10 );
	}

	public function woofreendor_render_new_product_template( $paramQueryVars ) {
        if ( isset( $paramQueryVars['new-product'] ) && !WeDevs_Dokan::init()->is_pro_exists() ) {
            $this->_dokan_get_template_part( 'products/new-product' );
        }
    }

    public function woofreendor_render_product_listing_template( $action ){//var_dump("FUCK");die;
    	$this->_dokan_get_template_part( 'products/products-listing' );
    }

    public function woofreendor_load_add_new_product_popup(){
    	$this->_dokan_get_template_part( 'products/tmpl-add-product-popup' );
    }

    public function woofreendor_product_content_inside_area_after(){
    	$this->_dokan_get_template_part( 'products/tmpl-update-batch-popup' );
    	$this->_dokan_get_template_part( 'products/tmpl-delete-batch-popup' );
    }

    public function woofreendor_dokan_dashboard_nav($paramUrls){
    	$paramUrls['products']['title'] = 'Produk';
    	$paramUrls['orders']['title'] = 'Pemesanan';
    	$paramUrls['settings']['title'] = 'Pengaturan';

    	return $paramUrls;
    }

    public function woofreendor_load_product_edit_template(){
    	self::_dokan_get_template_part( 'products/new-product-single' );
    }

    public function product_edit_template($template){
    	if ( ! self::_is_woo_installed() ) {
            return $template;
        }

        if ( ! ( get_query_var( 'edit' ) && is_singular( 'product' ) ) ) {
            return $template;
        }

        $edit_product_url = self::_dokan_locate_template( 'products/new-product-single.php' );

        return apply_filters( 'dokan_get_product_edit_template', $edit_product_url );
    }

    public function woofreendor_set_default_product_types( $paramProductTypes){
    	
    	$paramProductTypes = array(
            'simple' => __( 'Simple', 'dokan' ),
            'variable' => __( 'Variable', 'dokan' ),
        );

        return $paramProductTypes;
    }

    public static function _dokan_product_listing_filter(){
    	self::_dokan_get_template_part( 'products/listing-filter' );
    }

    private function _is_woo_installed(){
    	return function_exists( 'WC' );
    }

    private function _dokan_locate_template( $template_name, $template_path = '', $default_path = '', $pro = false ) {
	    $dokan = WeDevs_Dokan::init();

	    if ( ! $template_path ) {
	        $template_path = $dokan->template_path();
	    }

	    if ( ! $default_path ) {
	        $default_path = untrailingslashit( plugin_dir_path( __DIR__ ) ) . '/templates/';
	    }

	    // Look within passed path within the theme - this is priority
	    $template = locate_template(
	        array(
	            trailingslashit( $template_path ) . $template_name,
	        )
	    );

	    // Get default template
	    if ( ! $template ) {
	        $template = $default_path . $template_name;
	    }

	    // Return what we found
	    return apply_filters('dokan_locate_template', $template, $template_name, $template_path );
	}

    private function _dokan_get_template_part( $slug, $name = '', $args = array() ) {
	    $dokan = WeDevs_Dokan::init();

	    $defaults = array(
	        'pro' => false
	    );

	    $args = wp_parse_args( $args, $defaults );

	    if ( $args && is_array( $args ) ) {
	        extract( $args );
	    }

	    $template = '';

	    // Look in yourtheme/dokan/slug-name.php and yourtheme/dokan/slug.php
	    $template = locate_template( array( $dokan->template_path() . "{$slug}-{$name}.php", $dokan->template_path() . "{$slug}.php" ) );

	    /**
	     * Change template directory path filter
	     *
	     * @since 2.5.3
	     */
	    $template_path = apply_filters( 'dokan_set_template_path', untrailingslashit( plugin_dir_path( __DIR__ ) ) . '/templates', $template, $args );

	    // Get default slug-name.php
	    if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
	        $template = $template_path . "/{$slug}-{$name}.php";
	    }

	    if ( ! $template && !$name && file_exists( $template_path . "/{$slug}.php" ) ) {
	        $template = $template_path . "/{$slug}.php";
	    }

	    // Allow 3rd party plugin filter template file from their plugin
	    $template = apply_filters( 'dokan_get_template_part', $template, $slug, $name );

	    if ( $template ) {
	        include( $template );
	    }
	}

	function tenant_listing() {
        include plugin_dir_path( __FILE__ ).'admin/html-woofreendor-tenant.php';
    }
}