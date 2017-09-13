<?php
// if ( !defined( 'ABSPATH' ) ) {
// 	exit;
// }
// class Woofreendor_Tenant {

// 	private $id;

// 	public function __construct($paramId){
// 		$this->load_dependencies();

// 		$this->id = $paramId;
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

// 	public static function Data($paramOutletId){
// 		return get_userdata($paramOutletId);
// 	}

// 	// public static function GetAll( $paramArgs ){
// 	// 	$defaults = array(
// 	//         'role'       => 'woofreendor_tenant_role',
// 	//         'number'     => 9,
// 	//         'offset'     => 0,
// 	//         'orderby'    => 'registered',
// 	//         'order'      => 'ASC'
// 	//     );

// 	//     $args = wp_parse_args( $args, $defaults );

// 	//     $user_query = new WP_User_Query( $args );
// 	//     $tenants    = $user_query->get_results();

// 	//     return array( 'users' => $tenants, 'count' => $user_query->total_users );
// 	// }

// 	public static function GetInfo( $paramID ){
// 		$info = get_user_meta( $paramID, 'woofreendor_profile_settings', true );
// 	    $info = is_array( $info ) ? $info : array();

// 	    $defaults = array(
// 	        'tenant_name' => '',
// 	        'social'     => array(),
// 	        'payment'    => array( 'paypal' => array( 'email' ), 'bank' => array() ),
// 	        'phone'      => '',
// 	        'show_email' => 'off',
// 	        'address'    => '',
// 	        'location'   => '',
// 	        'banner'     => 0
// 	    );

// 	    $info               = wp_parse_args( $info, $defaults );
// 	    $info['tenant_name'] = empty( $info['tenant_name'] ) ? get_user_by( 'id', $paramID )->display_name : $info['tenant_name'];

// 	    return $info;
// 	}
// }