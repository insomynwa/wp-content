<?php
/*
Plugin Name: DBSnet WooCP
Description: DBSnet Woocommerce custom product 
Version: 1.0
*/

if (! defined( 'WPINC' )) {
	die;
}
include_once dirname( __FILE__ ) . '/includes/dbsnet-woocp-auto-creator.php';
register_activation_hook(__FILE__, array('DBSnet_Woocp_Auto_Creator', 'install'));

require_once plugin_dir_path( __FILE__ ) . 'includes/dbsnet-woocp-manager.php';


function run_dbsnet_woocp_manager() {
	$dcm = new DBSnet_Woocp_Manager();
	$dcm->run();
}

run_dbsnet_woocp_manager();