<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Group_Functions{

	public function __construct(){}

	public static function GetOutlets($paramMemberId){
		
		$binder_group = get_user_meta($paramMemberId, 'binder_group', true);

		$outlet_args = array(
			'role'		=> 'outlet_role',
			'meta_key'	=> 'binder_group',
			'meta_value'=>	$binder_group,
			'orderby'	=> 'ID',
			'order'		=> 'ASC'
			);

		$outlets = get_users($outlet_args);

		if(count($outlets)==0) return false;

		return $outlets;
	}

	public static function GetProducts($paramVendorId){

		$product_args = array(
			'author'		=> $paramVendorId,
			'orderby'		=> 'ID',
			'order'			=> 'ASC',
			'post_status'	=> 'publish',
			'post_type'		=> 'product'
			);

		$products = get_posts($product_args);

		if(count($products)==0) return false;

		return $products;
	}

}