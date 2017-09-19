<?php
/**
 * Dokan settings Class
 *
 * @author weDves <info@wedevs.com>
 */
class Woofreendor_Template_Main {

	/**
     * Load autometically when class inistantiate
     * hooked up all actions and filters
     *
     * @since 2.4
     */
    function __construct() {
        // remove_action( 'dokan_dashboard_content_before', array( Dokan_Template_Main::init(), 'get_dashboard_side_navigation' ), 10 );
        add_action( 'woofreendor_dashboard_content_before', array( $this, 'get_dashboard_side_navigation' ), 10 );
        add_action( 'template_redirect', array( $this, 'redirect_logged_in_user'),100);
        // add_action( 'woofreendor_dashboard_content_before', array( $this, 'get_dashboard_side_navigation' ), 10 );
    }

    /**
     * Singleton method
     *
     * @return self
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor_Template_Main();
        }

        return $instance;
    }

    /**
     * Get Dashboard Side Navigations
     *
     * @since 2.4
     *
     * @return void
     */
    public function get_dashboard_side_navigation() {
    	global $wp;
    	$request = $wp->request;
        // var_dump($request);
    	$active = explode('/', $request );
    	unset( $active[0] );

    	if ( $active ) {
    		$active_menu = implode( '/', $active );

            if ( $active_menu == 'new-outlet' ) {
                $active_menu = 'outlets';
            }

            if ( get_query_var( 'edit' ) && is_singular( 'outlet' ) ) {
                $active_menu = 'outlets';
            }
    	} else {
    		$active_menu = 'tenant-dashboard';
    	}

    	woofreendor_get_template_part( 'global/dashboard-nav', '', array( 'active_menu' => apply_filters( 'dokan_dashboard_nav_active', $active_menu, $request, $active ) ) );
    }

    public function redirect_logged_in_user(){

        if(is_account_page() && is_user_logged_in()) {
            if(woofreendor_is_user_tenant(get_current_user_id()) ){
                $url = woofreendor_get_page_url('tenant_dashboard','woofreendor');
                wp_redirect( $url );
                die;
            }
            else if(dokan_is_user_seller(get_current_user_id())){
                $url = dokan_get_page_url('dashboard','dokan_pages');
                wp_redirect( $url );
                die;
            }else{
                $url = dokan_get_page_url( 'myaccount', 'woocommerce' );
                wp_redirect( $url );
                die;
            }

        }
    }
}