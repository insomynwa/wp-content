<?php

function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

// Override the default specification for product # per row

add_filter('storefront_loop_columns', 'loop_columns',999);

if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 5; // 2 products per row
	}
}

add_action( 'init', 'child_theme_init' );
function child_theme_init() {
	add_action( 'storefront_before_content', 'woa_add_full_slider', 5 );
}

function woa_add_full_slider() { ?>
	<div id="slider">
		<?php echo do_shortcode("[metaslider id=390 percentwidth=100 restrict_to=home]"); ?>
	</div>
<?php
}

// Remove homepage section

function remove_storefront_homepage_content(){
	remove_action( 'homepage', 'storefront_homepage_content', 10 );
}

add_action( 'init', 'remove_storefront_homepage_content');

function remove_storefront_product_categories(){
	remove_action( 'homepage', 'storefront_product_categories', 20 );
}

add_action( 'init', 'remove_storefront_product_categories' );


