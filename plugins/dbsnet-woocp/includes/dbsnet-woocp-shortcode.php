<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Shortcode{

	public function __construct(){
		require_once plugin_dir_path(__FILE__) . 'dbsnet-woocp-groups-functions.php';
	}


	public function init(){
		$shortcodes = array(
			'dbsnet_woocp_outlet_list'	=> array($this, 'dbsnet_woocp_outlet_list'),
			'dbsnet_woocp_outlet_product_list'		=> array($this, 'dbsnet_woocp_outlet_product_list'),
			
		);

		foreach ($shortcodes as $shortcode => $function) {
			add_shortcode($shortcode, $function);
		}
	}

	public function dbsnet_woocp_outlet_list(){
		$user = wp_get_current_user();
		$user_meta = get_userdata($user->ID);
		$user_roles = $user_meta->roles;

		if(!in_array("tenant_role",$user_roles)){
			return "You aren't tenant.";
		}

		$outlets = DBSnet_Woocp_Group_Functions::GetTenantOutlets($user->ID);

		if(!$outlets) return "You don't have outlet yet. Create Now!";

		ob_start();
		require plugin_dir_path( __FILE__ ) . 'views/outlet/list.php';
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}

}