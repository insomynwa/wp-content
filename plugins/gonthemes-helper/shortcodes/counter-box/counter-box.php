<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode Counter Box
 *
 * @param $atts
 *
 * @return string
 */
function gon_shortcode_counter_box( $atts ) {

	wp_enqueue_script( 'gon-counter-box', GON_URL . 'js/counter-box.js', array( 'jquery' ), '', true );

	$counter_box = shortcode_atts( array(
		'number'       => '',
		'number_color' => '',
		'text'         => '',
		'text_color'   => '',
		'b_color'      => '',
		'el_class'     => '',
	), $atts );
	$html        = '';

	$circle_color = '';
	if ( $counter_box['b_color'] ) {
		$circle_color = 'style = background-color:' . $counter_box['b_color'] . '; ';
	}


	$number_color = '';
	if ( $counter_box['number_color'] ) {
		$number_color = 'style = color:' . $counter_box['number_color'] . '; ';
	}

	$text_color = '';
	if ( $counter_box['text_color'] ) {
		$text_color = 'style = color:' . $counter_box['text_color'] . '; ';
	}

	$html .=
		'<div class="result-box ' . esc_attr( $counter_box['el_class'] ) . '" ' . $circle_color . '>
			<div class="statistic">
				<div class="number" ' . $number_color . '>
					<span class="timer" data-from="0" data-to="' . $counter_box['number'] . '">"'.$counter_box['number'] .'"</span>
					<span class="counter-text" ' . $text_color . '>' . esc_attr( $counter_box['text'] ) . '</span>
				</div>
				
			</div>
		</div>';

	return $html;
}

add_shortcode( 'gon-counter-box', 'gon_shortcode_counter_box' );
