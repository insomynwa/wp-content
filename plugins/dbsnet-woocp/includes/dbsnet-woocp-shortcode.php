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
			'dbsnet_woocp_outlet_list_for_tenant'                    => array($this, 'dbsnet_woocp_outlet_list'),
		);

		foreach ($shortcodes as $shortcode => $function) {
			add_shortcode($shortcode, $function);
		}
	}

	public function dbsnet_woocp_outlet_list(){
		$tenant = wp_get_current_user();
		$outlets = DBSnet_Woocp_Group_Functions::GetGroupMember($tenant->ID,false);

		if(!$outlets)
			return "Nothing to be displayed.";

		ob_start();
		require plugin_dir_path( __FILE__ ) . 'views/outlet/list.php';
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}
}