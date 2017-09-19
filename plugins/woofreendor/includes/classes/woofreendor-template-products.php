<?php

/**
*  Product Functionality for Product Handler
*
*  @since 2.4
*
*  @package woofreendor
*/
class Woofreendor_Template_Products {

    public static $errors;
    public static $product_cat;
    public static $post_content;

    /**
     *  Load autometially when class initiate
     *
     *  @since 2.4
     *
     *  @uses actions
     *  @uses filters
     */
    function __construct() {
        remove_action( 'dokan_render_product_listing_template', array(Dokan_Template_Products::init(),'render_product_listing_template'), 11 );
        remove_action( 'dokan_render_product_edit_template', array(Dokan_Template_Products::init(),'load_product_edit_template'), 11 );
        remove_action( 'dokan_render_new_product_template', array(Dokan_Template_Products::init(),'render_new_product_template'), 10 );
        remove_action( 'dokan_after_listing_product', array(Dokan_Template_Products::init(),'load_add_new_product_popup'), 10 );

        add_action( 'dokan_render_product_listing_template', array( $this, 'render_product_listing_template' ), 11 );
        add_action( 'dokan_render_product_edit_template', array( $this, 'load_product_edit_template' ), 11 );
        add_action( 'dokan_render_new_product_template', array( $this, 'render_new_product_template' ), 10 );
        add_action( 'dokan_after_listing_product', array( $this, 'load_add_new_product_popup' ), 10 );
        add_action( 'dokan_new_product_added', array( $this, 'load_add_new_product_meta' ),10,2);
        

        add_action( 'woofreendor_batches_row', array( $this, 'woofreendor_render_batches_row' ), 10 );
        add_action( 'dokan_product_content_inside_area_after', array( $this, 'product_content_inside_area_after' ) );
        add_filter( 'dokan_product_types', array( $this, 'set_default_product_types' ) );
    }

    /**
     * Singleton method
     *
     * @return self
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor_Template_Products();
        }

        return $instance;
    }

    /**
     * Render New Product Template for only free version
     *
     * @since 2.4
     *
     * @param  array $query_vars
     *
     * @return void
     */
    public function render_new_product_template( $query_vars ) {
        if ( isset( $query_vars['new-product'] ) ) {
            // if(woofreendor_is_user_tenant(get_current_user_id())) {
                woofreendor_get_template_part( 'products/new-product' );
            // }else{
                // woofreendor_get_template_part( 'products/new-product-outlet' );
            // }
        }
    }

    /**
     * Load Product Edit Template
     *
     * @since 2.4
     *
     * @return void
     */
    function load_product_edit_template() {
        if(woofreendor_is_user_tenant(get_current_user_id())) {
            woofreendor_get_template_part( 'products/new-product-single' );
        }else{
            woofreendor_get_template_part( 'products/new-product-outlet' );
        }
        
    }

    /**
     * Render Product Listing Template
     *
     * @since 2.4
     *
     * @param  string $action
     *
     * @return void
     */
    function render_product_listing_template( $action ) {
        woofreendor_get_template_part( 'products/products-listing');
    }

    function load_add_new_product_popup() {
        if(woofreendor_is_user_tenant( get_current_user_id() ) ) {
            woofreendor_get_template_part( 'products/tmpl-add-product-popup' );
        }else{
            woofreendor_get_template_part( 'products/tmpl-add-outlet-product-popup' );
        }
        
    }

    function woofreendor_render_batches_row($paramProductId ){
        //echo Woofreendor_Template_Utility::GenerateHTML( plugin_dir_path( dirname(__DIR__) ) . 'templates/products/batches-row', $paramProductId);
        echo woofreendor_generate_html(plugin_dir_path( dirname(__DIR__) ) . 'templates/products/batches-row', $paramProductId);
    }

    function product_content_inside_area_after(){
        woofreendor_get_template_part( 'products/tmpl-update-batch-popup' );
        woofreendor_get_template_part( 'products/tmpl-delete-batch-popup' );
    }

    function set_default_product_types( $paramProductTypes){
        
        $paramProductTypes = array(
            'simple' => __( 'Simple', 'dokan' ),
            'variable' => __( 'Variable', 'dokan' ),
        );

        return $paramProductTypes;
    }

    function load_add_new_product_meta( $paramProductId, $paramProductData){
        // var_dump($paramProductData['product_parent']);
        if ( isset( $paramProductData['product_parent'] ) ) {
            update_post_meta( $paramProductId, 'product_parent', $paramProductData['product_parent'] );
        }
    }

}