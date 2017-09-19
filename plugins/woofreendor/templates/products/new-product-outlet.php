<?php

global $post;

$from_shortcode = false;

if ( !isset( $post->ID ) && ! isset( $_GET['product_id'] ) ) {
    wp_die( __( 'Access Denied, No product found', 'dokan-lite' ) );
}

if( isset( $post->ID ) && $post->ID && $post->post_type == 'product' ) {

    if ( $post->post_author != get_current_user_id() ) {
        wp_die( __( 'Access Denied', 'dokan-lite' ) );
    }

    $post_id = $post->ID;
    $post_title = $post->post_title;
    $post_content = $post->post_content;
    $post_excerpt = $post->post_excerpt;
    $post_status = $post->post_status;
    $product        = wc_get_product( $post_id );
}

if ( isset( $_GET['product_id'] ) ) {
    $post_id        = intval( $_GET['product_id'] );
    $post           = get_post( $post_id );
    $post_title     = $post->post_title;
    $post_content   = $post->post_content;
    $post_excerpt   = $post->post_excerpt;
    $post_status    = $post->post_status;
    $product        = wc_get_product( $post_id );
    $from_shortcode = true;
}

$_regular_price         = get_post_meta( $post_id, '_regular_price', true );
$_sale_price            = get_post_meta( $post_id, '_sale_price', true );
$is_discount            = !empty( $_sale_price ) ? true : false;
$_sale_price_dates_from = get_post_meta( $post_id, '_sale_price_dates_from', true );
$_sale_price_dates_to   = get_post_meta( $post_id, '_sale_price_dates_to', true );

$_sale_price_dates_from = !empty( $_sale_price_dates_from ) ? date_i18n( 'Y-m-d', $_sale_price_dates_from ) : '';
$_sale_price_dates_to   = !empty( $_sale_price_dates_to ) ? date_i18n( 'Y-m-d', $_sale_price_dates_to ) : '';
$show_schedule          = false;

if ( !empty( $_sale_price_dates_from ) && !empty( $_sale_price_dates_to ) ) {
$show_schedule          = true;
}
$product_parent         = (int)get_post_meta( $post_id, 'product_parent', true);
$_featured              = get_post_meta( $post_id, '_featured', true );
$_downloadable          = get_post_meta( $post_id, '_downloadable', true );
$_virtual               = get_post_meta( $post_id, '_virtual', true );
$_stock                 = get_post_meta( $post_id, '_stock', true );
$_stock_status          = get_post_meta( $post_id, '_stock_status', true );

$_enable_reviews        = $post->comment_status;
$is_downloadable        = ( 'yes' == $_downloadable ) ? true : false;
$is_virtual             = ( 'yes' == $_virtual ) ? true : false;
$_sold_individually     = get_post_meta( $post_id, '_sold_individually', true );

$terms                  = wp_get_object_terms( $post_id, 'product_type' );
$product_type           = ( ! empty( $terms ) ) ? sanitize_title( current( $terms )->name ): 'simple';
$variations_class       = ($product_type == 'simple' ) ? 'dokan-hide' : '';
$_visibility            = ( version_compare( WC_VERSION, '2.7', '>' ) ) ? $product->get_catalog_visibility() : get_post_meta( $post_id, '_visibility', true );
$visibility_options     = dokan_get_product_visibility_options();

if ( ! $from_shortcode ) {
    get_header();
}
?>

