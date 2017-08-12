<?php

class DBSnet_Woocp_My_Account {

	public function __construct(){
		add_action( 'init', array($this, 'dbsnet_woocp_add_endpoint'));
		add_filter('query_vars', array($this, 'dbsnet_woocp_add_query_vars'),0);

		add_filter('the_title', array($this, 'dbsnet_woocp_endpoint_title'));

		add_filter('woocommerce_account_menu_items', array($this, 'dbsnet_woocp_new_menu_items'));
		add_action('woocommerce_account_outlet-list_endpoint', array($this, 'dbsnet_woocp_endpoint_content'));

	}

	public function dbsnet_woocp_add_endpoint(){

		add_rewrite_endpoint('outlet-list', EP_ROOT | EP_PAGES );
	}

	public function dbsnet_woocp_add_query_vars($vars){
		$vars[] = 'outlet-list';
		return $vars;
	}

	public function dbsnet_woocp_endpoint_title($title){
		global $wp_query;
		$is_endpoint = isset($wp_query->query_vars['outlet-list']);

		if( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
			$title = __( 'Outlet', 'woocommerce');
			remove_filter('the_title', array( $this, 'dbsnet_woocp_endpoint_title'));
		}

		return $title;
	}

	public function dbsnet_woocp_new_menu_items($items){
		$logout = $items['customer-logout'];
		
		unset($items['downloads']);
		unset($items['customer-logout']);

		$items['outlet-list'] = __('Outlet', 'woocommerce');

		$items['customer-logout'] = $logout;

		return $items;
	}

	public function dbsnet_woocp_endpoint_content(){

		echo '<p>Hello Outlet</p>';
	}

	public static function dbsnet_woocp_my_account_install(){
		//flush_rewrite_rules();

		flush_rewrite_rules();
	}
	/*********************************/

	public function dbsnet_hide_account_menu_items($items){
		unset($items['downloads']);
		return $items;
	}

	public function dbsnet_add_account_menu_items(){
	}

	public function dbsnet_woocp_custom_item_query_vars($vars){
		$vars[] = 'outlets';
		return $vars;
	}
	public function dbsnet_woocp_custom_product_query_vars($vars){
		$vars[] = 'products';
		return $vars;
	}

	public function dbsnet_woocp_custom_menu_item($items){
		unset($items['downloads']);

		// $myorder = array(
  //                       'dashboard' => __( 'Dashboard', 'woocommerce' ),
  //                       'outlets' => __( 'Outlet', 'woocommerce' ),
  //                       'products' => __( 'Produk', 'woocommerce' ),
  //                       'edit-account' => __( 'Detail Akun', 'woocommerce' ),
  //                       'orders' => __( 'Pemesanan', 'woocommerce' ),
  //                       'edit-address' => __( 'Alamat', 'woocommerce' ),
  //                       'customer-logout' => __( 'Keluar', 'woocommerce' ),
  //                       );
  //      	return $myorder;

		$myorder['dashboard'] = __( 'Dashboard', 'woocommerce' );
		if(current_user_can('manage_woocommerce')){
			$myorder['outlets'] = __( 'Outlet', 'woocommerce' );
			$myorder['products'] = __( 'Produk', 'woocommerce' );
		}
		$myorder['orders'] = __( 'Pemesanan', 'woocommerce' );
		$myorder['edit-address'] = __( 'Alamat', 'woocommerce' );
		$myorder['edit-account'] = __( 'Detail Akun', 'woocommerce' );
		$myorder['customer-logout'] = __( 'Keluar', 'woocommerce' );

		return $myorder;
	}

	public function dbsnet_woocp_outlets_content(){
		?>
		<div class="woocommerce-MyAccount-content">
			<p>Hello World! - custom field can go here</p>
		</div>
		<?php
	}

	public function dbsnet_woocp_product_content(){
		?>
		<div class="woocommerce-MyAccount-content">
			<p>Hello Product! - custom field can go here</p>
		</div>
		<?php
	}

	public function dbsnet_woocp_custom_menu_title($title, $id){
		// global $wp_query;
		// $is_endpoint = isset( $wp_query->query_vars['products'] );
		// var_dump($wp_query->query_vars['products']);
		// if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
		// // New page title.
		// 	$title = __( 'My Product', 'woocommerce' );
		// 	remove_filter( 'the_title', array( $this, 'dbsnet_woocp_custom_menu_title' ) );
		// }
		// return $title;
		
		// var_dump($title);
		
		if ( is_wc_endpoint_url( 'orders' ) && in_the_loop() ) {
			$title = __( 'Pemesanan', 'woocommerce' );
		}
		else if ( is_wc_endpoint_url( 'edit-address' ) && in_the_loop() ) {
			$title = __( 'Alamat', 'woocommerce' );
		}
		else if ( is_wc_endpoint_url( 'edit-account' ) && in_the_loop() ) {
			$title = __( 'Detail Akun', 'woocommerce' );
		}
		else if ( is_wc_endpoint_url( 'outlets' ) && in_the_loop()) { // add your endpoint urls
			//var_dump("B");
			//$is_endpoint = isset( $wp_query->query_vars['my-outlet'] );
			//if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
				$title = __( 'Outlet', 'woocommerce' );
			//}
		}
		elseif ( is_wc_endpoint_url( 'products' ) && in_the_loop() ) {
			//var_dump("C");
			//$is_endpoint = isset( $wp_query->query_vars['my-product'] );
			//if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
				$title = __( 'Produk', 'woocommerce' );
			//}
		}
		// else if ( is_wc_endpoint_url( 'edit-address' ) && in_the_loop() ) {
		// 	$title = __( 'Alamat', 'woocommerce' );
		// }
		//var_dump("D");
		// remove_filter( 'the_title', array( $this, 'dbsnet_woocp_custom_menu_title' ) );
		return $title;
	}

}