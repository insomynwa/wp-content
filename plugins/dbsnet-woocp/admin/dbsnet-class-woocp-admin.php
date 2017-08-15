<?php 

class DBSnet_Woocp_Admin{
	protected $version;

	public function __construct( $version ) {
		$this->version = $version;
	}

	public function enqueue_scripts_and_styles(){
		wp_register_script( 'dbsnet-woocp', plugin_dir_url( __FILE__ ) . 'js/dbsnet-woocp.js' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-progressbar' );
		wp_enqueue_script('dbsnet-woocp');

		wp_localize_script(
			'dbsnet-woocp', 
			'dbsnet_ajax', 
			array(
				'ajax_url' => admin_url('admin-ajax.php'), 'dbsnet_security' => 'd85n3t'
				)
		);
	}

	public function dbsnet_woocp_remove_woocommerce_product_data(){
		if(current_user_can( 'manage_options' )) return;
		remove_meta_box('woocommerce-product-data', 'product', 'normal');
	}

	public function dbsnet_woocp_add_batch_meta_box_product(){

		add_meta_box( 'dbsnet_woocp_batch_metabox', __('Batch Produk'), array($this,'dbsnet_woocp_batch_metabox'), 'product', 'normal', 'high');
	}

	public function dbsnet_woocp_batch_metabox($product){
		?>
		<input id="product-type" type="hidden" name="product-type" value="variable">
		<table id="tab_logic">
			<thead>
				<tr >
					<th class="text-center">#</th>
					<th class="text-center">Produksi</th>
					<th class="text-center">Kadaluarsa</th>
					<th class="text-center">Stok</th>
					<th class="text-center">Harga</th>
					<th class="text-center"></th>
					<th class="text-center"></th>
				</tr>
			</thead>
			<tbody>
		<?php
		$args = array(
			'post_type' => 'product_variation',
			'post_parent' => $product->ID,
			'orderby' => 'ID',
			'order' => 'ASC'
		);
		$batches = get_posts($args);
		$index = 0;
		foreach($batches as $batch){
			$meta_batch_startdate = get_post_meta( $batch->ID, 'attribute_produksi', true ); 
			$meta_batch_endate = get_post_meta( $batch->ID, 'attribute_kadaluarsa', true );
			$meta_batch_stock = get_post_meta( $batch->ID, '_stock', true );
			$meta_batch_price = get_post_meta( $batch->ID, '_regular_price', true );
	    ?>
	    <tr class="batch_row_table" id='addr<?php _e($index); ?>'>
			<td>
				<input type="hidden" name="batch_id[]" value="<?php _e($batch->ID); ?>"  />
				<?php _e($index+1); ?>
			</td>
			<td>
				<input id='start-date<?php _e($batch->ID); ?>' type="text" name='batch_start_date[]'  placeholder='Tanggal Produksi' class="custom-woocp-datepicker" value="<?php if(!empty($meta_batch_startdate)) _e($meta_batch_startdate); ?>"/>
			</td>
			<td>
				<input id='end-date<?php _e($batch->ID); ?>' type="text" name='batch_end_date[]' placeholder='Tanggal kadaluarsa' class="custom-woocp-datepicker" value="<?php if(!empty($meta_batch_endate)) _e($meta_batch_endate); ?>" />
			</td>
			<td>
				<input id='stock<?php _e($batch->ID); ?>' type="number" name='batch_stock[]' placeholder='Stok' class="form-control" value="<?php _e($meta_batch_stock); ?>"/>
			</td>
			<td>
				<input id='price<?php _e($batch->ID); ?>' type="text" name='batch_price[]' placeholder='Harga' class="form-control" value="<?php if(!empty($meta_batch_price)) _e($meta_batch_price); ?>"/>
			</td>
			<td>
				<button id='' data-product-id='<?php _e($product->ID); ?>' data-batch-id='<?php _e($batch->ID); ?>' class='update-batch-btn button-primary'>Update</button>
			</td>
			<td><a href='#' id='' data-batch-id="<?php _e($batch->ID); ?>" class="delete-batch-row btn btn-default"><span id="<?php _e($batch->ID); ?>"></span>Hapus</a></td>
		</tr>
	
		<?php
		$index++;
		} // END FOREACH
		?>
			<tr class="batch_row_table" id='addr<?php _e($index+1); ?>'></tr>
			</tbody>
		</table>
		<input id="product-title" type="hidden" name="product_batch_title" value="<?php _e($product->post_title); ?>"  />
		<div id="batch-add-progress"></div>					
		<a href="#" id="add_row" class="btn btn-primary pull-left" data-product-id="<?php _e($product->ID); ?>"><span id="<?php _e($index+1); ?>"></span>Tambah Batch</a>
		<?php
	}

	public function add_woocp_product_metabox(){
		$screen = 'product';
		add_meta_box( 'woocp_product_metabox_id', 
			'Product Batch', 
			 array($this,'woocp_product_metabox_html'),
			 $screen 
		);
	}

	public function woocp_product_metabox_html($product){
		?>
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<table class="table table-bordered table-hover" id="tab_logic">
						<thead>
							<tr >
								<th class="text-center">#</th>
								<th class="text-center">Production Date</th>
								<th class="text-center">Expired Date</th>
								<th class="text-center">Stock</th>
								<th class="text-center">Price</th>
								<th class="text-center"></th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody> 
		<?php

		$args = array(
			'post_type' => 'product_variation',
			'post_parent' => $product->ID,
			'orderby' => 'ID',
			'order' => 'ASC'
		);
		$batches = get_posts($args); //var_dump($batches);die;
		$index=0;
		foreach($batches as $batch){
			$meta_batch_startdate = get_post_meta( $batch->ID, 'attribute_produksi', true ); 
			$meta_batch_endate = get_post_meta( $batch->ID, 'attribute_kadaluarsa', true );
			$meta_batch_stock = get_post_meta( $batch->ID, '_stock', true );
			$meta_batch_price = get_post_meta( $batch->ID, '_regular_price', true );
	    ?>

		<tr class="batch_row_table" id='addr<?php _e($index); ?>'>
			<td>
				<input type="hidden" name="batch_id[]" value="<?php _e($batch->ID); ?>"  />
				<?php _e($index+1); ?>
			</td>
			<td>
				<input id='start-date<?php _e($batch->ID); ?>' type="text" name='batch_start_date[]'  placeholder='Start Date' class="custom-woocp-datepicker" value="<?php if(!empty($meta_batch_startdate)) _e($meta_batch_startdate); ?>"/>
			</td>
			<td>
				<input id='end-date<?php _e($batch->ID); ?>' type="text" name='batch_end_date[]' placeholder='End Date' class="custom-woocp-datepicker" value="<?php if(!empty($meta_batch_endate)) _e($meta_batch_endate); ?>" />
			</td>
			<td>
				<input id='stock<?php _e($batch->ID); ?>' type="number" name='batch_stock[]' placeholder='Stock' class="form-control" value="<?php _e($meta_batch_stock); ?>"/>
			</td>
			<td>
				<input id='price<?php _e($batch->ID); ?>' type="text" name='batch_price[]' placeholder='Price' class="form-control" value="<?php if(!empty($meta_batch_price)) _e($meta_batch_price); ?>"/>
			</td>
			<td>
				<button id='' data-product-id='<?php _e($product->ID); ?>' data-batch-id='<?php _e($batch->ID); ?>' class='update-batch-btn button-primary'>Update</button>
			</td>
			<td><a href='#' id='' data-batch-id="<?php _e($batch->ID); ?>" class="delete-batch-row btn btn-default"><span id="<?php _e($batch->ID); ?>"></span>Delete</a></td>
		</tr>
	
		<?php
		$index++;
		} // END FOREACH
		?>
					<tr class="batch_row_table" id='addr<?php _e($index+1); ?>'></tr>
					</tbody>
				</table>
				<input id="product-title" type="hidden" name="product_batch_title" value="<?php _e($product->post_title); ?>"  />
			</div>
		</div>
		<div id="batch-add-progress"></div>					
		<a href="#" id="add_row" class="btn btn-primary pull-left" data-product-id="<?php _e($product->ID); ?>"><span id="<?php _e($index+1); ?>"></span>Add Batch</a>
		</div>
		<?php

	}

	public function AddBatch(){

    	$responses = array('status'=>false, 'message'=>"I hope you don't see this message. Error: function AddBatch(). Happy var_dump()!!!",'data' => array());
		$post_product_id = sanitize_text_field( $_POST['product'] );
		$post_product_title = sanitize_text_field( $_POST['product_title'] );
		$post_index_batch = sanitize_text_field( $_POST['index_batch'] );
		$batch_args = array(
			'post_title'=> $product_title.' - Batch #'.$post_index_batch, 
			'post_name'	=> 'product-'.$post_product_id.'-variation-'. $post_index_batch, 
			'post_status' => 'publish',
			'post_type'=>'product_variation',
			'post_parent' => $post_product_id,
			'menu_order' => $post_index_batch,
			'guid' => home_url().'/?product_variation=product-'. $post_id. '-variation-' . $post_index_batch
		);

    	$get_the_batch_id = wp_insert_post( $batch_args);
    	if($get_the_batch_id){
    		update_post_meta( $get_the_batch_id, '_manage_stock', 'yes');
    		$responses['message'] = "SUCCESS add new batch";
    		$responses['status'] = true;
    		$responses['data'] = 
    			array(
    				'batch'=> array(
    					'id' => $get_the_batch_id
    					),
    				'product'=> array(
    					'id' => $post_product_id
    					)
    			);
    	}

    	echo wp_json_encode( $responses );
		wp_die();
	}

	/**
	 * Invoked by ajax action whenever user click the "Add Row" button
	 */
	public function UpdateBatch(){
		$responses = array('status'=>false, 'message'=>"I hope you don't see this message. Error: function UpdateBatch(). Happy var_dump()!!!",'data' => array());
		$post_product_id = sanitize_text_field( $_POST['product'] );
		$post_batch_id = sanitize_text_field( $_POST['batch'] );
		$post_start_date = sanitize_text_field( $_POST['start_date'] );
		$post_end_date = sanitize_text_field( $_POST['end_date'] );
		$post_stock = sanitize_text_field( $_POST['stock'] );
		$post_price = sanitize_text_field( $_POST['price'] );
		$post_product_title = sanitize_text_field( $_POST['product_title'] );

		$isValidPost =
			$post_product_id > 0              &&
			$post_batch_id > 0                &&
			$post_start_date != ""            &&
			$post_end_date != ""              &&
			$post_stock != ""                 &&
			$post_price != ""
		;

		if($isValidPost){

			$available_attributes = array( 'Batch', 'Produksi','Kadaluarsa');
			$variations = array(
				'Batch'	=> $post_batch_id,
				'Produksi'	=> $post_start_date,
				'Kadaluarsa'	=> $post_end_date,
				);

			foreach($available_attributes as $attribute){
				/*
					check if term exists
					get_term_by( $field, $value, $taxonomy, $output, $filter )
				 */ 
				// $terms = get_term_by('slug', $post_product_id.'-'.$variations[$attribute], 'pa_'.$attribute);
				$terms = get_term_by('slug', $variations[$attribute], $attribute);
				if(!$terms){
					/*
						create term if not exists
						wp_insert_term( $term, $taxonomy, $args = array() )
					 */
					wp_insert_term( $variations[$attribute], $attribute, array('slug'=>$variations[$attribute]));
				}
				/*
					update post meta using term slug
					update_post_meta( $post_id, $meta_key, $meta_value, $prev_value )
				 */
				update_post_meta($post_batch_id,'attribute_'.lcfirst($attribute), $variations[$attribute]);
					
			}
	    	update_post_meta($post_batch_id,'_regular_price', $post_price);
	    	update_post_meta($post_batch_id,'_stock', $post_stock);

	    	$responses['status'] = true;
    		$responses['message'] = "SUCCESS update batch";
    		$responses['data'] = 
    			array(
    				'batch'=> array(
    					'id' => $post_batch_id
    					),
    				'product'=> array(
    					'id' => $post_product_id
    					)
    			);
		}

    	echo wp_json_encode( $responses );
		wp_die();
	}

	/**
	 * Invoked after "saved/updated product" saved in database
	 * @param var $post_id product id
	 */
	public function save_update_product($post_id){
		//var_dump(get_post_type($post_id));die;
		if( get_post_type($post_id) == "product")
			wp_set_object_terms($post_id, 'variable', 'product_type');

		$args = array(
			'post_type' => 'product_variation',
			'post_parent' => $post_id,
			'orderby' => 'ID',
			'order' => 'ASC'
		);
		$batches = get_posts($args);
		if(count($batches)==0){
			return;
		}

		$attributes_name = array('Batch','Produksi','Kadaluarsa');

		$variations_value = array();
		$batchid_str = "";
		$startdate_str = "";
		$enddate_str = "";
		$batch_count = count($batches);
		$batch_index = 0;
		foreach($batches as $batch){
			$meta_batchid = get_post_meta( $batch->ID, 'attribute_batch', true );
			$meta_startdate = get_post_meta( $batch->ID, 'attribute_produksi', true );
			$meta_enddate = get_post_meta( $batch->ID, 'attribute_kadaluarsa', true );
			$batchid_str .= $meta_batchid;
			$startdate_str .= $meta_startdate;
			$enddate_str .= $meta_enddate;
			if($batch_index < $batch_count-1){
				$batchid_str .= " | ";
				$startdate_str .= " | ";
				$enddate_str .= " | ";
			}
			$batch_index++;
			
		}
		$variations_value['Batch'] = $batchid_str;
		$variations_value['Produksi'] = $startdate_str;
		$variations_value['Kadaluarsa'] = $enddate_str;

    	$product_attributes_data = array();
    	$index_pos = 0;
		foreach($attributes_name as $attribute){//batchid, startdate, enddate
    		$product_attributes_data[/*'pa_'.*/$attribute] = array(
    			'name'		=> /*'pa_'.*/$attribute,
    			'value'		=> $variations_value[$attribute],
    			'position'	=> $index_pos,
    			'is_visible'=> '0',
    			'is_variation'=>'1',
    			'is_taxonomy'=>'0'
    		);
			wp_set_object_terms($post_id,$variations_value[$attribute],/*'pa_'.*/$attribute);
			$index_pos++;
    	}

    	update_post_meta($post_id,'_product_attributes', $product_attributes_data);
    	update_post_meta($post_id,'_manage_stock', 'no');
    	update_post_meta($post_id,'backorders', 'no');
    	update_post_meta($post_id,'_sold_individually', 'no');
    	update_post_meta($post_id,'_weight', '');
    	update_post_meta($post_id,'_length', '');
    	update_post_meta($post_id,'_width', '');
    	update_post_meta($post_id,'_height', '');
    	update_post_meta($post_id,'_upsell_ids', array());
    	update_post_meta($post_id,'_crosssell_ids', array());
    	update_post_meta($post_id,'_purchase_note', '');
    	update_post_meta($post_id,'_default_attributes', array());
    	update_post_meta($post_id,'_virtual', 'no');
    	update_post_meta($post_id,'_downloadable', 'no');
    	update_post_meta($post_id,'_product_image_gallery', '');
    	update_post_meta($post_id,'_download_limit', -1);
    	update_post_meta($post_id,'_download_expiry', -1);
    	update_post_meta($post_id,'_stock', '');
    	update_post_meta($post_id,'_stock_status', 'instock');
    	update_post_meta($post_id,'_price', '');
    	update_post_meta($post_id,'_regular_price', '');
    	update_post_meta($post_id,'_tax_status', 'taxable');
    	update_post_meta($post_id,'_sku', '');
    	update_post_meta($post_id,'_regular_price','');
    	update_post_meta($post_id,'total_sales',0);
	}

	public function DeleteBatch(){

		$responses = array('status'=>false, 'message'=>"I hope you don't see this message. Error: function UpdateBatch(). Happy var_dump()!!!",'data' => array());
		$post_batch_id = sanitize_text_field( $_POST['batch'] );
		$is_ValidPost = $post_batch_id > 0;
		if($is_ValidPost) {
			$batch = wc_get_product( $post_batch_id );
			$batch->delete( true );

	    	$responses['status'] = true;
    		$responses['message'] = "SUCCESS delete batch";
		}

    	echo wp_json_encode( $responses );
		wp_die();
	}

	public function dbsnet_woocp_remove_permalink_under_title(){
		if(!current_user_can('manage_options')){

			$return = '';

			return $return;
		}
	}

	public function dbsnet_woocp_customize_first_toolbar(){
		// if(!current_user_can("manage_options")){
			$button[] = 'bold';
			$button[] = 'italic';
			return $button;
		// }
	}

	public function dbsnet_woocp_remove_add_media(){
		if(!current_user_can('manage_options')){
			remove_action('media_buttons', 'media_buttons');
		}
	}

	public function dbsnet_woocp_remove_text_tab(){
		if(!current_user_can('manage_options')){
			$settings['quicktags'] = false;
			return $settings;
		}
	}

	public function dbsnet_woocp_single_column_layout(){
		return 1;
	}

	public function dbsnet_woocp_metabox_order(){
		if(!current_user_can('manage_options')){
			return array(
				'normal' => join(
					",",
					array(
						'customdiv-product',
		                'postexcerpt',
		                'product_catdiv',
		                'postimagediv',
		                'woocommerce-product-images',
		                'woocp_product_metabox_id',
		                'dbsnet_woocp_batch_metabox',
		                'submitdiv',
		                'commentsdiv',
						)
					),
				);
		}
			// remove_meta_box('product_catdiv','product','normal');
			// remove_meta_box('postexcerpt','product','normal');
			// remove_meta_box('postimagediv','product','normal');
			// remove_meta_box('woocommerce-product-images','product','normal');
			// remove_meta_box('dbsnet_woocp_batch_metabox','product','normal');
			// remove_meta_box('submitdiv','product','normal');
			// remove_meta_box('commentsdiv','product','normal');

			// add_meta_box('product_catdiv',__('Kategori','woocommerce'),'','product','normal','high');
			// add_meta_box('postexcerpt',__('Deskripsi','woocommerce'),'','product','normal','high');
			// add_meta_box('postimagediv',__('Gambar Produk','woocommerce'),'','product','normal','high');
			// add_meta_box('woocommerce-product-images',__('Galeri Produk','woocommerce'),'','product','normal','high');
			// add_meta_box('dbsnet_woocp_batch_metabox',__('Batch Produk','woocommerce'),'','product','normal','high');
			// add_meta_box('submitdiv',__('Publish Produk','woocommerce'),'','product','normal','high');
			// add_meta_box('commentsdiv',__('Review Produk','woocommerce'),'','product','normal','high');
	}

	public function dbsnet_woocp_hide_publishing_actions(){
		// $my_post_type = 'product';
		// global $post;
		if(!current_user_can('manage_options')){
			$screen = get_current_screen();
			// if($post->post_type == $my_post_type){
			if(in_array($screen->id,array('post','product'))){
				echo '
					<style type="text/css">
						#misc-publishing,
	                    #minor-publishing,
						#duplicate-action,
						#delete-action{
	                        display:none;
	                    }
					</style>
				';
			}
		}
	}

