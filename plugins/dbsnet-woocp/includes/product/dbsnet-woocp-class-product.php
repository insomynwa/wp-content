<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Product {

	private $id;

	public function __construct($paramId){
		$this->load_dependencies();
		
		$this->id = $paramId;
	}

	private function load_dependencies() {
		//require_once plugin_dir_path( __DIR__ ) . 'outlet/dbsnet-woocp-class-outlet.php';
	}

	public function GetByOutletId($paramOutletId){

		$product_args = array(
			'author__in'		=>	$paramOutletId,
			'post_status'	=>	'publish',
			'post_type'		=>	'product'
			);
		return get_posts($product_args);
	}
}