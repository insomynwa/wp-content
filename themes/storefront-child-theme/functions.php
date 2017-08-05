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
}

function dbsnettheme_enqueue_scripts(){
	$dependencies = array( 'jquery' );
	wp_enqueue_script('boot', '/wp-content/themes/' . get_stylesheet() . '/assets/bootstrap/js/bootstrap.min.js', $dependencies, '3.3.7', false );
}

add_action('wp_enqueue_scripts', 'dbsnettheme_enqueue_styles');
add_action('wp_enqueue_scripts', 'dbsnettheme_enqueue_scripts');

function dbsnettheme_wp_setup() {
	add_theme_support('title-tag');
}
add_action('after_setup_theme','dbsnettheme_wp_setup');

add_action('storefront_before_site', 'dbsnet_scripts_global',100);
add_action('storefront_before_site', 'dbsnet_go_top_navigation',100);
add_action('storefront_before_site', 'dbsnet_header_navigation',100);

add_filter('show_admin_bar','__return_false');

add_action( 'init', 'jk_remove_storefront_header_search' );

function jk_remove_storefront_header_search() {
	remove_action( 'storefront_header', 'storefront_product_search', 	40 );
}

function dbsnet_main_search_query($query){
  if($query->is_search()){
    if(isset($_GET['category']) && !empty($_GET['category'])){
      $query->set('tax_query', array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array($_GET['category'])
        )
      );
    }
  }
  return $query;var_dump($query);die;
}

add_action('pre_get_posts', 'dbsnet_main_search_query', 1000);

function storefront_recent_products( $args ) {
  if ( storefront_is_woocommerce_activated() ) {
    $args = apply_filters( 'storefront_recent_products_args', array(
        'limit'       => 3,
        'columns'       => 3,
        'title'       => __( 'New In', 'storefront' ),
      ) );
    echo storefront_do_shortcode( 'recent_products', apply_filters( 'storefront_recent_products_shortcode_args', array(
        'per_page' => intval( $args['limit'] ),
        'columns'  => intval( $args['columns'] ),
      ) ) );
  }
}

add_shortcode( 'resent_products', 'storefront_recent_products' );

function storefront_best_selling_products( $args ) {

  if ( storefront_is_woocommerce_activated() ) {
    $args = apply_filters( 'storefront_best_selling_products_args', array(
      'limit'   => 3,
      'columns' => 3,
      'title'      => esc_attr__( 'Best Sellers', 'storefront' ),
    ) );
    echo storefront_do_shortcode( 'best_selling_products', array(
      'per_page' => intval( $args['limit'] ),
      'columns'  => intval( $args['columns'] ),
    ) );
  }
}

add_shortcode( 'best_sellers', 'storefront_best_selling_products' );

function dbsnet_show_product_loop_sale_flash(){

  add_filter('woocommerce_sale_flash', 'dbsnet_change_sale_content', 10, 3);
}

function dbsnet_change_sale_content($content, $post, $product){

  return "";
}

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open',10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action('woocommerce_before_shop_loop_item', 'dbsnet_template_loop_product_link_open',10);
add_action('woocommerce_shop_loop_item_title', 'dbsnet_template_shop_loop_item_title',10);
add_action( 'woocommerce_before_shop_loop_item_title', 'dbsnet_show_product_loop_sale_flash', 10 );
add_action('woocommerce_after_shop_loop_item_title', 'dbsnet_template_loop_price',10);
add_action('woocommerce_after_shop_loop_item', 'dbsnet_template_loop_product_link_close',5);
add_action( 'woocommerce_after_shop_loop_item', 'dbsnet_template_loop_add_to_cart', 10 );

function dbsnet_template_loop_product_link_open(){
  global $product;
  echo '<span class="thumbnail thumbnail-mini">';
  echo '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
}

function dbsnet_template_shop_loop_item_title(){
  global $product;
  echo '<h4 class="">' . get_the_title() . '</h4>';
}

function dbsnet_template_loop_price(){
  global $product;
  if ( $price_html = $product->get_price_html() ){
    echo '<p class="price">'. $price_html . '</p>';
  }
  
}
function dbsnet_template_loop_product_link_close(){

  echo '</a><hr class="line">';
}

function dbsnet_template_loop_add_to_cart(){
  global $product;

  if ( $product ) {
    $defaults = array(
      'quantity' => 1,
      'class'    => implode( ' ', array_filter( array(
          'btn btn-success btn-block',
          'product_type_' . $product->get_type(),
          $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
          $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
      ) ) ),
    );

    $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
      sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( isset( $defaults['quantity'] ) ? $defaults['quantity'] : 1 ),
        esc_attr( $product->get_id() ),
        esc_attr( $product->get_sku() ),
        esc_attr( isset( $defaults['class'] ) ? $defaults['class'] : 'btn btn-success btn-block' ),
        esc_html( 'Beli'/*$product->add_to_cart_text()*/ )
      ),
    $product );
  }
  echo '</span>';
}