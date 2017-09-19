<?php
require_once dirname(__FILE__) . '/woofreendor-product-functions.php';
require_once dirname(__FILE__) . '/woofreendor-batch-functions.php';
require_once dirname(__FILE__) . '/woofreendor-outlet-functions.php';
require_once dirname(__FILE__) . '/woofreendor-tenant-functions.php';

function woofreendor_locatize_data() {
    return array(
        'ajaxurl'     => admin_url( 'admin-ajax.php' ),
        'reload_batch_error'    => __( 'Terjadi kesalahan', 'woofreendor' ),
        'reload_batch_nonce'    => wp_create_nonce( 'reload-batch' ),
        'update_batch_nonce'    => wp_create_nonce( 'update-batch' ),
        'delete_batch_nonce'    => wp_create_nonce( 'delete-batch' ),
        'add_batch_nonce'       => wp_create_nonce( 'add-batch' ),
        'add_outlet_nonce'      => wp_create_nonce( 'add-outlet' ),
        'update_outlet_nonce'   => wp_create_nonce( 'update-outlet' ),
        'delete_outlet_nonce'   => wp_create_nonce( 'delete-outlet' ),
        'product_data_nonce'   => wp_create_nonce( 'data-product' ),
        'outlet_name_required'      => __( 'Nama outlet belum diisi', 'woofreendor' ),
        'outlet_name_min_error'     => __( 'Nama outlet minimal 6 karakter', 'woofreendor' ),
        'outlet_username_required'  => __( 'Username outlet belum diisi', 'woofreendor' ),
        'outlet_username_min_error'     => __( 'Username outlet minimal 6 karakter', 'woofreendor' ),
        'outlet_email_required'  => __( 'E-mail outlet belum diisi', 'woofreendor' ),
        'outlet_password_required'  => __( 'Password outlet belum diisi', 'woofreendor' ),
    );
}

function woofreendor_get_tenant_info( $tenant_id ) {
    $info = get_user_meta( $tenant_id, 'woofreendor_profile_settings', true );
    $info = is_array( $info ) ? $info : array();

    $defaults = array(
        'tenant_name' => '',
        'social'     => array(),
        'payment'    => array( 'paypal' => array( 'email' ), 'bank' => array() ),
        'phone'      => '',
        'show_email' => 'off',
        'address'    => '',
        'location'   => '',
        'banner'     => 0
    );

    $info               = wp_parse_args( $info, $defaults );
    $info['tenant_name'] = empty( $info['tenant_name'] ) ? get_user_by( 'id', $tenant_id )->display_name : $info['tenant_name'];

    return $info;
}

function woofreendor_is_user_tenant( $user_id ) {
    if ( ! user_can( $user_id, 'woofreendor_tenant' ) ) {
        return false;
    }

    return true;
}

function woofreendor_is_user_outlet( $user_id ) {
    if ( ! user_can( $user_id, 'woofreendor_outlet' ) ) {
        return false;
    }

    return true;
}

function woofreendor_locate_template( $template_name, $template_path = '', $default_path = '', $pro = false ) {
    $woofreendor = Woofreendor::init();

    if ( ! $template_path ) {
        $template_path = $woofreendor->template_path();
    }

    if ( ! $default_path ) {
        $default_path = $woofreendor->plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
        )
    );

    // Get default template
    if ( ! $template ) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters('woofreendor_locate_template', $template, $template_name, $template_path );
}

function woofreendor_is_tenant_page() {
    $custom_tenant_url = dokan_get_option( 'custom_tenant_url', 'woofreendor_general', 'tenant' );

    if ( get_query_var( $custom_tenant_url ) ) {
        return true;
    }

    return false;
}

function woofreendor_get_tenant_url( $user_id ) {
    $userdata = get_userdata( $user_id );
    $user_nicename = ( !false == $userdata ) ? $userdata->user_nicename : '';

    $custom_tenant_url = dokan_get_option( 'custom_tenant_url', 'woofreendor_general', 'tenant' );
    return sprintf( '%s/%s/', home_url( '/' . $custom_tenant_url ), $user_nicename );
}

