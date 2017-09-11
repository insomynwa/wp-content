<?php

    /**
     *  dokan_new_product_wrap_before hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_new_product_wrap_before' );
?>
<div class="dokan-dashboard-wrap">

    <?php

        /**
         *  dokan_dashboard_content_before hook
         *  dokan_before_new_product_content_area hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
        do_action( 'dokan_before_new_product_content_area' );
    ?>


    <div class="dokan-dashboard-content">

        <?php

            /**
             *  dokan_before_new_product_inside_content_area hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_before_new_product_inside_content_area' );
        ?>

        <header class="dokan-dashboard-header dokan-clearfix">
            <h1 class="entry-title">
                <?php _e( 'Tambah Produk', 'dokan-lite' ); ?>
            </h1>
        </header><!-- .entry-header -->


        <div class="dokan-new-product-area">
            <?php if ( Dokan_Template_Products::$errors ) { ?>
                <div class="dokan-alert dokan-alert-danger">
                    <a class="dokan-close" data-dismiss="alert">&times;</a>

                    <?php foreach ( Dokan_Template_Products::$errors as $error) { ?>

                        <strong><?php _e( 'Error!', 'dokan-lite' ); ?></strong> <?php echo $error ?>.<br>

                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ( isset( $_GET['created_product'] ) ): ?>
                <div class="dokan-alert dokan-alert-success">
                    <a class="dokan-close" data-dismiss="alert">&times;</a>
                    <strong><?php _e( 'Success!', 'dokan-lite' ); ?></strong>
                    <?php echo sprintf( __( 'You have successfully created <a href="%s"><strong>%s</strong></a> product', 'dokan-lite' ), dokan_edit_product_url( intval( $_GET['created_product'] ) ), get_the_title( intval( $_GET['created_product'] ) ) ); ?>
                </div>
            <?php endif ?>

            <?php

            $can_sell = apply_filters( 'dokan_can_post', true );

            if ( $can_sell ) {
                $posted_img       = dokan_posted_input( 'feat_image_id' );
                $posted_img_url   = $hide_instruction = '';
                $hide_img_wrap    = 'dokan-hide';

                if ( !empty( $posted_img ) ) {
                    $posted_img     = empty( $posted_img ) ? 0 : $posted_img;
                    $posted_img_url = wp_get_attachment_url( $posted_img );
                    $hide_instruction = 'dokan-hide';
                    $hide_img_wrap = '';
                }
                if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>

                    <form class="dokan-form-container" method="post">

                        <div class="product-edit-container dokan-clearfix">
                            <div class="content-half-part featured-image">
                                <div class="featured-image">
                                    <div class="dokan-feat-image-upload">
                                        <div class="instruction-inside <?php echo $hide_instruction ?>">
                                            <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $posted_img ?>">
                                            <i class="fa fa-cloud-upload"></i>
                                            <a href="#" class="dokan-feat-image-btn dokan-btn"><?php _e( 'Upload Product Image', 'dokan-lite' ); ?></a>
                                        </div>

                                        <div class="image-wrap <?php echo $hide_img_wrap ?>">
                                            <a class="close dokan-remove-feat-image">&times;</a>
                                                <img src="<?php echo $posted_img_url ?>" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="dokan-product-gallery">
                                    <div class="dokan-side-body" id="dokan-product-images">
                                        <div id="product_images_container">
                                            <ul class="product_images dokan-clearfix">
                                                <?php
                                                    if ( isset( $_POST['product_image_gallery'] ) ) {
                                                        $product_images = $_POST['product_image_gallery'];
                                                        $gallery        = explode( ',', $product_images );

                                                        if ( $gallery ) {
                                                            foreach ( $gallery as $image_id ) {
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
                                                    }
                                                    ?>
                                                <li class="add-image add-product-images tips" data-title="<?php _e( 'Add gallery image', 'dokan-lite' ); ?>">
                                                    <a href="#" class="add-product-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </li>
                                            </ul>
                                            <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
                                        </div>
                                    </div>
                                </div> <!-- .product-gallery -->
                            </div>

                            <div class="content-half-part dokan-product-meta">
                                <div class="dokan-form-group">
                                    <input class="dokan-form-control" name="post_title" id="post-title" type="text" placeholder="<?php esc_attr_e( 'Nama produk..', 'dokan-lite' ); ?>" value="<?php echo dokan_posted_input( 'post_title' ); ?>">
                                </div>

                                <div class="dokan-form-group">
                                    <div class="dokan-form-group dokan-clearfix dokan-price-container">
                                        <div class="content-half-part">
                                            <div class="dokan-input-group">
                                                <input type="hidden" name="_regular_price" value="<?php echo dokan_posted_input('_regular_price') ?>">
                                            </div>
                                        </div>

                                        <div class="content-half-part sale-price">

                                            <div class="dokan-input-group">
                                                <input type="hidden" name="_sale_price" value="<?php echo dokan_posted_input('_sale_price') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dokan-form-group">
                                    <textarea name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder="<?php esc_attr_e( 'Deskripsi singkat produk...', 'dokan-lite' ); ?>"><?php echo dokan_posted_textarea( 'post_excerpt' ); ?></textarea>
                                </div>

                                <div class="dokan-form-group">

                                    <?php
                                    $selected_cat  = dokan_posted_input( 'product_cat' );
                                    $category_args =  array(
                                        'show_option_none' => __( '- Pilih kategori -', 'dokan-lite' ),
                                        'hierarchical'     => 1,
                                        'hide_empty'       => 0,
                                        'name'             => 'product_cat',
                                        'id'               => 'product_cat',
                                        'taxonomy'         => 'product_cat',
                                        'title_li'         => '',
                                        'class'            => 'product_cat dokan-form-control dokan-select2',
                                        'exclude'          => '',
                                        'selected'         => $selected_cat,
                                    );

                                    wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) );
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="dokan-form-group">
                            <label for="post_content" class="control-label"><?php _e( 'Deskripsi', 'dokan-lite' ) ?> <i class="fa fa-question-circle tips" data-title="<?php _e( 'Tambahkan deskripsi produk', 'dokan-lite' ) ?>" aria-hidden="true"></i></label>
                            <?php wp_editor( dokan_posted_textarea( 'post_content' ), 'post_content', array('editor_height' => 100, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_content', 'tinymce'=>false) ); ?>
                        </div>

                        <?php do_action( 'dokan_new_product_form' ); ?>

                        <hr>

                        <div class="dokan-form-group dokan-right">
                            <?php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ); ?>
                            
                            <button type="submit" name="add_product" class="dokan-btn dokan-btn-default dokan-btn-theme" value="create_new"><?php esc_attr_e( 'Buat Produk', 'dokan-lite' ); ?></button>
                        </div>

                    </form>

                <?php } else { ?>

                    <?php dokan_seller_not_enabled_notice(); ?>

                <?php } ?>

            <?php } else { ?>

                <?php do_action( 'dokan_can_post_notice' ); ?>

            <?php } ?>
        </div>

        <?php

            /**
             *  dokan_after_new_product_inside_content_area hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_after_new_product_inside_content_area' );
        ?>

    </div> <!-- #primary .content-area -->

    <?php

        /**
         *  dokan_dashboard_content_after hook
         *  dokan_after_new_product_content_area hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
        do_action( 'dokan_after_new_product_content_area' );
    ?>

</div><!-- .dokan-dashboard-wrap -->

<?php

    /**
     *  dokan_new_product_wrap_after hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_new_product_wrap_after' );
?>
