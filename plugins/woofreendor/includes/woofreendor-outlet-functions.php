<?php

function woofreendor_save_outlet($paramPostData){

	$post_tenant_id = sanitize_text_field( $paramPostData['tenant_id'] );
    $post_binder_group = sanitize_text_field( $paramPostData['binder_group'] );
    $post_email = sanitize_text_field( $paramPostData['outlet_email'] );
    $post_password = sanitize_text_field( $paramPostData['outlet_password'] );
    $post_username = sanitize_text_field( $paramPostData['outlet_username'] );

    $isValidPost =
        intval($post_tenant_id) > 0                &&
        intval($post_binder_group) > 0            &&
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
                    update_user_meta($new_outlet_id,'binder_group', $post_binder_group);
                    update_user_meta($new_outlet_id,'tenant_id', $post_tenant_id);
                    return intval($new_outlet_id);
                }
            }
        }     
    }
    return false;
}
function woofreendor_update_outlet($paramPostData){

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

function woofreendor_delete_outlet($paramPostData){

    $post_outlet_id = sanitize_text_field( $paramPostData['outlet_id'] );
    $post_tenant_id = sanitize_text_field( $paramPostData['tenant_id'] );

    if(! woofreendor_is_owner_outlet($post_outlet_id,$post_tenant_id)) {
        return false;
    }

    require_once(ABSPATH.'wp-admin/includes/user.php');
    if(wp_delete_user($post_outlet_id)){
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
