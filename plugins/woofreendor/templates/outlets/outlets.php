<?php
$action = isset( $_GET['action'] ) ? $_GET['action'] : 'listing';

if ( $action == 'edit' ) {
    do_action( 'dokan_render_outlet_edit_template', $action );
} else {
    do_action( 'woofreendor_render_outlet_listing_template', $action );
}