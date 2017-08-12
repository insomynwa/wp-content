<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also includes all of the dependencies used by
 * the plugin, and defines a function that starts the plugin.
 *
 * @link              http://code.tutsplus.com/tutorials/adding-custom-fields-to-simple-products-with-woocommerce--cms-27904
 * @package           CWF
 *
 * @wordpress-plugin
 * Plugin Name: DBSnet WooCP
 * Description: DBSnet Woocommerce custom product 
 * Version: 1.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

if (! defined( 'WPINC' )) {
	die;
}
if( in_array('groups/groups.php', apply_filters('active_plugins', get_option('active_plugins')))){
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-multitenant-admin.php';

	register_activation_hook(__FILE__, array('DBSnet_Woocp_Multitenant_Admin', 'dbsnet_woocp_activate'));

	require_once plugin_dir_path( __FILE__ ) . 'includes/dbsnet-class-woocp.php';

	function run_dbsnet_woocp() {
		$dcm = new DBSnet_Woocp();
		$dcm->run();
	}

	run_dbsnet_woocp();
	
}
// require_once plugin_dir_path( __FILE__ ) . 'includes/customizer/dbsnet-woocp-my-account.php';
// new DBSnet_Woocp_My_Account();
// register_activation_hook(__FILE__, array('DBSnet_Woocp_My_Account','dbsnet_woocp_my_account_install'));

