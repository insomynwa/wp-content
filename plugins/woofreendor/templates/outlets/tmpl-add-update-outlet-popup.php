<script type="text/html" id="tmpl-woofreendor-add-update-outlet">
    <div id="woofreendor-popup-add-outlet" class="white-popup woofreendor-popup">
        <h2 class="woofreendor_outlet_popup_title"><i class="fa fa-briefcase">&nbsp;</i>&nbsp;<?php _e( 'Manage Outlet', 'woofreendor' ); ?></h2>

        <form action="" method="post" id="woofreendor-add-update-popup-outlet-form">
            <div class="woofreendor-popup-form-container">
                <div class="content-half-part woofreendor-outlet-field-content">
                    <div class="dokan-form-group">
                        <input required type="text" class="dokan-form-control" name="outlet_name" placeholder="<?php _e( 'Nama outlet..', 'woofreendor' ); ?>">
                    </div>
                    <div class="dokan-form-group">
                        <input required type="text" class="dokan-form-control" name="outlet_username" placeholder="<?php _e( 'Username outlet..', 'woofreendor' ); ?>">
                    </div>
                    <div class="dokan-form-group">
                        <input required type="email" class="dokan-form-control" name="outlet_email" placeholder="<?php _e( 'E-mail outlet..', 'woofreendor' ); ?>">
                    </div>
                    <div class="dokan-form-group">
                        <label for="outlet_password">Password</label>
                        <input required type="password" class="dokan-form-control" name="outlet_password">
                    </div>
                </div>
                <div class="dokan-clearfix"></div>
                
            </div>
            <div id="woofreendor-popup-outlet-footer-add" class="woofreendor-popup-form-container-footer">
                <?php
                $tenant_id = get_current_user_id();
                // $tenant_group = woofreendor_get_binder_group( get_current_user_id());
                ?>
                <input type="hidden" name="outlet_action" value="">
                <input type="hidden" name="outlet_id" value="">
                <input type="hidden" name="tenant_id" value="<?php echo $tenant_id; ?>">
                <!-- <input type="hidden" name="binder_group" value="<?php //echo $tenant_group; ?>"> -->
                <span class="woofreendor-popup-error"></span>
                <span class="dokan-spinner woofreendor-popup-spinner dokan-hide"></span>
                <input type="submit" id="woofreendor-outlet-popup-btn" class="dokan-btn dokan-btn-theme" data-btn_id="create_new" value="<?php _e( 'Simpan Outlet', 'woofreendor' ) ?>">
            </div>
        </form>
    </div>
</script>
