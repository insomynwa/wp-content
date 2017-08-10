<?php 

class DBSnet_Woocp_Manager_Admin{
	protected $version;

	public function __construct( $version ) {
		$this->version = $version;
	}

	public function enqueue_scripts_and_styles(){
		wp_register_script( 'dbsnet-woocp', plugin_dir_url( __FILE__ ) . 'js/dbsnet-woocp.js' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-progressbar' );
		wp_enqueue_script('dbsnet-woocp');

		// wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );

		wp_localize_script(
			'dbsnet-woocp', 
			'dbsnet_ajax', 
			array(
				'ajax_url' => admin_url('admin-ajax.php'), 'dbsnet_security' => 'd85n3t'
				)
		);
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

			$meta_startdate_slug = get_post_meta( $batch->ID, 'attribute_pa_startdate', true );
			$meta_enddate_slug = get_post_meta( $batch->ID, 'attribute_pa_enddate', true );

			$terms_startdate = get_term_by('slug', $meta_startdate_slug, 'pa_startdate');
			$terms_enddate = get_term_by('slug', $meta_enddate_slug, 'pa_enddate');

			$meta_batch_startdate = $terms_startdate->name;
			$meta_batch_endate = $terms_enddate->name;
			// $meta_batch_startdate = get_post_meta( $batch->ID, 'attribute_pa_startdate', true ); 
			// $meta_batch_endate = get_post_meta( $batch->ID, 'attribute_pa_enddate', true );
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

			// Setting attributes
			$available_attributes = array( 'batchid', 'startdate','enddate');
			$variations = array(
				'batchid'	=> 'batch-'.$post_batch_id,
				'startdate'	=> $post_start_date,
				'enddate'	=> $post_end_date,
				);

			foreach($available_attributes as $attribute){
				/*
					check if term exists
					get_term_by( $field, $value, $taxonomy, $output, $filter )
				 */ 
				$terms = get_term_by('slug', $post_product_id.'-'.$variations[$attribute], 'pa_'.$attribute);
				if(!$terms){
					/*
						create term if not exists
						wp_insert_term( $term, $taxonomy, $args = array() )
					 */
					wp_insert_term( $variations[$attribute], 'pa_'.$attribute, array('slug'=>$post_product_id.'-'.$variations[$attribute]));
				}
				/*
					update post meta using term slug
					update_post_meta( $post_id, $meta_key, $meta_value, $prev_value )
				 */
				update_post_meta($post_batch_id,'attribute_pa_'.$attribute, $post_product_id.'-'.$variations[$attribute]);
					
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
	public function SavedProduct($post_id){

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
		$available_attributes = array('batchid','startdate','enddate');

		$product = get_post($post_id);
		$variations_slug = array();
		$variations_name = array();
		foreach($batches as $batch){
			$meta_batchid_slug = get_post_meta( $batch->ID, 'attribute_pa_batchid', true );
			$meta_startdate_slug = get_post_meta( $batch->ID, 'attribute_pa_startdate', true );
			$meta_enddate_slug = get_post_meta( $batch->ID, 'attribute_pa_enddate', true );

			$terms_batchid = get_term_by('slug', $meta_batchid_slug, 'pa_batchid');
			$terms_startdate = get_term_by('slug', $meta_startdate_slug, 'pa_startdate');
			$terms_enddate = get_term_by('slug', $meta_enddate_slug, 'pa_enddate');

			$variations_slug['batchid'][] = $meta_batchid_slug;
			$variations_slug['startdate'][] = $meta_startdate_slug;
			$variations_slug['enddate'][] = $meta_enddate_slug;

			$variations_name['batchid'][] = $terms_batchid->name;
			$variations_name['startdate'][] = $terms_startdate->name;
			$variations_name['enddate'][] = $terms_enddate->name;
		}
		$variations_slug['batchid'] = array_unique($variations_slug['batchid']);
		$variations_slug['startdate'] = array_unique($variations_slug['startdate']);
		$variations_slug['enddate'] = array_unique($variations_slug['enddate']);

		$variations_name['batchid'] = array_unique($variations_name['batchid']);
		$variations_name['startdate'] = array_unique($variations_name['startdate']);
		$variations_name['enddate'] = array_unique($variations_name['enddate']);

		wp_set_object_terms($post_id, 'variable', 'product_type');
    	$product_attributes_data = array();
		foreach($available_attributes as $attribute){//batchid, startdate, enddate
    		$product_attributes_data['pa_'.$attribute] = array(
    			'name'		=> 'pa_'.$attribute,
    			'value'		=> $variations_name[$attribute],
    			'is_visible'=> '1',
    			'is_variation'=>'1',
    			'is_taxonomy'=>'1'
    		);
			wp_set_object_terms($post_id,$variations_slug[$attribute],'pa_'.$attribute);
    	}

    	update_post_meta($post_id,'_product_attributes', $product_attributes_data);
	    	
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
}

?>