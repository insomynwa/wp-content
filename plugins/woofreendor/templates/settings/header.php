<?php
/**
 * Dokan Settings Header Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>
<header class="dokan-dashboard-header">
    <h1 class="entry-title">
        <?php echo $heading; ?>
        <small>&rarr; <a href="<?php echo woofreendor_get_tenant_url( get_current_user_id() ); ?>"><?php _e( 'Visit', 'woofreendor' ); ?></a></small>
    </h1>
</header><!-- .dokan-dashboard-header -->
