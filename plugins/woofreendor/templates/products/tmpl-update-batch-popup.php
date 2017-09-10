<script type="text/html" id="tmpl-update-batch-popup">
    <div id="woofreendor-update-batch-popup" class="white-popup dokan-add-new-product-popup">
        <h2><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Update Batch', 'dokan-lite' ); ?></h2>

        <form action="" method="post" id="woofreendor-update-batch-form">
            <div class="product-form-container">
                <div class="woofreendor_date_fields dokan-form-group">
                    <div class="product-full-container">
                        <h3 class="batch_id_title"></h3>
                    </div>
                    <div class="content-half-part from">
                        <div class="dokan-input-group">
                            <span class="dokan-input-group-addon"><?php _e( 'Produksi', 'dokan-lite' ); ?></span>
                            <input type="text" name="batch_start" class="dokan-form-control datepicker woofreendor_batch_start" value="" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php _e( 'Tanggal (YYYY-MM-DD)', 'dokan-lite' ); ?>">
                        </div>
                    </div>
                    <div class="content-half-part to">
                        <div class="dokan-input-group">
                            <span class="dokan-input-group-addon"><?php _e( 'Kadaluarsa', 'dokan-lite' ); ?></span>
                            <input type="text" name="batch_end" class="dokan-form-control datepicker woofreendor_batch_end" value="" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php _e( 'Tanggal (YYYY-MM-DD)', 'dokan-lite' ); ?>">
                        </div>
                    </div>
                </div>
                <div class="dokan-clearfix"></div>
                <div class="woofreendor_number_fields dokan-form-group">
                    <div class="content-half-part from">
                        <div class="dokan-input-group">
                            <span class="dokan-input-group-addon"><?php _e( 'Stok', 'dokan-lite' ); ?></span>
                            <input id='' type="number" name='batch_stock' placeholder='<?php _e( 'Stok', 'dokan-lite' ); ?>' class="form-control" value="" min="0"/>
                        </div>
                    </div>
                    <div class="content-half-part to">
                        <div class="dokan-input-group">
                            <span class="dokan-input-group-addon"><?php _e( "Harga (".get_woocommerce_currency_symbol().")", 'dokan-lite' ); ?></span>
                            <input id='' type="number" name='batch_price' placeholder='<?php _e( 'Harga', 'dokan-lite' ); ?>' class="form-control" value="" min="0"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="batch-container-footer">
                <input type="hidden" name="product_id">
                <input type="hidden" name="batch_id">
                <span class="woofreendor-show-add-batch-error"></span>
                <span class="dokan-spinner woofreendor-update-batch-spinner dokan-hide"></span>
                <input type="submit" id="woofreendor-update-batch-btn" class="dokan-btn dokan-btn-theme" data-btn_id="update_batch" value="<?php _e( 'Simpan Batch', 'dokan-lite' ) ?>">
            </div>
        </form>
    </div>
</script>
