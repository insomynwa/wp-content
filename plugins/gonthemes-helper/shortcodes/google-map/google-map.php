<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode Google Map
 *
 * @param $atts
 *
 * @return string
 */
function gon_shortcode_google_map( $atts ) {

	wp_enqueue_script( 'gon-google-map', GON_URL . 'js/google-map.js', array( 'jquery' ), '', true );

	$google_map = shortcode_atts(
		array(
			'title'            => esc_html__( 'Our Address', 'themes-helper' ),
			'map_center'       => '',
			'height'           => '',
			'zoom'             => '',
			'scroll_zoom'      => '',
			'draggable'        => '',
			'marker_at_center' => '',
			'marker_icon'      => '',
			'map_api'		   => 'AIzaSyBEswjEJ9Ivw2YWIx_ztXyKi3ZiO1p6mws',
			'animation'        => '',
			'el_class'         => '',
		), $atts
	);

	$animation = gon_getCSSAnimation( $google_map['animation'] );

	// Get settings
	$id     = 'map-canvas-' . md5( $google_map['map_center'] ) . '';
	$height = $google_map['height'] . 'px';
	$data   = 'data-address="' . $google_map['map_center'] . '" ';
	$data .= 'data-zoom="' . $google_map['zoom'] . '" ';
	$data .= 'data-scroll-zoom="' . $google_map['scroll_zoom'] . '" ';
	$data .= 'data-draggable="' . $google_map['draggable'] . '" ';
	$data .= 'data-marker-at-center="' . $google_map['marker_at_center'] . '" ';
	$data .= 'data-google-map-api="' . $google_map['map_api'] . '" ';

	$icon_src = wp_get_attachment_image_src( $google_map['marker_icon'] );
	$icon     = isset( $icon_src[0] ) ? $icon_src[0] : '';
	$data .= 'data-marker-icon="' . $icon . '" ';

	$class = 'google-map-canvas';

	$html = '<div class="' . $class . ' ' . $animation . ' ' . esc_attr( $google_map['el_class'] ) . '" id="' . $id . '" style="height: ' . $height . ';" ' . $data . ' ></div>';

	return $html;
}

add_shortcode( 'gon-google-map', 'gon_shortcode_google_map' );