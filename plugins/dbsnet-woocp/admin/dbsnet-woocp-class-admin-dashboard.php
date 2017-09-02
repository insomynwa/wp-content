<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Admin_Dashboard{

	private $template_path;

	public function __construct(){
		$this->load_dependencies();
		$this->template_path = "views/dbsnet-woocp-template-html.php";
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/dbsnet-woocp-class-template-utility.php';
		require_once plugin_dir_path(dirname( __FILE__ )) . 'includes/dbsnet-woocp-groups-functions.php';
	}

	public function dbsnet_woocp_admin_menu(){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_admin = current_user_can('manage_options');
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);

		if($is_tenant || $is_outlet){
			remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		}

		if($is_admin || $is_tenant){
			$this->add_custom_menu();

			// if($is_tenant){
				
			// }
		}

		// if($is_outlet){
			
		// }
		
	}

	private function add_custom_menu(){
		add_menu_page(
				__('Outlet', 'dbsnet-woocp'),
				__('Outlet', 'dbsnet-woocp'),
				'view_woocommerce_reports',
				'dbsnet-outlet',
				''//array( $this, 'dbsnet_woocp_render_outlet_page')
				//$icon_url,
				//$position
			);
			add_submenu_page(
				'dbsnet-outlet',
				__('List Outlet', 'dbsnet-woocp'),
				__('List Outlet', 'dbsnet-woocp'),
				'view_woocommerce_reports',
				'dbsnet-outlet',
				array( $this, 'dbsnet_woocp_render_outlet_page')
			);
			add_submenu_page(
				'dbsnet-outlet',
				__('Tambah Outlet', 'dbsnet-woocp'),
				__('Tambah Outlet', 'dbsnet-woocp'),
				'view_woocommerce_reports',
				'dbsnet-outlet-new',
				array( $this, 'dbsnet_woocp_render_outlet_page_new')
				);

			// add_menu_page(
			// 	__('Produk', 'dbsnet-woocp'),
			// 	__('Produk', 'dbsnet-woocp'),
			// 	'view_woocommerce_reports',
			// 	'dbsnet-product',
			// 	''//array( $this, 'dbsnet_woocp_render_outlet_page')
			// 	//$icon_url,
			// 	//$position
			// );
			// add_submenu_page(
			// 	'dbsnet-product',
			// 	__('List Produk', 'dbsnet-woocp'),
			// 	__('List Produk', 'dbsnet-woocp'),
			// 	'view_woocommerce_reports',
			// 	'dbsnet-product',
			// 	array( $this, 'dbsnet_woocp_render_product_page')
			// );
	}

	// private function remove_woocommerce_menu(){
	// 	$menu_name = 'woocommerce';
	// 	$removed_submenu = array('wc-addons','wc-status','wc-settings');
	// 	$this->removeSubmenu('tenant_role', $menu_name, $removed_submenu);
	// 	$this->removeSubmenu('outlet_role', $menu_name, $removed_submenu);
		
	// 	$menu_name = 'edit.php?post_type=product';
	// 	$removed_submenu_product = array(
	// 		'edit-tags.php?taxonomy=product_cat&amp;post_type=product',
	// 		'edit-tags.php?taxonomy=product_tag&amp;post_type=product',
	// 		'product_attributes'
	// 		);
	// 	$this->removeSubmenu('tenant_role', $menu_name, $removed_submenu_product);
	// 	$this->removeSubmenu('outlet_role', $menu_name, $removed_submenu_product);
	// }

	// private function removeSubmenu($role, $menu, $submenus){
	// 	$user = wp_get_current_user();
	// 	foreach ($submenus as $submenu) {
	// 		if(in_array($role, $user->roles)){
	// 			remove_submenu_page( $menu, $submenu );
	// 		}
	// 	}
	// }

	public function dbsnet_woocp_render_outlet_page(){
		$data = array();
		$user = wp_get_current_user();

		$data['page_title'] = "Outlet - ". $user->display_name;
		$data['view_path'] = "views/outlet/list.php";

		$user_meta = get_userdata($user->ID);
		$user_roles = $user_meta->roles;

		if(in_array("tenant_role",$user_roles)){
			$outlets = DBSnet_Woocp_Group_Functions::GetTenantOutlets($user->ID);
		}else{
			$outlets = DBSnet_Woocp_Group_Functions::GetOutlets();
		}

		$data['view_data']['list'] = $outlets;
		echo DBSnet_Woocp_Template_Utility::generateHTML($this->template_path, $data);
	}

	public function dbsnet_woocp_render_outlet_page_new(){
		$user = wp_get_current_user();
		$user_meta = get_userdata($user->ID);
		$user_roles = $user_meta->roles;

		$data = array();

		$data['page_title'] = "Tambah Outlet - ". $user->display_name;
		$data['view_path'] = "views/outlet/form.php";
		$data['view_data']['outlet']['group'] = DBSnet_Woocp_Group_Functions::GetBinderGroup($user->ID);

		echo DBSnet_Woocp_Template_Utility::generateHTML($this->template_path, $data);
	}

	// public function dbsnet_woocp_render_product_page(){
	// 	echo do_shortcode("[wcplpro wcplid='somerandomstringhere']");
	// }
}