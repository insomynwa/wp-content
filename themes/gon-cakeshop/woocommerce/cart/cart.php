<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.3
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
global $woocommerce;

wc_print_notices();

do_action('woocommerce_before_cart'); 
?>
<form class="cart-form" action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="post">
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<?php do_action('woocommerce_before_cart_table'); ?>

		<table class="shop_table cart" cellspacing="0">
			<thead>
				<tr>
					<th class="product-name" colspan="2"><?php esc_html_e('Product', 'gon-cakeshop'); ?></th>
					<th class="product-price"><?php esc_html_e('Price', 'gon-cakeshop'); ?></th>
					<th class="product-quantity"><?php esc_html_e('Quantity', 'gon-cakeshop'); ?></th>
					<th class="product-subtotal"><?php esc_html_e('Total', 'gon-cakeshop'); ?></th>
					<th class="product-remove">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php do_action('woocommerce_before_cart_contents'); ?>

				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						?>
						<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>" id="lcitem-<?php echo esc_attr($cart_item_key); ?>">
							<td class="product-thumbnail">
								<?php
									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

									if (! $_product->is_visible())
										echo $thumbnail;
									else
										printf('<a href="%s">%s</a>', $_product->get_permalink($cart_item), $thumbnail);
								?>
							</td>
							<td class="product-name">
								<?php
									if (! $_product->is_visible())
										echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);
									else
										echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', $_product->get_permalink($cart_item), $_product->get_title()), $cart_item, $cart_item_key);

									// Meta data
									echo WC()->cart->get_item_data($cart_item);

									// Backorder notification
									if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity']))
										echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'gon-cakeshop') . '</p>';
								?>
							</td>

							<td class="product-price">
								<?php
									echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
								?>
							</td>

							<td class="product-quantity">
								<?php
									if ($_product->is_sold_individually()) {
										$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
									} else {
										$product_quantity = woocommerce_quantity_input(array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
											'min_value'   => '0'
										), $_product, false);
									}

									echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key);
								?>
							</td>

							<td class="product-subtotal">
								<?php
									echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
								?>
							</td>
							<td class="product-remove">
								<?php
									//echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url(WC()->cart->get_remove_url($cart_item_key)), esc_html__('Remove this item', 'gon-cakeshop')), $cart_item_key);
								?>
								<?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" onclick="vinageckoMiniCartRemove(\'%s\', \'%s\');return false;" class="remove" title="%s"></a>', esc_url(WC()->cart->get_remove_url($cart_item_key)), esc_url(WC()->cart->get_remove_url($cart_item_key)), $cart_item_key, esc_html__('Remove this item', 'gon-cakeshop')), $cart_item_key); ?>
							</td>
						</tr>
						<?php
					}
				}

				do_action('woocommerce_cart_contents');
				?>

				<?php do_action('woocommerce_after_cart_contents'); ?>
			</tbody>
		</table>
		<div class="actions">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-sm-8 col-xs-12">
					<div class="coupon-wrapper">
						<?php if (WC()->cart->coupons_enabled()) { ?>
							<div class="coupon">
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_html_e('Coupon code', 'gon-cakeshop'); ?>" />
								<input type="submit" class="button" name="apply_coupon" value="<?php esc_html_e('Apply Coupon', 'gon-cakeshop'); ?>" />

								<?php do_action('woocommerce_cart_coupon'); ?>

							</div>
						<?php } ?>
						<?php do_action('woocommerce_cart_actions'); ?>
						
						<?php wp_nonce_field('woocommerce-cart'); ?>
						
						<?php if (WC()->customer->has_calculated_shipping()) : ?>
							<?php woocommerce_shipping_calculator(); ?>
						<?php endif; ?>
						<input type="submit" class="button update_cart" name="update_cart" value="<?php esc_html_e('Update Cart', 'gon-cakeshop'); ?>" />
					</div>
				</div>
				<div class="col-xs-12 col-md-4 col-sm-4 col-xs-12">
					<div class="cart-total-wrapper">
						<div class="total-cost">
							<?php woocommerce_cart_totals(); ?>
							<div class="wc-proceed-to-checkout">
								<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="crosssell-products">
	<?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div>
<?php do_action('woocommerce_after_cart_table'); ?>
<div class="loading"></div>
</form>
<?php do_action('woocommerce_after_cart'); ?>
