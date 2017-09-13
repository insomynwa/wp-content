<?php
// if ( !defined( 'ABSPATH' ) ) {
// 	exit;
// }

// class Woofreendor_Main{
// 	protected $loader;
// 	protected $plugin_slug;
// 	protected $version;

// 	public function __construct() {
// 		$this->plugin_slug = 'woofreendor';
// 		$this->version = '0.1.0';

// 		$this->load_dependencies();
// 		$this->define_admin_hooks();
// 		//$this->define_woocommerce_hooks();
// 		$this->define_customizer_hooks();
// 		$this->define_ajax_hooks();
// 		$this->define_multitenant_hooks();
// 		//$this->define_widget_hooks();
// 		$this->define_dokan_hooks();
// 	}

// 	private function load_dependencies() {
// 		// require_once plugin_dir_path( __FILE__ ) . 'admin/woofreendor-admin.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'admin/woofreendor-admin-dashboard.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-loader.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-groups.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-customizer.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-tenant.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-outlet.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-product.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-order.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-widget.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-dokan.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-template-utility.php';
// 		//require_once plugin_dir_path( __FILE__ ) . 'woofreendor-ajax.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-batch.php';
// 		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-shortcode.php';

// 		$this->loader = new Woofreendor_Loader();
// 		// Woofreendor_Shortcode::init()->init_shortcode();
// 	}

// 	private function define_admin_hooks() {

// 		$admin = new Woofreendor_Admin( $this->get_version() );
// 		//$admin_dashboard = new Woofreendor_Admin_Dashboard();

// 		// $this->loader->add_action( 'admin_notices', $admin, 'debug_admin_menus');

// 		//$this->loader->add_action( 'save_post', $admin, 'woofreendor_save_update_product' );

// 		// Load javascript or styles
// 		// $this->loader->add_action( 'admin_enqueue_scripts', $admin, 'woofreendor_admin_enqueue_scripts_and_styles' );
		
// 		// $this->loader->add_action('wp_ajax_AjaxUpdateBatch', $admin, 'woofreendor_update_batch_ajax');
// 		// $this->loader->add_action('wp_ajax_AjaxDeleteBatch', $admin, 'woofreendor_delete_batch_ajax');

// 		//$this->loader->add_action('wp_print_scripts', $admin, 'woofreender_remove_customer_password_strength',100);
		
// 		//$this->loader->add_action( 'admin_menu', $admin_dashboard, 'woofreendor_admin_menu');
// 	}
	
// 	private function define_dokan_hooks(){//var_dump("FUCK");
// 		$wfd_dokan = new Woofreendor_Dokan();
		
// 		// $this->loader->add_action( 'dokan_admin_menu', $wfd_dokan, 'woofreendor_load_admin_settings', 10, 2);
// 		// $this->loader->add_action( 'wp_head', $wfd_dokan, 'woofreendor_remove_actions');
		
// 		// $this->loader->add_action( 'dokan_get_dashboard_nav', $wfd_dokan, 'woofreendor_dokan_dashboard_nav');
// 		// $this->loader->add_action( 'dokan_render_product_listing_template', $wfd_dokan, 'woofreendor_render_product_listing_template', 11);
// 		// $this->loader->add_action( 'dokan_render_product_edit_template', $wfd_dokan, 'woofreendor_load_product_edit_template', 11);
// 		//$this->loader->add_filter( 'template_include', $wfd_dokan, 'product_edit_template', 999,1);
// 		//$this->loader->add_filter( 'template_include', $wfd_dokan, 'tenant_template', 999,1);
// 		// $this->loader->add_filter( 'dokan_product_types', $wfd_dokan, 'woofreendor_set_default_product_types', 10, 1);
// 		// $this->loader->add_action( 'dokan_after_listing_product', $wfd_dokan, 'woofreendor_load_add_new_product_popup', 10);
// 		// $this->loader->add_action( 'dokan_product_content_inside_area_after', $wfd_dokan, 'woofreendor_product_content_inside_area_after');
// 		// $this->loader->add_action( 'dokan_render_new_product_template', $wfd_dokan, 'woofreendor_render_new_product_template', 10);
// 	}

// 	private function define_customizer_hooks(){
// 		$customizer = new Woofreendor_Customizer();

// 		// Admin Menu
// 		//$this->loader->add_action( 'admin_menu', $customizer, 'dbsnet_woocp_customize_admin_menu',400);

// 		// Misc

// 		// User Profile
// 		// $this->loader->add_action( 'show_user_profile', $customizer, 'woofreendor_add_user_meta_fields',10,1);
// 		// $this->loader->add_action( 'edit_user_profile', $customizer, 'woofreendor_add_user_meta_fields',10,1);
// 		// $this->loader->add_action( 'personal_options_update', $customizer, 'woofreendor_save_meta_fields',10,1);
// 		// $this->loader->add_action( 'edit_user_profile_update', $customizer, 'woofreendor_save_meta_fields',10,1);
		

// 		// Product
// 		// A. List
// 		//$this->loader->add_action('init', $customizer, 'woofreendor_register_scripts');
// 		//$this->loader->add_action('wp_enqueue_scripts', $customizer, 'woofreendor_scripts');
// 		// $this->loader->add_action('woofreendor_batches_row', $customizer, 'woofreendor_render_batches_row',10,1);
// 		//$this->loader->add_filter('woofreendor_localized_args', $customizer, 'woofreendor_conditional_localized_args',10,1);
// 		//$this->loader->add_filter('bulk_actions-edit-product', $customizer, 'dbsnet_woocp_product_bulk',999,1);

