<?php

/**
 * Woofreendor Visual Composer Custom Shortcode
 * 
 * @load all shortcode for template  rendering
 */

class Woofreendor_VC_Shortcodes extends WPBakeryShortCode {
    
    public function __construct(){
        add_action( 'init', array( $this, 'tenant_product_listing_box_mapping') );
        add_shortcode( 'wvc_tenant_products', array( $this, 'tenant_products' ) );
    }

    public function tenant_product_listing_box_mapping(){
        
        if( !defined( 'WPB_VC_VERSION' ) ){
            return;
        }

        $order_by_values = array(
            '',
            esc_html__( 'Date', 'gonthemes-helper' ) => 'date',
            esc_html__( 'ID', 'gonthemes-helper' ) => 'ID',
            esc_html__( 'Author', 'gonthemes-helper' ) => 'author',
            esc_html__( 'Title', 'gonthemes-helper' ) => 'title',
            esc_html__( 'Modified', 'gonthemes-helper' ) => 'modified',
            esc_html__( 'Random', 'gonthemes-helper' ) => 'rand',
            esc_html__( 'Comment count', 'gonthemes-helper' ) => 'comment_count',
            esc_html__( 'Menu order', 'gonthemes-helper' ) => 'menu_order',
        );
    
        $order_way_values = array(
            '',
            esc_html__( 'Descending', 'gonthemes-helper' ) => 'DESC',
            esc_html__( 'Ascending', 'gonthemes-helper' ) => 'ASC',
        );

        $tenant_option_values = array(
            esc_html__( 'Show All', 'gonthemes-helper' ) => 'all',
            esc_html__( 'Show Specific Tenant', 'gonthemes-helper' ) => 'specific',
        );

        vc_map(
            array(
                'name'          => __( 'WVC Tenant Products Box' , 'text-domain' ),
                'base'          => 'wvc_tenant_products',
                'description'   => __( 'Woofreendor Tenant Products Box', 'text-domain' ),
                'category'      => __( 'Woofreendor', 'text-domain' ),
                'params'        => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Order by', 'gonthemes-helper' ),
                        'param_name' => 'orderby',
                        'value' => $order_by_values,
                        'save_always' => true,
                        'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Sort order', 'gonthemes-helper' ),
                        'param_name' => 'order',
                        'value' => $order_way_values,
                        'save_always' => true,
                        'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Show Mode', 'gonthemes-helper' ),
                        'param_name'    => 'showmode',
                        'value'         => $tenant_option_values,
                        'save_always'   => true,
                        'description'   => sprintf( __( 'Select how to show retrieved products. Show all tenants products or only specific tenant.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                    ),
                )
            )
        );
    }

    public function tenant_products( $paramAtts ){
        
        $list_tenant_products = shortcode_atts(
            array(
                'showmode'   => '',
                'orderby'   => '',
                'order'     => ''
            ),
            $paramAtts
        );

        $show_all   = isset( $list_tenant_products['showmode'] ) ? $list_tenant_products['showmode'] : 'all';
        $orderby    = isset( $list_tenant_products['orderby'] ) ? $list_tenant_products['orderby'] : 'title';
        $order      = isset( $list_tenant_products['order'] ) ? $list_tenant_products['order'] : 'ASC';
        $per_page   = isset( $list_tenant_products['per_page'] ) ? $list_tenant_products['per_page'] : '-1';

        ob_start();
        $args = array(
            'posts_per_page'    => $per_page,
            'post_type'         => 'product',
            'orderby'           => $orderby,
            'order'             => $order,
            'post_status'       => 'publish'
        );
        // var_dump($list_tenant_products);
        if( $show_all == 'specific'){
            $tenant_user   = get_userdata( get_query_var( 'author' ) );
            $args['author'] = $tenant_user->ID;
        }
        
        $query = new WP_Query( $args );
        ?>
        <div class="list-product-content">
        <?php
        if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) :
                $query->the_post(); global $product, $post;?>
                    <div class="item-col">
                        <div class="product-image">
                            <a class="oneimg" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
                                <?php 
                                echo $product->get_image('shop_catalog', array('class'=>'primary_image'));
                                ?>
                            </a>
                        </div>
                        <div class="text-block">
                            <h3 class="product-name">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="ratings"><?php echo wc_get_rating_html( $product->get_average_rating() ); ?></div>
                            <div class="price-box"><?php echo $product->get_price_html(); ?></div>
                        </div>
                    </div>
                <?php
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
        </div>
        <?php
            return '<div class="list-product-woo">' . ob_get_clean() . '</div>';
        
    }
    
}