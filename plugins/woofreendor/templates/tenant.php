<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//global $wp_query;$seller_info  = get_user_by( 'slug', $author );
$tenant_user   = get_userdata( get_query_var( 'author' ) );//get_user_by( 'slug', get_query_var( 'tenant' ) );//var_dump($tenant_user);
$tenant_info   = woofreendor_get_tenant_info( $tenant_user->ID );//var_dump($tenant_user->ID);
$map_location = isset( $tenant_info['location'] ) ? esc_attr( $tenant_info['location'] ) : '';
get_header( 'shop' );
?>
    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <?php if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) { ?>
        <div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar" role="complementary" style="margin-right:3%;">
            <div class="dokan-widget-area widget-collapse">
                 <?php do_action( 'dokan_sidebar_store_before', $tenant_user, $tenant_info ); ?>
                <?php //var_dump(dynamic_sidebar( 'sidebar-store' ));
                if ( ! dynamic_sidebar( 'sidebar-store' ) ) {
                    // var_dump('a');
                    $args = array(
                        'before_widget' => '<aside class="widget">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    );
                    
                    // if ( class_exists( 'Dokan_Store_Location' ) ) {
                        // the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'woofreendor' ) ), $args );

                        // if ( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && !empty( $map_location ) ) {
                            // the_widget( 'Woofreendor_Tenant_Location', array( 'title' => __( 'Tenant Location', 'woofreendor' ) ), $args );
                        // }

                        // if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                            // the_widget( 'Woofreendor_Tenant_Contact_Form', array( 'title' => __( 'Contact Tenant', 'woofreendor' ) ), $args );
                        // }
                    // }

                }
                // var_dump('b');
                ?>

                <?php do_action( 'dokan_sidebar_store_after', $tenant_user, $tenant_info ); ?>
            </div>
        </div><!-- #secondary .widget-area -->
    <?php
    } else {
        get_sidebar( 'store' );
    }
    ?>

    <div id="dokan-primary" class="dokan-single-store dokan-w8">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php woofreendor_get_template_part( 'tenant-header' ); ?>
            <?php do_action( 'dokan_store_profile_frame_after', $tenant_user, $tenant_info ); ?>

            <?php if ( have_posts() ) { ?>

                <div class="seller-items">

                    <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php woofreendor_get_template_part( 'products/content-product-tenant' ); ?>

                        <?php endwhile; // end of the loop. ?>

                    <?php woocommerce_product_loop_end(); ?>

                </div><?php //echo woofreendor_is_tenant_page(); ?>
                <script type="text/html" id="tmpl-woofreendor-detail-product-popup">
                    <div id="" class="white-popup container">
                        <h2 id="wf_product_det_title"><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<span><?php _e( 'Title', 'dokan-lite' ); ?></span></h2>
                        <div class="row">
                            <div class="container col-md-6">
                                <img id="wf_product_det_image" src="" alt="" class="img-responsive">
                            </div>
                            <div class="container col-md-6">
                                <p id="wf_product_det_desc"></p>
                                <p id="wf_product_det_cat"></p>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php _e('Beli Sekarang Di:','woofreendor'); ?>  <span class="caret"></span>
                                    </button>
                                    <ul id="wf_product_det_outlet" class="dropdown-menu"></ul>
                                </div>
                            </div>
                        </div>                  
                    </div>
                </script>
                <?php dokan_content_nav( 'nav-below' ); ?>

            <?php } else { ?>

                <p class="dokan-info"><?php _e( 'No products were found of this vendor!', 'dokan-lite' ); ?></p>

            <?php } ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>