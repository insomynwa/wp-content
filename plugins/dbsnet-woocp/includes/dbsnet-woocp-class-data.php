<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Data{

	public function __construct(){
		
	}

	public function dbsnet_woocp_sync_insert_order( $paramOrderId){
		global $wpdb;

	    if ( get_post_meta( $paramOrderId, 'has_sub_order', true ) == '1' ) {
	        return;
	    }

	    $order              = new WC_Order( $paramOrderId );
	    $seller_id          = dokan_get_seller_id_by_order( $paramOrderId );
	    $order_total        = $order->get_total();
	    $order_status       = dokan_get_prop( $order, 'status' );
	    $admin_commission   = dokan_get_admin_commission_by( $order, $seller_id );
	    $net_amount         = $order_total - $admin_commission;
	    $net_amount         = apply_filters( 'dokan_order_net_amount', $net_amount, $order );

	    dokan_delete_sync_duplicate_order( $paramOrderId, $seller_id );

	    // make sure order status contains "wc-" prefix
	    if ( stripos( $order_status, 'wc-' ) === false ) {
	        $order_status = 'wc-' . $order_status;
	    }

	    $wpdb->insert( $wpdb->prefix . 'dbsnet_woocp_orders',
	        array(
	            'order_id'     => $paramOrderId,
	            'seller_id'    => $seller_id,
	            'order_total'  => $order_total,
	            'net_amount'   => $net_amount,
	            'order_status' => $order_status,
	        ),
	        array(
	            '%d',
	            '%d',
	            '%f',
	            '%f',
	            '%s',
	        )
	    );
	}

	public static function SubOrderGetTotalCoupon( $order_id ) {
	    global $wpdb;

	    $sql = $wpdb->prepare( "SELECT SUM(oim.meta_value) FROM {$wpdb->prefix}woocommerce_order_itemmeta oim
	            LEFT JOIN {$wpdb->prefix}woocommerce_order_items oi ON oim.order_item_id = oi.order_item_id
	            WHERE oi.order_id = %d AND oi.order_item_type = 'coupon'", $order_id );

	    $result = $wpdb->get_var( $sql );
	    if ( $result ) {
	        return $result;
	    }

	    return 0;
	}

}