<?php

function woofreendor_save_outlet_ajax($paramPostData){

	$post_tenant_id = sanitize_text_field( $paramPostData['tenant_id'] );
    // $post_binder_group = sanitize_text_field( $paramPostData['binder_group'] );
    $post_email = sanitize_text_field( $paramPostData['outlet_email'] );
    $post_password = sanitize_text_field( $paramPostData['outlet_password'] );
    $post_username = sanitize_text_field( $paramPostData['outlet_username'] );

    $isValidPost =
        intval($post_tenant_id) > 0                &&
        // intval($post_binder_group) > 0            &&
        $post_email != ""              &&
        $post_password != ""                 &&
        $post_username != ""
    ;

    if($isValidPost){
        $status = true;

        if(empty($post_username) || is_null($post_username)){
            $status = false;
        }
        if(empty($post_email) || is_null($post_email)){
            $status = false;
        }
        if(empty($post_password) || is_null($post_password)){
            $status = false;
        }
        if($status){
            if(username_exists($post_username)){
                $status = false;
            }
            if(strlen($post_username) < 6){
                $status = false;
            }
            if(email_exists($post_email)){
                $status = false;
            }
            if(strlen($post_email) < 6){
                $status = false;
            }
            if(strlen($post_password) < 5){
                $status = false;
            }
            if($status){
                $outlet_data = array(
                    'user_login'    => $post_username,
                    'user_pass'     => $post_password,
                    'user_email'    => $post_email,
                    'role'          => 'seller',
                    'display_name'  => ucfirst($post_username)
                    );

                $new_outlet_id = wp_insert_user($outlet_data);
                if($new_outlet_id){
                    // update_user_meta($new_outlet_id,'binder_group', $post_binder_group);
                    // update_user_meta($new_outlet_id,'tenant_id', $post_tenant_id);
                    // update_user_meta($new_outlet_id,'has_tenant', 1);
                    woofreendor_enable_outlet( $new_outlet_id, $post_tenant_id);

                    $cache_key = 'woofreendor-count-outlets-' . $post_tenant_id;
                    $counts = wp_cache_get( $cache_key, 'woofreendor' );

                    if(false !== $counts){
                        wp_cache_delete($cache_key,'woofreendor');
                    }

                    return intval($new_outlet_id);
                }
            }
        }     
    }
    return false;
}

function woofreendor_update_outlet_ajax($paramPostData){

    $email = sanitize_text_field($paramPostData['outlet_email']);
    $password = sanitize_text_field($paramPostData['outlet_password']);
    $outlet_id = sanitize_text_field($paramPostData['outlet_id']);
    $owner = sanitize_text_field( $paramPostData['tenant_id'] );

    if(! woofreendor_is_owner_outlet($outlet_id,$owner)) {
        return false;
    }

    $status = true;
    $outlet_data = array();
    $outlet_data['ID'] = $outlet_id;

    $status_dif = false;
    if(!empty($email) && !is_null($email) && !(strlen($email) < 6) && (!email_exists($email))){
        $status_dif = true;
        $outlet_data['user_email'] = $email;
    }
    if(!empty($password) && !is_null($password) && !(strlen($password) < 5) ){
        $status_dif = true;
        $outlet_data['user_pass'] = $password;
    }

    if($status_dif){
        $updated_outlet_id = wp_update_user($outlet_data);
        if($updated_outlet_id){
            return intval($outlet_id);
        }
    }
    return false;
}

function woofreendor_delete_outlet_ajax($paramPostData){

    $post_outlet_id = sanitize_text_field( $paramPostData['outlet_id'] );
    $post_tenant_id = sanitize_text_field( $paramPostData['tenant_id'] );

    if(! woofreendor_is_owner_outlet($post_outlet_id,$post_tenant_id)) {
        return false;
    }

    require_once(ABSPATH.'wp-admin/includes/user.php');
    if(wp_delete_user($post_outlet_id)){
        $products = woofreendor_get_outlet_publish_products($post_outlet_id);
        if($products['count']>0){
            foreach ($products['products'] as $product) {
                woofreendor_permanently_delete_product($product->ID);
            }
        }
        
        $batches = woofreendor_get_outlet_publish_batches($post_outlet_id);
        if($batches['count']>0){
            foreach ($batches['batches'] as $batch) {
                woofreendor_permanently_delete_product($batch->ID);
            }
        }
        return true;
    }
    
    return false;
}

function woofreendor_get_outlets($paramTenantId){
    $outlet_args = array(
        'role'      => 'seller',
        'meta_key'  => 'tenant_id',
        'meta_value'=>  $paramTenantId,
        'orderby'   => 'ID',
        'order'     => 'ASC'
        );

    return get_users($outlet_args);
}

function woofreendor_is_owner_outlet($paramOutletId, $paramTenantId){
    $owner = get_user_meta( $paramOutletId, 'tenant_id', true );

    return ($owner == $paramTenantId);
}

function woofreendor_disable_outlet($paramOutletId){
    update_user_meta( $paramOutletId,'tenant_id', 0 );
    update_user_meta( $paramOutletId, 'has_tenant', false);
}

function woofreendor_enable_outlet($paramOutletId, $paramTenantId){
    update_user_meta( $paramOutletId,'tenant_id', $paramTenantId);
    update_user_meta( $paramOutletId,'has_tenant', true);
}

/* function woofreendor_count_outlet_by_tenant( $paramTenantId ){
    $args = array(
            'role'       => 'seller',
            'orderby'    => 'registered',
            'order'      => 'ASC',
            'meta_query' => array(
                'relation'  => 'AND',
                    array(
                        'key'   => 'has_tenant',
                        'value' => true,
                        'compare'=> '='
                        ),
                    array(
                        'key'   => 'tenant_id',
                        'value' => $paramTenantId,
                        'compare'=> '='
                        )
                    )
                
                );

    $user_query = new WP_User_Query( $args );
    $sellers    = $user_query->get_results();

    return array( 'users' => $sellers, 'count' => $user_query->total_users );
} */

function woofreendor_count_outlets($paramTenantId){
    global $wpdb;
    
    $cache_key = 'woofreendor-count-outlets-' . $paramTenantId;
    $counts = wp_cache_get( $cache_key, 'woofreendor' );

    if ( false === $counts ) {
        $query = 
            "SELECT COUNT( * ) 
            FROM (SELECT DISTINCT um.user_id 
                FROM {$wpdb->usermeta} um 
                INNER JOIN {$wpdb->users} u 
                ON um.user_id != %d 
                WHERE um.meta_key = %s AND um.meta_value = %d ) outlet";
        $results = $wpdb->get_var( $wpdb->prepare( $query, $paramTenantId, 'tenant_id', $paramTenantId ));
        // var_dump($num_outlets);

        // $total = 0;
        // foreach ( $results as $row ) {
        //     if ( ! in_array( $row['post_status'], $post_status ) ) {
        //         continue;
        //     }

        //     $counts[ $row['post_status'] ] = (int) $row['num_posts'];
        //     $total += (int) $row['num_posts'];
        // }

        $counts['total'] = $results;
        $counts = (object) $counts;
        wp_cache_set( $cache_key, $counts, 'woofreendor' );
    }

    return $counts;
}

