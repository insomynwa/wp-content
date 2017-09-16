<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Woofreendor_Admin{

	public function __construct( ) {
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'dokan_admin_menu', array($this, 'mod_admin_menu') ,10,2);
        add_action( 'admin_notices', array($this, 'debug_admin_menus') );
	}

	// public function woofreendor_admin_enqueue_scripts_and_styles(){
	// 	wp_enqueue_style( 'woofreendor-bootstrap-style', plugins_url() . '/woofreendor/assets/css/bootstrap.min.css');
	// 	wp_register_script( 'woofreendor-bootstrap-script', plugins_url() . '/woofreendor/assets/js/bootstrap.min.js',array('jquery') );
	// 	wp_enqueue_script('woofreendor-bootstrap-script');
 //        wp_enqueue_script( 'woofreendor-admin', plugins_url() . '/woofreendor/assets/js/woofreendor-admin.js', array( 'jquery' ) );
	// }

	function admin_menu(){
        $menu_position = apply_filters( 'woofreendor_menu_position', 16 );
        $capability    = apply_filters( 'woofreendor_menu_capability', 'manage_options' );

		$dashboard = add_menu_page( __( 'Woofreendor', 'woofreendor' ), __( 'Woofreendor', 'woofreendor' ), $capability, 'woofreendor', array( $this, 'dashboard'), 'data:image/svg+xml;base64,' . base64_encode( '<svg width="2048" height="1792" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M657 896q-162 5-265 128h-134q-82 0-138-40.5t-56-118.5q0-353 124-353 6 0 43.5 21t97.5 42.5 119 21.5q67 0 133-23-5 37-5 66 0 139 81 256zm1071 637q0 120-73 189.5t-194 69.5h-874q-121 0-194-69.5t-73-189.5q0-53 3.5-103.5t14-109 26.5-108.5 43-97.5 62-81 85.5-53.5 111.5-20q10 0 43 21.5t73 48 107 48 135 21.5 135-21.5 107-48 73-48 43-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-1024-1277q0 106-75 181t-181 75-181-75-75-181 75-181 181-75 181 75 75 181zm704 384q0 159-112.5 271.5t-271.5 112.5-271.5-112.5-112.5-271.5 112.5-271.5 271.5-112.5 271.5 112.5 112.5 271.5zm576 225q0 78-56 118.5t-138 40.5h-134q-103-123-265-128 81-117 81-256 0-29-5-66 66 23 133 23 59 0 119-21.5t97.5-42.5 43.5-21q124 0 124 353zm-128-609q0 106-75 181t-181 75-181-75-75-181 75-181 181-75 181 75 75 181z"/></svg>' ), $menu_position );

        add_submenu_page( 'woofreendor', __( 'Tenant Listing', 'woofreendor' ), __( 'All Tenants', 'woofreendor' ), $capability, 'woofreendor-tenants', array($this, 'tenant_listing_dashboard' ) );

        add_action( $dashboard, array($this, 'dashboard_script' ) );
        //add_action( $settings, array($this, 'dashboard_script' ) );
	}

	function mod_admin_menu( $paramCapability, $paramMenuPosition ){
		remove_submenu_page( 'dokan', 'dokan-pro-features' );
		remove_submenu_page( 'dokan', 'dokan-addons' );
	}

    function dashboard() {
        include dirname(__FILE__) . '/dashboard.php';
    }

	function tenant_listing_dashboard() {
        include 'html-woofreendor-tenant.php';
    }

    function dashboard_script(){
    	wp_enqueue_style( 'dokan-admin-dash', DOKAN_PLUGIN_ASSEST . '/css/admin.css' );

        wp_enqueue_style( 'dokan-admin-report', DOKAN_PLUGIN_ASSEST . '/css/admin.css' );
        wp_enqueue_style( 'jquery-ui' );
        wp_enqueue_style( 'dokan-chosen-style' );

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'dokan-flot' );
        wp_enqueue_script( 'dokan-chart' );
        wp_enqueue_script( 'dokan-chosen' );

        do_action( 'dokan_enqueue_admin_dashboard_script' );
    }
	
	function debug_admin_menus() {
		if ( !is_admin())
			return;

		$tenant = get_role('seller');
		var_dump($tenant->capabilities);
		/*global $submenu, $menu, $pagenow;

		//	var_dump(get_taxonomy('product_cat'));die;
		if ( current_user_can('manage_options') ) { // ONLY DO THIS FOR ADMIN
			if( $pagenow == 'index.php' ) {  // PRINTS ON DASHBOARD
				echo '<pre>'; print_r( $menu ); echo '</pre>'; // TOP LEVEL MENUS
				echo '<pre>'; print_r( $submenu ); echo '</pre>'; // SUBMENUS
			}
		}*/
	}

	/**
	 * Invoked by ajax action whenever user click the "Add Row" button
	 */
	// public function woofreendor_update_batch_ajax(){
	// 	$responses = array('status'=>false, 'message'=>"I hope you don't see this message. Error: function UpdateBatch(). Happy var_dump()!!!",'data' => array());
	// 	$post_product_id = sanitize_text_field( $_POST['product'] );
	// 	$post_batch_id = sanitize_text_field( $_POST['batch'] );
	// 	$post_start_date = sanitize_text_field( $_POST['start_date'] );
	// 	$post_end_date = sanitize_text_field( $_POST['end_date'] );
	// 	$post_stock = sanitize_text_field( $_POST['stock'] );
	// 	$post_price = sanitize_text_field( $_POST['price'] );
	// 	$post_product_title = sanitize_text_field( $_POST['product_title'] );

	// 	$isValidPost =
	// 		$post_product_id > 0              &&
	// 		$post_batch_id > 0                &&
	// 		$post_start_date != ""            &&
	// 		$post_end_date != ""              &&
	// 		$post_stock != ""                 &&
	// 		$post_price != ""
	// 		;

	// 	if($isValidPost){

	// 		$available_attributes = array( 'Batch', 'Produksi','Kadaluarsa');
	// 		$variations = array(
	// 			'Batch'	=> $post_batch_id,
	// 			'Produksi'	=> $post_start_date,
	// 			'Kadaluarsa'	=> $post_end_date,
	// 			);

	// 		foreach($available_attributes as $attribute){
				
	// 				check if term exists
	// 				get_term_by( $field, $value, $taxonomy, $output, $filter )
				  
	// 			// $terms = get_term_by('slug', $post_product_id.'-'.$variations[$attribute], 'pa_'.$attribute);
	// 			$terms = get_term_by('slug', $variations[$attribute], $attribute);
	// 			if(!$terms){
	// 				/*
	// 					create term if not exists
	// 					wp_insert_term( $term, $taxonomy, $args = array() )
	// 				 */
	// 				wp_insert_term( $variations[$attribute], $attribute, array('slug'=>$variations[$attribute]));
	// 			}
	// 			/*
	// 				update post meta using term slug
	// 				update_post_meta( $post_id, $meta_key, $meta_value, $prev_value )
	// 			 */
	// 			update_post_meta($post_batch_id,'attribute_'.lcfirst($attribute), $variations[$attribute]);
					
	// 		}
	//     	update_post_meta($post_batch_id,'_regular_price', $post_price);
	//     	update_post_meta($post_batch_id,'_stock', $post_stock);

	//     	$responses['status'] = true;
 //    		$responses['message'] = "SUCCESS update batch";
 //    		$responses['data'] = 
 //    			array(
 //    				'batch'=> array(
 //    					'id' => $post_batch_id
 //    					),
 //    				'product'=> array(
 //    					'id' => $post_product_id
 //    					)
 //    			);
	// 	}

 //    	echo wp_json_encode( $responses );
	// 	wp_die();
	// }

	/**
	 * Invoked after "saved/updated product" saved in database
	 * @param var $post_id product id
	 */
	// public function woofreendor_save_update_product($post_id){
	// 	//var_dump(get_post_type($post_id));die;
	// 	if( get_post_type($post_id) == "product")
	// 		wp_set_object_terms($post_id, 'variable', 'product_type');

	// 	$args = array(
	// 		'post_type' => 'product_variation',
	// 		'post_parent' => $post_id,
	// 		'orderby' => 'ID',
	// 		'order' => 'ASC'
	// 	);
	// 	$batches = get_posts($args);
	// 	if(count($batches)==0){
	// 		return;
	// 	}

	// 	$attributes_name = array('Batch','Produksi','Kadaluarsa');

	// 	$variations_value = array();
	// 	$batchid_str = "";
	// 	$startdate_str = "";
	// 	$enddate_str = "";
	// 	$batch_count = count($batches);
	// 	$batch_index = 0;
	// 	foreach($batches as $batch){
	// 		$meta_batchid = get_post_meta( $batch->ID, 'attribute_batch', true );
	// 		$meta_startdate = get_post_meta( $batch->ID, 'attribute_produksi', true );
	// 		$meta_enddate = get_post_meta( $batch->ID, 'attribute_kadaluarsa', true );
	// 		$batchid_str .= $meta_batchid;
	// 		$startdate_str .= $meta_startdate;
	// 		$enddate_str .= $meta_enddate;
	// 		if($batch_index < $batch_count-1){
	// 			$batchid_str .= " | ";
	// 			$startdate_str .= " | ";
	// 			$enddate_str .= " | ";
	// 		}
	// 		$batch_index++;
			
	// 	}
	// 	$variations_value['Batch'] = $batchid_str;
	// 	$variations_value['Produksi'] = $startdate_str;
	// 	$variations_value['Kadaluarsa'] = $enddate_str;

 //    	$product_attributes_data = array();
 //    	$index_pos = 0;
	// 	foreach($attributes_name as $attribute){//batchid, startdate, enddate
 //    		$product_attributes_data[/*'pa_'.*/$attribute] = array(
 //    			'name'		=> /*'pa_'.*/$attribute,
 //    			'value'		=> $variations_value[$attribute],
 //    			'position'	=> $index_pos,
 //    			'is_visible'=> '0',
 //    			'is_variation'=>'1',
 //    			'is_taxonomy'=>'0'
 //    		);
	// 		wp_set_object_terms($post_id,$variations_value[$attribute],/*'pa_'.*/$attribute);
	// 		$index_pos++;
 //    	}

 //    	update_post_meta($post_id,'_product_attributes', $product_attributes_data);
 //    	update_post_meta($post_id,'_manage_stock', 'no');
 //    	update_post_meta($post_id,'_backorders', 'no');
 //    	update_post_meta($post_id,'_sold_individually', 'no');
 //    	update_post_meta($post_id,'_weight', '');
 //    	update_post_meta($post_id,'_length', '');
 //    	update_post_meta($post_id,'_width', '');
 //    	update_post_meta($post_id,'_height', '');
 //    	update_post_meta($post_id,'_upsell_ids', array());
 //    	update_post_meta($post_id,'_crosssell_ids', array());
 //    	update_post_meta($post_id,'_purchase_note', '');
 //    	update_post_meta($post_id,'_default_attributes', array());
 //    	update_post_meta($post_id,'_virtual', 'no');
 //    	update_post_meta($post_id,'_downloadable', 'no');
 //    	update_post_meta($post_id,'_product_image_gallery', '');
 //    	update_post_meta($post_id,'_download_limit', -1);
 //    	update_post_meta($post_id,'_download_expiry', -1);
 //    	update_post_meta($post_id,'_stock', '');
 //    	update_post_meta($post_id,'_stock_status', 'instock');
 //    	update_post_meta($post_id,'_price', '');
 //    	update_post_meta($post_id,'_regular_price', '');
 //    	update_post_meta($post_id,'_tax_status', 'taxable');
 //    	update_post_meta($post_id,'_sku', '');
 //    	update_post_meta($post_id,'_regular_price','');
 //    	update_post_meta($post_id,'total_sales',0);
 //    	update_post_meta($post_id,'_sale_price','');
 //    	update_post_meta($post_id,'_sale_price_dates_from','');
 //    	update_post_meta($post_id,'_sale_price_dates_to','');
 //    	update_post_meta($post_id,'_tax_class','');
	// }

	// public function woofreendor_delete_batch_ajax(){

	// 	$responses = array('status'=>false, 'message'=>"I hope you don't see this message. Error: function UpdateBatch(). Happy var_dump()!!!",'data' => array());
	// 	$post_batch_id = sanitize_text_field( $_POST['batch'] );
	// 	$is_ValidPost = $post_batch_id > 0;
	// 	if($is_ValidPost) {
	// 		$batch = wc_get_product( $post_batch_id );
	// 		$batch->delete( true );

	//     	$responses['status'] = true;
 //    		$responses['message'] = "SUCCESS delete batch";
	// 	}

 //    	echo wp_json_encode( $responses );
	// 	wp_die();
	// }

	// public function woofreender_remove_customer_password_strength(){
	// 	if(wp_script_is('wc-password-strength-meter', 'enqueued')){
	// 		wp_dequeue_script('wc-password-strength-meter');
	// 	}
	// }

	// public function woofreender_outlet_custom_column($columns){
	// 	$screen = get_current_screen();
	// 	$new_columns = array();

	// 	if(in_array($screen->id,array('page','dbsnet-outlet'))){

	// 		$user = wp_get_current_user();
	// 		$user_role = get_userdata($user->ID);

	// 		if(current_user_can('manage_options') || current_user_can('woofreender_tenant')){
	// 			//var_dump($columns);
	// 			$new_columns['dbsnet_woocp_outlet_picture'] = __('Foto', 'dbsnet-woocp');
	// 			$new_columns['dbsnet_woocp_outlet_name'] = __('Outlet', 'dbsnet-woocp');
	// 			$new_columns['dbsnet_woocp_outlet_address'] = __('Alamat', 'dbsnet-woocp');
	// 		}
	// 	}
		
	// 	return $new_columns;
	// }

}
new Woofreendor_Admin();