<?php
/**
 * Dokan Dahsboard Product Listing
 * filter template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>
<?php do_action( 'dokan_product_listing_filter_before_form' ); ?>

    <form class="dokan-form-inline dokan-w6 dokan-product-date-filter" method="get" >

        <?php
        if ( isset( $_GET['outlet_search_name'] ) ) { ?>
            <input type="hidden" name="outlet_search_name" value="<?php echo $_GET['outlet_search_name']; ?>">
        <?php }
        ?>

    </form>

    <?php do_action( 'dokan_product_listing_filter_before_search_form' ); ?>

    <form method="get" class="dokan-form-inline dokan-w6 dokan-product-search-form">

        <button type="submit" name="outlet_listing_search" value="ok" class="dokan-btn dokan-btn-theme"><?php _e( 'Cari', 'woofreendor'); ?></button>

        <?php wp_nonce_field( 'woofreendor_outlet_search', 'woofreendor_outlet_search_nonce' ); ?>

        <div class="dokan-form-group">
            <input type="text" class="dokan-form-control" name="outlet_search_name" placeholder="<?php _e( 'Cari outlet', 'woofreendor' ) ?>" value="<?php echo isset( $_GET['outlet_search_name'] ) ? $_GET['outlet_search_name'] : '' ?>">
        </div>
    </form>

    <?php do_action( 'dokan_product_listing_filter_after_form' ); ?>
