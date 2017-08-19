<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */

require 'inc/dbsnet-template-functions.php';
// require 'inc/storefront-template-hooks.php';
// require 'inc/storefront-template-functions.php';

function dbsnettheme_enqueue_styles(){
	wp_register_style('bootstrap', '/wp-content/themes/' . get_stylesheet() . '/assets/bootstrap/css/bootstrap.min.css');
	$dependencies = array('bootstrap');
	wp_enqueue_style('dbsnettheme-style', get_stylesheet_uri(), $dependencies );

	wp_register_style( 'dbsnet-style-css', '/wp-content/themes/' . get_stylesheet() . '/assets/css/style.css');
	wp_enqueue_style( 'dbsnet-style-css' );

	wp_register_style( 'dbsnet-flexslider-css', '/wp-content/themes/' . get_stylesheet() . '/assets/css/flexslider.css');
	wp_enqueue_style( 'dbsnet-flexslider-css' );
}

function dbsnettheme_enqueue_scripts(){
	$dependencies = array( 'jquery' );
	wp_enqueue_script('boot', '/wp-content/themes/' . get_stylesheet() . '/assets/bootstrap/js/bootstrap.min.js', $dependencies, '3.3.7', false );

	wp_register_script( 'dbsnet-easing-js','/wp-content/themes/' . get_stylesheet() . '/assets/js/easing.js' );
	wp_enqueue_script( 'dbsnet-easing-js' );

	wp_register_script( 'dbsnet-movetop-js','/wp-content/themes/' . get_stylesheet() . '/assets/js/move-top.js' );
	wp_enqueue_script( 'dbsnet-movetop-js' );

	wp_register_script( 'dbsnet-waypoints-js','/wp-content/themes/' . get_stylesheet() . '/assets/js/waypoints.min.js' );
	wp_enqueue_script( 'dbsnet-waypoints-js' );

	wp_register_script( 'dbsnet-flexslider-js','/wp-content/themes/' . get_stylesheet() . '/assets/js/jquery.flexslider.js' );
	wp_enqueue_script( 'dbsnet-flexslider-js' );

	wp_register_script( 'dbsnet-minicart-js','/wp-content/themes/' . get_stylesheet() . '/assets/js/minicart.js' );
	wp_enqueue_script( 'dbsnet-minicart-js' );
}

add_action('wp_enqueue_scripts', 'dbsnettheme_enqueue_styles');
add_action('wp_enqueue_scripts', 'dbsnettheme_enqueue_scripts');
add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

function dbsnettheme_wp_setup() {
	add_theme_support('title-tag');
}
add_action('after_setup_theme','dbsnettheme_wp_setup');

add_action('pre_get_posts', 'dbsnet_main_search_query', 1000);

add_action('dbsnet_theme_header', 'dbsnet_scripts_global',100);
////add_action('dbsnet_theme_header', 'dbsnet_header_navigation',100);
add_action('dbsnet_theme_header','dbsnet_header_navigation_v2',100);

// Action for banner TOP 
add_action('dbsnet_theme_homepage', 'dbsnet_homepage_banner_top_start',100);
add_action('dbsnet_theme_homepage', 'dbsnet_homepage_banner_top_left',100);
add_action('dbsnet_theme_homepage', 'dbsnet_homepage_banner_top_right',100);
add_action('dbsnet_theme_homepage', 'dbsnet_homepage_banner_top_end',100);

add_action('dbsnet_theme_homepage', 'dbsnet_homepage_banner_bottom',100);
add_action('dbsnet_theme_homepage', 'dbsnet_product_hot_v2',100);
add_action('dbsnet_theme_homepage', 'dbsnet_product_best_seller_v2',100);

add_action('dbsnet_theme_breadcrumb', 'dbsnet_theme_breadcrumb_shop');

