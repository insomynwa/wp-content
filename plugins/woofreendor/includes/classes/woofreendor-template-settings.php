<?php

/**
 * Dokan Pro Template Settings class
 *
 * @since 2.4
 *
 * @package dokan
 */
class Woofreendor_Template_Settings {
    public $current_tenant;
    public $tenant_profile;

    /**
     * Load autometically when class initiate
     *
     * @since 2.4
     *
     * @uses actions hook
     * @uses filter hook
     *
     * @return void
     */
    public function __construct() {
        $this->current_tenant = get_current_user_id();
        $this->tenant_profile = woofreendor_get_tenant_info( get_current_user_id() );

        // add_filter( 'dokan_get_dashboard_settings_nav', array( $this, 'load_settings_menu' ), 10 );
        add_filter( 'dokan_dashboard_settings_heading_title', array( $this, 'load_settings_header' ), 10, 2 );
        // add_filter( 'dokan_dashboard_settings_helper_text', array( $this, 'load_settings_helper_text' ), 10, 2 );

        // add_action( 'dokan_ajax_settings_response', array( $this, 'add_progressbar_in_settings_save_response' ), 10 );
        // add_action( 'dokan_settings_load_ajax_response', array( $this, 'render_pro_settings_load_progressbar' ), 25 );
        // add_action( 'dokan_settings_render_profile_progressbar', array( $this, 'load_settings_progressbar' ), 10, 2 );
        // add_action( 'dokan_settings_content_area_header', array( $this, 'render_shipping_status_message' ), 25 );
        add_action( 'dokan_render_settings_content', array( $this, 'load_settings_content' ), 10 );
        // add_action( 'dokan_settings_form_bottom', array( $this, 'add_discount_option' ), 10, 2 );
        // add_action( 'dokan_store_profile_saved', array( $this, 'save_store_discount_data' ), 10, 2 );
    }

    /**
     * Singleton object
     *
     * @staticvar boolean $instance
     *
     * @return \self
     */
    public static function init() {

        static $instance = false;

        if ( !$instance ) {
            $instance = new Woofreendor_Template_Settings();
        }

        return $instance;
    }
    
    /**
     * Load Settings Content
     *
     * @since 2.4
     *
     * @param  array $query_vars
     *
     * @return void
     */
    public function load_settings_content( $query_vars ) {

        if ( isset( $query_vars['settings'] ) && $query_vars['settings'] == 'tenant' ) {
            $this->load_tenant_content();
        }
    }

    /**
     * Load Tenant Page Content
     *
     * @since 2.4
     *
     * @return void
     */
    public function load_tenant_content() {

        // var_dump(get_user_meta( $this->current_tenant, 'woofreendor_profile_settings', true ));
        woofreendor_get_template_part( 'settings/tenant-form', '', array(
            'pro'           => true,
            'current_tenant'  => $this->current_tenant,
            'tenant_profile'  => $this->tenant_profile,
        ) );
    }
    
    /**
     * Save tenant settings via ajax
     *
     * @since 2.4
     *
     * @return void
     */
    function tenant_setting_ajax() {

        if ( ! woofreendor_is_user_tenant( get_current_user_id() ) ) {
            wp_send_json_error( __( 'Are you cheating?', 'woofreendor' ) );
        }

        $_POST['woofreendor_update_profile'] = '';

        switch( $_POST['form_id'] ) {
            case 'tenant-form':
                if ( !wp_verify_nonce( $_POST['_wpnonce'], 'woofreendor_tenant_settings_nonce' ) ) {
                    wp_send_json_error( __( 'Are you cheating?', 'woofreendor' ) );
                }
                $ajax_validate =  $this->tenant_validate();
                break;
        }

        if ( is_wp_error( $ajax_validate ) ) {
            wp_send_json_error( $ajax_validate->errors );
        }

        // we are good to go
        $save_data = $this->insert_settings_info();

        $success_msg = __( 'Your information has been saved successfully', 'woofreendor' ) ;

        $data = apply_filters( 'dokan_ajax_settings_response', array(
            'msg'      => $success_msg,
        ) );

        wp_send_json_success( $data );
    }
    
