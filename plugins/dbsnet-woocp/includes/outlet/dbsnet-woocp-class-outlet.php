<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Outlet {

	private $id;
	private $tenant;
	private $products;

	public function __construct($paramId){
		$this->load_dependencies();

		$this->id = $paramId;
	}

	private function load_dependencies() {
		require_once plugin_dir_path( __DIR__ ) . 'tenant/dbsnet-woocp-class-tenant.php';
	}

	public static function GetByBinderGroup($paramBinderGroup){
		$outlet_args = array(
			'role'		=> 'outlet_role',
			'meta_key'	=> 'binder_group',
			'meta_value'=>	$paramBinderGroup,
			'orderby'	=> 'ID',
			'order'		=> 'ASC'
			);

		return get_users($outlet_args);
	}

	public static function GetProducts($paramOutletId){
		//require_once plugin_dir_path( __DIR__ ) . 'product/dbsnet-woocp-class-product.php';
		return DBSnet_Woocp_Product::GetByOutletId($paramOutletId);
	}

	public static function GetOrdersOnHold($paramOutletId){
		//require_once plugin_dir_path( __DIR__ ) . 'product/dbsnet-woocp-class-product.php';
		return DBSnet_Woocp_Order::GetOnHoldByOutletId($paramOutletId);
	}

	public static function Data($paramOutletId){
		return get_userdata($paramOutletId);
	}
}