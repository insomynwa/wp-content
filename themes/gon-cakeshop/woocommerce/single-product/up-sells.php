<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
$gon_options  = gon_get_global_variables();

$upsells = $product->get_upsell_ids();

if (sizeof($upsells) == 0) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => -1,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array($product->get_id()),
	'meta_query'          => $meta_query
);

$products = new WP_Query($args);

$woocommerce_loop['columns'] = 1;

if ($products->have_posts()) :
?>
<div class="widget upsells_products_widget">
	<?php if(isset($gon_options['upsells_title'])) { ?>
	<h2 class="heading-title"><span><?php echo esc_html($gon_options['upsells_title']); ?></span></h2>
	<?php } ?>
	<div class="upsells products">

		<?php woocommerce_product_loop_start(); ?>

			<?php while ($products->have_posts()) : $products->the_post(); ?>

				<?php wc_get_template_part('content', 'product'); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>
</div>
<?php endif;

wp_reset_postdata();
