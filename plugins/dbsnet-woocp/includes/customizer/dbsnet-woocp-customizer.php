<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Customizer{

	public function __construct(){
		$this->load_dependencies();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( __DIR__ ) . 'dbsnet-woocp-groups-functions.php';
	}

	// public function dbsnet_woocp_customize_admin_menu(){
	// 	$user = wp_get_current_user();
	// 	if(in_array("tenant_role", $user->roles)){
	// 		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
	// 	}
	// 	if(in_array("outlet_role", $user->roles)){
	// 		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
	// 	}

	// 	$menu_name = 'woocommerce';
	// 	$removed_submenu = array('wc-addons','wc-status','wc-settings');
	// 	$this->removeSubmenu('tenant_role', $menu_name, $removed_submenu);
	// 	$this->removeSubmenu('outlet_role', $menu_name, $removed_submenu);
		
	// 	$menu_name = 'edit.php?post_type=product';
	// 	$removed_submenu_product = array(
	// 		'edit-tags.php?taxonomy=product_cat&amp;post_type=product',
	// 		'edit-tags.php?taxonomy=product_tag&amp;post_type=product',
	// 		'product_attributes'
	// 		);
	// 	$this->removeSubmenu('tenant_role', $menu_name, $removed_submenu_product);
	// 	$this->removeSubmenu('outlet_role', $menu_name, $removed_submenu_product);
	// }

	// private function removeSubmenu($role, $menu, $submenus){
	// 	$user = wp_get_current_user();
	// 	foreach ($submenus as $submenu) {
	// 		if(in_array($role, $user->roles)){
	// 			remove_submenu_page( $menu, $submenu );
	// 		}
	// 	}
	// }

	/**
	 * Create field in user profile form
	 */
	public function dbsnet_woocp_new_user_form_custom_field(){
		?>
		<h3>Tenant Group</h3>
		<p>select this option if you want to create an OUTLET</p>
		<i>if there is no option to be selected, create a TENANT first.</i><br>
        <select name="group-id">
    	<?php foreach(Groups_Group::get_group_ids() as $group_id): ?>
        	<?php $group_name = Groups_Group::read($group_id)->name;
        	if( $group_name != "Tenant" && $group_name != "Outlet" && $group_name != "Registered" ):
    	 	?>
        	<option value="<?php _e($group_id); ?>"><?php _e($group_name); ?></option>
        	<?php endif; ?>
    	<?php endforeach; ?>
        </select>
		<?php
	}

	public function dbsnet_woocp_custom_filter_product_list($query){
		global $pagenow, $typenow;
		$current_user=wp_get_current_user();
		

		if(!current_user_can('administrator') && current_user_can('manage_woocommerce') && ('edit.php' == $pagenow) &&  $typenow == 'product'){
			$group_id = get_user_meta($current_user->ID, 'binder_group', true);
			$user_role = '';

			if(in_array("tenant_role", $current_user->roles)){
				//$group_id = $user->ID;//var_dump($group_id);
				$user_role = "tenant_role";
				//$query->set('author', $user->ID);
			}
			if(in_array("outlet_role", $current_user->roles)){
				$user_role = "outlet_role";
				//var_dump($group_id);
				//$query->set('author', $user->ID);
			}
			$group = new Groups_Group($group_id);
			$group_member = $group->users;//var_dump(count($group_member));

			
			$accepted_user = array();
			foreach($group_member as $member){
				//var_dump($member->ID);
				$member_meta = get_userdata($member->ID);
				if($user_role=="tenant_role"){
					if($member->ID == $current_user->ID || (!in_array($user_role, $member_meta->roles))){
						$accepted_user[] = $member->ID;
					}
				}else if($user_role=="outlet_role"){
					if( $member->ID == $current_user->ID) {
						$accepted_user[] = $member->ID;
					}
				}
			}
			$query->set('author__in', $accepted_user );
		}
	}

	public function dbsnet_woocp_metabox_product(){
		$this->remove_woocommerce_metabox_product();

		$this->add_batch_metabox_product();
	}

	private function remove_woocommerce_metabox_product(){
		//if(current_user_can( 'manage_options' )) return;
		remove_meta_box('woocommerce-product-data', 'product', 'normal');
	}

	private function add_batch_metabox_product(){
		add_meta_box( 'dbsnet_woocp_batch_metabox', __('Batch Produk'), array($this,'dbsnet_woocp_batch_metabox'), 'product', 'normal', 'high');
	}

	public function dbsnet_woocp_batch_metabox($product){
		?>
		<?php wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' ); ?>
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

	public function dbsnet_woocp_screen_column_layout($columns){
		$columns['dashboard'] = 1;

		return $columns;
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
	}

	public function dbsnet_woocp_hide_publishing_actions(){

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

	public function dbsnet_woocp_page_title_actions(){
		$new_columns = array();
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);

		if($is_tenant || $is_outlet){
			$screen = get_current_screen();
			//var_dump($screen);
		    if($screen->id == 'edit-shop_order' ){
		        ?>
		            <script>
		            jQuery(document).ready(function($){
		            	$('#wpbody-content div.wrap h1 a.page-title-action').remove();
		            });
		            </script>
		        <?php
		    }

		    if($screen->id == 'edit-product'){
		    	if($is_tenant){
		    	?>
		            <script>
		            jQuery(document).ready(function($){
		            	$('#wpbody-content div.wrap h1 a.page-title-action').remove();
		            });
		            </script>
		        <?php
		    	}
		    	if($is_outlet){
		    	?>
		            <script>
		            jQuery(document).ready(function($){
		            	$('#wpbody-content div.wrap h1 a.page-title-action').not(':first').remove();
		            });
		            </script>
		        <?php
		    	}
		    }
		}

		// if(!current_user_can('manage_options')){
		// 	$screen = get_current_screen();
				

		// 	$user = wp_get_current_user();
		// 	$user_role = get_userdata($user->ID);

		// 	if(in_array('tenant_role', $user_role->roles)){
		// 		echo '
		// 			<style type="text/css">
		// 				#wpbody-content > div.wrap > h1 > a.page-title-action{
	 //                        display:none;
	 //                    }
		// 			</style>
		// 		';
		// 	}else{
		// 		echo '
		// 			<style type="text/css">
		// 				#wpbody-content > div.wrap > h1 > a.page-title-action:not(:first-child){
	 //                        display:none;
	 //                    }
		// 			</style>
		// 		';
		// 	}
		// }
	}

	public function dbsnet_woocp_post_row_actions($actions, $post){
		$new_columns = array();
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);
		$is_admin = current_user_can('manage_options');

		if($is_outlet || $is_tenant){

			if($post->post_type === 'product'){
				//$product = wc_get_product($post->ID);
				if($is_tenant){
					unset($actions['duplicate']);
					unset($actions['inline hide-if-no-js']);
					unset($actions['trash']);
					unset($actions['edit']);
				}
				
			}
			else if($post->post_type === 'shop_order'){
				unset($actions['trash']);
				unset($actions['edit']);
			}
			
		}

		return $actions;
	}

	public function dbsnet_woocp_customize_admin_bar(){
		if(!current_user_can('manage_options')){
			global $wp_admin_bar;
			//var_dump($wp_admin_bar);
			$wp_admin_bar->remove_menu('new-post');
			$wp_admin_bar->remove_menu('new-shop_order');
			$wp_admin_bar->remove_menu('new-shop_coupon');
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

	public function dbsnet_woocp_remove_order_metabox(){
		if(!current_user_can('manage_options')){
			remove_meta_box('postcustom', 'shop_order', 'normal');
			remove_meta_box('woocommerce-order-downloads', 'shop_order', 'normal');
			
		}

		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);

		if(in_array('tenant_role', $user_role->roles)){
			remove_meta_box('woocommerce-order-actions', 'shop_order', 'side');
			remove_meta_box('woocommerce-order-notes', 'shop_order', 'side');
		}
	}

	public function dbsnet_woocp_hide_recalculate_order(){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);

		if(in_array('tenant_role', $user_role->roles)){
			$screen = get_current_screen();
			// if($post->post_type == $my_post_type){
			if(in_array($screen->id,array('post','shop_order'))){
				echo '
					<style type="text/css">
						#woocommerce-order-items > div > div.wc-order-data-row.wc-order-bulk-actions.wc-order-data-row-toggle{
	                        display:none;
	                    }
					</style>
				';
			}
		}
	}

	public function dbsnet_woocp_order_custom_column($paramColumns){
		$new_columns = array();
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);
		$is_admin = current_user_can('manage_options');

		$new_columns['dbsnet_woocp_order_status_column'] = __('Status', 'dbsnet-woocp');
		$new_columns['dbsnet_woocp_order_id_column'] = __('#', 'dbsnet-woocp');
		$new_columns['dbsnet_woocp_order_date_column'] = __('Tanggal', 'dbsnet-woocp');
		$new_columns['dbsnet_woocp_order_customer_column'] = __('Pembeli', 'dbsnet-woocp');
		$new_columns['dbsnet_woocp_order_total_column'] = __('Total', 'dbsnet-woocp');
		if($is_admin||$is_tenant) $new_columns['dbsnet_woocp_order_outlet_column'] = __('Outlet', 'dbsnet-woocp');
		if($is_admin) $new_columns['dbsnet_woocp_order_tenant_column'] = __('Tenant', 'dbsnet-woocp');
		if($is_outlet) $new_columns['dbsnet_woocp_order_action_column'] = __('', 'dbsnet-woocp');
		
		return $new_columns;
	}

	public function dbsnet_woocp_order_custom_column_value($paramColumn, $paramOrderId){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);
		$is_admin = current_user_can('manage_options');

		$order = wc_get_order($paramOrderId);
		$order_data = $order->get_data();//var_dump($order_data);
		//$items = $order->get_items();


		if('dbsnet_woocp_order_status_column'===$paramColumn){
			echo $order_data['status'];
		}
		else if('dbsnet_woocp_order_id_column'===$paramColumn){
			echo $paramOrderId;
		}
		else if('dbsnet_woocp_order_date_column'===$paramColumn){
			echo $order->order_date;
		}
		else if('dbsnet_woocp_order_customer_column'===$paramColumn){
			$customer_id = get_post_meta($paramOrderId,'_customer_user',true);
			$customer_obj = get_userdata($customer_id);
			$customer_name = $customer_obj->first_name;
			echo $customer_name;
		}
		else if('dbsnet_woocp_order_total_column'===$paramColumn){
			echo get_woocommerce_currency_symbol("IDR").$order_data['total'];
		}
		else if(($is_admin||$is_tenant)&&'dbsnet_woocp_order_outlet_column'===$paramColumn){
			$outlet_id = get_post($item['product_id'])->post_author;
			$outlet_obj = get_userdata($outlet_id);
			$outlet_name = $outlet_obj->display_name;
			echo $outlet_name;
		}
		else if(($is_admin)&&'dbsnet_woocp_order_tenant_column'===$paramColumn){
			$binder_group = $outlet_obj->binder_group;
			$tenant = DBSnet_Woocp_Group_Functions::GetTenant($binder_group);
			echo $tenant->display_name;
			echo $customer_name;
		}
		else if(($is_outlet)&&'dbsnet_woocp_order_action_column'===$paramColumn){
			echo $customer_name;
		}

		// foreach($items as $item){
			


		// 	$outlet_id = get_post($item['product_id'])->post_author;
		// 	$outlet_obj = get_userdata($outlet_id);
		// 	$outlet_name = $outlet_obj->display_name;

		// 	$customer_id = get_post_meta($paramOrderId,'_customer_user',true);
		// 	$customer_obj = get_userdata($customer_id);
		// 	$customer_name = $customer_obj->first_name;
		// 	//var_dump($item['customer']['id']);

		// 	if($is_admin && 'dbsnet_woocp_order_tenant_column'===$paramColumn){
		// 		$binder_group = $outlet_obj->binder_group;
		// 		$tenant = DBSnet_Woocp_Group_Functions::GetTenant($binder_group);
		// 		echo $tenant->display_name;
		// 	}
		// 	if( ($is_admin || $is_tenant) && 'dbsnet_woocp_order_outlet_column'===$paramColumn){
		// 		echo $outlet_name;
		// 	}
		// 	if('dbsnet_woocp_order_customer_column'===$paramColumn){
		// 		echo $customer_name;
		// 	}
		// }
	}

	public function dbsnet_woocp_order_bulk($actions){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		$is_tenant = in_array('tenant_role', $user_role->roles);
		$is_outlet = in_array('outlet_role', $user_role->roles);
		$is_admin = current_user_can('manage_options');

		if($is_tenant || $is_outlet){
			unset($actions['delete']);
			unset($actions['trash']);
			unset($actions['mark_processing']);
			unset($actions['mark_on-hold']);
			unset($actions['mark_completed']);
		}
		return $actions;
	}

	public function dbsnet_woocp_product_bulk($actions){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		if(in_array('tenant_role', $user_role->roles)){
			unset($actions['edit']);
			unset($actions['trash']);
		}
		return $actions;
	}

	public function dbsnet_woocp_customize_currency_symbol($paramCurrencySymbol, $paramCurrency){
		switch($paramCurrency){
			case 'IDR': $paramCurrencySymbol = 'Rp'; break;
		}
		return $paramCurrencySymbol;
	}

	// public function dbsnet_woocp_search_customer_order($paramArray){
	// 	$new_array = array();
	// 	return $new_array;
	// }

	public function dbsnet_woocp_edit_form_top(){
		echo '<h2>edit_form_top</h2>';
	}
}
