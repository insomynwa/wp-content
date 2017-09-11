<?php

/**
*  Product Functionality for Product Handler
*
*  @since 2.4
*
*  @package woofreendor
*/
class Woofreendor_Template_Outlets {

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
        add_action( 'woofreendor_render_new_outlet_template', array( $this, 'render_new_outlet_template' ), 10 );
        add_action( 'woofreendor_render_outlet_listing_template', array( $this, 'render_outlet_listing_template' ), 11 );
    }

    /**
     * Singleton method
     *
     * @return self
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor_Template_Outlets();
        }

        return $instance;
    }

    public function render_new_outlet_template( $query_vars ) {
        if ( isset( $query_vars['new-outlet'] ) && !WeDevs_Dokan::init()->is_pro_exists() ) {
            woofreendor_get_template_part( 'outlets/new-outlet' );
        }
    }

    function render_outlet_listing_template( $action ) {
        woofreendor_get_template_part( 'outlets/outlets-listing');
    }

}