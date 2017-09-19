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

/**
 * Get Tenant's product
 *
 * @param int Tenant ID
 * @return object product
 */
function woofreendor_get_tenant_products( $paramTenantId ){
    $args = array(
        'post_per_page'     => -1,
        'orderby'           => 'title',
        'order'             => 'ASC',
        'author'            => $paramTenantId,
        'post_type'         => 'product',
        'post_status'       => 'pending'
    );

    $products = get_posts($args);
    return array( 'products' => $products, 'count' => count($products) );
}

function woofreendor_get_product_data( $paramProductId ){
    $product = get_post($paramProductId);
    $product_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->ID), 'full' )[0];
    $product_term = wp_get_post_terms( $paramProductId, 'product_cat', array( 'fields' => 'ids') )[0];
    return array( 'product' => $product, 'image' => $product_image, 'term' => $product_term);
}