<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Outlet {

	private $id;
	private $tenant;
	private $products;

	public function __construct($paramId){
		$this->load_dependencies();

		$this->id = $paramId;
	}

	private function load_dependencies() {
		require_once plugin_dir_path( __FILE__ ) . 'woofreendor-tenant.php';
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
		return woofreendor_Product::GetByOutletId($paramOutletId);
	}

	public static function GetOrdersOnHold($paramOutletId){
		//require_once plugin_dir_path( __DIR__ ) . 'product/dbsnet-woocp-class-product.php';
		return Woofreendor_Order::GetOnHoldByOutletId($paramOutletId);
	}

	public static function Data($paramOutletId){
		return get_userdata($paramOutletId);
	}
}