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
		$this->loader = new DBSnet_Woocp_Manager_Loader();
	}

	private function define_admin_hooks() {

		$admin = new DBSnet_Woocp_Manager_Admin( $this->get_version() );

		// Load javascript or styles
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts_and_styles' );

		// Save Post data 
		$this->loader->add_action( 'woocommerce_process_product_meta', $admin, 'save_woocp_batch_product_data_fields' );

		$this->loader->add_action( 'add_meta_boxes', $admin, 'add_woocp_product_metabox', 10, 1 );

		// Custom post-type: batch
		$this->loader->add_action( 'init', $admin, 'add_woocp_batch_post_type' );

		// Trash batch
		$this->loader->add_action('trashed_post', $admin, 'delete_woocp_batch_on_post_trash');
		// Untrashed post
		$this->loader->add_action('untrash_post', $admin, 'unstrashed_woocp_batch_on_post_trash');
	}

	public function run() {
		$this->loader->run();
	}

	public function get_version() {
		return $this->version;
	}
}