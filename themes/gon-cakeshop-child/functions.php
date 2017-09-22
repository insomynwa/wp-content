<?php
/**
 * @version    1.0
 * @package    Gon CakeShop
 * @author     GonThemes
 * @copyright  Copyright (C) 2015 GonThemes Team. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.com/cakeshop/
 */

add_action('wp_enqueue_scripts', 'gon_child_enqueue_styles', 10000);
function gon_child_enqueue_styles() {
    wp_enqueue_style('gon-child-style', get_stylesheet_directory_uri() . '/style.css' );
}

// Before VC Init
add_action( 'vc_before_init', 'vc_before_init_actions' );
 
function vc_before_init_actions() {
     
    //var_dump(get_stylesheet_directory());
    require_once(get_stylesheet_directory().'/vc-elements/vcInfoBox.php' ); 
     
}