<?php
//Shortcodes for Visual Composer
add_action('vc_before_init', 'gon_vc_shortcodes');
function gon_vc_shortcodes() {
	//Brand logos
	vc_map(array(
		"name" => esc_html__("Brand Logos", "gon-cakeshop"),
		"base" => "ourbrands",
		"class" => "",
		"category" => esc_html__("GonThemes Helper", "gon-cakeshop"),
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Number of rows", "gon-cakeshop"),
				"param_name" => "rowsnumber",
				"value" => array(
						'one'	=> 'one',
						'two'	=> 'two',
						'four'	=> 'four',
					),
			),
		)
	));
	
	//Testimonials
	vc_map( array(
		"name" => esc_html__( "Testimonials", "gon-cakeshop" ),
		"base" => "woothemes_testimonials",
		"class" => "",
		"category" => esc_html__( "GonThemes Helper", "gon-cakeshop"),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Number of testimonial", "gon-cakeshop" ),
				"param_name" => "limit",
				"value" => esc_html__( "10", "gon-cakeshop" ),
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Image size", "gon-cakeshop" ),
				"param_name" => "size",
				"value" => esc_html__( "120", "gon-cakeshop" ),
			),
		)
	) );
	
	//Icons
	vc_map(array(
		"name" => esc_html__("FontAwesome Icon", "gon-cakeshop"),
		"base" => "themeicon",
		"class" => "",
		"category" => esc_html__("GonThemes Helper", "gon-cakeshop"),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => esc_html__("FontAwesome Icon", "gon-cakeshop"),
				"description" => wp_kses(__("<a href=\"http://fortawesome.github.io/Font-Awesome/cheatsheet/\" target=\"_blank\">Go here</a> to get icon class. Example: fa-search", "gon-cakeshop"), array('a' => array('href' => array(),'title' => array(), 'target' => array()))),
				"param_name" => "icon",
				"value" => esc_html__("fa-search", "gon-cakeshop"),
			),
		)
	));
}

?>