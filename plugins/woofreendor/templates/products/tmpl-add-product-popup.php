<script type="text/html" id="tmpl-dokan-add-new-product">
    <div id="dokan-add-new-product-popup" class="white-popup dokan-add-new-product-popup">
        <h2><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Tambah Produk', 'dokan-lite' ); ?></h2>

        <form action="" method="post" id="dokan-add-new-product-form">
            <div class="product-form-container">
                <div class="content-half-part dokan-feat-image-content">
                    <div class="dokan-feat-image-upload">
                        <?php
                        $wrap_class        = ' dokan-hide';
                        $instruction_class = '';
                        $feat_image_id     = 0;
                        ?>
                        <div class="instruction-inside<?php echo $instruction_class; ?>">
                            <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $feat_image_id; ?>">

                            <i class="fa fa-cloud-upload"></i>
                            <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php _e( 'Unggah cover produk', 'dokan-lite' ); ?></a>
                        </div>

                        <div class="image-wrap<?php echo $wrap_class; ?>">
                            <a class="close dokan-remove-feat-image">&times;</a>
                            <img height="" width="" src="" alt="">
                        </div>
                    </div>

                    <div class="dokan-product-gallery">
                        <div class="dokan-side-body" id="dokan-product-images">
                            <div id="product_images_container">
                                <ul class="product_images dokan-clearfix">

                                    <li class="add-image add-product-images tips" data-title="<?php _e( 'Tambah galeri produk', 'dokan-lite' ); ?>">
                                        <a href="#" class="add-product-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                                <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
                            </div>
                        </div>
                    </div> <!-- .product-gallery -->
                </div>
                <div class="content-half-part dokan-product-field-content">
                    <div class="dokan-form-group">
                        <input type="text" class="dokan-form-control" name="post_title" placeholder="<?php _e( 'Nama produk..', 'dokan-lite' ); ?>">
                    </div>

                    <div class="dokan-clearfix">
                        <input type="hidden" class="dokan-form-control" name="_regular_price" value="0">
                        <input type="hidden" class="dokan-form-control" name="_sale_price" value="0">
                        <div class="dokan-form-group" dokan-clearfix >
                            <?php
                            $product_cat = -1;
                            $category_args =  array(
                                'show_option_none' => __( '- Pilih kategori -', 'dokan-lite' ),
                                'hierarchical'     => 1,
                                'hide_empty'       => 0,
                                'name'             => 'product_cat',
                                'id'               => 'product_cat',
                                'taxonomy'         => 'product_cat',
                                'title_li'         => '',
                                'class'            => 'product_cat dokan-form-control',
                                'exclude'          => '',
                                'selected'         => $product_cat,
                            );

                            wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) );
                        ?>
                        </div>
                    </div>
                </div>
                <div class="dokan-clearfix"></div>
                <div class="product-full-container">
                    <div class="dokan-form-group">
                        <textarea name="post_excerpt" id="" class="dokan-form-control" rows="5" placeholder="<?php _e( 'Masukkan deskripsi singkat produk' , 'dokan-lite' ) ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="product-container-footer">
                <span class="dokan-show-add-product-error"></span>
                <span class="dokan-spinner dokan-add-new-product-spinner dokan-hide"></span>
                <input type="submit" id="dokan-create-new-product-btn" class="dokan-btn dokan-btn-default" data-btn_id="create_new" value="<?php _e( 'Buat Produk', 'dokan-lite' ) ?>">
            </div>
        </form>
    </div>
</script>
