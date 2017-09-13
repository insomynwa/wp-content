<?php
//wp_widget_rss_output
function dokan_admin_dash_metabox( $title = '', $callback = null ) {
    ?>
    <div class="postbox">
        <h3 class="hndle"><span><?php echo esc_html( $title ); ?></span></h3>
        <div class="inside">
            <div class="main">
                <?php if ( is_callable( $callback ) ) {
                    call_user_func( $callback );
                } ?>
            </div> <!-- .main -->
        </div> <!-- .inside -->
    </div> <!-- .postbox -->
    <?php
}

function dokan_admin_dash_metabox_report() {
    dokan_admin_report();
    ?>
    <div class="chart-container">
        <div class="chart-placeholder main" style="width: 100%; height: 350px;"></div>
    </div>
    <?php
}

function dokan_admin_dash_metabox_glance() {
    $user_count      = count_users();
    $withdraw_counts = dokan_get_withdraw_count();
    $outlet_counts   = dokan_get_seller_count();
    $total_tenant    = isset( $user_count['avail_roles']['woofreendor_tenant_role'] ) ? $user_count['avail_roles']['woofreendor_tenant_role'] : 0;
    $total_outlet    = isset( $user_count['avail_roles']['seller'] ) ? $user_count['avail_roles']['seller'] : 0;
    ?>

    <div class="dokan-left">
        <h4><?php _e( 'Store', 'woofreendor' ); ?></h4>

        <ul>
            <li class="seller-count">
                <div class="dashicons dashicons-businessman"></div>
                <a href="<?php echo admin_url( 'admin.php?page=woofreendor-tenants' ); ?>"><?php printf( _n( __( '%d Total Tenant', 'woofreendor' ), __( '%d Total Tenant', 'woofreendor' ), $total_tenant, 'woofreendor' ), $total_tenant ); ?></a>
            </li>
            <li class="seller-count">
                <div class="dashicons dashicons-businessman"></div>
                <a href="<?php echo WeDevs_Dokan::init()->is_pro_exists() ? admin_url( 'admin.php?page=dokan-sellers' ) : ''; ?>"><?php printf( _n( __( '%d Total Outlet', 'woofreendor' ), __( '%d Total Outlet', 'woofreendor' ), $total_outlet, 'woofreendor' ), $total_outlet ); ?></a>
            </li>
            <li class="seller-count mark-green">
                <div class="dashicons dashicons-awards"></div>
                <a href="<?php echo WeDevs_Dokan::init()->is_pro_exists() ? admin_url( 'admin.php?page=dokan-sellers' ) : ''; ?>">
                    <?php
                    if ( $outlet_counts['active'] ) {
                        printf( _n( __( '%d Active Outlet', 'woofreendor' ), __( '%d Active Outlets', 'woofreendor' ), $outlet_counts['active'], 'woofreendor' ), $outlet_counts['active'] );
                    } else {
                        _e( 'No Active Outlet', 'woofreendor' );
                    }  ?>
                </a>
            </li>
            <li class="seller-count <?php echo ($outlet_counts['inactive'] < 1) ? 'mark-green' : 'mark-red'; ?>">
                <div class="dashicons dashicons-editor-help"></div>
                <a href="<?php echo WeDevs_Dokan::init()->is_pro_exists() ? admin_url( 'admin.php?page=dokan-sellers' ) : ''; ?>">
                    <?php
                    if ( $outlet_counts['inactive'] ) {
                        printf( _n( __( '%d Pending Outlet', 'woofreendor' ), __( '%d Pending Outlets', 'woofreendor' ), $outlet_counts['inactive'], 'woofreendor' ), $outlet_counts['inactive'] );
                    } else {
                        _e( 'No Pending Outlet', 'woofreendor' );
                    }  ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="dokan-right">
        <h4><?php _e( 'Withdraw', 'woofreendor' ); ?></h4>

        <ul>
            <li class="withdraw-pending <?php echo ($withdraw_counts['pending'] < 1) ? 'mark-green' : 'mark-red'; ?>">
                <div class="dashicons dashicons-visibility"></div>
                <a href="<?php echo WeDevs_Dokan::init()->is_pro_exists() ? admin_url( 'admin.php?page=dokan-withdraw' ) : ''; ?>"><?php printf( __( '%d Pending Withdraw', 'woofreendor' ), $withdraw_counts['pending'] ); ?></a>
            </li>
            <li class="withdraw-completed mark-green">
                <div class="dashicons dashicons-yes"></div>
                <a href="<?php echo WeDevs_Dokan::init()->is_pro_exists() ? admin_url( 'admin.php?page=dokan-withdraw&amp;status=completed' ) : ''; ?>"><?php printf( __( '%d Completed Withdraw', 'woofreendor' ), $withdraw_counts['completed'] ); ?></a>
            </li>
            <li class="withdraw-cancelled">
                <div class="dashicons dashicons-dismiss"></div>
                <a href="<?php echo WeDevs_Dokan::init()->is_pro_exists() ? admin_url( 'admin.php?page=dokan-withdraw&amp;status=cancelled' ) : ''; ?>"><?php printf( __( '%d Cancelled Withdraw', 'woofreendor' ), $withdraw_counts['cancelled'] ); ?></a>
            </li>
        </ul>
    </div>

    <?php
}

?>
<div class="wrap dokan-dashboard">

    <h2><?php _e( 'Woofreendor Dashboard', 'woofreendor' ); ?></h2>

    <div class="metabox-holder">
        <div class="post-box-container">
            <div class="meta-box-sortables">
                <?php dokan_admin_dash_metabox( __( 'At a Glance', 'woofreendor' ), 'dokan_admin_dash_metabox_glance' ); ?>

                <?php do_action( 'dokan_admin_dashboard_metabox_left' ); ?>
            </div>
        </div> <!-- .post-box-container -->

        <div class="post-box-container">
            <div class="meta-box-sortables">
                <?php dokan_admin_dash_metabox( __( 'Overview', 'woofreendor' ), 'dokan_admin_dash_metabox_report' ); ?>

                <?php do_action( 'dokan_admin_dashboard_metabox_right' ); ?>
            </div>
        </div> <!-- .post-box-container -->

    </div> <!-- .metabox-holder -->

</div> <!-- .wrap -->