function woofreendor_get_template_part( $slug, $name = '', $args = array() ) {
    $woofreendor = Woofreendor::init();
// var_dump($slug);
// var_dump($name);
// var_dump($args);
    $defaults = array(
        'pro' => false
    );

    $args = wp_parse_args( $args, $defaults );

    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $template = '';

    // Look in yourtheme/dokan/slug-name.php and yourtheme/dokan/slug.php
    $template = locate_template( array( $woofreendor->template_path() . "{$slug}-{$name}.php", $woofreendor->template_path() . "{$slug}.php" ) );
// var_dump($template);
    /**
     * Change template directory path filter
     *
     * @since 2.5.3
     */
    $template_path = apply_filters( 'woofreendor_set_template_path', $woofreendor->plugin_path() . '/templates', $template, $args );
    // var_dump($template_path);
    // Get default slug-name.php
    if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
        $template = $template_path . "/{$slug}-{$name}.php";
    }

    if ( ! $template && !$name && file_exists( $template_path . "/{$slug}.php" ) ) {
        $template = $template_path . "/{$slug}.php";
    }
// var_dump($template);
    // Allow 3rd party plugin filter template file from their plugin
    $template = apply_filters( 'woofreendor_get_template_part', $template, $slug, $name );

// var_dump($template);
    if ( $template ) {
        include( $template );
    }
}
function woofreendor_is_tenant_dashboard() {
    $page_id = dokan_get_option( 'tenant_dashboard', 'woofreendor_pages' );

    if ( ! $page_id ) {
        return false;
    }

    if ( $page_id == get_the_ID() ) {
        return true;
    }

    return false;
}
function woofreendor_redirect_if_not_tenant( $redirect = '' ) {
    if ( !woofreendor_is_user_tenant( get_current_user_id() ) ) {
        $redirect = empty( $redirect ) ? home_url( '/' ) : $redirect;

        wp_redirect( $redirect );
        exit;
    }
}

function woofreendor_product_listing_filter(){
    woofreendor_get_template_part( 'products/listing-filter' );
}

function woofreendor_outlet_listing_filter(){
    woofreendor_get_template_part( 'outlets/listing-filter' );
}

function woofreendor_after_login_redirect( $redirect_to, $user ) {

    if ( user_can( $user, 'woofreendor_outlet' ) ) {
        $seller_dashboard = dokan_get_option( 'dashboard', 'dokan_pages' );

        if ( $seller_dashboard != -1 ) {
            $redirect_to = get_permalink( $seller_dashboard );
        }
    }
    else if ( user_can( $user, 'woofreendor_tenant' ) ) {
        $tenant_dashboard = dokan_get_option( 'tenant_dashboard', 'woofreendor_pages' );

        if ( $tenant_dashboard != -1 ) {
            $redirect_to = get_permalink( $tenant_dashboard );
        }
    }

    if ( isset( $_GET['redirect_to'] ) && !empty( $_GET['redirect_to'] ) ) {
        $redirect_to = esc_url( $_GET['redirect_to'] );
    }

    return $redirect_to;
}

remove_filter( 'woocommerce_login_redirect', 'dokan_after_login_redirect' , 1, 2 );
add_filter( 'woocommerce_login_redirect', 'woofreendor_after_login_redirect' , 1, 2 );

function woofreendor_get_navigation_url( $name = '' ) {
    $page_id = dokan_get_option( 'tenant_dashboard', 'woofreendor_pages' );

    if ( ! $page_id ) {
        return;
    }

    if ( ! empty( $name ) ) {
        $url = get_permalink( $page_id ) . $name.'/';
    } else {
        $url = get_permalink( $page_id );
    }

    return apply_filters( 'woofreendor_get_navigation_url', $url, $name );
}

// function woofreendor_get_binder_group($paramUserId){
//     return get_user_meta( $paramUserId, 'binder_group', true);
// }

function woofreendor_get_tenant_tabs( $tenant_id ) {

    $tabs = array(
        'outlets' => array(
            'title' => __( 'Outlets', 'woofreendor' ),
            'url'   => woofreendor_get_tenant_url( $tenant_id )
        ),
    );

    $store_info = woofreendor_get_tenant_info( $tenant_id );
    // $tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );

    // if ( isset($store_info['enable_tnc']) && $store_info['enable_tnc'] == 'on' && $tnc_enable == 'on' ) {
    //     $tabs['terms_and_conditions'] = array(
    //         'title' => __( 'Terms and Conditions', 'woofreendor' ),
    //         'url'   => dokan_get_toc_url( $tenant_id )
    //     );
    // }

    return apply_filters( 'woofreendor_tenant_tabs', $tabs, $tenant_id );
}

