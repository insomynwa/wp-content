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

        add_action( 'wp_ajax_woofreendor_create_new_batch', array( $this, 'create_batch' ) );
        add_action( 'wp_ajax_woofreendor_update_batch', array( $this, 'update_batch' ) );
        add_action( 'wp_ajax_woofreendor_reload_batch', array( $this, 'reload_batch' ) );
        add_action( 'wp_ajax_woofreendor_delete_batch', array( $this, 'delete_batch' ) );

        add_action( 'wp_ajax_woofreendor_create_new_outlet', array( $this, 'create_outlet' ) );
        add_action( 'wp_ajax_woofreendor_update_outlet', array( $this, 'update_outlet' ) );
        add_action( 'wp_ajax_woofreendor_delete_outlet', array( $this, 'delete_outlet' ) );
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
            wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
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
            wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
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
            wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
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
            wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
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
            wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
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
            wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
        }
    }

}