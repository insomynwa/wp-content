<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Product {

	public function __construct(){
	}

	public static function GetByOutletId($paramOutletId){

		$product_args = array(
			'author__in'		=>	$paramOutletId,
			'post_status'	=>	'publish',
			'post_type'		=>	'product'
			);
		return get_posts($product_args);
	}

	public static function GetBatches($paramProductId){
		$args = array(
			'post_type' => 'product_variation',
			'post_parent' => $paramProductId,
			'orderby' => 'ID',
			'order' => 'ASC',
			'posts_per_page' => -1
		);//var_dump(get_posts($args));
		return get_posts($args);
	}

	public static function Data($paramProductId){
		return get_post($paramProductId);
	}
}