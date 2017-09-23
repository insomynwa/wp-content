<?php

/**
 * Woofreendor rewrite rules class
 *
 * @package Woofreendor
 */
class Woofreendor_Rewrites {

    public $query_vars = array();
    public $custom_tenant_url = '';

    /**
     * Hook into the functions
     */
    public function __construct() {
        $this->custom_tenant_url = dokan_get_option( 'custom_tenant_url', 'woofreendor_general', 'tenant' );

        add_action( 'init', array( $this, 'register_rule' ) );
        
        remove_filter( 'template_include', array( Dokan_Rewrites::init(), 'store_template' ) );
        add_filter( 'template_include', array( $this, 'store_template' ) );

        add_filter( 'template_include', array( $this, 'tenant_template' ) );
        add_filter( 'template_include', array( $this,  'product_edit_template' ),999 );
        add_filter( 'template_include', array( $this,  'tenant_tenant_outlets_template' ) );

        add_filter( 'query_vars', array( $this, 'register_query_var' ) );
        add_filter( 'pre_get_posts', array( $this, 'tenant_query_filter' ) );
        
        remove_filter( 'woocommerce_get_breadcrumb', array( Dokan_Rewrites::init(), 'store_page_breadcrumb'), 10 ,1  );
        add_filter( 'woocommerce_get_breadcrumb', array( $this, 'store_page_breadcrumb'), 10 ,1  );
        add_filter( 'woocommerce_get_breadcrumb', array( $this, 'tenant_page_breadcrumb'), 10 ,1  );
    }


    /**
     * Initializes the Woofreendor_Rewrites() class
     *
     * @since 2.5.2
     *
     * Checks for an existing Woofreendor_Rewrites() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor_Rewrites();
        }

        return $instance;
    }
    
    /**
     * Include store template
     *
     * @param type  $template
     *
     * @return string
     */
    function store_template( $template ) {

        $store_name = get_query_var( Dokan_Rewrites::init()->custom_store_url );

        if ( ! $this->is_woo_installed() ) {
            return $template;
        }

        if ( !empty( $store_name ) ) {
            $store_user = get_user_by( 'slug', $store_name );

            // no user found
            if ( ! $store_user ) {
                return get_404_template();
            }

            // check if the user is seller
            if ( ! dokan_is_user_seller( $store_user->ID ) ) {
                return get_404_template();
            }

            return woofreendor_locate_template( 'store.php' );
        }

        return $template;
    }

    public function store_page_breadcrumb( $crumbs ){
        // var_dump(get_query_vars)
        if (  dokan_is_store_page() ) {
            $author      = get_query_var( Dokan_Rewrites::init()->custom_store_url );
            $outlet_info = get_user_by( 'slug', $author );
            $tenant_id = get_user_meta( $outlet_info->data->ID, 'tenant_id', true );
            $tenant_info = get_userdata( $tenant_id );
            // var_dump(dokan_get_store_url( $outlet_info->data->ID ));
            // $crumbs[1]   = array( ucwords($this->custom_tenant_url) , site_url().'/'.$this->custom_tenant_url );
            $crumbs[1]   = array( __( 'Tenants', 'woofreendor') , site_url().'/tenant-listing' );
            $crumbs[2]   = array( $tenant_info->display_name , woofreendor_get_tenant_url( $tenant_info->ID ) );
            // $crumbs[2]   = array( $author, woofreendor_get_tenant_url( $seller_info->data->ID ) );
            $crumbs[3]   = array( $outlet_info->data->display_name, dokan_get_store_url( $outlet_info->data->ID ) );
        }

        return $crumbs;
    }

    /**
     * Generate breadcrumb for tenant page
     *
     * @since 2.4.7
     *
     * @param array $crumbs
     *
     * @return array $crumbs
     */
    public function tenant_page_breadcrumb( $crumbs ){
        // var_dump(get_query_vars)
        if (  woofreendor_is_tenant_page() ) {
            $author      = get_query_var( $this->custom_tenant_url );
            $seller_info = get_user_by( 'slug', $author );
            // var_dump($seller_info->data);
            // $crumbs[1]   = array( ucwords($this->custom_tenant_url) , site_url().'/'.$this->custom_tenant_url );
            $crumbs[1]   = array( __( 'Tenants', 'woofreendor') , site_url().'/tenant-listing' );
            // $crumbs[2]   = array( $author, woofreendor_get_tenant_url( $seller_info->data->ID ) );
            $crumbs[2]   = array( $seller_info->data->display_name, woofreendor_get_tenant_url( $seller_info->data->ID ) );
        }

        return $crumbs;
    }

    /**
     * Check if WooCommerce installed or not
     *
     * @return boolean
     */
    public function is_woo_installed() {
        return function_exists( 'WC' );
    }

    /**
     * Register the rewrite rule
     *
     * @return void
     */
    