    /**
     * Validate tenant settings
     *
     * @return bool|WP_Error
     */
    function tenant_validate() {

        if ( !isset( $_POST['woofreendor_update_tenant_settings'] ) ) {
            return false;
        }

        if ( !wp_verify_nonce( $_POST['_wpnonce'], 'woofreendor_tenant_settings_nonce' ) ) {
            wp_die( __( 'Are you cheating?', 'woofreendor' ) );
        }

        $error = new WP_Error();

        $tenant_name = sanitize_text_field( $_POST['woofreendor_tenant_name'] );

        if ( empty( $tenant_name ) ) {
            $error->add( 'tenant_name', __( 'Tenant name required', 'woofreendor' ) );
        }

        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;

    }
    
    /**
     * Validate settings submission
     *
     * @return void
     */
    function validate() {

        if ( !isset( $_POST['woofreendor_update_profile'] ) ) {
            return false;
        }

        if ( !wp_verify_nonce( $_POST['_wpnonce'], 'dokan_settings_nonce' ) ) {
            wp_die( __( 'Are you cheating?', 'woofreendor' ) );
        }

        $error = new WP_Error();

        $tenant_name = sanitize_text_field( $_POST['woofreendor_tenant_name'] );

        if ( empty( $tenant_name ) ) {
            $error->add( 'tenant_name', __( 'Tenant name required', 'woofreendor' ) );
        }

        /* Address Fields Validation */
        $required_fields  = array(
            'street_1',
            'city',
            'zip',
            'country',
        );
        if ( $_POST['dokan_address']['state'] != 'N/A' ) {
            $required_fields[] = 'state';
        }
        foreach ( $required_fields as $key ) {
            if ( empty( $_POST['dokan_address'][$key] ) ) {
                $code = 'dokan_address['.$key.']';
                $error->add( $code, sprintf( __('Address field for %s is required', 'woofreendor'), $key ) );
            }
        }


        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;
    }
    
    /**
     * Save tenant settings
     *
     * @return void
     */
    function insert_settings_info() {

        $tenant_id                = get_current_user_id();
        $existing_woofreendor_settings = get_user_meta( $tenant_id, 'woofreendor_profile_settings', true );
        $prev_woofreendor_settings     = ! empty( $existing_woofreendor_settings ) ? $existing_woofreendor_settings : array();

        if ( wp_verify_nonce( $_POST['_wpnonce'], 'woofreendor_tenant_settings_nonce' ) ) {

            //update store setttings info
            $woofreendor_settings = array(
                'tenant_name'                   => sanitize_text_field( $_POST['woofreendor_tenant_name'] ),
                'tenant_opp'                    => absint( $_POST['woofreendor_tenant_opp'] ),
                'address'                      => isset( $_POST['dokan_address'] ) ? $_POST['dokan_address'] : $prev_woofreendor_settings['address'],
                'location'                     => sanitize_text_field( $_POST['location'] ),
                'find_address'                 => sanitize_text_field( $_POST['find_address'] ),
                'banner'                       => isset( $_POST['dokan_banner'] ) ? absint( $_POST['dokan_banner'] ) : null,
                'phone'                        => sanitize_text_field( $_POST['setting_phone'] ),
                'show_email'                   => sanitize_text_field( $_POST['setting_show_email'] ),
                'show_more_ptab'               => sanitize_text_field( $_POST['setting_show_more_ptab'] ),
                'gravatar'                     => absint( $_POST['dokan_gravatar'] )
            );

        }

        $woofreendor_settings = array_merge( $prev_woofreendor_settings,$woofreendor_settings );

        $profile_completeness = $this->calculate_profile_completeness_value( $woofreendor_settings );
        $woofreendor_settings['profile_completion'] = $profile_completeness;

        update_user_meta( $tenant_id, 'woofreendor_profile_settings', $woofreendor_settings );
        update_user_meta( $tenant_id, 'woofreendor_tenant_name', $woofreendor_settings['tenant_name'] );

        // do_action( 'dokan_store_profile_saved', $tenant_id, $woofreendor_settings );

        if ( ! defined( 'DOING_AJAX' ) ) {
            $_GET['message'] = 'profile_saved';
        }
    }
    