<?php

    /**
     *  dokan_dashboard_wrap_before hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_dashboard_wrap_before', $post, $post_id );
?>

<div class="dokan-dashboard-wrap">

    <?php

        /**
         *  dokan_dashboard_content_before hook
         *  dokan_before_product_content_area hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
        do_action( 'dokan_before_product_content_area' );
    ?>

    <div class="dokan-dashboard-content dokan-product-edit">

        <?php

            /**
             *  dokan_product_content_inside_area_before hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_product_content_inside_area_before' );
        ?>

        <header class="dokan-dashboard-header dokan-clearfix">
            <h1 class="entry-title">
                <?php _e( 'Ubah Produk', 'dokan-lite' ); ?>
                <span class="dokan-label <?php echo dokan_get_post_status_label_class( $post->post_status ); ?> dokan-product-status-label">
                    <?php echo dokan_get_post_status( $post->post_status ); ?>
                </span>

                <?php if ( $post->post_status == 'publish' ) { ?>
                    <span class="dokan-right">
                        <a class="dokan-btn dokan-btn-theme dokan-btn-sm" href="<?php echo get_permalink( $post->ID ); ?>" target="_blank"><?php _e( 'View Product', 'dokan-lite' ); ?></a>
                    </span>
                <?php } ?>

                <?php if ( $_visibility == 'hidden' ) { ?>
                    <span class="dokan-right dokan-label dokan-label-default dokan-product-hidden-label"><i class="fa fa-eye-slash"></i> <?php _e( 'Hidden', 'dokan-lite' ); ?></span>
                <?php } ?>
            </h1>
        </header><!-- .entry-header -->

        <div class="product-edit-new-container product-edit-container">
            <?php if ( Dokan_Template_Products::$errors ) { ?>
                <div class="dokan-alert dokan-alert-danger">
                    <a class="dokan-close" data-dismiss="alert">&times;</a>

                    <?php foreach ( Dokan_Template_Products::$errors as $error) { ?>
                        <strong><?php _e( 'Error!', 'dokan-lite' ); ?></strong> <?php echo $error ?>.<br>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ( isset( $_GET['message'] ) && $_GET['message'] == 'success') { ?>
                <div class="dokan-message">
                    <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
                    <strong><?php _e( 'Success!', 'dokan-lite' ); ?></strong> <?php _e( 'The product has been saved successfully.', 'dokan-lite' ); ?>

                    <?php if ( $post->post_status == 'publish' ) { ?>
                        <a href="<?php echo get_permalink( $post_id ); ?>" target="_blank"><?php _e( 'View Product &rarr;', 'dokan-lite' ); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php
            $can_sell = apply_filters( 'dokan_can_post', true );

            if ( $can_sell ) {

                if ( dokan_is_seller_enabled( get_current_user_id() ) || woofreendor_is_user_tenant( get_current_user_id() )) { ?>
                    <form class="dokan-product-edit-form" role="form" method="post">

                        <?php //do_action( 'dokan_product_data_panel_tabs' ); ?>
                        <?php //do_action( 'dokan_product_edit_before_main' ); ?>

                        <div class="dokan-form-top-area">

                            <div class="content-half-part dokan-product-meta">

                                <div class="dokan-form-group">
                                    <input type="hidden" name="dokan_product_id" id="dokan-edit-product-id" value="<?php echo $post_id; ?>"/>

                                    <label for="post_title" class="form-label"><?php _e( 'Nama', 'dokan-lite' ); ?></label>
                                    <?php dokan_post_input_box( $post_id, 'post_title', array( 'placeholder' => __( 'Nama produk..', 'dokan-lite' ), 'value' => $post_title ) ); ?>
                                    <div class="dokan-product-title-alert dokan-hide">
                                        <?php _e( 'Masukkan nama produk!', 'dokan-lite' ); ?>
                                    </div>
                                </div>
                                <div class="dokan-form-group">
                                    <div class="dokan-product-short-description">
                                        <label for="post_excerpt" class="form-label"><?php _e( 'Deskripsi singkat', 'dokan-lite' ); ?></label>
                                        <?php wp_editor( $post_excerpt , 'post_excerpt', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_excerpt', 'tinymce' => false) ); ?>
                                    </div>
                                </div>

                                <div class="dokan-form-group">
                                    <div class="dokan-product-description">
                                        <label for="post_content" class="form-label"><?php _e( 'Deskripsi', 'dokan-lite' ); ?></label>
                                        <?php wp_editor( $post_content , 'post_content', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_content', 'tinymce' => false) ); ?>
                                    </div>
                                </div>

                                <?php $product_types = apply_filters( 'dokan_product_types', 'variable' ); ?>

                                <input type="hidden" id="product_parent" name="product_parent" value="<?php echo $product_parent; ?>">
                                <input type="hidden" id="product_type" name="product_type" value="variable">
                                <input type="hidden" id="_regular_price" name="_regular_price" value="0">
                                <input type="hidden" id="_sale_price" name="_sale_price">
                                <input type="hidden" id="product_tag" name="product_tag[]">
                                <input type="hidden" id="_stock" name="_stock" value="0">
                                <input type="hidden" id="_sold_individually" name="_sold_individually" value="yes">
                                <input type="hidden" id="post_status" name="post_status" value="publish">
                                <input type="hidden" id="_visibility" name="_visibility" value="visible">
                                <input type="hidden" id="product_cat" name="product_cat" value="<?php echo wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'ids') )[0]; ?>">
                                <?php //var_dump(wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'ids') )[0]); ?>
                                
                            </div><!-- .content-half-part -->

                            <div class="content-half-part featured-image">
                                <div class="dokan-feat-image-upload dokan-new-product-featured-img">
                                    <?php
                                    $wrap_class        = ' dokan-hide';
                                    $instruction_class = '';
                                    $feat_image_id     = 0;
                                    // var_dump(has_post_thumbnail( $product_parent ));
                                    if ( has_post_thumbnail( $product_parent ) ) {
                                        $wrap_class        = '';
                                        $instruction_class = ' dokan-hide';
                                        $feat_image_id     = get_post_thumbnail_id( $product_parent );
                                    }
                                    // var_dump($product_parent);
                                    ?>

                                    <div class="image-wrap">
                                        <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $feat_image_id; ?>">
                                        <?php if ( $feat_image_id ) { ?>
                                            <?php echo get_the_post_thumbnail( $product_parent, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array( 'height' => '', 'width' => '' ) ); ?>
                                        <?php } else { ?>
                                            <img height="" width="" src="" alt="">
                                        <?php } ?>
                                    </div>
                                </div><!-- .dokan-feat-image-upload -->
                                <div class="dokan-product-gallery">
                                    <div class="dokan-side-body" id="dokan-product-images">
                                        <div id="product_images_container">
                                            <ul class="product_images dokan-clearfix">
                                                <?php
                                                $product_images = get_post_meta( $product_parent, '_product_image_gallery', true );
                                                $gallery = explode( ',', $product_images );

                                                if ( $gallery ) {
                                                    foreach ($gallery as $image_id) {
                                                        if ( empty( $image_id ) ) {
                                                            continue;
                                                        }

                                                        $attachment_image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                                                        ?>
                                                        <li class="image" data-attachment_id="<?php echo $image_id; ?>">
                                                            <img src="<?php echo $attachment_image[0]; ?>" alt="">
                                                            <a href="#" class="action-delete" title="<?php esc_attr_e( 'Delete image', 'dokan-lite' ); ?>">&times;</a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>

                                            <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( $product_images ); ?>">
                                        </div>
                                    </div>
                                </div> <!-- .product-gallery -->
                            </div><!-- .content-half-part -->
                        </div><!-- .dokan-form-top-area -->

                        <?php do_action( 'dokan_new_product_form', $post, $post_id ); ?>
                        <?php do_action( 'dokan_product_edit_after_main', $post, $post_id ); ?>

                        <?php do_action( 'dokan_product_edit_after_inventory_variants', $post, $post_id ); ?>
                        
                        <div class="dokan-other-options dokan-edit-row dokan-clearfix">
                            <div class="dokan-section-heading" data-togglehandler="dokan_other_options">
                                <h2><i class="fa fa-cubes" aria-hidden="true"></i> <?php _e( 'Batch', 'dokan-lite' ); ?></h2>
                                <p><?php _e( 'Masukkan batch produk', 'dokan-lite' ); ?></p>
                                <a href="#" class="dokan-section-toggle">
                                    <i class="fa fa-sort-desc fa-flip-vertical" aria-hidden="true"></i>
                                </a>
                                <div class="dokan-clearfix"></div>
                            </div>

                            <div class="dokan-section-content">
                                <table id="tab_logic" class="dokan-table dokan-table-striped">
                                    <thead>
                                        <tr >
                                            <th class="text-center"><?php _e( '#', 'dokan-lite' ); ?></th>
                                            <th class="text-center"><?php _e( 'Produksi', 'dokan-lite' ); ?></th>
                                            <th class="text-center"><?php _e( 'Kadaluarsa', 'dokan-lite' ); ?></th>
                                            <th class="text-center"><?php _e( 'Stok', 'dokan-lite' ); ?></th>
                                            <th class="text-center"><?php _e( 'Harga', 'dokan-lite' ); ?></th>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo (do_action( 'woofreendor_batches_row', $post_id )); ?>
                                    </tbody>
                                </table>
                                <div class="dokan-form-group">
                                    <span class="dokan-show-add-product-error"></span>
                                    <span class="dokan-spinner woofreendor-add-new-batch-spinner dokan-hide"></span>
                                    <a href="#" data-product_id="<?php echo $post_id; ?>" class="add-new-product-batch dokan-btn dokan-btn-theme dokan-right"><?php _e( 'Tambah Batch', 'dokan' ) ?></a>
                                </div>
                                <div class="dokan-clearfix"></div>
                            </div>
                        </div>

                        <div class="dokan-other-options dokan-edit-row dokan-clearfix">
                            <div class="dokan-section-heading" data-togglehandler="dokan_other_options">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i> <?php _e( 'Other Options', 'dokan-lite' ); ?></h2>
                                <p><?php _e( 'Set your extra product options', 'dokan-lite' ); ?></p>
                                <a href="#" class="dokan-section-toggle">
                                    <i class="fa fa-sort-desc fa-flip-vertical" aria-hidden="true"></i>
                                </a>
                                <div class="dokan-clearfix"></div>
                            </div>

                            <div class="dokan-section-content">
                                
                                <div class="dokan-form-group">
                                    <label for="_purchase_note" class="form-label"><?php _e( 'Purchase Note', 'dokan-lite' ); ?></label>
                                    <?php dokan_post_input_box( $post_id, '_purchase_note', array( 'placeholder' => __( 'Customer will get this info in their order email', 'dokan-lite' ) ), 'textarea' ); ?>
                                </div>

                                <div class="dokan-form-group">
                                    <?php $_enable_reviews = ( $post->comment_status == 'open' ) ? 'yes' : 'no'; ?>
                                    <?php dokan_post_input_box( $post_id, '_enable_reviews', array('value' => $_enable_reviews, 'label' => __( 'Enable product reviews', 'dokan-lite' ) ), 'checkbox' ); ?>
                                </div>

                            </div>
                        </div><!-- .dokan-other-options -->

                        <?php if ( $post_id ): ?>
                            <?php do_action( 'dokan_product_edit_after_options' ); ?>
                        <?php endif; ?>

                        <?php wp_nonce_field( 'dokan_edit_product', 'dokan_edit_product_nonce' ); ?>

                        <!--hidden input for Firefox issue-->
                        <input type="hidden" name="dokan_update_product" value="<?php esc_attr_e( 'Save Product', 'dokan-lite' ); ?>"/>
                        <input type="submit" name="dokan_update_product" class="dokan-btn dokan-btn-theme dokan-btn-lg dokan-right" value="<?php esc_attr_e( 'Save Product', 'dokan-lite' ); ?>"/>
                        <div class="dokan-clearfix"></div>
                    </form>
                    <script type="text/javascript">
                        (function($) {
                            $("textarea.post_excerpt, textarea.post_content").attr('readonly',true);
                        })(jQuery);
                    </script>
                <?php } else { ?>
                    <div class="dokan-alert dokan-alert">
                        <?php echo dokan_seller_not_enabled_notice(); ?>
                    </div>
                <?php } ?>

            <?php } else { ?>

                <?php do_action( 'dokan_can_post_notice' ); ?>

            <?php } ?>
        </div> <!-- #primary .content-area -->

        <?php

            /**
             *  dokan_product_content_inside_area_after hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_product_content_inside_area_after' );
        ?>
    </div>

    <?php

        /**
         *  dokan_dashboard_content_after hook
         *  dokan_after_product_content_area hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
        do_action( 'dokan_after_product_content_area' );
    ?>

</div><!-- .dokan-dashboard-wrap -->
<div class="dokan-clearfix"></div>

<?php

    /**
     *  dokan_dashboard_content_before hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_dashboard_wrap_after', $post, $post_id );

    wp_reset_postdata();

    if ( ! $from_shortcode ) {
        get_footer();
    }
?>

