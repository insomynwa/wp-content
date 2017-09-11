<?php
// if ( !defined( 'ABSPATH' ) ) {
// 	exit;
// }
// class Woofreendor_Ajax{

// 	public function __construct( ) {
		
// 	}

// 	// public static function init() {

//  //        static $instance = false;

//  //        if ( !$instance ) {
//  //            $instance = new self;
//  //        }

//  //        return $instance;
//  //    }

//     // public function init_ajax() {
//     //     add_action( 'wp_ajax_woofreendor_create_new_batch', array( $this, 'create_batch' ) );
//     //     add_action( 'wp_ajax_woofreendor_reload_batch', array( $this, 'reload_batch' ) );
//     // }

//     public function create_batch() { 
//         check_ajax_referer( 'add-batch', 'security' );

//         if ( ! current_user_can( 'dokandar' ) ) {
//             die(-1);
//         }

//         $product_id = intval( $_POST['product'] );

//         $response = Woofreendor_Batch::SaveBatch( $product_id );
//         if ( is_wp_error( $response ) ) {
//             wp_send_json_error( $response );
//         }

//         if ( is_int( $response ) ) {
//             wp_send_json_success( $response );
//         } else {
//             wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
//         }
//     }

//     public function update_batch() { 
//         check_ajax_referer( 'update-batch', 'security' );

//         if ( ! current_user_can( 'dokandar' ) ) {
//             die(-1);
//         }

//         parse_str( $_POST['postdata'], $postdata );

//         $response = Woofreendor_Batch::UpdateBatch( $postdata );

//         if ( is_wp_error( $response ) ) {
//             wp_send_json_error( $response );
//         }

//         if ( is_int( $response ) ) {
//             wp_send_json_success( $response );
//         } else {
//             wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
//         }
//     }

//     public function delete_batch() { 
//         check_ajax_referer( 'delete-batch', 'security' );

//         if ( ! current_user_can( 'dokandar' ) ) {
//             die(-1);
//         }

//         parse_str( $_POST['postdata'], $postdata );

//         $response = Woofreendor_Batch::DeleteBatch( $postdata );
        
//         if ( is_wp_error( $response ) ) {
//             wp_send_json_error( $response );
//         }

//         if ( $response ) {
//             wp_send_json_success( $response );
//         } else {
//             wp_send_json_error( __( 'Something wrong, please try again later', 'dokan-lite' ) );
//         }
//     }

//     public function reload_batch() {
//         check_ajax_referer( 'reload-batch', 'security' );

//         if ( ! current_user_can( 'dokandar' ) ) {
//             die(-1);
//         }

//         $product_id = intval( $_GET['product'] );

//         $response = $this->_render_batch_row($product_id);
//         //var_dump($response);
//         wp_send_json_success( $response );
//     }

//     private function _render_batch_row($paramProductId){
//     	return Woofreendor_Template_Utility::GenerateHTML( plugin_dir_path( __DIR__ ) . 'templates/products/batches-row', $paramProductId);
//     }

// }