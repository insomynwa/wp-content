<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

$tenant_user   = get_userdata( get_query_var( 'author' ) );
$tenant_info   = woofreendor_get_tenant_info( $tenant_user->ID );
$store_tabs    = woofreendor_get_tenant_tabs( $tenant_user->ID );
$outlets = woofreendor_tenant_get_active_outlet( $tenant_user->ID );

$sidebar = 'left';
$sidebar_shop = '';
if(isset($gon_options['sidebar_shop']) && $gon_options['sidebar_shop']!=''){
	$sidebar = $gon_options['sidebar_shop'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$sidebar = $_GET['sidebar'];
}
switch($sidebar) {
	case 'left':
		$sidebar_shop = 'left';
		break;
	case 'right':
		$sidebar_shop = 'right';
		break;
	default:
		$sidebar_shop = $sidebar_shop;
		break;
}

get_header(); ?>
<?php
    $style_bg = "";
    if(isset( $tenant_info['banner'] ) && !empty( $tenant_info['banner'] )){
        $style_bg = "background-image: url( " . wp_get_attachment_url( $tenant_info['banner'] ) . ")";
    }
?>
<div class="main-container page-shop">
	<div class="breadcrumb-blog" style="<?php echo $style_bg; ?>">
		<div class="container">
			<h3><?php echo esc_html($tenant_user->display_name, 'gon-cakeshop'); ?></h3>
			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action('woocommerce_before_main_content');
			?>
		</div>
	</div>
    <?php if($store_tabs): ?>
    <div class="vc_tta-container" data-vc-action="collapse">
        <div class="vc_general vc_tta vc_tta-tabs vc_tta-color-grey vc_tta-style-classic vc_tta-shape-rounded vc_tta-spacing-1 tab-product vc_tta-tabs-position-top vc_tta-controls-align-left tab-product">
            <div class="vc_tta-tabs-container">
                <ul class="vc_tta-tabs-list">
                    <?php $step=0;foreach( $store_tabs as $key => $tab ): ?>
                    <li class="vc_tta-tab <?php if($step==1) echo 'vc_active';$active=false;?>" data-vc-tab="">
                        <a href="<?php echo esc_url( $tab['url'] ); ?>" data-vc-tabs="" data-vc-container=".vc_tta">
                            <span class="vc_tta-title-text"><?php echo $tab['title']; ?></span>
                        </a>
                    </li>
                    <?php $step++;endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif;?>
	<div class="page-content">
		<div class="container">
			<div class="shop-content">
				<div class="row">
					<?php if($sidebar_shop=='left') :?>
						<?php //get_sidebar('category'); ?>
					<?php endif; ?>
					
					<div id="archive-product" class="col-xs-12 <?php if (is_active_sidebar('sidebar-category')) : ?>col-md-9<?php endif; ?>">
						<div class="archive-border">
							<?php if(!empty($gon_options['cat_banner_img']['url'])){ ?>
								<div class="theme-banner banner-category"><a href="<?php echo esc_url($gon_options['cat_banner_link']); ?>"><img src="<?php echo esc_url($gon_options['cat_banner_img']['url']); ?>" alt=""></a></div>
							<?php } ?>
							<?php do_action('woocommerce_archive_description'); ?>
							
							<?php if ($outlets['count'] > 0) : ?>
								
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
                                                        <div class="add-to-cart">
                                                            <p class="product woocommerce add_to_cart_inline ">
                                                                <a class="button product_type_simple add_to_cart_button" data-product_id="<?php the_ID(); ?>" href="<?php echo $store_url; ?>"><?php _e( 'Visit Store', 'woofreendor' ); ?></a>
                                                            </p>
                                                        </div>

                                                        <?php do_action( 'dokan_seller_listing_footer_content', $outlet, $store_info ); ?>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php endforeach; // end of the loop. ?>

                                        </ul>
                                    </div>
                                </div>
								
							<?php elseif (! woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

								<?php wc_get_template('loop/no-products-found.php'); ?>

							<?php endif; ?>

						<?php
							/**
							 * woocommerce_after_main_content hook
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action('woocommerce_after_main_content');
						?>
						</div>
					</div>
					
					<?php if($sidebar_shop=='right') :?>
						<?php get_sidebar('category'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>