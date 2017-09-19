<?php

$batches = woofreendor_get_batches($paramData);

foreach($batches as $batch){
    $meta_batch_startdate = get_post_meta( $batch->ID, 'attribute_produksi', true ); 
    $meta_batch_endate = get_post_meta( $batch->ID, 'attribute_kadaluarsa', true );
    $meta_batch_stock = get_post_meta( $batch->ID, '_stock', true );
    $meta_batch_price = get_post_meta( $batch->ID, '_regular_price', true );
?>
<tr<?php if(isset($tr_class)) echo $tr_class; ?> id="batch_row_<?php echo $batch->ID; ?>">
    <td>
        <h4><?php _e( '#' . $batch->ID, 'dokan-lite'); ?></h4>
    </td>
    <td><h4><?php _e( $meta_batch_startdate, 'dokan-lite' ); ?></h4>
        <input type="hidden" name="batch_startdate_<?php echo $batch->ID; ?>" value="<?php _e( $meta_batch_startdate, 'dokan-lite' ); ?>">
    </td>
    <td><h4><?php _e( $meta_batch_endate, 'dokan-lite' ); ?></h4>
        <input type="hidden" name="batch_enddate_<?php echo $batch->ID; ?>" value="<?php echo $meta_batch_endate; ?>">
    </td>
    <td><h4><?php _e( $meta_batch_stock, 'dokan-lite' ); ?></h4>
        <input type="hidden" name="batch_stock_<?php echo $batch->ID; ?>" value="<?php  echo $meta_batch_stock; ?>">
    </td>
    <td><h4><?php _e( $meta_batch_price, 'dokan-lite' ); ?></h4>
        <input type="hidden" name="batch_price_<?php echo $batch->ID; ?>" value="<?php echo $meta_batch_price; ?>">
    </td>
    <td>
        <a href="#" class="dokan-btn dokan-btn-theme woofreendor_update_batch" data-product_id="<?php echo $paramData; ?>" data-batch_id="<?php echo $batch->ID; ?>"><?php _e( 'Update', 'dokan' ) ?></a>
    </td>
    <td>
        <a href="#" class="dokan-btn dokan-btn-default dokan-btn-sm woofreendor_delete_batch" data-product_id="<?php echo $paramData; ?>" data-batch_id="<?php echo $batch->ID; ?>"><?php _e( 'Hapus', 'dokan' ) ?></a>
    </td>
</tr>
<?php
}
?>