function woofreendor_get_tenant_short_address( $tenant_id, $line_break = true ) {
    $store_address = woofreendor_get_tenant_address( $tenant_id, true );

    $short_address = array();
    $formatted_address = '';

    if ( ! empty( $store_address['street_1'] ) && empty( $store_address['street_2'] ) ) {
        $short_address[] = $store_address['street_1'];
    } else if ( empty( $store_address['street_1'] ) && ! empty( $store_address['street_2'] ) ) {
        $short_address[] = $store_address['street_2'];
    } else if ( ! empty( $store_address['street_1'] ) && ! empty( $store_address['street_2'] ) ) {
        $short_address[] = $store_address['street_1'];
    }

    if ( ! empty( $store_address['city'] ) && ! empty( $store_address['city'] ) ) {
        $short_address[] = $store_address['city'];
    }

    if ( ! empty( $store_address['state'] ) && ! empty( $store_address['country'] ) ) {
        $short_address[] = $store_address['state'] . ', ' . $store_address['country'];
    } else if ( ! empty( $store_address['country'] ) ) {
        $short_address[] = $store_address['country'];
    }

    if ( ! empty( $short_address  ) && $line_break ) {
        $formatted_address = implode( '<br>', $short_address );
    } else {
        if ( count( $short_address ) > 1 ) {
            $formatted_address = implode( ', ', $short_address );
        } else {
            $formatted_address = implode( ' ', $short_address );
        }
    }


    return apply_filters( 'woofreendor_tenant_header_adress', $formatted_address, $store_address, $short_address );
}


function woofreendor_get_tenant_address( $tenant_id = '', $get_array = false ) {

    if ( $tenant_id == '' ) {
        $tenant_id = get_current_user_id();
    }

    $profile_info = woofreendor_get_tenant_info( $tenant_id );

    if ( isset( $profile_info['address'] ) ) {

        $address = $profile_info['address'];

        $country_obj = new WC_Countries();
        $countries   = $country_obj->countries;
        $states      = $country_obj->states;

        $street_1     = isset( $address['street_1'] ) ? $address['street_1'] : '';
        $street_2     = isset( $address['street_2'] ) ? $address['street_2'] : '';
        $city         = isset( $address['city'] ) ? $address['city'] : '';

        $zip          = isset( $address['zip'] ) ? $address['zip'] : '';
        $country_code = isset( $address['country'] ) ? $address['country'] : '';
        $state_code   = isset( $address['state'] ) ? $address['state'] : '';
        $state_code   = isset( $address['state'] ) ? ( $address['state'] == 'N/A' ) ? '' : $address['state'] : '';

        $country_name = isset( $countries[$country_code] ) ? $countries[$country_code] : '';
        $state_name   = isset( $states[$country_code][$state_code] ) ? $states[$country_code][$state_code] : $state_code;

    } else {
        return 'N/A';
    }

    if ( $get_array == true ) {
        $address = array(
            'street_1' => $street_1,
            'street_2' => $street_2,
            'city'     => $city,
            'zip'      => $zip,
            'country'  => $country_name,
            'state'    => isset( $states[$country_code][$state_code] ) ? $states[$country_code][$state_code] : $state_code,
        );

        return apply_filters( 'woofreendor_get_tenant_address', $address, $profile_info );
    }

    $country           = new WC_Countries();
    $formatted_address = $country->get_formatted_address( array(
        'address_1' => $street_1,
        'address_2' => $street_2,
        'city'      => $city,
        'postcode'  => $zip,
        'state'     => $state_code,
        'country'   => $country_code
    ) );

    return apply_filters( 'woofreendor_get_tenant_formatted_address', $formatted_address, $profile_info );
}

add_action( 'wp', 'woofreendor_set_is_home_false_on_tenant' );

