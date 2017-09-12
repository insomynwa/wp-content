<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//global $wp_query;
$tenant_user   = get_userdata( get_query_var( 'tenant' ) );//var_dump($wp_query->query['tenant']);
$tenant_info   = woofreendor_get_tenant_info( $tenant_user->ID );
$map_location = isset( $tenant_info['location'] ) ? esc_attr( $tenant_info['location'] ) : '';
get_header( 'shop' );
?>
    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <?php if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) { ?>
        <div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar" role="complementary" style="margin-right:3%;">
            <div class="dokan-widget-area widget-collapse">
                 <?php do_action( 'dokan_sidebar_store_before', $tenant_user, $tenant_info ); ?>
                <?php
                if ( ! dynamic_sidebar( 'sidebar-store' ) ) {

                    $args = array(
                        'before_widget' => '<aside class="widget">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    );

                    if ( class_exists( 'Dokan_Store_Location' ) ) {
                        the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'woofreendor' ) ), $args );

                        if ( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && !empty( $map_location ) ) {
                            the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'woofreendor' ) ), $args );
                        }

                        if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                            the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Vendor', 'woofreendor' ) ), $args );
                        }
                    }

                }
                ?>

                <?php do_action( 'dokan_sidebar_store_after', $tenant_user, $tenant_info ); ?>
            </div>
        </div><!-- #secondary .widget-area -->
    <?php
    }
    else {

        get_sidebar( 'store' );
    }
    ?>

    <div id="dokan-primary" class="dokan-single-store dokan-w8">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php woofreendor_get_template_part( 'tenant-header' ); ?>

            <?php //do_action( 'dokan_store_profile_frame_after', $tenant_user, $tenant_info ); ?>
            <?php
            $binder_group = woofreendor_get_binder_group( $tenant_user->ID);
            $args = array(
                'role' => 'seller', 
                // 'number' => $limit, 
                // 'offset' => $offset,
                'order'          => 'ASC',
                'orderby'        => 'display_name',
                'meta_key'       => 'binder_group',
                'meta_value'     => intval($binder_group)
                );
            $user_search = new WP_User_Query( $args );
            $outlets     = (array) $user_search->get_results();
            
            $template_args = array(
                'tenants'         => $outlets,
                // 'limit'           => $limit,
                // 'offset'          => $offset,
                // 'paged'           => $paged,
                // 'search_query'    => $search_query,
                // 'pagination_base' => $pagination_base,
                // 'per_row'         => $per_row,
                // 'search_enabled'  => $search,
                'image_size'      => $image_size,
            );

            echo woofreendor_get_template_part( 'tenant-lists-loop', false, $template_args );
            ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>