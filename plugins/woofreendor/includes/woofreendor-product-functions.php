<?php

function woofreendor_get_outlet_publish_products($paramOutletId){
    $args = array(
        'author'    => $paramOutletId,
        'posts_per_page'    => -1,
        'post_type' => 'product',
        'post_status'   => 'any'
        );
    $products = get_posts($args);
    return array( 'products' => $products, 'count' => count($products) );
}

function woofreendor_permanently_delete_product($paramProductId){
    wp_delete_post( $paramProductId, true );
}

function woofreendor_get_outlet_publish_batches($paramOutletId){
    $args = array(
        'author'    => $paramOutletId,
        'posts_per_page'    => -1,
        'post_type' => 'product_variation',
        'post_status'   => 'any'
        );
    $batches = get_posts($args);
    return array( 'batches' => $batches, 'count' => count($batches) );
}