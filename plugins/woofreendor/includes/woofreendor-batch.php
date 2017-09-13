<?php
// if ( !defined( 'ABSPATH' ) ) {
// 	exit;
// }
// class Woofreendor_Batch {

// 	public function __construct(){
// 	}

// 	public static function SaveBatch($paramPostData){

// 		$post_id = $paramPostData;

// 		$variation = array(
//             'post_title'   => 'Product #' . $post_id . ' Variation',
//             'post_content' => '',
//             'post_status'  => 'publish',
//             'post_author'  => get_current_user_id(),
//             'post_parent'  => $post_id,
//             'post_type'    => 'product_variation',
//             'menu_order'   => -1
//         );

//     	$variation_id = wp_insert_post( $variation);
//     	if($variation_id){
//     		update_post_meta( $variation_id, '_manage_stock', 'yes');
//     		return $variation_id;
//     	}

//     	return false;
// 	}

//     public static function UpdateBatch($paramPostData){

//         $post_batch_id = sanitize_text_field( $paramPostData['batch_id'] );
//         $post_start_date = sanitize_text_field( $paramPostData['batch_start'] );
//         $post_end_date = sanitize_text_field( $paramPostData['batch_end'] );
//         $post_stock = sanitize_text_field( $paramPostData['batch_stock'] );
//         $post_price = sanitize_text_field( $paramPostData['batch_price'] );

//         $isValidPost =
//             intval($post_batch_id) > 0                &&
//             $post_start_date != ""            &&
//             $post_end_date != ""              &&
//             $post_stock != ""                 &&
//             $post_price != ""
//         ;

//         if($isValidPost){

//             $available_attributes = array( 'Batch', 'Produksi','Kadaluarsa');
//             $variations = array(
//                 'Batch' => $post_batch_id,
//                 'Produksi'  => $post_start_date,
//                 'Kadaluarsa'    => $post_end_date,
//                 );

//             foreach($available_attributes as $attribute){
//                 $terms = get_term_by('slug', $variations[$attribute], $attribute);
//                 if(!$terms){
//                     wp_insert_term( $variations[$attribute], $attribute, array('slug'=>$variations[$attribute]));
//                 }
//                 update_post_meta($post_batch_id,'attribute_'.lcfirst($attribute), $variations[$attribute]);
                    
//             }
//             update_post_meta($post_batch_id,'_regular_price', $post_price);
//             update_post_meta($post_batch_id,'_stock', $post_stock);
//             return intval($post_batch_id);
//         }
//         return false;
//     }

//     public static function DeleteBatch($paramPostData){

//         $post_batch_id = sanitize_text_field( $paramPostData['batch_id'] );
//         $is_ValidPost = intval($post_batch_id) > 0;
//         if($is_ValidPost) {
//             $batch = wc_get_product( $post_batch_id );
//             $batch->delete( true );

//             return true;
//         }
//         return false;
//     }
// }