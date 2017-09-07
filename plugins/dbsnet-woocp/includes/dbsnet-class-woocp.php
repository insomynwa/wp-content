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
		$this->define_woocommerce_hooks();
		$this->define_customizer_hooks();
		$this->define_multitenant_hooks();
		$this->define_widget_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dbsnet-class-woocp-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dbsnet-woocp-class-admin-dashboard.php';
		require_once plugin_dir_path( __FILE__ ) . 'dbsnet-class-woocp-loader.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/dbsnet-woocp-customizer.php';
		require_once plugin_dir_path( __FILE__ ) . 'tenant/dbsnet-woocp-class-tenant.php';
		require_once plugin_dir_path( __FILE__ ) . 'outlet/dbsnet-woocp-class-outlet.php';
		require_once plugin_dir_path( __FILE__ ) . 'product/dbsnet-woocp-class-product.php';
		require_once plugin_dir_path( __FILE__ ) . 'order/dbsnet-woocp-class-order.php';
		require_once plugin_dir_path( __FILE__ ) . 'widget/dbsnet-woocp-class-widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'dbsnet-woocp-class-woocommerce.php';
		require_once plugin_dir_path( __FILE__ ) . 'dbsnet-woocp-class-utility.php';
		require_once plugin_dir_path( __FILE__ ) . 'dbsnet-woocp-class-data.php';

		$this->loader = new DBSnet_Woocp_Loader();
	}

	private function define_admin_hooks() {

		$admin = new DBSnet_Woocp_Admin( $this->get_version() );
		$admin_dashboard = new DBSnet_Woocp_Admin_Dashboard();
		$data_woocp = new DBSnet_Woocp_Data();

		$this->loader->add_action( 'save_post', $admin, 'dbsnet_woocp_save_update_product' );

		// Load javascript or styles
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'dbsnet_woocp_enqueue_scripts_and_styles' );

		// Add Row Batch
		$this->loader->add_action('wp_ajax_AjaxAddBatch', $admin, 'dbsnet_woocp_add_new_batch_ajax');
		$this->loader->add_action('wp_ajax_AjaxUpdateBatch', $admin, 'dbsnet_woocp_update_batch_ajax');
		$this->loader->add_action('wp_ajax_AjaxDeleteBatch', $admin, 'dbsnet_woocp_delete_batch_ajax');

		//$this->loader->add_action('wp_print_scripts', $admin, 'dbsnet_woocp_remove_customer_password_strength',100);

		$this->loader->add_action( 'admin_menu', $admin_dashboard, 'dbsnet_woocp_admin_menu');

		//$this->loader->add_action( 'dokan_checkout_update_order_meta', $data_woocp, 'dbsnet_woocp_sync_insert_order');
	}

	private function define_customizer_hooks(){
		$customizer = new DBSnet_Woocp_Customizer();

		// Admin Menu
		//$this->loader->add_action( 'admin_menu', $customizer, 'dbsnet_woocp_customize_admin_menu',400);

		// Misc
		

		// Product
		// A. List
		$this->loader->add_filter('bulk_actions-edit-product', $customizer, 'dbsnet_woocp_product_bulk',999,1);

		// B. Form
		$this->loader->add_action( 'add_meta_boxes_product', $customizer, 'dbsnet_woocp_metabox_product');
		//$this->loader->add_action( 'add_meta_boxes_product', $customizer, 'dbsnet_woocp_remove_woocommerce_product_data');
		//$this->loader->add_action( 'add_meta_boxes_product', $customizer, 'dbsnet_woocp_add_batch_meta_box_product');

		// Order
		// A. List
		$this->loader->add_filter('bulk_actions-edit-shop_order', $customizer, 'dbsnet_woocp_order_bulk',999,1);
		// $this->loader->add_filter('woocommerce_shop_order_search_fields', $customizer, 'dbsnet_woocp_search_customer_order',999,1);

		// General custom
		$this->loader->add_filter('post_row_actions', $customizer,'dbsnet_woocp_post_row_actions', 15, 2);
		$this->loader->add_action('admin_print_footer_scripts', $customizer, 'dbsnet_woocp_page_title_actions');
		//$this->loader->add_action('admin_head', $customizer, 'dbsnet_woocp_page_title_actions');

		//$this->loader->add_filter('manage_edit-shop_order_columns', $customizer, 'dbsnet_woocp_order_custom_column',20,1);
		//$this->loader->add_action('manage_shop_order_posts_custom_column', $customizer, 'dbsnet_woocp_order_custom_column_value',10,2);

		

		//$this->loader->add_action( 'add_meta_boxes_shop_order', $customizer, 'dbsnet_woocp_remove_order_metabox');
		//$this->loader->add_filter('get_user_option_meta-box-order_product',$customizer,'dbsnet_woocp_metabox_order');

		$this->loader->add_action( 'user_new_form', $customizer, 'dbsnet_woocp_new_user_form_custom_field');
		$this->loader->add_action( 'pre_get_posts', $customizer, 'dbsnet_woocp_custom_filter_product_list');
		//$this->loader->add_filter('get_sample_permalink_html', $customizer, 'dbsnet_woocp_remove_permalink_under_title');
		//$this->loader->add_filter('mce_buttons', $customizer, 'dbsnet_woocp_customize_first_toolbar' );
		//$this->loader->add_action('admin_head', $customizer, 'dbsnet_woocp_remove_add_media');
		//$this->loader->add_filter('wp_editor_settings', $customizer, 'dbsnet_woocp_remove_text_tab');
		$this->loader->add_filter('screen_layout_columns', $customizer, 'dbsnet_woocp_screen_column_layout',10,3);
		$this->loader->add_filter('get_user_option_screen_layout_product', $customizer, 'dbsnet_woocp_single_column_layout');
		$this->loader->add_filter('get_user_option_screen_layout_dashboard', $customizer, 'dbsnet_woocp_single_column_layout');
		$this->loader->add_filter('get_user_option_screen_layout_shop_order', $customizer, 'dbsnet_woocp_single_column_layout');
		//$this->loader->add_action('admin_head',$customizer, 'dbsnet_woocp_hide_publishing_actions');
		
		

		$this->loader->add_action('wp_before_admin_bar_render', $customizer, 'dbsnet_woocp_customize_admin_bar',100);

		//$this->loader->add_action('admin_head',$customizer,'dbsnet_woocp_hide_recalculate_order',100);

		
	}
	
	private function define_multitenant_hooks(){
		$multitenant = new DBSnet_Woocp_Multitenant_Admin();
		
		$this->loader->add_action( 'admin_notices', $multitenant, 'debug_admin_menus');

		$this->loader->add_action( 'user_register', $multitenant, 'dbsnet_woocp_grouping_new_user');
		$this->loader->add_action( 'delete_user', $multitenant, 'dbsnet_woocp_remove_deleted_user_component');
	}

	private function define_widget_hooks(){
		$widget = new DBSnet_Woocp_Widget();
		$this->loader->add_action( 'wp_dashboard_setup', $widget, 'dbsnet_woocp_widget',20);
	}

	private function define_woocommerce_hooks(){
		$frontend = new DBSnet_Woocp_Woocommerce();
		// $this->loader->add_action( 'woocommerce_new_order_item', $frontend, 'dbsnet_woocp_order_item_meta',10,3);
		//$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $frontend, 'dbsnet_woocp_create_sub_order',10);
	}

	public function run() {
		$this->loader->run();
	}

	public function get_version() {
		return $this->version;
	}
}