<?php

/**
 * Dokan Dashboard Template
 *
 * Dokan Dashboard Product widget template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<div class="dashboard-widget products">
    <div class="widget-title">
        <i class="fa fa-briefcase" aria-hidden="true"></i> <?php _e( 'Outlets', 'woofreendor' ); ?>

        <!-- <span class="pull-right">
            <a href="<?php // echo woofreendor_get_navigation_url( 'new-outlet' ); ?>"><?php //_e( '+ Add new outlet', 'woofreendor' ); ?></a>
        </span> -->
    </div>

    <ul class="list-unstyled list-count">
        <li>
            <a href="<?php echo $outlets_url; ?>">
                <span class="title"><?php _e( 'Total', 'woofreendor' ); ?></span> <span class="count"><?php echo $outlet_counts->total; ?></span>
            </a>
        </li>
        <!-- <li>
            <a href="<?php //echo add_query_arg( array( 'post_status' => 'publish' ), $outlets_url ); ?>">
                <span class="title"><?php //_e( 'Live', 'woofreendor' ); ?></span> <span class="count"><?php //echo $outlet_counts->publish; ?></span>
            </a>
        </li>
        <li>
            <a href="<?php //echo add_query_arg( array( 'post_status' => 'draft' ), $outlets_url ); ?>">
                <span class="title"><?php //_e( 'Offline', 'woofreendor' ); ?></span> <span class="count"><?php //echo $outlet_counts->draft; ?></span>
            </a>
        </li>
        <li>
            <a href="<?php //echo add_query_arg( array( 'post_status' => 'pending' ), $outlets_url ); ?>">
                <span class="title"><?php //_e( 'Pending Review', 'woofreendor' ); ?></span> <span class="count"><?php //echo $outlet_counts->pending; ?></span>
            </a>
        </li> -->
    </ul>
</div> <!-- .products -->
