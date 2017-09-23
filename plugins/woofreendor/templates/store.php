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
$store_tabs    = dokan_get_store_tabs( $tenant_user->ID );

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
                    <?php $active = true;foreach( $store_tabs as $key => $tab ): ?>
                    <li class="vc_tta-tab <?php if($active) echo 'vc_active';$active=false;?>" data-vc-tab="">
                        <a href="<?php echo esc_url( $tab['url'] ); ?>" data-vc-tabs="" data-vc-container=".vc_tta">
                            <span class="vc_tta-title-text"><?php echo $tab['title']; ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
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
						<?php get_sidebar('category'); ?>
					<?php endif; ?>
					
					<div id="archive-product" class="col-xs-12 <?php if (is_active_sidebar('sidebar-category')) : ?>col-md-9<?php endif; ?>">
						<div class="archive-border">
							<?php if(!empty($gon_options['cat_banner_img']['url'])){ ?>
								<div class="theme-banner banner-category"><a href="<?php echo esc_url($gon_options['cat_banner_link']); ?>"><img src="<?php echo esc_url($gon_options['cat_banner_img']['url']); ?>" alt=""></a></div>
							<?php } ?>
							<?php do_action('woocommerce_archive_description'); ?>
							
							<?php if (have_posts()) : ?>
								
								<?php
									/**
									* remove message from 'woocommerce_before_shop_loop' and show here
									*/
									do_action('woocommerce_show_message');
								?>
								<?php if(('' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && '' !== get_option('woocommerce_category_archive_display'))) : ?>
								<div class="all-subcategories">
									<?php woocommerce_product_subcategories(); ?>
									<div class="clearfix"></div>
								</div>							
								<?php endif; ?>
								<?php if(('subcategories' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && 'subcategories' !== get_option('woocommerce_category_archive_display')) || (empty($product_subcategories) && 'subcategories' == get_option('woocommerce_category_archive_display')) ||  is_product_tag()): ?>
								<div class="toolbar">
									<div class="view-mode">
										<a href="#" class="grid active" title="<?php echo esc_attr__('Grid', 'gon-cakeshop'); ?>"><i class="icon-grid icons"></i></a>
										<a href="#" class="list" title="<?php echo esc_attr__('List', 'gon-cakeshop'); ?>"><i class="icon-list icons"></i></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 * 
										 */
										do_action('woocommerce_before_shop_loop');
										do_action('woocommerce_after_shop_loop');
									?>
									<div class="clearfix"></div>
								</div>
								<?php endif; ?>
								
								<?php woocommerce_product_loop_start(); ?>

									<?php while (have_posts()) : the_post(); ?>

                                        <?php woofreendor_get_template_part( 'products/content-product' ); ?>

									<?php endwhile; // end of the loop. ?>

								<?php woocommerce_product_loop_end(); ?>
								
								<?php if(('subcategories' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && 'subcategories' !== get_option('woocommerce_category_archive_display')) || (empty($product_subcategories) && 'subcategories' == get_option('woocommerce_category_archive_display')) ||  is_product_tag()): ?>
								<div class="toolbar tb-bottom">
									<div class="view-mode">
										<a href="#" class="grid active" title="<?php echo esc_attr__('Grid', 'gon-cakeshop'); ?>"><i class="icon-grid icons"></i></a>
										<a href="#" class="list" title="<?php echo esc_attr__('List', 'gon-cakeshop'); ?>"><i class="icon-list icons"></i></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 * 
										 */
										do_action('woocommerce_before_shop_loop');
										do_action('woocommerce_after_shop_loop');
									?>
									<div class="clearfix"></div>
								</div>
								<?php endif; ?>
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