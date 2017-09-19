<script type="text/html" id="tmpl-dokan-add-new-product">
    <div id="dokan-add-new-product-popup" class="white-popup dokan-add-new-product-popup">
        <h2><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Tambah Produk', 'woofreendor' ); ?></h2>
        <?php
        $outlet_owner_id = woofreendor_get_outlet_owner_id( get_current_user_id() );
        $owner_products = woofreendor_get_tenant_products( $outlet_owner_id );
        ?>
        <form action="" method="post" id="dokan-add-new-product-form">
            <div class="product-form-container">
                <div class="dokan-form-group btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         -Pilih Produk- <span class="glyphicon glyphicon-chevron-down"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($owner_products['products'] as $product): ?>
                        <li><a data-product_id="<?php echo $product->ID; ?>" class="woofreendor-select-product" href="#"><img width="40" height="40" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id($product->ID), 'thumbnail' )[0]; ?>" /><?php echo $product->post_title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="content-half-part dokan-feat-image-content">
                    <div class="dokan-feat-image-upload">
                        <div class="image-wrap">
                            <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $feat_image_id; ?>">
                            <img id="woofreendor_tenant_product_img_popup" height="" width="" src="" alt="">
                        </div>
                    </div>
                </div>
                <div class="content-half-part dokan-product-field-content">
                    <div class="dokan-form-group">
                        <input readonly type="text" class="dokan-form-control" name="post_title" placeholder="<?php _e( 'Nama produk..', 'woofreendor' ); ?>">
                    </div>

                    <div class="dokan-clearfix">
                        <input type="hidden" class="dokan-form-control" name="_regular_price" value="0">
                        <input type="hidden" class="dokan-form-control" name="product_parent" value="0">
                        <input type="hidden" class="dokan-form-control" name="_sale_price" value="0">
                        <input id="product_cat" type="hidden" class="dokan-form-control" name="product_cat" value="">
                    </div>
                </div>
                <div class="dokan-clearfix"></div>
                <div class="product-full-container">
                    <div class="dokan-form-group">
                        <textarea readonly name="post_excerpt" id="" class="dokan-form-control post_excerpt" rows="5" placeholder="<?php _e( 'Deskripsi singkat produk' , 'woofreendor' ) ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="product-container-footer">
                <span class="dokan-show-add-product-error"></span>
                <span class="dokan-spinner dokan-add-new-product-spinner dokan-hide"></span>
                <input type="submit" id="dokan-create-new-product-btn" class="dokan-btn dokan-btn-default" data-btn_id="create_new" value="<?php _e( 'Buat Produk', 'woofreendor' ) ?>">
            </div>
        </form>
    </div>
</script>
<script type="text/javascript">
    (function($) {
        var product_selector = $( 'a.woofreendor-select-product' );
        $('body').on('click','a.woofreendor-select-product',function(e){
            e.preventDefault();
            var product_id = $(this).attr('data-product_id');
            var data_product = {
                product: product_id,
                action: 'woofreendor_get_product_data',
                security: woofreendor.product_data_nonce
            };
            $("input#dokan-create-new-product-btn").attr('disabled',true);
            $.get( woofreendor.ajaxurl, data_product, function( resp ) {
                if ( resp.success ) {
                    //console.log(resp.data.image_id);
                    $("input[name='product_parent']").val(resp.data.product.ID);
                    $("input[name='post_title']").val(resp.data.product.post_title);
                    $("input[name='feat_image_id']").val(resp.data.image_id);
                    $("img#woofreendor_tenant_product_img_popup").attr('src',resp.data.image_url);
                    $("textarea.post_excerpt").val(resp.data.product.post_excerpt).attr('readonly',true);
                    $("input[name='product_cat']").val(resp.data.term);
                    $("input#dokan-create-new-product-btn").attr('disabled',false);
                } else {
                    
                }
                
            });
        });
    })(jQuery);
</script>
