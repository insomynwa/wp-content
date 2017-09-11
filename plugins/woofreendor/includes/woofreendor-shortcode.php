<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Shortcode{

	public function __construct( ) {
		
	}

	public static function init() {

        static $instance = false;

        if ( !$instance ) {
            $instance = new self;
        }

        return $instance;
    }

    public function init_shortcode() {
        add_shortcode( 'woofreendor-tenants', array( $this, 'tenant_listing' ));
    }

    public function tenant_listing() {
        $attr = shortcode_atts( apply_filters( 'woofreendor_tenant_listing_per_page', array(
            'per_page' => 10,
            'search'   => 'yes',
            'per_row'  => 3,
            'featured'  => 'no'
        ) ), $atts );
        $paged   = max( 1, get_query_var( 'paged' ) );
        $limit   = $attr['per_page'];
        $offset  = ( $paged - 1 ) * $limit;

        $tenant_args = array(
            'number' => $limit,
            'offset' => $offset
        );

        // if search is enabled, perform a search
        if ( 'yes' == $attr['search'] ) {
            $search_term = isset( $_GET['woofreendor_tenant_search'] ) ? sanitize_text_field( $_GET['woofreendor_tenant_search'] ) : '';
            if ( '' != $search_term ) {

                $tenant_args['meta_query'] = array(
                     array(
                        'key'     => 'woofreendor_tenant_name',
                        'value'   => $search_term,
                        'compare' => 'LIKE'
                    )
                );
            }
        }

        $tenants = Woofreendor_Tenant::GetAll( apply_filters( 'woofreendor_tenant_listing_args', $tenant_args ) );

        /**
         * Filter for store listing args
         *
         * @since 2.4.9
         */
        $template_args = apply_filters( 'woofreendor_tenant_list_args', array(
            'tenants'    => $tenants,
            'limit'      => $limit,
            'offset'     => $offset,
            'paged'      => $paged,
            'image_size' => 'full',
            'search'     => $attr['search'],
            'per_row'    => $attr['per_row']
        ) );
        ob_start();
        woofreendor_get_template_part( 'tenant-lists', false, $template_args );
        $content = ob_get_clean();

        return apply_filters( 'woofreendor_tenant_listing', $content, $attr );
    }

}