// 		// B. Form
// 		//$this->loader->add_action( 'add_meta_boxes_product', $customizer, 'dbsnet_woocp_metabox_product');
// 		//$this->loader->add_action( 'add_meta_boxes_product', $customizer, 'dbsnet_woocp_remove_woocommerce_product_data');
// 		//$this->loader->add_action( 'add_meta_boxes_product', $customizer, 'dbsnet_woocp_add_batch_meta_box_product');

// 		// Order
// 		// A. List
// 		//$this->loader->add_filter('bulk_actions-edit-shop_order', $customizer, 'dbsnet_woocp_order_bulk',999,1);
// 		// $this->loader->add_filter('woocommerce_shop_order_search_fields', $customizer, 'dbsnet_woocp_search_customer_order',999,1);

// 		// General custom
// 		//$this->loader->add_filter('post_row_actions', $customizer,'dbsnet_woocp_post_row_actions', 15, 2);
// 		//$this->loader->add_action('admin_print_footer_scripts', $customizer, 'dbsnet_woocp_page_title_actions');
// 		//$this->loader->add_action('admin_head', $customizer, 'dbsnet_woocp_page_title_actions');

// 		//$this->loader->add_filter('manage_edit-shop_order_columns', $customizer, 'dbsnet_woocp_order_custom_column',20,1);
// 		//$this->loader->add_action('manage_shop_order_posts_custom_column', $customizer, 'dbsnet_woocp_order_custom_column_value',10,2);

		

// 		//$this->loader->add_action( 'add_meta_boxes_shop_order', $customizer, 'dbsnet_woocp_remove_order_metabox');
// 		//$this->loader->add_filter('get_user_option_meta-box-order_product',$customizer,'dbsnet_woocp_metabox_order');

// 		//$this->loader->add_action( 'user_new_form', $customizer, 'dbsnet_woocp_new_user_form_custom_field');
// 		//$this->loader->add_action( 'pre_get_posts', $customizer, 'dbsnet_woocp_custom_filter_product_list');
// 		//$this->loader->add_filter('get_sample_permalink_html', $customizer, 'dbsnet_woocp_remove_permalink_under_title');
// 		//$this->loader->add_filter('mce_buttons', $customizer, 'dbsnet_woocp_customize_first_toolbar' );
// 		//$this->loader->add_action('admin_head', $customizer, 'dbsnet_woocp_remove_add_media');
// 		//$this->loader->add_filter('wp_editor_settings', $customizer, 'dbsnet_woocp_remove_text_tab');
// 		//$this->loader->add_filter('screen_layout_columns', $customizer, 'dbsnet_woocp_screen_column_layout',10,3);
// 		//$this->loader->add_filter('get_user_option_screen_layout_product', $customizer, 'dbsnet_woocp_single_column_layout');
// 		//$this->loader->add_filter('get_user_option_screen_layout_dashboard', $customizer, 'dbsnet_woocp_single_column_layout');
// 		//$this->loader->add_filter('get_user_option_screen_layout_shop_order', $customizer, 'dbsnet_woocp_single_column_layout');
// 		//$this->loader->add_action('admin_head',$customizer, 'dbsnet_woocp_hide_publishing_actions');
		
		

// 		//$this->loader->add_action('wp_before_admin_bar_render', $customizer, 'dbsnet_woocp_customize_admin_bar',100);

// 		//$this->loader->add_action('admin_head',$customizer,'dbsnet_woocp_hide_recalculate_order',100);	
// 	}

// 	private function define_ajax_hooks(){
// 		$wfd_ajax = new Woofreendor_Ajax();
		

// 		// $this->loader->add_action( 'wp_ajax_woofreendor_create_new_batch', $wfd_ajax, 'create_batch');
// 		// $this->loader->add_action( 'wp_ajax_woofreendor_update_batch', $wfd_ajax, 'update_batch');
// 		// $this->loader->add_action( 'wp_ajax_woofreendor_reload_batch', $wfd_ajax, 'reload_batch');
// 		// $this->loader->add_action( 'wp_ajax_woofreendor_delete_batch', $wfd_ajax, 'delete_batch');
// 	} 
	
// 	private function define_multitenant_hooks(){
// 		$wfd_groups = new Woofreendor_Groups();
		

// 		// $this->loader->add_action( 'user_register', $wfd_groups, 'woofreendor_new_user_group');
// 		// $this->loader->add_action( 'delete_user', $wfd_groups, 'woofreendor_remove_deleted_user_component');
// 	}

// 	private function define_widget_hooks(){
// 		$widget = new Woofreendor_Widget();
// 		$this->loader->add_action( 'wp_dashboard_setup', $widget, 'dbsnet_woocp_widget',20);
// 	}

// 	private function define_woocommerce_hooks(){
// 		$frontend = new Woofreendor_Woocommerce();
// 		// $this->loader->add_action( 'woocommerce_new_order_item', $frontend, 'dbsnet_woocp_order_item_meta',10,3);
// 		//$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $frontend, 'dbsnet_woocp_create_sub_order',10);
// 	}

// 	public function run() {
// 		$this->loader->run();
// 	}

// 	public function get_version() {
// 		return $this->version;
// 	}
// }