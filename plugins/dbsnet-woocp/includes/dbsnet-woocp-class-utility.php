<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Utility {

	public function __construct(){
	}

	public static function GetProp( $object, $prop, $callback = false ) {

	    if ( version_compare( WC_VERSION, '2.7', '>' ) ) {
	        $fn_name = $callback ? $callback : 'get_' . $prop;
	        return $object->$fn_name();
	    }

	    return $object->$prop;
	}
}