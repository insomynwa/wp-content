<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Woofreendor_Admin{

	public function __construct( ) {
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'dokan_admin_menu', array($this, 'mod_admin_menu') ,10,2);
        add_action( 'admin_notices', array($this, 'debug_admin_menus') );
	}

	// public function woofreendor_admin_enqueue_scripts_and_styles(){
	// 	wp_enqueue_style( 'woofreendor-bootstrap-style', plugins_url() . '/woofreendor/assets/css/bootstrap.min.css');
	// 	wp_register_script( 'woofreendor-bootstrap-script', plugins_url() . '/woofreendor/assets/js/bootstrap.min.js',array('jquery') );
	// 	wp_enqueue_script('woofreendor-bootstrap-script');
 //        wp_enqueue_script( 'woofreendor-admin', plugins_url() . '/woofreendor/assets/js/woofreendor-admin.js', array( 'jquery' ) );
	// }

	function admin_menu(){
        $menu_position = apply_filters( 'woofreendor_menu_position', 16 );
        $capability    = apply_filters( 'woofreendor_menu_capability', 'manage_options' );

		$dashboard = add_menu_page( __( 'Woofreendor', 'woofreendor' ), __( 'Woofreendor', 'woofreendor' ), $capability, 'woofreendor', array( $this, 'dashboard'), 'data:image/svg+xml;base64,' . base64_encode( '<svg width="2048" height="1792" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M657 896q-162 5-265 128h-134q-82 0-138-40.5t-56-118.5q0-353 124-353 6 0 43.5 21t97.5 42.5 119 21.5q67 0 133-23-5 37-5 66 0 139 81 256zm1071 637q0 120-73 189.5t-194 69.5h-874q-121 0-194-69.5t-73-189.5q0-53 3.5-103.5t14-109 26.5-108.5 43-97.5 62-81 85.5-53.5 111.5-20q10 0 43 21.5t73 48 107 48 135 21.5 135-21.5 107-48 73-48 43-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-1024-1277q0 106-75 181t-181 75-181-75-75-181 75-181 181-75 181 75 75 181zm704 384q0 159-112.5 271.5t-271.5 112.5-271.5-112.5-112.5-271.5 112.5-271.5 271.5-112.5 271.5 112.5 112.5 271.5zm576 225q0 78-56 118.5t-138 40.5h-134q-103-123-265-128 81-117 81-256 0-29-5-66 66 23 133 23 59 0 119-21.5t97.5-42.5 43.5-21q124 0 124 353zm-128-609q0 106-75 181t-181 75-181-75-75-181 75-181 181-75 181 75 75 181z"/></svg>' ), $menu_position );

        add_submenu_page( 'woofreendor', __( 'Tenant Listing', 'woofreendor' ), __( 'All Tenants', 'woofreendor' ), $capability, 'woofreendor-tenants', array($this, 'tenant_listing_dashboard' ) );

        add_action( $dashboard, array($this, 'dashboard_script' ) );
        //add_action( $settings, array($this, 'dashboard_script' ) );
	}

	function mod_admin_menu( $paramCapability, $paramMenuPosition ){
		remove_submenu_page( 'dokan', 'dokan-pro-features' );
		remove_submenu_page( 'dokan', 'dokan-addons' );
	}

    function dashboard() {
        include dirname(__FILE__) . '/dashboard.php';
    }

	function tenant_listing_dashboard() {
        include 'html-woofreendor-tenant.php';
    }

    function dashboard_script(){
    	wp_enqueue_style( 'dokan-admin-dash', DOKAN_PLUGIN_ASSEST . '/css/admin.css' );

        wp_enqueue_style( 'dokan-admin-report', DOKAN_PLUGIN_ASSEST . '/css/admin.css' );
        wp_enqueue_style( 'jquery-ui' );
        wp_enqueue_style( 'dokan-chosen-style' );

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'dokan-flot' );
        wp_enqueue_script( 'dokan-chart' );
        wp_enqueue_script( 'dokan-chosen' );

        do_action( 'dokan_enqueue_admin_dashboard_script' );
    }
	
	function debug_admin_menus() {
		if ( !is_admin())
			return;
		
		$limit = 5;
		$my_debug = array();
		// $my_debug = woofreendor_get_best_selling_products( $limit );
		echo '<pre>';
		print_r($my_debug);
		echo '</pre>';
	}

}
new Woofreendor_Admin();