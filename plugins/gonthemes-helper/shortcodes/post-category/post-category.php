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

function gon_shortcode_post_category( $atts ) {
	$id = uniqid();
	$post_category = shortcode_atts( array(
		'per_page'  			=> '',
		'columns'      			=> '',
		'orderby'       		=> '',
		'order'         		=> '',
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
	$per_page 		= isset( $post_category['per_page'] ) ? $post_category['per_page'] : 12;
	$columns 		= isset( $post_category['columns'] ) ? $post_category['columns'] : 4;
	$orderby 		= isset( $post_category['orderby'] ) ? $post_category['orderby'] : "";
	$order 			= isset( $post_category['order'] ) ? $post_category['order'] : "";
	$category 		= isset( $post_category['category'] ) ? $post_category['category'] : "";
	
	$items_desktop 			= isset( $post_category['items_desktop'] ) ? $post_category['items_desktop'] : 4;
	$items_desktop_small 	= isset( $post_category['items_desktop_small'] ) ? $post_category['items_desktop_small'] : 3;
	$items_tablet 			= isset( $post_category['items_tablet'] ) ? $post_category['items_tablet'] : 3;
	$items_tablet_small 	= isset( $post_category['items_tablet_small'] ) ? $post_category['items_tablet_small'] : 2;
	$items_mobile 			= isset( $post_category['items_mobile'] ) ? $post_category['items_mobile'] : 1;
	$auto_play 				= isset( $post_category['auto_play'] ) ? $post_category['auto_play'] : false;
	$mouse_drag 			= isset( $post_category['mouse_drag'] ) ? $post_category['mouse_drag'] : false;
	$navigation 			= isset( $post_category['navigation'] ) ? $post_category['navigation'] : true;
	$pagination 			= isset( $post_category['pagination'] ) ? $post_category['pagination'] : false;
	$left_offset 			= isset( $post_category['left_offset'] ) ? $post_category['left_offset'] : 0;
	$el_class 				= isset( $post_category['el_class'] ) ? $post_category['el_class'] : '';
	
	ob_start();
	$args = array(
		'posts_per_page'	=> $per_page,
		'cat' 				=> $category,
		'post_type'			=> 'post',
		'orderby' 			=> $orderby,
		'order'				=> $order,
	);
	if($category == "all") {
		$args = array(
			'posts_per_page'	=> $per_page,
			'post_type'			=> 'post',
			'orderby' 			=> $orderby,
			'order'				=> $order,
		);
	}
	$query = new WP_Query( $args );
	

	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();
			echo '<div class="post-item">';
			get_template_part('content', 'carousel');
			echo '</div>';
		endwhile; // end of the loop.
	endif;
	wp_reset_postdata();
	$gon_script = '
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#carousel-post-'.$id.'").owlCarousel({
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
	return '<div id="carousel-post-'.$id.'" class="carousel-post '.esc_attr( $el_class ).'">' . ob_get_clean() . '</div>'.$gon_script;
}

add_shortcode( 'wt-post-category', 'gon_shortcode_post_category' );