function woofreendor_set_is_home_false_on_tenant() {
    global $wp_query;

    if ( woofreendor_is_tenant_page() ) {
        $wp_query->is_home = false;
    }
}

function woofreendor_media_uploader_restrict( $args ) {
    // bail out for admin and editor
    if ( current_user_can( 'delete_pages' ) ) {
        return $args;
    }

    if ( current_user_can( 'woofreendor_tenant' ) ) {
        $args['author'] = get_current_user_id();

        return $args;
    }

    return $args;
}

add_filter( 'ajax_query_attachments_args', 'woofreendor_media_uploader_restrict' );


/**
 * Generate Address fields form for seller
 * @since 2.3
 *
 * @param boolean verified
 *
 * @return void
 */
function woofreendor_tenant_address_fields( $verified = false, $required = false ) {
    
    $disabled = $verified ? 'disabled' : '';

    /**
     * Filter the seller Address fields
     *
     * @since 2.2
     *
     * @param array $dokan_seller_address
     */
    $seller_address_fields = apply_filters( 'dokan_seller_address_fields', array(

            'street_1' => array(
                'required' => $required ? 1 : 0,
            ),
            'street_2' => array(
                'required' => 0,
            ),
            'city'     => array(
                'required' => $required ? 1 : 0,
            ),
            'zip'      => array(
                'required' => $required ? 1 : 0,
            ),
            'country'  => array(
                'required' => 1,
            ),
            'state'    => array(
                'required' => 0,
            ),
        )
    );

    $profile_info = woofreendor_get_tenant_info( get_current_user_id() );

    dokan_get_template_part( 'settings/address-form', '', array(
        'disabled' => $disabled,
        'seller_address_fields' => $seller_address_fields,
        'profile_info' => $profile_info,
    ) );
}

/**
 * User avatar wrapper for custom uploaded avatar
 *
 * @since 2.0
 *
 * @param string $avatar
 * @param mixed $id_or_email
 * @param int $size
 * @param string $default
 * @param string $alt
 * @return string image tag of the user avatar
 */
function woofreendor_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    
if ( is_numeric( $id_or_email ) ) {
    $user = get_user_by( 'id', $id_or_email );
} elseif ( is_object( $id_or_email ) ) {
    if ( $id_or_email->user_id != '0' ) {
        $user = get_user_by( 'id', $id_or_email->user_id );
    } else {
        return $avatar;
    }
} else {
    $user = get_user_by( 'email', $id_or_email );
}

if ( !$user ) {
    return $avatar;
}

// see if there is a user_avatar meta field
$user_avatar = get_user_meta( $user->ID, 'woofreendor_profile_settings', true );
$gravatar_id = isset( $user_avatar['gravatar'] ) ? $user_avatar['gravatar'] : 0;
if ( empty( $gravatar_id ) ) {
    return $avatar;
}

$avater_url = wp_get_attachment_thumb_url( $gravatar_id );

return sprintf( '<img src="%1$s" alt="%2$s" width="%3$s" height="%3$s" class="avatar photo">', esc_url( $avater_url ), $alt, $size );
}

add_filter( 'get_avatar', 'woofreendor_get_avatar', 100, 5 );

function woofreendor_get_batches($paramProductId){
    $args = array(
        'post_type' => 'product_variation',
        'post_parent' => $paramProductId,
        'orderby' => 'ID',
        'order' => 'ASC',
        'posts_per_page' => -1
    );//var_dump(get_posts($args));
    return get_posts($args);
}

function woofreendor_generate_html( $paramPath, $paramData ){
    ob_start();
    require $paramPath . '.php';
    $html = ob_get_contents();
    ob_end_clean();
    
    return $html;
}

register_sidebar( array( 'name' => __( 'Woofreendor Tenant Sidebar', 'woofreendor' ), 'id' => 'sidebar-tenant' ) );

function woofreendor_get_page_url( $page, $context = 'woofreendor' ) {
    
        if ( $context == 'woocommerce' ) {
            $page_id = wc_get_page_id( $page );
        } else {
            $page_id = dokan_get_option( $page, 'woofreendor_pages' );
        }
    
        return apply_filters( 'dokan_get_page_url', get_permalink( $page_id ), $page_id, $context );
    }