    /**
     * Calculate Profile Completeness meta value
     *
     * @since 2.1
     *
     * @param  array  $woofreendor_settings
     *
     * @return array
     */
    function calculate_profile_completeness_value( $woofreendor_settings ) {

        $profile_val = 0;
        $next_add    = '';
        $track_val   = array();

        $progress_values = array(
            'banner_val'          => 15,
            'profile_picture_val' => 15,
            'tenant_name_val'      => 10,
            'social_val'          => array(
                'fb'       => 2,
                'gplus'    => 2,
                'twitter'  => 2,
                'youtube'  => 2,
                'linkedin' => 2,
            ),
            'phone_val'           => 10,
            'address_val'         => 10,
            'map_val'             => 15,
        );

        // setting values for completion
        $progress_values = apply_filters('dokan_profile_completion_values', $progress_values);

        extract( $progress_values );

        //settings wise completeness section
        if ( isset( $profile_picture_val ) && isset( $woofreendor_settings['gravatar'] ) ):
            if ( $woofreendor_settings['gravatar'] != 0 ) {
                $profile_val           = $profile_val + $profile_picture_val;
                $track_val['gravatar'] = $profile_picture_val;
            } else {
                if ( strlen( $next_add ) == 0 ) {
                    $next_add = sprintf(__( 'Add Profile Picture to gain %s%% progress', 'woofreendor' ), $profile_picture_val);
                }
            }
        endif;

        // Calculate Social profiles
        if ( isset( $social_val ) && isset( $woofreendor_settings['social'] ) ):

            foreach ( $woofreendor_settings['social'] as $key => $value ) {

                if ( isset( $social_val[$key] ) && $value != false ) {
                    $profile_val     = $profile_val + $social_val[$key];
                    $track_val[$key] = $social_val[$key];
                }

                if ( isset( $social_val[$key] ) && $value == false ) {

                    if ( strlen( $next_add ) == 0 ) {
                        //replace keys to nice name
                        $nice_name = ( $key === 'fb' ) ? __( 'Facebook', 'woofreendor' ) : ( ( $key === 'gplus' ) ? __( 'Google+', 'woofreendor' ) : $key);
                        $next_add = sprintf( __( 'Add %s profile link to gain %s%% progress', 'woofreendor' ), $nice_name, $social_val[$key] );
                    }
                }
            }
        endif;

        //calculate completeness for phone
        if ( isset( $phone_val ) && isset( $woofreendor_settings['phone'] ) ):

            if ( strlen( trim( $woofreendor_settings['phone'] ) ) != 0 ) {
                $profile_val        = $profile_val + $phone_val;
                $track_val['phone'] = $phone_val;
            } else {
                if ( strlen( $next_add ) == 0 ) {
                    $next_add = sprintf( __( 'Add Phone to gain %s%% progress', 'woofreendor' ), $phone_val );
                }
            }

        endif;

        //calculate completeness for banner
        if ( isset( $banner_val ) && isset( $woofreendor_settings['banner'] ) ):

            if ( $woofreendor_settings['banner'] != 0 ) {
                $profile_val         = $profile_val + $banner_val;
                $track_val['banner'] = $banner_val;
            } else {
                $next_add = sprintf(__( 'Add Banner to gain %s%% progress', 'woofreendor' ), $banner_val);
            }

        endif;

        //calculate completeness for store name
        if ( isset( $store_name_val ) && isset( $woofreendor_settings['tenant_name'] ) ):
            if ( isset( $woofreendor_settings['tenant_name'] ) ) {
                $profile_val             = $profile_val + $store_name_val;
                $track_val['tenant_name'] = $store_name_val;
            } else {
                if ( strlen( $next_add ) == 0 ) {
                    $next_add = sprintf( __( 'Add Tenant Name to gain %s%% progress', 'woofreendor' ), $store_name_val );
                }
            }
        endif;

        //calculate completeness for address
        if ( isset( $address_val ) && isset( $woofreendor_settings['address'] ) ):
            if ( !empty($woofreendor_settings['address']['street_1']) ) {
                $profile_val          = $profile_val + $address_val;
                $track_val['address'] = $address_val;
            } else {
                if ( strlen( $next_add ) == 0 ) {
                    $next_add = sprintf(__( 'Add address to gain %s%% progress', 'woofreendor' ),$address_val);
                }
            }
        endif;

        // set message if no payment method found
        if ( strlen( $next_add ) == 0 && $payment_method_val !=0 ) {
            $next_add = sprintf( __( 'Add a Payment method to gain %s%% progress', 'woofreendor' ), $payment_method_val );
        }

        if ( isset( $woofreendor_settings['location'] ) && strlen(trim($woofreendor_settings['location'])) != 0 ) {
            $profile_val           = $profile_val + $map_val;
            $track_val['location'] = $map_val;
        } else {
            if ( strlen( $next_add ) == 0 ) {
                $next_add = sprintf( __( 'Add Map location to gain %s%% progress', 'woofreendor' ), $map_val );
            }
        }

        $track_val['next_todo']     = $next_add;
        $track_val['progress']      = $profile_val;
        $track_val['progress_vals'] = $progress_values;
        
        return apply_filters( 'dokan_profile_completion_progress_value', $track_val ) ;
    }

