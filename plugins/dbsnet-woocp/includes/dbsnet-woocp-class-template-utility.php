<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class DBSnet_Woocp_Template_Utility{

	public static function generateHTML($paramPathTemplateLocation,$paramData){
		ob_start();
		require plugin_dir_path( __FILE__ ) . '' .$paramPathTemplateLocation;
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}
}