	public function dbsnet_woocp_hide_export_import_actions(){
		// $my_post_type = 'product';
		// global $post;
		if(!current_user_can('manage_options')){
			$screen = get_current_screen();
			// if($post->post_type == $my_post_type){
			//if(in_array($screen->id,array('post','product'))){
				echo '
					<style type="text/css">
						
						#wpbody-content > div.wrap > h1 > a.page-title-action:not(:first-child){
	                        display:none;
	                    }
					</style>
				';
			//}
		}
	}

	public function dbsnet_woocp_remove_link($actions, $post){
		//var_dump(wp_get_current_user());
		if(!current_user_can('manage_options')){
			if($post->post_type != 'product'){
				return $actions;
			}
			$product = wc_get_product($post->ID);
			unset($actions['duplicate']);
			unset($actions['inline hide-if-no-js']);
		}

		// $user = wp_get_current_user();
		// $user_role = get_userdata($user->ID);

		// if(in_array('tenant_role', $user_role->roles)){
		// 	unset($actions['trash']);
		// 	unset($actions['edit']);
		// }

		return $actions;
	}

	public function dbsnet_woocp_customize_admin_bar(){
		if(!current_user_can('manage_options')){
			global $wp_admin_bar;
			//var_dump($wp_admin_bar);
			$wp_admin_bar->remove_menu('new-post');
			$wp_admin_bar->remove_menu('new-shop_order');
			$wp_admin_bar->remove_menu('new-media');
			$wp_admin_bar->remove_menu('comments');
			$wp_admin_bar->remove_menu('archive');
			$wp_admin_bar->remove_menu('view-store');
			$wp_admin_bar->remove_menu('view-site');
			$wp_admin_bar->remove_node('mwp-settings');
			$wp_admin_bar->remove_node('mwp-logout');
			

			$logout = array(
				'id'    => 'mwp-logout',
				'title' => 'Keluar <i class="mdi-action-exit-to-app"></i>',
				'href'  => wp_logout_url(),
				'parent'=> 'top-secondary',
				'meta'  => array(
				'class' => "force-mdi tooltiped tooltip-ajust",
				'title' => __('Keluar', 'material-wp')
				)
			);
			$wp_admin_bar->add_node($logout);
			//$wp_admin_bar->remove_node($logout);

		}
	}

	public function dbsnet_woocp_remove_customer_password_strength(){
		if(wp_script_is('wc-password-strength-meter', 'enqueued')){
			wp_dequeue_script('wc-password-strength-meter');
		}
	}

	public function dbsnet_woocp_remove_order_metabox(){
		if(!current_user_can('manage_options')){
			remove_meta_box('postcustom', 'shop_order', 'normal');
			remove_meta_box('woocommerce-order-downloads', 'shop_order', 'normal');
			
		}
	}

	// public function dbsnet_woocp_force_post_status_published($post){
	// 	var_dump($post);
	// 	if(!current_user_can('manage_options')){
	// 		if( 'trash' !== $post[ 'post_status' ] ) {  We still want to use the trash 
	// 	        if( in_array( $post[ 'post_type' ], array( 'post', 'product' ) ) ) {
	// 	            $post['post_status'] = 'publish';
	// 	        }
		        
	// 	    }
	// 	}
	// 	return $post;
	// }
}

?>