<?php

class DBSnet_Woocp_Auto_Creator{

	public function __construct(){}

	static function install(){
		$attributes = array();

		$attributes = array(
			array(
				'attribute_label' => "Batch",
				'attribute_name' => 'batchid', //this is slug 
				'attribute_type' =>'select',
				'attribute_orderby' => 'menu_order',
				'attribute_public' => 0
				),
			array(
				'attribute_label' => "Tanggal Produksi",
				'attribute_name' => 'startdate', //this is slug 
				'attribute_type' =>'select',
				'attribute_orderby' => 'menu_order',
				'attribute_public' => 0
				),
			array(
				'attribute_label' => "Tanggal Kadaluarsa",
				'attribute_name' => 'enddate', //this is slug 
				'attribute_type' =>'select',
				'attribute_orderby' => 'menu_order',
				'attribute_public' => 0
				),
		);


		foreach($attributes as $attribute) {

			if ( empty( $attribute['attribute_type'] ) ) {
				$attribute['attribute_type'] = 'select';
			}
			if ( empty( $attribute['attribute_label'] ) ) {
				$attribute['attribute_label'] = ucfirst( $attribute['attribute_name'] );
			}
			if ( empty( $attribute['attribute_name'] ) ) {
				$attribute['attribute_name'] = wc_sanitize_taxonomy_name( $attribute['attribute_label'] );
			}

			global $wpdb;

			if ( empty( $attribute['attribute_name'] ) || empty( $attribute['attribute_label'] ) ) {
				return new WP_Error( 'error', __( 'Please, provide an attribute name and slug.', 'woocommerce' ) );
			} elseif ( taxonomy_exists( wc_attribute_taxonomy_name( $attribute['attribute_name'] ) ) ) {
				return new WP_Error( 'error', sprintf( __( 'Slug "%s" is already in use. Change it, please.', 'woocommerce' ), sanitize_title( $attribute['attribute_name'] ) ) );
			}

			$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
			//echo $wpdb->insert_id;

			do_action( 'woocommerce_attribute_added', $wpdb->insert_id, $attribute );
		}

		flush_rewrite_rules();
		delete_transient( 'wc_attribute_taxonomies' );
	}

}

