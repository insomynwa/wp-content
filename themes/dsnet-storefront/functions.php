<?php

// Override the default specification for product # per row

add_filter('storefront_loop_columns', 'loop_columns',999);

if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 5; // 2 products per row
	}
}


