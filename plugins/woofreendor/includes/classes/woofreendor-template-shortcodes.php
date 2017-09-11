<?php

/**
 * Tempalte shortcode class file
 *
 * @load all shortcode for template  rendering
 */
class Woofreendor_Template_Shortcodes {

    /**
     *  Dokan template shortcodes __constract
     *  Initial loaded when class create an instanace
     *
     *  @since 2.4
     */
    function __construct() {
        add_shortcode( 'woofreendor-tenants', array( $this, 'tenant_listing' ));  
        add_shortcode( 'woofreendor-tenant-dashboard', array( $this, 'load_template_files' ) );      
    }

    /**
     * Singleton method
     *
     * @return self
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor_Template_Shortcodes();
        }

        return $instance;
    }

    public function tenant_listing() {
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

    public function load_template_files() {
        global $wp;
        
        if ( ! function_exists( 'WC' ) ) {
            return sprintf( __( 'Please install <a href="%s"><strong>WooCommerce</strong></a> plugin first', 'dokan-lite' ), 'http://wordpress.org/plugins/woocommerce/' );
        }
        
        ob_start();

        if ( isset( $wp->query_vars['outlets'] ) ) {
            woofreendor_get_template_part( 'outlets/outlets' );
            return ob_get_clean();
        }

        if ( isset( $wp->query_vars['new-outlet'] ) ) {
            do_action( 'woofreendor_render_new_outlet_template', $wp->query_vars );
            return ob_get_clean();
        }

        // if ( isset( $wp->query_vars['orders'] ) ) {
        //     dokan_get_template_part( 'orders/orders' );
        //     return ob_get_clean();
        // }

        // if ( isset( $wp->query_vars['withdraw'] ) ) {
        //     dokan_get_template_part( 'withdraw/withdraw' );
        //     return ob_get_clean();
        // }

        // if ( isset( $wp->query_vars['settings'] ) ) {
        //     dokan_get_template_part('settings/store');
        //     return ob_get_clean();
        // }

        if ( isset( $wp->query_vars['page'] ) ) {
            woofreendor_get_template_part( 'dashboard/dashboard' );
            return ob_get_clean();
        }
        // if ( isset( $wp->query_vars['edit-account'] ) ) {
        //     dokan_get_template_part( 'dashboard/edit-account' );
        //     return ob_get_clean();
        // }
        
        do_action( 'dokan_load_custom_template', $wp->query_vars );
  
    }
}