    function register_rule() {
        $this->query_vars = apply_filters( 'dokan_query_var_filter', array(
            'outlets',
            'new-outlet'
        ) );

        foreach ( $this->query_vars as $var ) {
            add_rewrite_endpoint( $var, EP_PAGES );
        }

        add_rewrite_rule( 
            $this->custom_tenant_url.'/([^/]+)/?$', 
            'index.php?'.$this->custom_tenant_url.'=$matches[1]', 
            'top' );
        add_rewrite_rule( 
            $this->custom_tenant_url.'/([^/]+)/page/?([0-9]{1,})/?$', 
            'index.php?'.$this->custom_tenant_url.'=$matches[1]&paged=$matches[2]', 
            'top' );
        add_rewrite_rule( 
            $this->custom_tenant_url.'/([^/]+)/section/?([0-9]{1,})/?$', 
            'index.php?'.$this->custom_tenant_url.'=$matches[1]&term=$matches[2]&term_section=true', 
            'top' );
        add_rewrite_rule( 
            $this->custom_tenant_url.'/([^/]+)/section/?([0-9]{1,})/page/?([0-9]{1,})/?$', 
            'index.php?'.$this->custom_tenant_url.'=$matches[1]&term=$matches[2]&paged=$matches[3]&term_section=true', 
            'top' );

        add_rewrite_rule( 
            $this->custom_tenant_url.'/([^/]+)/outlets?$', 
            'index.php?'.$this->custom_tenant_url.'=$matches[1]&outlets=true', 
            'top' );
        add_rewrite_rule( 
            $this->custom_tenant_url.'/([^/]+)/outlets/page/?([0-9]{1,})/?$', 
            'index.php?'.$this->custom_tenant_url.'=$matches[1]&paged=$matches[2]&outlets=true', 
            'top' );
    }

    /**
     * Register the query var
     *
     * @param array  $vars
     *
     * @return array
     */
    function register_query_var( $vars ) {
        $vars[] = $this->custom_tenant_url;

        foreach ( $this->query_vars as $var ) {
            $vars[] = $var;
        }
        return $vars;
    }

    /**
     * Include tenant template
     *
     * @param type  $template
     *
     * @return string
     */
    function tenant_template( $template ) {

        $tenant_name = get_query_var( $this->custom_tenant_url );

        if ( ! $this->is_woo_installed() ) {
            return $template;
        }

        if ( !empty( $tenant_name ) ) {
            $tenant_user = get_user_by( 'slug', $tenant_name );

            // no user found
            if ( ! $tenant_user ) {
                return get_404_template();
            }

            // check if the user is seller
            if ( ! woofreendor_is_user_tenant( $tenant_user->ID ) ) {
                return get_404_template();
            }

            return woofreendor_locate_template( 'tenant.php' );
        }
        return $template;
    }

    /**
     * Returns the edit product template
     *
     * @param string  $template
     *
     * @return string
     */
    function product_edit_template( $template ) {
        if ( ! $this->is_woo_installed() ) {
            return $template;
        }

        if ( ! ( get_query_var( 'edit' ) && is_singular( 'product' ) ) ) {
            return $template;
        }

        if(woofreendor_is_user_tenant(get_current_user_id())){
            $edit_product_url = woofreendor_locate_template( 'products/new-product-single.php' );
        }else{
            $edit_product_url = woofreendor_locate_template( 'products/new-product-outlet.php' );
        }
        

        return apply_filters( 'woofreendor_get_product_edit_template', $edit_product_url );
    }

    /**
     * Store query filter
     *
     * Handles the product filtering by category in tenant page
     *
     * @param object  $query
     *
     * @return void
     */
    function tenant_query_filter( $query ) {
        global $wp_query;

        $author = get_query_var( $this->custom_tenant_url );

        if ( !is_admin() && $query->is_main_query() && !empty( $author ) ) {
            $seller_info  = get_user_by( 'slug', $author );
            $tenant_info   = woofreendor_get_tenant_info( $seller_info->data->ID );
            $post_per_page = isset( $tenant_info['tenant_opp'] ) && !empty( $tenant_info['tenant_opp'] ) ? $tenant_info['tenant_opp'] : 12;
            set_query_var( 'posts_per_page', 2);//$post_per_page );
            $query->set( 'post_type', 'product' );
            $query->set( 'author_name', $author );
            $query->query['term_section'] = isset( $query->query['term_section'] ) ? $query->query['term_section'] : array();
            
            if ( $query->query['term_section'] ) {
                $query->set( 'tax_query',
                    array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $query->query['term']
                        )
                    )
                );
            }
        }
    }

    /**
     * Returns the tenant outlets template
     *
     * @since 2.3
     *
     * @param string $template
     *
     * @return string
     */
    function tenant_tenant_outlets_template( $template ) {
        
        if ( ! $this->is_woo_installed() ) {
            return $template;
        }
        if ( get_query_var( 'outlets' ) ) {
            return woofreendor_locate_template( 'tenant-outlets.php' );
        }

        return $template;

    }
}
