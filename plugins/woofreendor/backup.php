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















<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;

$gon_options  = gon_get_global_variables();
$gon_showcountdown 	= gon_get_global_variables('gon_showcountdown');
$gon_productrows 	= gon_get_global_variables('gon_productrows');
$gon_productsfound 	= gon_get_global_variables('gon_productsfound');
$gon_columns 	= gon_get_global_variables('gon_columns');
$gon_options['product_columns'] = isset($gon_options['product_columns']) ? $gon_options['product_columns'] : 3;

//product columns
if($gon_options['product_columns']){
	$gon_columns = esc_html($gon_options['product_columns']);
} else {
	$gon_columns = 3;
}

//hide countdown on category page, show on all others
if(!isset($gon_showcountdown)) {
	$gon_showcountdown = true;
}

// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
	$woocommerce_loop['columns'] = apply_filters('loop_shop_columns', $gon_columns);

// Ensure visibility
if (! $product || ! $product->is_visible())
	return;

// Extra post classes
$classes = array();
if (0 == ($woocommerce_loop['loop']) % $woocommerce_loop['columns'] || 0 == $woocommerce_loop['columns']) {
	$classes[] = 'first';
}
if (0 == ($woocommerce_loop['loop'] + 1) % $woocommerce_loop['columns']) {
	$classes[] = 'last';
}

$count   = $product->get_rating_count();

if ($woocommerce_loop['columns']==3 || $woocommerce_loop['columns']==4 || $woocommerce_loop['columns']==2) {
	$colwidth = 12/$woocommerce_loop['columns'];
} else {
	$colwidth = 4;
}

$class_img = '';
if(isset($gon_options['second_image'])){
	if($gon_options['second_image'] == true){
		$class_img = 'twoimg';
	} else {
		$class_img = 'oneimg';
	}
}

$classes[] = ' item-col col-xs-6 col-sm-'.$colwidth ;?>

<?php if ((0 == ($woocommerce_loop['loop'] - 1) % 2) && ($woocommerce_loop['columns'] == 2)) {
	if($gon_productrows!=1){
		echo '<div class="group">';
	}
} ?>

