<?php

/**
 * Dokan Pro Report Class
 *
 * @since 2.4
 *
 * @package dokan
 *
 */
class Woofreendor_Woocommerce {

    public function __construct() {
        add_filter( 'woocommerce_account_menu_items', array( $this, 'woo_remove_product_tabs'), 98 );
    }

    
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Woofreendor_Woocommerce();
        }

        return $instance;
    }

    public function woo_remove_product_tabs($tabs){
        global $wp;
        
        unset( $tabs['downloads'] );

        return $tabs;
    }

}
