<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Admin_Dashboard{

	public function __construct(){}

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

		if(!current_user_can('manage_options')){
			$user = wp_get_current_user();
			$user_role = get_userdata($user->ID);
			//var_dump($columns);
			foreach($columns as $column_name => $column_info){
				if(in_array('tenant_role', $user_role->roles)){
					if('order_notes'!== $column_name && 'customer_message'!== $column_name && 'shipping_address'!== $column_name){
						$new_columns[$column_name] = $column_info;
					}
				
					if('order_title'=== $column_name){
						$new_columns['dbsnet_woocp_order_outlet'] = __('Outlet', 'woocommerce');
					}
				}
			}
		}
		
		return $new_columns;
	}

	public function dbsnet_woocp_order_custom_column_value($column){
		if(!current_user_can('manage_options')){
			$user = wp_get_current_user();
			$user_role = get_userdata($user->ID);
			if(in_array('tenant_role', $user_role->roles)){
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
	}

	public function dbsnet_woocp_add_custom_admin_menu(){
		$user = wp_get_current_user();
		$user_role = get_userdata($user->ID);

		if(in_array('tenant_role', $user_role->roles) || current_user_can('manage_options')){
			add_menu_page(
				__('Outlet', 'dbsnet-woocp'),
				__('Outlet', 'dbsnet-woocp'),
				'view_woocommerce_reports',
				'dbsnet-outlet',
				''//array( $this, 'dbsnet_woocp_render_outlet_page')
				//$icon_url,
				//$position
			);
			add_submenu_page(
				'dbsnet-outlet',
				__('List Outlet', 'dbsnet-woocp'),
				__('List Outlet', 'dbsnet-woocp'),
				'view_woocommerce_reports',
				'dbsnet-outlet',
				array( $this, 'dbsnet_woocp_render_outlet_page')
			);
			add_submenu_page(
				'dbsnet-outlet',
				__('Tambah Outlet', 'dbsnet-woocp'),
				__('Tambah Outlet', 'dbsnet-woocp'),
				'view_woocommerce_reports',
				'dbsnet-outlet-new',
				array( $this, 'dbsnet_woocp_render_outlet_page')
				);
		}
		
	}
}