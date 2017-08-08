<?php 

class DBSnet_Woocp_Manager_Admin{
	protected $version;
	protected $prev_batch;

	public function __construct( $version ) {
		$this->version = $version;
		$this->prev_batch = array();
	}

	public function enqueue_scripts_and_styles(){
		wp_register_script( 'dbsnet-woocp', plugin_dir_url( __FILE__ ) . 'js/dbsnet-woocp.js' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script('dbsnet-woocp');

		wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
	}

	public function save_woocp_batch_product_data_fields($post_id){
		//var_dump($_POST);die;
		if(!$post_id){
			return false;
		}
		// force product as variable product
		wp_set_object_terms( $post_id, 'variable', "product_type" );

		$post_temp_id = $post_id;
		$batch_start_date = $_POST['batch_start_date'];
		$batch_end_date = $_POST['batch_end_date'];
		$batch_stock = $_POST['batch_stock'];
		$batch_price = $_POST['batch_price'];
		$product_batch_title = sanitize_text_field( $_POST['product_batch_title']);
		if($product_batch_title==""){
			$product_batch_title = sanitize_text_field( $_POST['post_title'] );
		}

		if(isset($_POST['batch_deleted_id'])){
			$deleted_batches_id = $_POST['batch_deleted_id'];
			foreach($deleted_batches_id as $deleted_batch_id){
				wp_delete_post( $deleted_batch_id, true );
			}
		}
	    // var_dump($batch_start_date);die;
		$batches_id = $_POST['batch_id']; //var_dump($batches_id);die;
		$i=0;
	    foreach($batches_id as $key => $batch_id) {
	    	$get_the_batch_id=$batch_id;
	    	$title = $product_batch_title." - Batch ".$batch_id;
		    if(($batch_id == "") && (sanitize_text_field( $batch_start_date[$i] )!="") && (sanitize_text_field( $batch_end_date[$i] )!="") && (sanitize_text_field( $batch_stock[$i] )!="") && (sanitize_text_field( $batch_price[$i] )!=""))
		    {
		    	$batch_args = array(
		    			'post_title'=> $title, 
		    			'post_name'	=> 'product-'.$post_id.'-variation-'. $i, 
		    			'post_status' => 'publish',
		    			'post_type'=>'product_variation',
		    			'post_parent' => $post_id,
		    			// 'post_content'=>'batch_'.$post_id
		    			'menu_order' => $i,
		    			'guid' => home_url().'/?product_variation=product-'. $post_id. '-variation-' . $i
		    			);
		    	$get_the_batch_id = wp_insert_post( $batch_args);
		    	// create metadata (post_id)
		    	// update_post_meta( $batch_id, 'meta_product_parent', $post_id);
		    }
		    if( $get_the_batch_id !="" && $get_the_batch_id>0 ){
		    	//var_dump("UYE");die;
			    /*update_post_meta($get_the_batch_id,'meta_batch_startdate', $batch_start_date[$key]);
				update_post_meta($get_the_batch_id,'meta_batch_endate', $batch_end_date[$key]);
				update_post_meta($get_the_batch_id,'_stock', $batch_stock[$key]);
				update_post_meta($get_the_batch_id,'_regular_price', $batch_price[$key]);
				update_post_meta($get_the_batch_id,'_manage_stock', 'yes');
				update_post_meta($get_the_batch_id,'attribute_pa_batch', $get_the_batch_id);*/

		    	// save attributes & update variation
		    	$variations = array(
		    		array(
		    			'attributes' => array(
		    				'batchid'	=> 'batch_'.$get_the_batch_id,
		    				'startdate' => $batch_start_date[$key],
		    				'enddate' => $batch_end_date[$key]
		    				),
		    			'price' => $batch_price[$key],
		    			'stock' => $batch_stock[$key],
		    			'manage_stock' => 'yes'
		    			)
		    		);
		    	$available_attributes = array('batchid','startdate','enddate');
		    	$this->insertProductAttributes($post_id,$available_attributes,$variations);
		    	$this->insertProductVariations($post_id,$get_the_batch_id,$variations);
			}
			
			$i++;
		}

	}

	private function insertProductAttributes($post_id, $available_attributes, $variations){
		foreach ($available_attributes as $attribute){
    		$values = array(); // Set up an array to store the current attributes values.

	        foreach ($variations as $variation) // Loop each variation in the file
	        {
	            $attribute_keys = array_keys($variation['attributes']); // Get the keys for the current variations attributes

	            foreach ($attribute_keys as $key) // Loop through each key
	            {
	                if ($key === $attribute) // If this attributes key is the top level attribute add the value to the $values array
	                {
	                    $values[] = $variation['attributes'][$key];
	                }
	            }
	        }//var_dump($values[0]);die;
    		$values = array_unique($values);//var_dump(taxonomy_exists('pa_'.$attribute));die;//var_dump(get_term_by('name','biru','pa_color'));die;
    		$terms = get_term_by('name', $values[0], 'pa_'.$attribute);//var_dump($terms);die;
    		if(!$terms){
    			//var_dump("CIE");
    			wp_insert_term( $values[0], 'pa_'.$attribute);
    		}
    		wp_set_object_terms($post_id,$values[0],'pa_'.$attribute);
    	}
    	$product_attributes_data = array();
    	foreach($available_attributes as $attribute){
    		$product_attributes_data['pa_'.$attribute] = array(
    			'name'		=> 'pa_'.$attribute,
    			'value'		=> '',
    			'is_visible'=> '1',
    			'is_variation'=>'1',
    			'is_taxonomy'=>'1'
    			);
    	}
    	update_post_meta($post_id,'_product_attributes', $product_attributes_data);
	}

	private function insertProductVariations($post_id, $variation_post_id, $variations){
		foreach ($variations as $index => $variation){
	        // $variation_post = array( // Setup the post data for the variation
	        // 	'ID'			=> $variation_post_id,
	        //     'post_title'  => 'Batch #'.$index.' of '.count($variations).' for product#'. $post_id,
	        //     'post_name'   => 'product-'.$post_id.'-variation-'.$index,
	        //     'post_status' => 'publish',
	        //     'post_parent' => $post_id,
	        //     'post_type'   => 'product_variation',
	        //     'guid'        => home_url() . '/?product_variation=product-' . $post_id . '-variation-' . $index
	        // );

	        // $variation_post_id = wp_insert_post($variation_post); // Insert the variation

	        foreach ($variation['attributes'] as $attribute => $value) // Loop through the variations attributes
	        {   
	            $attribute_term = get_term_by('name', $value, 'pa_'.$attribute); // We need to insert the slug not the name into the variation post meta
	            //var_dump($attribute_term);die;
	            update_post_meta($variation_post_id, 'attribute_pa_'.$attribute, $attribute_term->slug);
	          // Again without variables: update_post_meta(25, 'attribute_pa_size', 'small')
	        }

	        //update_post_meta($variation_post_id, '_price', $variation['price']);
	        update_post_meta($variation_post_id, '_regular_price', $variation['price']);
	        update_post_meta($variation_post_id,'_stock', $variation['stock']);
			update_post_meta($variation_post_id,'_manage_stock', $variation['manage_stock']);
	    }
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
									<th class="text-center">
										#
									</th>
									<th class="text-center">
										Production Date
									</th>
									<th class="text-center">
										Expired Date
									</th>
									<th class="text-center">
										Stock
									</th>
									<th class="text-center">
										Price
									</th>
								</tr>
							</thead>
							<tbody> 
		<?php
//var_dump($product);die;
		$args = array(
			'post_type' => 'product_variation',
			// 'meta_key' => 'meta_product_parent',
			'post_parent' => $product->ID,
			// 'meta_value' => $product->ID,
			'orderby' => 'ID',
			'order' => 'ASC'
		);
		$batches = get_posts($args); //var_dump(count($batches));
		$index=0;
		foreach($batches as $batch){
			$this->prev_batch[$index] = $batch->ID;
			$meta_batch_startdate = get_post_meta( $batch->ID, 'attribute_pa_startdate', true ); 
			$meta_batch_endate = get_post_meta( $batch->ID, 'attribute_pa_enddate', true );
			$meta_batch_stock = get_post_meta( $batch->ID, '_stock', true );
			$meta_batch_price = get_post_meta( $batch->ID, '_regular_price', true );
	    ?>

	     
								<tr class="batch_row_table" id='addr<?php _e($index); ?>'>
									<td>
									<input type="hidden" name="batch_id[]" value="<?php _e($batch->ID); ?>"  />
									<?php _e($index+1); ?>
									</td>
									<td>
									<input type="text" name='batch_start_date[]'  placeholder='Start Date' class="custom-woocp-datepicker" value="<?php if(!empty($meta_batch_startdate)) _e($meta_batch_startdate); ?>"/>
									</td>
									<td>
									<input type="text" name='batch_end_date[]' placeholder='End Date' class="custom-woocp-datepicker" value="<?php if(!empty($meta_batch_endate)) _e($meta_batch_endate); ?>" />
									</td>
									<td>
									<input type="number" name='batch_stock[]' placeholder='Stock' class="form-control" value="<?php _e($meta_batch_stock); ?>"/>
									</td>
									<td>
									<input type="text" name='batch_price[]' placeholder='Price' class="form-control" value="<?php if(!empty($meta_batch_price)) _e($meta_batch_price); ?>"/>
									</td>
									<td><a id='' class="delete-batch-row pull-right btn btn-default"><span id="<?php _e($batch->ID); ?>"></span>Delete Row</a></td>
								</tr>
								<input id="inpt<?php _e($index); ?>" type="hidden" name="batch_deleted_id[]" value=""  />
	
		<?php
		$index++;
		} //endforeach
		?>
							<tr class="batch_row_table" id='addr<?php _e($index); ?>'>
								<td>
								<input id="" type="hidden" name="batch_id[]" value=""  />
								<?php _e($index+1); ?>
								</td>
								<td>
								<input type="text" name='batch_start_date[]'  placeholder='Start Date' class="custom-woocp-datepicker"/>
								</td>
								<td>
								<input type="text" name='batch_end_date[]' placeholder='End Date' class="custom-woocp-datepicker"/>
								</td>
								<td>
								<input type="number" name='batch_stock[]' placeholder='Stock' class="form-control"/>
								</td>
								<td>
								<input type="text" name='batch_price[]' placeholder='Price' class="form-control"/>
								</td>
								<td><a id='' class="delete-batch-row pull-right btn btn-default"><span id=""></span>Delete Row</a></td>
							</tr>
							<!-- <input id="" type="hidden" name="batch_deleted_id[]" value=""  /> -->
							<tr class="batch_row_table" id='addr<?php _e($index+1); ?>'></tr>
							</tbody>
						</table>
						<input id="" type="hidden" name="product_batch_title" value="<?php _e($product->post_title); ?>"  />
					</div>
				</div>
									
				<a id="add_row" class="btn btn-default pull-left"><span id="<?php _e($index+1); ?>"></span>Add Row</a>
				<!-- <a id='delete_row' class="pull-right btn btn-default"><span id="<?php //_e($index+1); ?>"></span>Delete Row</a> -->
			</div>
		<?php

	}

	public function delete_woocp_batch_on_post_trash($product_id){
		// Test: GetBatchesByProductId($product_id)
		// $test_batch = new WOOCP_Batch();
		// $get_batch = $test_batch->GetBatchesByProductId($product_id);
		// var_dump($get_batch);die;

		$args = array(
			'post_type' => 'batch',
			'meta_key' => 'meta_product_parent',
			'meta_value' => $product_id,
		);
		$batches = get_posts($args); //var_dump($batches);die;

		foreach ($batches as $batch) {
			wp_trash_post( $batch->ID );
		}

	}

	public function unstrashed_woocp_batch_on_post_trash($product_id){
		$args = array(
			'post_type' => 'batch',
			'post_status' => 'trash',
			'meta_key' => 'meta_product_parent',
			'meta_value' => $product_id,
		);
		//$get_posts = get_posts(104); var_dump($product);die;
		$batches = get_posts($args); //var_dump(get_posts($args));die;

		foreach ($batches as $batch) {
			wp_untrash_post( $batch->ID );
		}

	}

	public function add_woocp_batch_post_type() {
		$labels = array(
			'name'               => _x( 'Batches', 'batch' ),
			'singular_name'      => _x( 'Batch', 'batch' ),
			'menu_name'          => _x( 'Batches', 'batch' ),
			'name_admin_bar'     => _x( 'Batch', 'batch' ),
			'add_new'            => _x( 'Add New','batch' ),
			'add_new_item'       => __( 'Add New Batch', 'batch' ),
			'new_item'           => __( 'New Batch', 'batch' ),
			'edit_item'          => __( 'Edit Batch', 'batch' ),
			'view_item'          => __( 'View Batch', 'batch' ),
			'all_items'          => __( 'All Batches', 'batch' ),
			'search_items'       => __( 'Search Batches', 'batch' ),
			'parent_item_colon'  => __( 'Parent Batches:', 'batch' ),
			'not_found'          => __( 'No books found.', 'batch' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'batch' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'A custom post type for batch.', 'batch' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'batch' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array('custom-fields'),
			'taxonomies' 		 => array('category', 'post_tag')
		);

		register_post_type( 'batch', $args );
	}
}

?>