add_action('dbsnet_theme_shop', 'dbsnet_homepage_banner_top_start',10);
add_action('dbsnet_theme_shop', 'dbsnet_homepage_banner_top_left',20);
add_action('dbsnet_theme_shop', 'dbsnet_theme_banner_shop', 30);
add_action('dbsnet_theme_shop', 'dbsnet_homepage_banner_top_end',40);

// ABOUT US
add_action('dbsnet_about_us', 'dbsnet_about_us', 100);

// CONTACT US
add_action('dbsnet_contact_us', 'dbsnet_contact_us', 100);

//FAQ
add_action('dbsnet_faq', 'dbsnet_faq', 100);

//add_action('dbsnet_theme_homepage', 'dbsnet_homepage_slideshow',100);

//add_action('dbsnet_theme_homepage', 'dbsnet_homepage_tenant',100);
// add_action('dbsnet_theme_homepage', 'dbsnet_product_categories',100);
// add_action('dbsnet_theme_homepage', 'dbsnet_product_hot',100);
// add_action('dbsnet_theme_homepage', 'dbsnet_product_best_seller',100);

add_action('dbsnet_single_product', 'dbsnet_single_product', 100);

add_action('woocommerce_single_product_summary', 'dbsnet_product_batch',6);


// add_shortcode( 'dbsnet_product_categories', 'dbsnet_product_categories_shortcode' );
// add_shortcode( 'resent_products', 'dbsnet_recent_products_shortcode' );
// add_shortcode( 'best_sellers', 'dbsnet_best_selling_products_shortcode' );


add_filter('show_admin_bar','__return_false');
add_filter('woocommerce_product_get_price', 'dbsnet_batch_get_price',20,3);
/************************************************************/


add_action( 'init', 'jk_remove_storefront_header_search' );

function jk_remove_storefront_header_search() {
	remove_action( 'storefront_header', 'storefront_product_search', 	40 );
}



// remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open',10);
// remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',10);
// remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
// add_action('woocommerce_before_shop_loop_item', 'dbsnet_template_loop_product_link_open',10);
// add_action('woocommerce_shop_loop_item_title', 'dbsnet_template_shop_loop_item_title',10);
// add_action('woocommerce_after_shop_loop_item_title', 'dbsnet_template_loop_price',10);
// add_action('woocommerce_after_shop_loop_item', 'dbsnet_template_loop_product_link_close',5);
// add_action( 'woocommerce_after_shop_loop_item', 'dbsnet_template_loop_add_to_cart', 10 );

// function dbsnet_template_loop_product_link_open(){
//   global $product;
//   echo '<span class="thumbnail thumbnail-mini">';
//   echo '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
// }

// function dbsnet_template_shop_loop_item_title(){
//   global $product;
//   echo '<h4 class="">' . get_the_title() . '</h4>';
// }

// function dbsnet_template_loop_price(){
//   global $product;
//   if ( $price_html = $product->get_price_html() ){
//     echo '<p class="price">'. $price_html . '</p>';
//   }
  
// }
// function dbsnet_template_loop_product_link_close(){

//   echo '</a><hr class="line">';
// }

// function dbsnet_template_loop_add_to_cart(){
//   global $product;

//   if ( $product ) {
//     $defaults = array(
//       'quantity' => 1,
//       'class'    => implode( ' ', array_filter( array(
//           'btn btn-success btn-block',
//           'product_type_' . $product->get_type(),
//           $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
//           $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
//       ) ) ),
//     );

//     $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

//     echo apply_filters( 'woocommerce_loop_add_to_cart_link',
//       sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
//         esc_url( $product->add_to_cart_url() ),
//         esc_attr( isset( $defaults['quantity'] ) ? $defaults['quantity'] : 1 ),
//         esc_attr( $product->get_id() ),
//         esc_attr( $product->get_sku() ),
//         esc_attr( isset( $defaults['class'] ) ? $defaults['class'] : 'btn btn-success btn-block' ),
//         esc_html( $product->add_to_cart_text() )
//       ),
//     $product );
//   }
//   echo '</span>';
// }