<div <?php post_class($classes); ?>>
	<div class="product-wrapper">
		<div class="list-col4">
			<div class="product-image">
				<a class="<?php echo esc_attr($class_img); ?>" href="#" title="<?php echo esc_attr( $product->get_title() ); ?>" >
					<?php 
					echo $product->get_image('shop_catalog', array('class'=>'primary_image'));
					if(isset($gon_options['second_image'])){
						if($gon_options['second_image'] == true){
							$attachment_ids = $product->get_gallery_attachment_ids();
							if (!empty($attachment_ids)) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
				</a>
			</div>
		</div>
		<div class="list-col8">
			<div class="gridview">
				<div class="text-block">
					<h3 class="product-name">
						<a href="#"><?php the_title(); ?></a>
					</h3>
					<a class="button product_type_simple woofreendor_detail_product" data-product_id="<?php the_ID(); ?>" href="#">View Detail</a>
					<!-- <div class="ratings"><?php //echo wc_get_rating_html( $product->get_average_rating() ); ?></div> -->
					<!-- <div class="price-box"><?php //echo $product->get_price_html(); ?></div> -->
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php //do_action('woocommerce_after_shop_loop_item'); ?>
	</div>
</div>
<?php if (((0 == $woocommerce_loop['loop'] % 2 || $gon_productsfound == $woocommerce_loop['loop']) && $woocommerce_loop['columns'] == 2) ) { /* for odd case: $gon_productsfound == $woocommerce_loop['loop'] */
	if($gon_productrows!=1){
		echo '</div>';
	}
} ?>







<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

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
            <?php
                $outlets = woofreendor_tenant_get_active_outlet( $tenant_user->ID );
            ?>
            <?php //do_action( 'dokan_store_profile_frame_after', $tenant_user, $tenant_info ); ?>
            <?php if ( $outlets['count'] > 0 ) { ?>

                <!-- <div class="seller-items"> -->
                <div id="dokan-seller-listing-wrap">
                    <div class="seller-listing-content">
                        <ul class="dokan-seller-wrap">

                            <?php foreach ( $outlets['users'] as $outlet ): ?>
                            <?php
                            $image_size = 'full';
                            $store_info = dokan_get_store_info( $outlet->ID );
                            $banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;
                            $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'woofreendor' );
                            $store_url  = dokan_get_store_url( $outlet->ID );
                            $store_address  = dokan_get_seller_short_address( $outlet->ID );
                            $seller_rating  = dokan_get_seller_rating( $outlet->ID );
                            $banner_url = ( $banner_id ) ? wp_get_attachment_image_src( $banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
                            $featured_seller = get_user_meta( $outlet->ID, 'dokan_feature_seller', true );
                            ?>

                            <li class="dokan-single-seller woocommerce coloum-<?php echo $per_row; ?> <?php echo ( ! $banner_id ) ? 'no-banner-img' : ''; ?>">
                                <div class="store-wrapper">
                                    <div class="store-content">
                                        <div class="store-info" style="background-image: url( '<?php echo is_array( $banner_url ) ? $banner_url[0] : $banner_url; ?>');">
                                            <div class="store-data-container">
                                                <div class="featured-favourite">
                                                    <?php if ( ! empty( $featured_seller ) && 'yes' == $featured_seller ): ?>
                                                        <div class="featured-label"><?php _e( 'Featured', 'woofreendor' ); ?></div>
                                                    <?php endif ?>

                                                    <?php do_action( 'dokan_seller_listing_after_featured', $outlet, $store_info ); ?>
                                                </div>

                                                <div class="store-data">
                                                    <h2><a href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a></h2>

                                                    <?php if ( !empty( $seller_rating['count'] ) ): ?>
                                                        <div class="star-rating dokan-seller-rating" title="<?php echo sprintf( __( 'Rated %s out of 5', 'woofreendor' ), $seller_rating['rating'] ) ?>">
                                                            <span style="width: <?php echo ( ( $seller_rating['rating']/5 ) * 100 - 1 ); ?>%">
                                                                <strong class="rating"><?php echo $seller_rating['rating']; ?></strong> out of 5
                                                            </span>
                                                        </div>
                                                    <?php endif ?>

                                                    <?php if ( $store_address ): ?>
                                                        <p class="store-address"><?php echo $store_address; ?></p>
                                                    <?php endif ?>

                                                    <?php if ( !empty( $store_info['phone'] ) ) { ?>
                                                        <p class="store-phone">
                                                            <i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html( $store_info['phone'] ); ?>
                                                        </p>
                                                    <?php } ?>

                                                    <?php do_action( 'dokan_seller_listing_after_store_data', $outlet, $store_info ); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="store-footer">
                                        <div class="seller-avatar">
                                            <?php echo get_avatar( $outlet->ID, 150 ); ?>
                                        </div>
                                        <a href="<?php echo $store_url; ?>" class="dokan-btn dokan-btn-theme"><?php _e( 'Visit Store', 'woofreendor' ); ?></a>

                                        <?php do_action( 'dokan_seller_listing_footer_content', $outlet, $store_info ); ?>
                                    </div>
                                </div>
                            </li>

                        <?php endforeach; // end of the loop. ?>

                        </ul>
                    </div>
                </div>

                <!-- </div> -->

                <?php dokan_content_nav( 'nav-below' ); ?>

            <?php } else { ?>

                <p class="dokan-info"><?php _e( 'No outlets were found of this tenant!', 'woofreendor' ); ?></p>

            <?php } ?>
            <?php
            // $binder_group = woofreendor_get_binder_group( $tenant_user->ID);
            // $args = array(
            //     'role' => 'seller', 
            //     // 'number' => $limit, 
            //     // 'offset' => $offset,
            //     'order'          => 'ASC',
            //     'orderby'        => 'display_name',
            //     'meta_key'       => 'tenant_id',
            //     'meta_value'     => $tenant_user->ID
            //     );
            // $user_search = new WP_User_Query( $args );
            // $outlets     = (array) $user_search->get_results();
            
            // $template_args = array(
            //     'tenants'         => $outlets,
            //     // 'limit'           => $limit,
            //     // 'offset'          => $offset,
            //     // 'paged'           => $paged,
            //     // 'search_query'    => $search_query,
            //     // 'pagination_base' => $pagination_base,
            //     // 'per_row'         => $per_row,
            //     // 'search_enabled'  => $search,
            //     'image_size'      => $image_size,
            // );

            // echo woofreendor_get_template_part( 'tenant-lists-loop', false, $template_args );
            ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>








store.php
<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = get_userdata( get_query_var( 'author' ) );//var_dump(get_query_var( 'author' ));
$store_info   = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

get_header( 'shop' );
?>
    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <?php if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) { ?>
        <div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar" role="complementary" style="margin-right:3%;">
            <div class="dokan-widget-area widget-collapse">
                 <?php do_action( 'dokan_sidebar_store_before', $store_user, $store_info ); ?>
                <?php //var_dump($store_user);
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

                <?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
            </div>
        </div><!-- #secondary .widget-area -->
    <?php
    } else {
        get_sidebar( 'store' );
    }
    ?>

    <div id="dokan-primary" class="dokan-single-store dokan-w8">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php dokan_get_template_part( 'store-header' );?>

            <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>

            <?php if ( have_posts() ) { ?>

                <div class="seller-items">

                    <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php woofreendor_get_template_part( 'products/content-product' ); ?>

                        <?php endwhile; // end of the loop. ?>

                    <?php woocommerce_product_loop_end(); ?>

                </div>

                <?php dokan_content_nav( 'nav-below' ); ?>

            <?php } else { ?>

                <p class="dokan-info"><?php _e( 'No products were found of this vendor!', 'woofreendor' ); ?></p>

            <?php } ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>