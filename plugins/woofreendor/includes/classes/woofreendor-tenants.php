<?php

/**
 * Dokan Pro Report Class
 *
 * @since 2.4
 *
 * @package dokan
 *
 */
class Woofreendor_Tenants {

    public function __construct() {
        add_filter( 'dokan_get_dashboard_settings_nav', array( $this, 'load_settings_menu' ), 10 );
    }

    
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Woofreendor_Tenants();
        }

        return $instance;
    }

    public function load_tenants_template( $query_vars ) {
        if ( isset( $query_vars['reports'] ) ) {
            dokan_get_template_part( 'report/reports', '', array( 'pro' => true ) );
            return;
        }
    }

    public function load_settings_menu( $sub_settings ) {

        if ( woofreendor_is_user_tenant( get_current_user_id() ) ) {

            $sub_settings['tenant'] = array(
                'title' => __( 'Tenant', 'woofreendor' ),
                'icon'  => '<i class="fa fa-share-alt-square"></i>',
                'url'   => woofreendor_get_navigation_url( 'settings/tenant' ),
                'pos'   => 30
                );
        }
        else{

        }

        return $sub_settings;
    }

}
