<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Widget {
	private $wid = 'dbsnet_woocp_widget';

	public function __construct(){}

	private function _remove_wp_widget(){

		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_admin = current_user_can('manage_options');
		
		global $wp_meta_boxes;
		if(!$is_admin){
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);

			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		}

	}

	private function _remove_wc_widget(){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_admin = current_user_can('manage_options');

		if(!$is_admin){
			remove_meta_box( 'woocommerce_dashboard_recent_reviews','dashboard','normal');
			remove_meta_box( 'woocommerce_dashboard_status','dashboard','normal');
		}
	}

	public function dbsnet_woocp_widget(){
		$this->_remove_wp_widget();
		$this->_remove_wc_widget();
		$this->_add_dashboard_widget();

	}

	private function _add_dashboard_widget(){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_admin = current_user_can('manage_options');
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);

		if($is_outlet){
			wp_add_dashboard_widget( 
				$this->wid, 
				'Status', 
				array( $this, 'CallBackFunctions')
				);
		}
	}

	public function CallBackFunctions(){
		echo "Halo fika";
	}
}