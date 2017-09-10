<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Tenant {

	private $id;

	public function __construct($paramId){
		$this->load_dependencies();

		$this->id = $paramId;
	}

	private function load_dependencies() {
	}

	private static function _get_binder_group($paramTenantId){
		return get_user_meta( $paramTenantId, 'binder_group', true);
	}

	public static function GetOutlets($paramTenantId){
		//require_once plugin_dir_path( __DIR__ ) . 'outlet/dbsnet-woocp-class-outlet.php';

		$outlets = Woofreendor_Outlet::GetByBinderGroup(self::_get_binder_group($paramTenantId));
		if(count($outlets)==0) return false;

		return $outlets;
	}

	public static function Data($paramOutletId){
		return get_userdata($paramOutletId);
	}
}