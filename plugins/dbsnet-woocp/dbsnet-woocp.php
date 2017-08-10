<?php
/*
Plugin Name: DBSnet WooCP
Description: DBSnet Woocommerce custom product 
Version: 1.0
*/

if (! defined( 'WPINC' )) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/dbsnet-woocp-manager.php';


function run_dbsnet_woocp_manager() {
	$dcm = new DBSnet_Woocp_Manager();
	$dcm->run();
}

run_dbsnet_woocp_manager();