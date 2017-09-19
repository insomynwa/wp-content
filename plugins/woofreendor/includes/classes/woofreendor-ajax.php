<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Ajax{

	public function __construct( ) {
		
	}
    public static function init() {

        static $instance = false;

        if ( !$instance ) {
            $instance = new self;
        }

        return $instance;
    }

    function init_ajax(){
        $settings = Woofreendor_Template_Settings::init();
        add_action( 'wp_ajax_woofreendor_settings', array( $settings, 'tenant_setting_ajax' ) );

        add_action( 'wp_ajax_woofreendor_tenant_listing_search', array($this, 'tenant_listing_search') );
        add_action( 'wp_ajax_nopriv_woofreendor_tenant_listing_search', array($this, 'tenant_listing_search') );

        add_action( 'wp_ajax_woofreendor_create_new_batch', array( $this, 'create_batch' ) );
        add_action( 'wp_ajax_woofreendor_update_batch', array( $this, 'update_batch' ) );
        add_action( 'wp_ajax_woofreendor_reload_batch', array( $this, 'reload_batch' ) );
        add_action( 'wp_ajax_woofreendor_delete_batch', array( $this, 'delete_batch' ) );

        add_action( 'wp_ajax_woofreendor_create_new_outlet', array( $this, 'create_outlet' ) );
        add_action( 'wp_ajax_woofreendor_update_outlet', array( $this, 'update_outlet' ) );
        add_action( 'wp_ajax_woofreendor_delete_outlet', array( $this, 'delete_outlet' ) );

        add_action( 'wp_ajax_woofreendor_get_product_data', array( $this, 'product_data' ) );
    }

    public function create_batch() { 
        check_ajax_referer( 'add-batch', 'security' );

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        $product_id = intval( $_POST['product'] );

        $response = woofreendor_save_batch( $product_id );
        if ( is_wp_error( $response ) ) {
            wp_send_json_error( $response );
        }

        if ( is_int( $response ) ) {
            wp_send_json_success( $response );
        } else {
            wp_send_json_error( __( 'Something wrong, please try again later', 'woofreendor' ) );
        }
    }

    public function update_batch() { 
        check_ajax_referer( 'update-batch', 'security' );

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        parse_str( $_POST['postdata'], $postdata );

        $response = woofreendor_update_batch( $postdata );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( $response );
        }

        if ( is_int( $response ) ) {
            wp_send_json_success( $response );
        } else {
            wp_send_json_error( __( 'Something wrong, please try again later', 'woofreendor' ) );
        }
    }

    public function delete_batch() { 
        check_ajax_referer( 'delete-batch', 'security' );

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        parse_str( $_POST['postdata'], $postdata );

        $response = woofreendor_delete_batch( $postdata );
        
        if ( is_wp_error( $response ) ) {
            wp_send_json_error( $response );
        }

        if ( $response ) {
            wp_send_json_success( $response );
        } else {
            wp_send_json_error( __( 'Something wrong, please try again later', 'woofreendor' ) );
        }
    }

    public function reload_batch() {
        check_ajax_referer( 'reload-batch', 'security' );

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        $product_id = intval( $_GET['product'] );

        $response = woofreendor_render_batch_row($product_id);
        //var_dump($response);
        wp_send_json_success( $response );
    }

    public function create_outlet() { 
        check_ajax_referer( 'add-outlet', 'security' );

        if ( ! current_user_can( 'woofreendor_tenant' ) ) {
            die(-1);
        }

        parse_str( $_POST['postdata'], $postdata );

        $response = woofreendor_save_outlet_ajax( $postdata );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( $response );
        }

        if ( is_int( $response ) ) {
            wp_send_json_success( $response );
        } else {
            wp_send_json_error( __( 'Something wrong, please try again later', 'woofreendor' ) );
        }
    }

    public function update_outlet() { 
        check_ajax_referer( 'update-outlet', 'security' );

        if ( ! current_user_can( 'woofreendor_tenant' ) ) {
            die(-1);
        }

        parse_str( $_POST['postdata'], $postdata );

        $response = woofreendor_update_outlet_ajax( $postdata );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( $response );
        }

        if ( is_int( $response ) ) {
            wp_send_json_success( $response );
        } else {
            wp_send_json_error( __( 'Something wrong, please try again later', 'woofreendor' ) );
        }
    }

    public function delete_outlet() { 
        check_ajax_referer( 'delete-outlet', 'security' );

        if ( ! current_user_can( 'woofreendor_tenant' ) ) {
            die(-1);
        }

        parse_str( $_POST['postdata'], $postdata );

        $response = woofreendor_delete_outlet_ajax( $postdata );
        
        if ( is_wp_error( $response ) ) {
            wp_send_json_error( $response );
        }

        if ( $response ) {
            wp_send_json_success( $response );
        } else {
            wp_send_json_error( __( 'Something wrong, please try again later', 'woofreendor' ) );
        }
    }
    
    /**
     * Search seller listing
     *
     * @return void
     */
    public function tenant_listing_search() {
        if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'woofreendor-tenant-listing-search' ) ) {
            wp_send_json_error( __( 'Error: Nonce verification failed', 'woofreendor' ) );
        }

        $paged  = 1;
        $limit  = 10;
        $offset = ( $paged - 1 ) * $limit;

        $tenant_args = array(
            'number' => $limit,
            'offset' => $offset
        );

        $search_term = isset( $_REQUEST['search_term'] ) ? sanitize_text_field( $_REQUEST['search_term'] ) : '';
        $pagination_base = isset( $_REQUEST['pagination_base'] ) ? sanitize_text_field( $_REQUEST['pagination_base'] ) : '';
        $per_row = isset( $_REQUEST['per_row'] ) ? sanitize_text_field( $_REQUEST['per_row'] ) : '3';

        if ( '' != $search_term ) {

            $tenant_args['meta_query'] = array(

                array(
                    'key'     => 'woofreendor_tenant_name',
                    'value'   => $search_term,
                    'compare' => 'LIKE'
                )

            );
        }

        $tenants = woofreendor_get_tenants( $tenant_args );

        $template_args = apply_filters( 'dokan_store_list_args', array(
            'tenants'         => $tenants,
            'limit'           => $limit,
            'paged'           => $paged,
            'image_size'      => 'medium',
            'search'          => 'yes',
            'pagination_base' => $pagination_base,
            'per_row'         => $per_row,
            'search_query'    => $search_term,
        ) );

        ob_start();
        woofreendor_get_template_part( 'tenant-lists-loop', false, $template_args );
        $content = ob_get_clean();

        wp_send_json_success( $content );
    }
    
    public function product_data() {
        check_ajax_referer( 'data-product', 'security' );

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        $product_id = intval( $_GET['product'] );

        $response = woofreendor_get_product_data($product_id);
        //var_dump($response);
        wp_send_json_success( $response );
    }

}