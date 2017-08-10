<?php
class DBSnet_Woocp_Manager {
	protected $loader;
	protected $plugin_slug;
	protected $version;

	public function __construct() {
		$this->plugin_slug = 'dbsnet-woocp-manager-slug';
		$this->version = '0.1.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dbsnet-woocp-manager-admin.php';
		require_once plugin_dir_path( __FILE__ ) . 'dbsnet-woocp-manager-loader.php';
		require_once plugin_dir_path(__FILE__) . 'dbsnet-woocp-class-batch.php';

		$this->loader = new DBSnet_Woocp_Manager_Loader();
	}

	private function define_admin_hooks() {

		$admin = new DBSnet_Woocp_Manager_Admin( $this->get_version() );

		// Load javascript or styles
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts_and_styles' );

		// Save Post data 
		$this->loader->add_action( 'save_post', $admin, 'SavedProduct' );

		$this->loader->add_action( 'add_meta_boxes', $admin, 'add_woocp_product_metabox', 10, 1 );

		// Add Row Batch
		$this->loader->add_action('wp_ajax_AjaxAddBatch', $admin, 'AddBatch');
		$this->loader->add_action('wp_ajax_AjaxUpdateBatch', $admin, 'UpdateBatch');
		$this->loader->add_action('wp_ajax_AjaxDeleteBatch', $admin, 'DeleteBatch');
	}

	public function run() {
		$this->loader->run();
	}

	public function get_version() {
		return $this->version;
	}
}