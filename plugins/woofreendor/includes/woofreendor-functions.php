<?php
require_once dirname(__FILE__) . '/woofreendor-batch-functions.php';

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

    /**
     * Change template directory path filter
     *
     * @since 2.5.3
     */
    $template_path = apply_filters( 'woofreendor_set_template_path', $woofreendor->plugin_path() . '/templates', $template, $args );

    // Get default slug-name.php
    if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
        $template = $template_path . "/{$slug}-{$name}.php";
    }

    if ( ! $template && !$name && file_exists( $template_path . "/{$slug}.php" ) ) {
        $template = $template_path . "/{$slug}.php";
    }

    // Allow 3rd party plugin filter template file from their plugin
    $template = apply_filters( 'woofreendor_get_template_part', $template, $slug, $name );

    if ( $template ) {
        include( $template );
    }
}
function woofreendor_get_tenants( $args = array() ) {

    $defaults = array(
	        'role'       => 'woofreendor_tenant_role',
	        'number'     => 9,
	        'offset'     => 0,
	        'orderby'    => 'registered',
	        'order'      => 'ASC'
	    );

    $args = wp_parse_args( $args, $defaults );

    $user_query = new WP_User_Query( $args );
    $sellers    = $user_query->get_results();

    return array( 'users' => $sellers, 'count' => $user_query->total_users );
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

function woofreendor_get_binder_group($paramUserId){
    return get_user_meta( $paramUserId, 'binder_group', true);
}

function woofreendor_tenants() {
    $attr = shortcode_atts( apply_filters( 'woofreendor_tenant_listing_per_page', array(
        'per_page' => 10,
        'search'   => 'yes',
        'per_row'  => 3,
    ) ), $atts );
    $paged   = max( 1, get_query_var( 'paged' ) );
    $limit   = $attr['per_page'];
    $offset  = ( $paged - 1 ) * $limit;

    $tenant_args = array(
        'number' => $limit,
        'offset' => $offset
    );

    // if search is enabled, perform a search
    if ( 'yes' == $attr['search'] ) {
        $search_term = isset( $_GET['woofreendor_tenant_search'] ) ? sanitize_text_field( $_GET['woofreendor_tenant_search'] ) : '';
        if ( '' != $search_term ) {

            $tenant_args['meta_query'] = array(
                 array(
                    'key'     => 'woofreendor_tenant_name',
                    'value'   => $search_term,
                    'compare' => 'LIKE'
                )
            );
        }
    }

    $tenants = woofreendor_get_tenants( apply_filters( 'woofreendor_tenant_listing_args', $tenant_args ) );

    /**
     * Filter for store listing args
     *
     * @since 2.4.9
     */
    $template_args = apply_filters( 'woofreendor_tenant_list_args', array(
        'tenants'    => $tenants,
        'limit'      => $limit,
        'offset'     => $offset,
        'paged'      => $paged,
        'image_size' => 'full',
        'search'     => $attr['search'],
        'per_row'    => $attr['per_row']
    ) );
    ob_start();
    woofreendor_get_template_part( 'tenant-lists', false, $template_args );
    $content = ob_get_clean();

    return apply_filters( 'woofreendor_tenant_listing', $content, $attr );
}
add_shortcode( 'woofreendor-tenants', 'woofreendor_tenants');  