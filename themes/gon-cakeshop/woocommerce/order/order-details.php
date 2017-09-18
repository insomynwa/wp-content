<?php
/**
 * Order details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$order = wc_get_order($order_id);

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>
<h2><?php esc_html_e('Order Details', 'gon-cakeshop'); ?></h2>
<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'gon-cakeshop' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Total', 'gon-cakeshop' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach( $order->get_items() as $item_id => $item ) {
				$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );

				wc_get_template( 'order/order-details-item.php', array(
					'order'			     => $order,
					'item_id'		     => $item_id,
					'item'			     => $item,
					'show_purchase_note' => $show_purchase_note,
					'purchase_note'	     => $product ? get_post_meta( $product->get_id(), '_purchase_note', true ) : '',
					'product'	         => $product,
				) );
			}
		?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	</tbody>
	<tfoot>
		<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
				<tr>
					<th scope="row"><?php echo $total['label']; ?></th>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action('woocommerce_order_details_after_order_table', $order); ?>

<header>
	<h2><?php esc_html_e('Customer details', 'gon-cakeshop'); ?></h2>
</header>
<table class="shop_table shop_table_responsive customer_details">
<?php
	if ($order->billing_email) {
		echo '<tr><th>' . esc_html__('Email:', 'gon-cakeshop') . '</th><td data-title="' . esc_html__('Email', 'gon-cakeshop') . '">' . $order->billing_email . '</td></tr>';
	}

	if ($order->billing_phone) {
		echo '<tr><th>' . esc_html__('Telephone:', 'gon-cakeshop') . '</th><td data-title="' . esc_html__('Telephone', 'gon-cakeshop') . '">' . $order->billing_phone . '</td></tr>';
	}

	// Additional customer details hook
	do_action('woocommerce_order_details_after_customer_details', $order);
?>
</table>

<?php if (! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option('woocommerce_calc_shipping') !== 'no') : ?>

<div class="col2-set addresses">

	<div class="col-1">

<?php endif; ?>

		<header class="title">
			<h3><?php esc_html_e('Billing Address', 'gon-cakeshop'); ?></h3>
		</header>
		<address>
			<?php
				if (! $order->get_formatted_billing_address()) {
					esc_html_e('N/A', 'gon-cakeshop');
				} else {
					echo $order->get_formatted_billing_address();
				}
			?>
		</address>

<?php if (! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option('woocommerce_calc_shipping') !== 'no') : ?>

	</div><!-- /.col-1 -->

	<div class="col-2">

		<header class="title">
			<h3><?php esc_html_e('Shipping Address', 'gon-cakeshop'); ?></h3>
		</header>
		<address>
			<?php
				if (! $order->get_formatted_shipping_address()) {
					esc_html_e('N/A', 'gon-cakeshop');
				} else {
					echo $order->get_formatted_shipping_address();
				}
			?>
		</address>

	</div><!-- /.col-2 -->

</div><!-- /.col2-set -->

<?php endif; ?>

<div class="clear"></div>
