<?php

function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );