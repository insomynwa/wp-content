<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;

$gon_options  = gon_get_global_variables();
$gon_showcountdown 	= gon_get_global_variables('gon_showcountdown');
$gon_productrows 	= gon_get_global_variables('gon_productrows');
$gon_productsfound 	= gon_get_global_variables('gon_productsfound');
$gon_columns 	= gon_get_global_variables('gon_columns');
$gon_options['product_columns'] = isset($gon_options['product_columns']) ? $gon_options['product_columns'] : 3;

//product columns
if($gon_options['product_columns']){
	$gon_columns = esc_html($gon_options['product_columns']);
} else {
	$gon_columns = 3;
}

//hide countdown on category page, show on all others
if(!isset($gon_showcountdown)) {
	$gon_showcountdown = true;
}

// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
	$woocommerce_loop['columns'] = apply_filters('loop_shop_columns', $gon_columns);

// Ensure visibility
if (! $product || ! $product->is_visible())
	return;

// Extra post classes
$classes = array();
if (0 == ($woocommerce_loop['loop']) % $woocommerce_loop['columns'] || 0 == $woocommerce_loop['columns']) {
	$classes[] = 'first';
}
if (0 == ($woocommerce_loop['loop'] + 1) % $woocommerce_loop['columns']) {
	$classes[] = 'last';
}

$count   = $product->get_rating_count();

if ($woocommerce_loop['columns']==3 || $woocommerce_loop['columns']==4 || $woocommerce_loop['columns']==2) {
	$colwidth = 12/$woocommerce_loop['columns'];
} else {
	$colwidth = 4;
}

$class_img = '';
if(isset($gon_options['second_image'])){
	if($gon_options['second_image'] == true){
		$class_img = 'twoimg';
	} else {
		$class_img = 'oneimg';
	}
}

$classes[] = ' item-col col-xs-6 col-sm-'.$colwidth ;?>

<?php if ((0 == ($woocommerce_loop['loop'] - 1) % 2) && ($woocommerce_loop['columns'] == 2)) {
	if($gon_productrows!=1){
		echo '<div class="group">';
	}
} ?>

<div <?php post_class($classes); ?>>
	<div class="product-wrapper">
		<div class="list-col4">
			<div class="product-image">
				<a class="<?php echo esc_attr($class_img); ?>" href="#" title="<?php echo esc_attr( $product->get_title() ); ?>" >
					<?php 
					echo $product->get_image('shop_catalog', array('class'=>'primary_image'));
					if(isset($gon_options['second_image'])){
						if($gon_options['second_image'] == true){
							$attachment_ids = $product->get_gallery_attachment_ids();
							if (!empty($attachment_ids)) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
				</a>
			</div>
		</div>
		<div class="list-col8">
			<div class="gridview">
				<div class="text-block">
					<h3 class="product-name">
						<a href="#"><?php the_title(); ?></a>
					</h3>
					<a class="button product_type_simple woofreendor_detail_product" data-product_id="<?php the_ID(); ?>" href="#">View Detail</a>
					<!-- <div class="ratings"><?php //echo wc_get_rating_html( $product->get_average_rating() ); ?></div> -->
					<!-- <div class="price-box"><?php //echo $product->get_price_html(); ?></div> -->
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php //do_action('woocommerce_after_shop_loop_item'); ?>
	</div>
</div>
<?php if (((0 == $woocommerce_loop['loop'] % 2 || $gon_productsfound == $woocommerce_loop['loop']) && $woocommerce_loop['columns'] == 2) ) { /* for odd case: $gon_productsfound == $woocommerce_loop['loop'] */
	if($gon_productrows!=1){
		echo '</div>';
	}
} ?>