    /**
     * Load Settings Header
     *
     * @since 2.4
     *
     * @param  string $header
     * @param  array $query_vars
     *
     * @return string
     */
    public function load_settings_header( $header, $query_vars ) {
        if ( $query_vars == 'tenant' ) {
            $header = __( 'Tenant Profiles', 'woofreendor' );
        }

        return $header;
    }

    /**
     * Load Settings Progressbar
     *
     * @since 2.4
     *
     * @param  $array $query_vars
     *
     * @return void
     */
    // public function render_pro_settings_load_progressbar() {
    //     global $wp;

    //     if ( isset( $wp->query_vars['settings'] ) && $wp->query_vars['settings'] == 'store' ) {
    //         echo dokan_get_profile_progressbar();
    //     }

    //     if ( isset( $wp->query_vars['settings'] ) && $wp->query_vars['settings'] == 'payment' ) {
    //         echo dokan_get_profile_progressbar();
    //     }

    //     if ( isset( $wp->query_vars['settings'] ) && $wp->query_vars['settings'] == 'social' ) {
    //         echo dokan_get_profile_progressbar();
    //     }

    // }

    /**
     * Add progressbar in settings save feedback message
     *
     * @since 2.4
     *
     * @param array $message
     *
     * @return array
     */
    // public function add_progressbar_in_settings_save_response( $message ) {
    //     $progress_bar = dokan_get_profile_progressbar();
    //     $message['progress'] = $progress_bar;

    //     return $message;
    // }

    /**
     * Load Settings page helper
     *
     * @since 2.4
     *
     * @param  string $help_text
     * @param  array $query_vars
     *
     * @return string
     */
    public function load_settings_helper_text( $help_text, $query_vars ) {

        if ( $query_vars == 'social' ) {
            $help_text = __( 'Social profiles help you to gain more trust. Consider adding your social profile links for better user interaction.', 'woofreendor' );
        }

        if ( $query_vars == 'shipping' ) {

            $help_text = sprintf ( '<p>%s</p><p>%s</p>',
                __( 'This page contains your store-wide shipping settings, costs, shipping and refund policy.', 'woofreendor' ),
                __( 'You can enable/disable shipping for your products. Also you can override these shipping costs while creating or editing a product.', 'woofreendor' )
            );
        }

        return $help_text;
    }

    /**
     * Render Shipping status message
     *
     * @since 2.4
     *
     * @return void
     */
    public function render_shipping_status_message() {
        if ( isset( $_GET['message'] ) && $_GET['message'] == 'shipping_saved' ) {
            dokan_get_template_part( 'global/dokan-message', '', array(
                'message' => __( 'Shipping options saved successfully', 'woofreendor' )
            ) );
        }
    }

    /**
     * Render discount options
     *
     * @since 2.6
     *
     * @return void
     **/
    // public function add_discount_option( $current_tenant, $tenant_profile ) {
    //     $is_enable_op_discount = dokan_get_option( 'discount_edit', 'dokan_selling' );
    //     $is_enable_op_discount = $is_enable_op_discount ? $is_enable_op_discount : array();
    //     $is_enable_order_discount = isset( $tenant_profile['show_min_order_discount'] ) ? $tenant_profile['show_min_order_discount'] : 'no';
    //     $setting_minimum_order_amount = isset( $tenant_profile['setting_minimum_order_amount'] ) ? $tenant_profile['setting_minimum_order_amount'] : '';
    //     $setting_order_percentage = isset( $tenant_profile['setting_order_percentage'] ) ? $tenant_profile['setting_order_percentage'] : '';

    //     dokan_get_template_part( 'settings/discount', '', array(
    //         'pro'                          => true,
    //         'is_enable_op_discount'        => $is_enable_op_discount,
    //         'is_enable_order_discount'     => $is_enable_order_discount,
    //         'setting_minimum_order_amount' => $setting_minimum_order_amount,
    //         'setting_order_percentage'     => $setting_order_percentage
    //     ) );
    // }

}