<?php

/**
 * Dokan Pro Report Class
 *
 * @since 2.4
 *
 * @package dokan
 *
 */
class Woofreendor_Outlets {

    public function __construct() {
        // add_filter( 'dokan_query_var_filter', array( $this, 'load_outlet_menu' ) );
        add_filter( 'dokan_get_dashboard_nav', array( $this, 'add_outlets_menu' ) );
        add_action( 'dokan_load_custom_template', array( $this, 'load_outlets_template' ) );
        // add_action( 'dokan_report_content_area_header', array( $this, 'outlet_header_render' ) );
        // add_action( 'dokan_report_content', array( $this, 'render_review_content' ) );
        // add_action( 'template_redirect', array( $this, 'handle_statement' ) );
        // add_action( 'dokan_report_content_area_header', array( $this, 'report_header_render' ) );
        // add_action( 'dokan_report_content', array( $this, 'render_review_content' ) );
        // add_action( 'template_redirect', array( $this, 'handle_statement' ) );
    }

    
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Woofreendor_Outlets();
        }

        return $instance;
    }

    public function add_outlets_menu( $paramUrls ){
        if ( woofreendor_is_user_tenant( get_current_user_id() ) ) {
            $paramUrls['outlets'] = array(
                'title' => __( 'Outlets', 'woofreendor' ),
                'icon'  => '<i class="fa fa-line-chart"></i>',
                'url'   => woofreendor_get_navigation_url( 'outlets' ),
                'pos'   => 30
            );
        }

        return $paramUrls;
    }

    public function load_outlets_template( $query_vars ) {//var_dump($query_vars);die;
        if ( woofreendor_is_user_tenant( get_current_user_id() ) && isset( $query_vars['outlets'] ) ) {
            woofreendor_get_template_part( 'outlets/outlets' );
            return;
        }
        // if ( isset( $query_vars['new-outlet'] ) ) {
        //     do_action( 'woofreendor_render_new_outlet_template', $wp->query_vars );
        //     return;
        // }
    }

    public function outlet_header_render() {
        woofreendor_get_template_part( 'outlets/header' );
    }

    // public function load_outlet_menu($query_vars){
    //     $query_vars['outlets'] = 'outlets';
    //     return $query_vars;
    // }

}
