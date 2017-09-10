<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Woofreendor_Template_Utility{

	public static function GenerateHTML( $paramPath, $paramData ){
		ob_start();
		require $paramPath . '.php';
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}
}