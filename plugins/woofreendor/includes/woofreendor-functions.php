<?php
require_once dirname(__FILE__) . '/woofreendor-product-functions.php';
require_once dirname(__FILE__) . '/woofreendor-batch-functions.php';
require_once dirname(__FILE__) . '/woofreendor-outlet-functions.php';
require_once dirname(__FILE__) . '/woofreendor-tenant-functions.php';

function woofreendor_locatize_data() {
    $general_settings = get_option( 'dokan_general', array() );

    $banner_width     = ! empty( $general_settings['store_banner_width'] ) ? $general_settings['store_banner_width'] : 625;
    $banner_height    = ! empty( $general_settings['store_banner_height'] ) ? $general_settings['store_banner_height'] : 300;
    $has_flex_width   = ! empty( $general_settings['store_banner_flex_width'] ) ? $general_settings['store_banner_flex_width'] : true;
    $has_flex_height  = ! empty( $general_settings['store_banner_flex_height'] ) ? $general_settings['store_banner_flex_height'] : true;
    return array(
        'i18n_choose_featured_img'            => __( 'Upload featured image', 'dokan-lite' ),
        'i18n_choose_file'                    => __( 'Choose a file', 'dokan-lite' ),
        'i18n_choose_gallery'                 => __( 'Add Images to Product Gallery', 'dokan-lite' ),
        'i18n_choose_featured_img_btn_text'   => __( 'Set featured image', 'dokan-lite' ),
        'i18n_choose_file_btn_text'           => __( 'Insert file URL', 'dokan-lite' ),
        'i18n_choose_gallery_btn_text'        => __( 'Add to gallery', 'dokan-lite' ),
        'duplicates_attribute_messg'          => __( 'Sorry, this attribute option already exists, Try a different one.', 'dokan-lite' ),
        'variation_unset_warning'             => __( 'Warning! This product will not have any variations if this option is not checked.', 'dokan-lite' ),
        'new_attribute_prompt'                => __( 'Enter a name for the new attribute term:', 'dokan-lite' ),
        'remove_attribute'                    => __( 'Remove this attribute?', 'dokan-lite' ),
        'dokan_placeholder_img_src'           => wc_placeholder_img_src(),
        'add_variation_nonce'                 => wp_create_nonce( 'add-variation' ),
        'link_variation_nonce'                => wp_create_nonce( 'link-variations' ),
        'delete_variations_nonce'             => wp_create_nonce( 'delete-variations' ),
        'load_variations_nonce'               => wp_create_nonce( 'load-variations' ),
        'save_variations_nonce'               => wp_create_nonce( 'save-variations' ),
        'bulk_edit_variations_nonce'          => wp_create_nonce( 'bulk-edit-variations' ),
        'i18n_link_all_variations'            => esc_js( sprintf( __( 'Are you sure you want to link all variations? This will create a new variation for each and every possible combination of variation attributes (max %d per run).', 'dokan-lite' ), defined( 'WC_MAX_LINKED_VARIATIONS' ) ? WC_MAX_LINKED_VARIATIONS : 50 ) ),
        'i18n_enter_a_value'                  => esc_js( __( 'Enter a value', 'dokan-lite' ) ),
        'i18n_enter_menu_order'               => esc_js( __( 'Variation menu order (determines position in the list of variations)', 'dokan-lite' ) ),
        'i18n_enter_a_value_fixed_or_percent' => esc_js( __( 'Enter a value (fixed or %)', 'dokan-lite' ) ),
        'i18n_delete_all_variations'          => esc_js( __( 'Are you sure you want to delete all variations? This cannot be undone.', 'dokan-lite' ) ),
        'i18n_last_warning'                   => esc_js( __( 'Last warning, are you sure?', 'dokan-lite' ) ),
        'i18n_choose_image'                   => esc_js( __( 'Choose an image', 'dokan-lite' ) ),
        'i18n_set_image'                      => esc_js( __( 'Set variation image', 'dokan-lite' ) ),
        'i18n_variation_added'                => esc_js( __( "variation added", 'dokan-lite' ) ),
        'i18n_variations_added'               => esc_js( __( "variations added", 'dokan-lite' ) ),
        'i18n_no_variations_added'            => esc_js( __( "No variations added", 'dokan-lite' ) ),
        'i18n_remove_variation'               => esc_js( __( 'Are you sure you want to remove this variation?', 'dokan-lite' ) ),
        'i18n_scheduled_sale_start'           => esc_js( __( 'Sale start date (YYYY-MM-DD format or leave blank)', 'dokan-lite' ) ),
        'i18n_scheduled_sale_end'             => esc_js( __( 'Sale end date (YYYY-MM-DD format or leave blank)', 'dokan-lite' ) ),
        'i18n_edited_variations'              => esc_js( __( 'Save changes before changing page?', 'dokan-lite' ) ),
        'i18n_variation_count_single'         => esc_js( __( '%qty% variation', 'dokan-lite' ) ),
        'i18n_variation_count_plural'         => esc_js( __( '%qty% variations', 'dokan-lite' ) ),
        'i18n_no_result_found'                => esc_js( __( 'No Result Found', 'dokan-lite' ) ),
        'variations_per_page'                 => absint( apply_filters( 'dokan_product_variations_per_page', 10 ) ),
        'store_banner_dimension'              => [ 'width' => $banner_width, 'height' => $banner_height, 'flex-width' => $has_flex_width, 'flex-height' => $has_flex_height ],
        'selectAndCrop'                       => __( 'Select and Crop', 'dokan-lite' ),
        'chooseImage'                         => __( 'Choose Image', 'dokan-lite' ),
        'product_title_required'              => __( 'Product title is required', 'dokan-lite' ),
        'product_category_required'           => __( 'Product category is required', 'dokan-lite' ),
        'search_products_nonce'               => wp_create_nonce( 'search-products' ),
        'ajaxurl'     => admin_url( 'admin-ajax.php' ),
        'reload_batch_error'    => __( 'Terjadi kesalahan', 'woofreendor' ),
        'reload_batch_nonce'    => wp_create_nonce( 'reload-batch' ),
        'update_batch_nonce'    => wp_create_nonce( 'update-batch' ),
        'delete_batch_nonce'    => wp_create_nonce( 'delete-batch' ),
        'add_batch_nonce'       => wp_create_nonce( 'add-batch' ),
        'add_outlet_nonce'      => wp_create_nonce( 'add-outlet' ),
        'update_outlet_nonce'   => wp_create_nonce( 'update-outlet' ),
        'delete_outlet_nonce'   => wp_create_nonce( 'delete-outlet' )
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
// var_dump($template);die;
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
    //         'title' => __( 'Terms and Conditions', 'dokan-lite' ),
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