<script type="text/html" id="tmpl-delete-batch-popup">
    <div id="woofreendor-delete-batch-popup" class="white-popup dokan-add-new-product-popup">
        <h2><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Hapus Batch', 'dokan-lite' ); ?></h2>

        <form action="" method="post" id="woofreendor-delete-batch-form">
            <div class="product-form-container">
                <div class="woofreendor_date_fields dokan-form-group">
                    <div class="product-full-container">
                        <h3 class="batch_id_title"></h3>
                    </div>
                </div>
            </div>
            <div class="batch-container-delete-footer">
                <input type="hidden" name="product_id">
                <input type="hidden" name="batch_id">
                <span class="woofreendor-show-add-batch-error"></span>
                <span class="dokan-spinner woofreendor-delete-batch-spinner dokan-hide"></span>
                <input type="submit" id="woofreendor-delete-batch-btn" class="dokan-btn dokan-btn-theme" data-btn_id="delete_batch" value="<?php _e( 'Hapus Batch', 'dokan-lite' ) ?>">
            </div>
        </form>
    </div>
</script>
