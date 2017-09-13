<?php
// if ( !defined( 'ABSPATH' ) ) {
// 	exit;
// }
// class Woofreendor_Customizer{

// 	public function __construct(){
// 	}

	// public function woofreendor_register_scripts(){
 //        wp_register_style( 'woofreendor-style', plugins_url( 'assets/css/style.css', __DIR__ ), false, null );
 //        if ( is_rtl() ) {
 //            wp_register_style( 'woofreendor-rtl-style', plugins_url( 'assets/css/rtl.css', __DIR__ ), false, null );
 //        }
	// 	wp_register_script( 'woofreendor-script', plugins_url( 'assets/js/woofreendor-script.js', __DIR__ ), array( 'imgareaselect', 'customize-base', 'customize-model'  ), null, true );

	// 	wp_enqueue_script('woofreendor-script');
	// }

	// public function woofreendor_scripts(){
	// 	if ( ! function_exists( 'WC' ) ) {
 //            return;
 //        }

 //        wp_enqueue_style( 'woofreendor-style' );
 //        if ( is_rtl() ) {
 //            wp_enqueue_style( 'woofreendor-rtl-style' );
 //        }

 //        $default_script = array(
 //                'ajaxurl'     => admin_url( 'admin-ajax.php' ),
 //                'nonce'       => wp_create_nonce( 'woofreendor_reviews' ),
 //                'ajax_loader' => plugins_url( 'assets/images/ajax-loader.gif', __FILE__ ),
 //                'seller'      => array(
 //                    'available'    => __( 'Available', 'dokan-lite' ),
 //                    'notAvailable' => __( 'Not Available', 'dokan-lite' )
 //                ),
 //                'delete_confirm' => __('Are you sure?', 'dokan-lite' ),
 //                'wrong_message'  => __('Something went wrong. Please try again.', 'dokan-lite' ),
 //        	);

 //        $localize_script = apply_filters( 'woofreendor_localized_args', $default_script );

 //        wp_localize_script( 'jquery', 'woofreendor', $localize_script );

 //        if ( ( dokan_is_seller_dashboard() || ( get_query_var( 'edit' ) && is_singular( 'product' ) ) ) || apply_filters( 'dokan_forced_load_scripts', false ) ) {
 //            $this->_dokan_dashboard_scripts();
 //        }

 //        if ( dokan_is_store_page() || dokan_is_store_review_page() || is_account_page() ) {

 //            wp_enqueue_script( 'woofreendor-script' );
 //        }
	// }

// 	private function _dokan_dashboard_scripts() {
// 		wp_enqueue_script( 'woofreendor-script' );
// 	}

// 	public function woofreendor_conditional_localized_args( $paramDefaultArgs ){
// 		if ( dokan_is_seller_dashboard()
//                 || ( get_query_var( 'edit' ) && is_singular( 'product' ) )
//                 || dokan_is_store_page()
//                 || is_account_page()
//                 || apply_filters( 'dokan_force_load_extra_args', false )
//             ) {

//             $custom_args             = array (
//                 'product_title_required'              => __( 'Nama produk harus diisi', 'dokan-lite' ),
//                 'product_category_required'           => __( 'Kategori produk harus dipilih', 'dokan-lite' ),
//                 'reload_batch_error'           => __( 'Terjadi kesalahan', 'dokan-lite' ),
//                 'reload_batch_nonce'              => wp_create_nonce( 'reload-batch' ),
//                 'update_batch_nonce'              => wp_create_nonce( 'update-batch' ),
//                 'delete_batch_nonce'              => wp_create_nonce( 'delete-batch' ),
//                 'add_batch_nonce'                 => wp_create_nonce( 'add-batch' )
//             );

//             $paramDefaultArgs = array_merge( $paramDefaultArgs, $custom_args );
//         }

//         return $paramDefaultArgs;
// 	}

// 	public function woofreendor_render_batches_row($paramProductId ){
// 		echo Woofreendor_Template_Utility::GenerateHTML( plugin_dir_path( __DIR__ ) . 'templates/products/batches-row', $paramProductId);
// 	}
// }
