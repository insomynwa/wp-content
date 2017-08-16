<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Customizer{

	public function dbsnet_woocp_customize_admin_menu(){
		$user = wp_get_current_user();
		if(in_array("tenant_role", $user->roles)){
			remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		}
		if(in_array("outlet_role", $user->roles)){
			remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		}

		$menu_name = 'woocommerce';
		$removed_submenu = array('wc-addons','wc-status','wc-settings');
		$this->removeSubmenu('tenant_role', $menu_name, $removed_submenu);
		$this->removeSubmenu('outlet_role', $menu_name, $removed_submenu);
		
		$menu_name = 'edit.php?post_type=product';
		$removed_submenu_product = array(
			'edit-tags.php?taxonomy=product_cat&amp;post_type=product',
			'edit-tags.php?taxonomy=product_tag&amp;post_type=product',
			'product_attributes'
			);
		$this->removeSubmenu('tenant_role', $menu_name, $removed_submenu_product);
		$this->removeSubmenu('outlet_role', $menu_name, $removed_submenu_product);
	}

	private function removeSubmenu($role, $menu, $submenus){
		$user = wp_get_current_user();
		foreach ($submenus as $submenu) {
			if(in_array($role, $user->roles)){
				remove_submenu_page( $menu, $submenu );
			}
		}
	}

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

	public function dbsnet_woocp_remove_woocommerce_product_data(){
		if(current_user_can( 'manage_options' )) return;
		remove_meta_box('woocommerce-product-data', 'product', 'normal');
	}

	public function dbsnet_woocp_add_batch_meta_box_product(){

		add_meta_box( 'dbsnet_woocp_batch_metabox', __('Batch Produk'), array($this,'dbsnet_woocp_batch_metabox'), 'product', 'normal', 'high');
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

	public function dbsnet_woocp_hide_export_import_actions(){
		if(!current_user_can('manage_options')){
			$screen = get_current_screen();
				

			$user = wp_get_current_user();
			$user_role = get_userdata($user->ID);

			if(in_array('tenant_role', $user_role->roles)){
				echo '
					<style type="text/css">
						#wpbody-content > div.wrap > h1 > a.page-title-action{
	                        display:none;
	                    }
					</style>
				';
			}else{
				echo '
					<style type="text/css">
						#wpbody-content > div.wrap > h1 > a.page-title-action:not(:first-child){
	                        display:none;
	                    }
					</style>
				';
			}
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

	public function dbsnet_woocp_order_custom_column($columns){
		//$user = wp_get_current_user();
		//$user_role = get_userdata($user->ID);

		//if(in_array('tenant_role', $user_role->roles)){
		$new_columns = array();
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);

		if(current_user_can('manage_options') || in_array('tenant_role', $user_role->roles)){
			//var_dump($columns);
			foreach($columns as $column_name => $column_info){
				if('order_notes'!== $column_name && 'customer_message'!== $column_name && 'shipping_address'!== $column_name && 'order_actions'!== $column_name){
					$new_columns[$column_name] = $column_info;
				}
			
				if('order_status'=== $column_name){
					$new_columns['dbsnet_woocp_order_outlet'] = __('Outlet', 'woocommerce');
				}
			}
		}
		
		return $new_columns;
	}

	public function dbsnet_woocp_order_custom_column_value($column){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		if(current_user_can('manage_options') || in_array('tenant_role', $user_role->roles)){
			if('dbsnet_woocp_order_outlet'===$column){
				global $post;
				$order = wc_get_order($post->ID);
				$items = $order->get_items();
				$num_items = count($items);
				$step = 0;
				foreach($items as $item){
					$outlet_id = get_post($item['product_id'])->post_author;
					$outlet_name = get_userdata($outlet_id)->display_name;

					echo $outlet_name;
					if($step < ($num_items-1)){
						echo ', ';
					}
					
				}
			}
		}
	}

	public function dbsnet_woocp_remove_order_bulk($actions){
		if(!current_user_can('manage_options')){
			unset($actions['delete']);
			unset($actions['trash']);
			unset($actions['mark_processing']);
			unset($actions['mark_on-hold']);
			unset($actions['mark_completed']);
		}
		return $actions;
	}

	public function dbsnet_woocp_remove_product_bulk($actions){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);
		if(in_array('tenant_role', $user_role->roles)){
			unset($actions['edit']);
			unset($actions['trash']);
		}
		return $actions;
	}
}