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

	public function dbsnet_woocp_add_custom_admin_menu(){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);

		if(in_array('tenant_role', $user_role->roles) || current_user_can('manage_options')){
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
		}
		
	}

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
}