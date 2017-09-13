<?php
// if ( !defined( 'ABSPATH' ) ) {
// 	exit;
// }
// class Woofreendor_Order {


// 	public function __construct(){
// 	}

// 	private function load_dependencies() {
// 	}

// 	private static function _get_binder_group($paramTenantId){
// 		return get_user_meta( $paramTenantId, 'binder_group', true);
// 	}

// 	public static function GetOutlets($paramTenantId){
// 		//require_once plugin_dir_path( __DIR__ ) . 'outlet/dbsnet-woocp-class-outlet.php';

// 		$outlets = Woofreendor_Outlet::GetByBinderGroup(self::_get_binder_group($paramTenantId));
// 		if(count($outlets)==0) return false;

// 		return $outlets;
// 	}

// 	public static function Data($paramOrderId){
// 		return get_userdata($paramOutletId);
// 	}

// 	public static function GetOnHoldByOutletId(){
// 		$on_hold_orders = self::_get_all_on_hold();
// 		$on_hold_items = self::_get_on_hold_item($on_hold_orders);

// 	    return $all_orders;
// 	}

// 	private function _get_all_on_hold(){
// 		$query_args = array(
// 			'fields'			=> 'id=>parent',	
// 	        'post_type'			=> wc_get_order_types(),
// 	        'post_status' 		=> 'wc-on-hold',
// 	        'posts_per_page'	=> 999999999999,
// 	    );

// 	    return get_posts( $query_args );
// 	}

// 	private function _get_on_hold_item($paramArrayOrders){
// 		$items = array();
// 		foreach ($paramArrayOrders as $order_id => $value) {
// 			$order = new WC_Order($order_id);
			
// 		}
// 	}
// }