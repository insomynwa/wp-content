<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class DBSnet_Woocp{
	protected $loader;
	protected $plugin_slug;
	protected $version;

	public function __construct() {
		$this->plugin_slug = 'dbsnet-woocp-slug';
		$this->version = '0.1.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dbsnet-class-woocp-admin.php';
		require_once plugin_dir_path( __FILE__ ) . 'dbsnet-class-woocp-loader.php';
		//require_once plugin_dir_path(__FILE__) . 'dbsnet-woocp-wc-customizer.php';
		require_once plugin_dir_path(__FILE__) . 'dbsnet-woocp-shortcode.php';
		require_once plugin_dir_path(__FILE__) . 'dbsnet-woocp-class-batch.php';

		$this->loader = new DBSnet_Woocp_Loader();
	}

	private function define_admin_hooks() {

		$admin = new DBSnet_Woocp_Admin( $this->get_version() );
		$multitenant = new DBSnet_Woocp_Multitenant_Admin();
		$shortcode = new DBSnet_Woocp_Shortcode();

		//$wc_customizer = new DBSnet_Woocp_WC_Customizer( $this->get_version() );
		//$this->loader->add_action( 'init', $multitenant, 'RegisterWPCustomMultitenant');
		$this->loader->add_action( 'init', $shortcode, 'init' );

		$this->loader->add_action( 'admin_menu', $multitenant, 'dbsnet_woocp_filter_admin_menu',400);
		$this->loader->add_action( 'admin_notices', $multitenant, 'debug_admin_menus');
		$this->loader->add_action( 'user_register', $multitenant, 'grouping_new_user');
		$this->loader->add_action( 'user_new_form', $multitenant, 'adding_field_in_create_user_form');
		$this->loader->add_action( 'delete_user', $multitenant, 'DeleteUserComponent');
		$this->loader->add_action( 'pre_get_posts', $multitenant, 'ShowProductByOwner');

		// Load javascript or styles
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts_and_styles' );

		// Save Post data 
		$this->loader->add_action( 'save_post', $admin, 'save_update_product' );

		$this->loader->add_action( 'add_meta_boxes', $admin, 'add_woocp_product_metabox', 10, 1 );

		// Add Row Batch
		$this->loader->add_action('wp_ajax_AjaxAddBatch', $admin, 'AddBatch');
		$this->loader->add_action('wp_ajax_AjaxUpdateBatch', $admin, 'UpdateBatch');
		$this->loader->add_action('wp_ajax_AjaxDeleteBatch', $admin, 'DeleteBatch');

		// Customize Woocommerce
		//$this->loader->add_filter('woocommerce_account_menu_items', $wc_customizer, 'dbsnet_hide_account_menu_items');
		//$this->loader->add_filter('init', $wc_customizer, 'dbsnet_add_account_menu_items');
	}

	public function run() {
		$this->loader->run();
	}

	public function get_version() {
		return $this->version;
	}
}