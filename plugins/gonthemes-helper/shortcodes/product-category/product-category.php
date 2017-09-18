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

function gon_shortcode_product_category( $atts ) {
	global $woocommerce_loop;
	$id = uniqid();
	$product_category = shortcode_atts( array(
		'per_page'  			=> '',
		'columns'      			=> '',
		'rows'      			=> '',
		'orderby'       		=> '',
		'order'         		=> '',
		'meta_key'      		=> '',
		'category'      		=> '',
		'items_desktop'      	=> '',
		'items_desktop_small'   => '',
		'items_tablet'      	=> '',
		'items_tablet_small'    => '',
		'items_mobile'      	=> '',
		'auto_play'      		=> '',
		'mouse_drag'	 		=> '',
		'navigation'			=> '',
		'pagination'      		=> '',
		'left_offset'      		=> '',
		'el_class'           	=> '',

	), $atts );

	//button inline style
	$per_page 		= isset( $product_category['per_page'] ) ? $product_category['per_page'] : 12;
	$columns 		= isset( $product_category['columns'] ) ? $product_category['columns'] : 4;
	$rows 			= isset( $product_category['rows'] ) ? $product_category['rows'] : 2;
	$orderby 		= isset( $product_category['orderby'] ) ? $product_category['orderby'] : "";
	$order 			= isset( $product_category['order'] ) ? $product_category['order'] : "";
	$meta_key 		= isset( $product_category['meta_key'] ) ? $product_category['meta_key'] : "";
	$category 		= isset( $product_category['category'] ) ? $product_category['category'] : "";
	
	$items_desktop 			= isset( $product_category['items_desktop'] ) ? $product_category['items_desktop'] : 4;
	$items_desktop_small 	= isset( $product_category['items_desktop_small'] ) ? $product_category['items_desktop_small'] : 3;
	$items_tablet 			= isset( $product_category['items_tablet'] ) ? $product_category['items_tablet'] : 3;
	$items_tablet_small 	= isset( $product_category['items_tablet_small'] ) ? $product_category['items_tablet_small'] : 2;
	$items_mobile 			= isset( $product_category['items_mobile'] ) ? $product_category['items_mobile'] : 1;
	$auto_play 				= isset( $product_category['auto_play'] ) ? $product_category['auto_play'] : false;
	$mouse_drag 			= isset( $product_category['mouse_drag'] ) ? $product_category['mouse_drag'] : false;
	$navigation 			= isset( $product_category['navigation'] ) ? $product_category['navigation'] : true;
	$pagination 			= isset( $product_category['pagination'] ) ? $product_category['pagination'] : false;
	$left_offset 			= isset( $product_category['left_offset'] ) ? $product_category['left_offset'] : 0;
	$el_class 				= isset( $product_category['el_class'] ) ? $product_category['el_class'] : '';
	
	ob_start();
	$woocommerce_loop['columns'] = $columns;
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
	
	$woocommerce_loop['columns'] = $columns;

	if ( $query->have_posts() ) :
		woocommerce_product_loop_start();
		$i = 1;
		echo '<div class="item-wrapper">';
		while ( $query->have_posts() ) : $query->the_post();
			wc_get_template_part( 'content', 'product' );
			
			if ($i % $rows == 0 && ($query->found_posts != $i)) {
				echo '</div><div class="item-wrapper">';
			}
			$i++;
		endwhile; // end of the loop.
		echo '</div>';
		woocommerce_product_loop_end();
	endif;
	wp_reset_postdata();
	$themes_script = '
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#carousel2-'.$id.' .shop-products").owlCarousel({
			items: 				'.$columns.',
			itemsDesktop: 		[1170,'.$items_desktop.'],
			itemsDesktopSmall: 	[980,'.$items_desktop_small.'],
			itemsTablet: 		[800,'.$items_tablet.'],
			itemsTabletSmall: 	[650,'.$items_tablet_small.'],
			itemsMobile: 		[450,'.$items_mobile.'],				
			slideSpeed: 		200,
			paginationSpeed: 	800,
			rewindSpeed: 		1000,				
			autoPlay: 			'.$auto_play.',
			stopOnHover: 		false,				
			navigation: 		'.$navigation.',
			scrollPerPage: 		false,
			pagination: 		'.$pagination.',
			paginationNumbers: 	false,
			mouseDrag: 			'.$mouse_drag.',
			touchDrag: 			false,
			navigationText: 	["'.esc_html__("Prev", "themes-helper").'", "'.esc_html__("Next", "themes-helper").'"],
			leftOffSet: 		'.$left_offset.',
		});
	});
	</script>';
	return '<div id="carousel2-'.$id.'" class="carousel-product '.esc_attr( $el_class ).'"><div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div></div>'.$themes_script;
}

add_shortcode( 'wt-product-category', 'gon_shortcode_product_category' );
