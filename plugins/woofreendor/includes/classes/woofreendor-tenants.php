<?php

/**
 * Dokan Pro Report Class
 *
 * @since 2.4
 *
 * @package dokan
 *
 */
class Woofreendor_Tenants {

    public function __construct() {
        add_filter( 'dokan_get_dashboard_settings_nav', array( $this, 'load_settings_menu' ), 10 );
        // add_action( 'dokan_render_settings_content', array( $this, 'render_settings_content') );
        // add_action( 'dokan_load_custom_template', array( $this, 'load_tenant_template' ) );
    }

    
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Woofreendor_Tenants();
        }

        return $instance;
    }

    public function load_settings_menu( $sub_settings ) {

        if ( woofreendor_is_user_tenant( get_current_user_id() ) ) {

            $sub_settings['tenant'] = array(
                'title' => __( 'Tenant', 'woofreendor' ),
                'icon'  => '<i class="fa fa-share-alt-square"></i>',
                'url'   => woofreendor_get_navigation_url( 'settings/tenant' ),
                'pos'   => 30
                );
        }
        else{

        }

        return $sub_settings;
    }

    // public function render_settings_content( $query_var){
    //     if ( isset( $wp->query_vars['settings'] ) && $wp->query_vars['settings'] == 'tenant' ) {
    //         $this->load_tenant_content();
    //     }
    // }

    // /**
    //  * Load Dashboar "Setting Tenant" content
    //  *
    //  * @return void
    //  */
    // public function load_tenant_content() {
    //     $validate = $this->validate();
    //     $currentuser = get_current_user_id();
    //     $profile_info = woofreendor_get_tenant_info( get_current_user_id() );

    //     woofreendor_get_template_part( 'settings/tenant-form', '', array(
    //         'current_user' => $currentuser,
    //         'profile_info' => $profile_info,
    //         'validate'     => $validate,
    //     ) );

    // }

    // public function load_tenant_template( $query_vars ){
    //     // var_dump($query_vars);
    //     if ( woofreendor_is_user_tenant( get_current_user_id() ) && isset( $query_vars['settings'] ) ) {
    //         woofreendor_get_template_part( 'settings/tenant' );
    //         return;
    //     }
    // }
    
    /**
     * Validate settings submission
     *
     * @return void
     */
    function validate() {

        if ( !isset( $_POST['dokan_update_profile'] ) ) {
            return false;
        }

        if ( !wp_verify_nonce( $_POST['_wpnonce'], 'dokan_settings_nonce' ) ) {
            wp_die( __( 'Are you cheating?', 'dokan-lite' ) );
        }

        $error = new WP_Error();

        $dokan_name = sanitize_text_field( $_POST['dokan_store_name'] );

        if ( empty( $dokan_name ) ) {
            $error->add( 'dokan_name', __( 'Store name required', 'dokan-lite' ) );
        }

        if ( isset( $_POST['setting_category'] ) ) {

            if ( !is_array( $_POST['setting_category'] ) || !count( $_POST['setting_category'] ) ) {
                $error->add( 'dokan_type', __( 'Store type required', 'dokan-lite' ) );
            }
        }

        if ( !empty( $_POST['setting_paypal_email'] ) ) {
            $email = filter_var( $_POST['setting_paypal_email'], FILTER_VALIDATE_EMAIL );
            if ( empty( $email ) ) {
                $error->add( 'dokan_email', __( 'Invalid email', 'dokan-lite' ) );
            }
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
                $error->add( $code, sprintf( __('Address field for %s is required', 'dokan-lite'), $key ) );
            }
        }


        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;
    }

}
