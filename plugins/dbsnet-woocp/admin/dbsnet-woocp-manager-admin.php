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
		
		$batch_start_date = $_POST['batch_start_date'];
		$batch_end_date = $_POST['batch_end_date'];
		$batch_stock = $_POST['batch_stock'];
		$batch_price = $_POST['batch_price'];

		$deleted_batches_id = $_POST['batch_deleted_id'];
		foreach($deleted_batches_id as $deleted_batch_id){
			wp_delete_post( $deleted_batch_id, true );
		}
	    
		$batches_id = $_POST['batch_id']; //var_dump($batches_id);die;

	    foreach($batches_id as $key => $batch_id) {

		    if($batch_id == 0) {
		   
		    	// create new post (batch)
		    	$batch_id = wp_insert_post( 
		    		array(
		    			'post_title'=>'batch_'.$post_id, 
		    			'post_type'=>'batch',
		    			'post_status' => 'publish',
		    			'post_content'=>'batch_'.$post_id));
		    	// create metadata (post_id)
		    	update_post_meta( $batch_id, 'meta_product_parent', $post_id);
		    }
		    update_post_meta($batch_id,'meta_batch_startdate', $batch_start_date[$key]);
			update_post_meta($batch_id,'meta_batch_endate', $batch_end_date[$key]);
			update_post_meta($batch_id,'meta_batch_stock', $batch_stock[$key]);
			update_post_meta($batch_id,'meta_batch_price', $batch_price[$key]);
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

		$args = array(
			'post_type' => 'batch',
			'meta_key' => 'meta_product_parent',
			'meta_value' => $product->ID,
		);
		$batches = get_posts($args); //var_dump(count($batches));
		$index=0;
		foreach($batches as $batch){
			$this->prev_batch[$index] = $batch->ID;
			$meta_batch_startdate = get_post_meta( $batch->ID, 'meta_batch_startdate', true ); 
			$meta_batch_endate = get_post_meta( $batch->ID, 'meta_batch_endate', true );
			$meta_batch_stock = get_post_meta( $batch->ID, 'meta_batch_stock', true );
			$meta_batch_price = get_post_meta( $batch->ID, 'meta_batch_price', true );
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
									<input type="number" name='batch_stock[]' placeholder='Stock' class="form-control" value="<?php if(!empty($meta_batch_stock)) _e($meta_batch_stock); ?>"/>
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
							<input id="" type="hidden" name="batch_deleted_id[]" value=""  />
							<input id="" type="hidden" name="batch_id[]" value=""  />
							<tr class="batch_row_table" id='addr<?php _e($index+1); ?>'></tr>
							</tbody>
						</table>
					</div>
				</div>
									
				<a id="add_row" class="btn btn-default pull-left"><span id="<?php _e($index+1); ?>"></span>Add Row</a>
				<!-- <a id='delete_row' class="pull-right btn btn-default"><span id="<?php //_e($index+1); ?>"></span>Delete Row</a> -->
			</div>
		<?php

	}

	public function delete_woocp_batch_on_post_trash($product){
		$args = array(
			'post_type' => 'batch',
			'meta_key' => 'meta_product_parent',
			'meta_value' => $product->ID,
		);
		$batches = get_posts($args); //var_dump($batches);die;

		foreach ($batches as $batch) {
			wp_trash_post( $batch->ID );
		}

	}

	public function unstrashed_woocp_batch_on_post_trash($product){
		$args = array(
			'post_type' => 'batch',
			'post_status' => 'trash',
			'meta_key' => 'meta_product_parent',
			'meta_value' => $product,
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