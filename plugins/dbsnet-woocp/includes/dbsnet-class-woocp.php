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
		$this->loader->add_action( 'save_post', $admin, 'save_update_product' );

		// Load javascript or styles
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts_and_styles' );

		$this->loader->add_action( 'add_meta_boxes_product', $admin, 'dbsnet_woocp_remove_woocommerce_product_data');
		$this->loader->add_action( 'add_meta_boxes_product', $admin, 'dbsnet_woocp_add_batch_meta_box_product');
		//$this->loader->add_action( 'add_meta_boxes', $admin, 'add_woocp_product_metabox', 10, 1 );

		// Add Row Batch
		$this->loader->add_action('wp_ajax_AjaxAddBatch', $admin, 'AddBatch');
		$this->loader->add_action('wp_ajax_AjaxUpdateBatch', $admin, 'UpdateBatch');
		$this->loader->add_action('wp_ajax_AjaxDeleteBatch', $admin, 'DeleteBatch');

		$this->loader->add_filter('get_sample_permalink_html', $admin, 'dbsnet_woocp_remove_permalink_under_title');
		$this->loader->add_filter('mce_buttons', $admin, 'dbsnet_woocp_customize_first_toolbar' );
		$this->loader->add_action('admin_head', $admin, 'dbsnet_woocp_remove_add_media');
		$this->loader->add_filter('wp_editor_settings', $admin, 'dbsnet_woocp_remove_text_tab');
		$this->loader->add_filter('get_user_option_screen_layout_product', $admin, 'dbsnet_woocp_single_column_layout');
		$this->loader->add_filter('get_user_option_meta-box-order_product',$admin,'dbsnet_woocp_metabox_order');
		$this->loader->add_action('admin_head',$admin,'dbsnet_woocp_hide_publishing_actions');
		$this->loader->add_action('admin_head',$admin,'dbsnet_woocp_hide_export_import_actions');
		
		$this->loader->add_filter('post_row_actions',$admin,'dbsnet_woocp_remove_link', 15, 2);

		$this->loader->add_action('wp_before_admin_bar_render', $admin,'dbsnet_woocp_customize_admin_bar',100);
		// $this->loader->add_filter('wp_insert_post_data', $admin, 'dbsnet_woocp_force_post_status_published',0,1);

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