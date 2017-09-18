<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode Product Category
 *
 * @param $atts
 *
 * @return string
 */

function gon_shortcode_list_product( $atts ) {
	$id = uniqid();
	$list_product = shortcode_atts( array(
		'title'					=> '',
		'per_page'  			=> '',
		'orderby'       		=> '',
		'order'         		=> '',
		'meta_key'      		=> '',
		'category'      		=> '',
		'el_class'           	=> '',

	), $atts );

	//button inline style
	$title 			= isset( $list_product['title'] ) ? $list_product['title'] : '';
	$per_page 		= isset( $list_product['per_page'] ) ? $list_product['per_page'] : 3;
	$orderby 		= isset( $list_product['orderby'] ) ? $list_product['orderby'] : "";
	$order 			= isset( $list_product['order'] ) ? $list_product['order'] : "";
	$meta_key 		= isset( $list_product['meta_key'] ) ? $list_product['meta_key'] : "";
	$category 		= isset( $list_product['category'] ) ? $list_product['category'] : "";
	$el_class 				= isset( $list_product['el_class'] ) ? $list_product['el_class'] : '';

	ob_start();
	$args = array(
		'posts_per_page'	=> $per_page,
		'product_cat' 		=> $category,
		'post_type'			=> 'product',
		'orderby' 			=> $orderby,
		'order'				=> $order,
	);
	if($category == "all-category") {
		$args = array(
			'posts_per_page'	=> $per_page,
			'post_type'			=> 'product',
			'orderby' 			=> $orderby,
			'order'				=> $order,
		);
	}
	if (isset($meta_key)) {
		switch ( $meta_key ) {
			case '_featured' :
				$args['meta_key'] = '_featured';
				$args['meta_value'] = 'yes';
				break;
			case 'total_sales' :
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				break;
			case '_wc_average_rating' :
				$args['meta_key'] = '_wc_average_rating';
				$args['orderby']  = 'meta_value_num';
				break;
		}
	}
	$query = new WP_Query( $args );
?>
<?php if($title != '') { ?>
<div class="list-product-title">
	<h3 class="heading-title"><?php echo esc_html($title); ?></h3>
</div>
<?php } ?>
<div class="list-product-content">
<?php
if ( $query->have_posts() ) : ?>
<?php while ( $query->have_posts() ) :
		$query->the_post(); global $product, $post;?>
			<div class="item-col">
				<div class="product-image">
					<a class="oneimg" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
						<?php 
						echo $product->get_image('shop_catalog', array('class'=>'primary_image'));
						?>
					</a>
				</div>
				<div class="text-block">
					<h3 class="product-name">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<div class="ratings"><?php echo wc_get_rating_html( $product->get_average_rating() ); ?></div>
					<div class="price-box"><?php echo $product->get_price_html(); ?></div>
				</div>
			</div>
		<?php
	endwhile;
endif;
wp_reset_postdata();
?>
</div>
<?php
	return '<div class="list-product-woo">' . ob_get_clean() . '</div>';
}

add_shortcode( 'list-product-woo', 'gon_shortcode_list_product' );
