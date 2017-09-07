<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Woocommerce {

	public function __construct(){
		
	}

	// public function dbsnet_woocp_order_item_meta( $paramItemId, $paramValue, $paramCartItemKey){
	// 	$product = DBSnet_Woocp_Product::Data($paramValue['product_id']);

	// 	wc_add_order_item_meta( $paramItemId, '_outlet_id', $product->post_author);
	// }

	public function dbsnet_woocp_create_sub_order( $parent_order_id, $data ) {

	    if ( get_post_meta( $parent_order_id, 'has_sub_order' ) == true ) {
	        $args = array(
	            'post_parent' => $parent_order_id,
	            'post_type'   => 'shop_order',
	            'numberposts' => -1,
	            'post_status' => 'any'
	        );
	        $child_orders = get_children( $args );

	        foreach ( $child_orders as $child ) {
	            wp_delete_post( $child->ID );
	        }
	    }

	    $parent_order         = new WC_Order( $parent_order_id );
	    $sellers              = DBSnet_Woocp_Order::GetOrderOutlets( $parent_order_id );

	    // return if we've only ONE seller
	    if ( count( $sellers ) == 1 ) {
	        $temp = array_keys( $sellers );
	        $seller_id = reset( $temp );
	        wp_update_post( array( 'ID' => $parent_order_id, 'post_author' => $seller_id ) );
	        return;
	    }

	    // flag it as it has a suborder
	    update_post_meta( $parent_order_id, 'has_sub_order', true );

	    // seems like we've got multiple sellers
	    foreach ($sellers as $seller_id => $seller_products ) {
	        DBSnet_Woocp_Order::CreateOutletOrder( $parent_order, $seller_id, $seller_products );
	    }
	}
	
}