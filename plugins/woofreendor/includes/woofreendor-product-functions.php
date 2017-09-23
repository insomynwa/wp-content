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
        'post_status'       => 'publish'
    );

    $products = get_posts($args);
    return array( 'products' => $products, 'count' => count($products) );
}

function woofreendor_get_tenant_product_ids( $paramTenantId = 0){
    $args = array(
        'fields'            => 'ids',
        'post_per_page'     => -1,
        'orderby'           => 'title',
        'order'             => 'ASC',
        // 'author'            => $paramTenantId,
        'post_type'         => 'product',
        'post_status'       => 'publish'
    );

    if( $paramTenantId != 0) {
        $args['author'] = $paramTenantId;
    }else{
        $tenant_ids = woofreendor_get_tenant_ids();
        $args['author__in'] = $tenant_ids;
    }

    $products = get_posts($args);
    return $products;
    // return array( 'products' => $products, 'count' => count($products) );
}

function woofreendor_get_product_data( $paramProductId ){
    $product = get_post($paramProductId);

    $product_image = get_post_thumbnail_id($product->ID);
    $product_image_url = wp_get_attachment_image_src( $product_image, 'full' )[0];
    $product_term = wp_get_post_terms( $paramProductId, 'product_cat', array( 'fields' => 'ids') )[0];
    return array( 'product' => $product, 'image_url' => $product_image_url, 'term' => $product_term, 'image_id' => $product_image);
}

function woofreendor_get_product_detail( $paramProductId) {
    $product = get_post($paramProductId);
    $product_image = get_post_thumbnail_id($paramProductId);
    $image_url = wp_get_attachment_image_src( $product_image, 'full' )[0];
    $term = wp_get_post_terms( $paramProductId, 'product_cat', array() )[0];
    $child_products = woofreendor_get_child_products($paramProductId);
    $child_product_data = array();
    foreach($child_products as $cp){
        $child_product_data[] = array(
            'outlet' => get_the_author_meta('display_name', $cp->post_author), 
            'product_url' => get_permalink( $cp->ID )
        );
    }

    return array( 'product' => $product, 'image_url' => $image_url, 'term' => $term, 'child_product' => $child_product_data);
}

function woofreendor_get_child_products( $paramProductParentId){
    $ch_args = array(
        'post_type'	=> 'product',
        'meta_key'	=> 'product_parent',
        'meta_value'=> 5532,
        'posts_per_page' => '-1',
        'orderby'	=> 'post_author',
        'order'		=> 'ASC'
    );
    return get_posts($ch_args);
}

function woofreendor_get_child_product_ids( $paramProductParentId){
    $ch_args = array(
        'fields'    => 'ids',
        'post_type'	=> 'product',
        'meta_key'	=> 'product_parent',
        'meta_value'=> 5532,
        'posts_per_page' => '-1',
        'orderby'	=> 'post_author',
        'order'		=> 'ASC'
    );
    return get_posts($ch_args);
}

/**
 * Get Best Selling Product
 *
 * @param int number of product to show
 * @return array Parent Product ID and Total Sales
 */
function woofreendor_get_best_selling_products($limit){
    global $wpdb;
    
    // $cache_key = 'woofreendor-count-outlets-' . $paramTenantId;
    // $counts = wp_cache_get( $cache_key, 'woofreendor' );

    // if ( false === $counts ) {
        $query =
        "SELECT pm3.parent, SUM(pm3.total) as total_sales FROM (
            SELECT pm2.meta_value as parent, pm1.meta_value as total FROM (
                SELECT post_id, meta_value FROM {$wpdb->postmeta}
                WHERE meta_key IN (%s) AND
                    post_id IN (
                        SELECT post_id FROM {$wpdb->postmeta}
                        WHERE meta_key IN (%s)
                    )
                ) pm1
            LEFT JOIN (
                SELECT post_id, meta_value FROM {$wpdb->postmeta}
                WHERE meta_key IN (%s)
                ) pm2
            ON pm1.post_id = pm2.post_id
        ) pm3
        GROUP BY pm3.parent
        ORDER BY pm3.total DESC
        LIMIT %d";
        $results = $wpdb->get_results( $wpdb->prepare( $query, "total_sales", 'product_parent', 'product_parent' , $limit), ARRAY_A);
        return $results;
        // $counts['total'] = $results;
        // $counts = (object) $counts;
        // wp_cache_set( $cache_key, $counts, 'woofreendor' );
    // }

    // return $counts;
}

function woofreendor_custom_product_list($query){
    if ( ! is_admin() && $query->is_main_query() && is_shop() ) {
        $arr_tenant_products = woofreendor_get_tenant_product_ids();
        $query->set( 'post__in', $arr_tenant_products );
        // echo '<pre>';var_dump($arr_tenant_products);echo '</pre>';
        return;
    }
}

add_filter( 'pre_get_posts', 'woofreendor_custom_product_list' );