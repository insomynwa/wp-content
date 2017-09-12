<script type="text/html" id="tmpl-delete-outlet-popup">
    <div id="woofreendor-delete-outlet-popup" class="white-popup dokan-add-new-product-popup">
        <h2><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Hapus Outlet', 'woofreendor' ); ?></h2>

        <form action="" method="post" id="woofreendor-popup-delete-outlet-form">
            <div class="product-form-container">
                <div class="woofreendor_date_fields dokan-form-group">
                    <div class="product-full-container">
                        <h3 class="outlet_title"></h3>
                    </div>
                </div>
            </div>
            <div id="woofreendor-popup-outlet-delete-footer" class="outlet-container-delete-footer">
                <?php
                $tenant_id = get_current_user_id();
                ?>
                <input type="hidden" name="tenant_id" value="<?php echo $tenant_id; ?>">
                <input type="hidden" name="outlet_id">
                <span class="woofreendor-show-add-outlet-error"></span>
                <span class="dokan-spinner woofreendor-delete-outlet-spinner dokan-hide"></span>
                <input type="submit" id="woofreendor-delete-outlet-btn" class="dokan-btn dokan-btn-theme" data-btn_id="delete_outlet" value="<?php _e( 'Hapus Outlet', 'woofreendor' ) ?>">
            </div>
        </form>
    </div>
</script>
