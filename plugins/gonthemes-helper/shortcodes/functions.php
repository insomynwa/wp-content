<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate param type "number"
 *
 * @param $settings
 * @param $value
 *
 * @return string
 */

function gon_number_settings_field( $settings, $value ) {
	$dependency = vc_generate_dependencies_attributes( $settings );
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$min        = isset( $settings['min'] ) ? $settings['min'] : '';
	$max        = isset( $settings['max'] ) ? $settings['max'] : '';
	$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;

	return $output;
}

vc_add_shortcode_param( 'number', 'gon_number_settings_field' );

/**
 * Generate param type "radioimage"
 *
 * @param $settings
 * @param $value
 *
 * @return string
 */
function gon_radioimage_settings_field( $settings, $value ) {
	$dependency = vc_generate_dependencies_attributes( $settings );
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$radios     = isset( $settings['options'] ) ? $settings['options'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	$output     = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '_field ' . $class . '" value="' . $value . '"  ' . $dependency . ' />';
	$output .= '<div id="' . $param_name . '_wrap" class="icon_style_wrap ' . $class . '" >';
	if ( $radios != '' && is_array( $radios ) ) {
		$i = 0;
		foreach ( $radios as $key => $image_url ) {
			$class   = ( $key == $value ) ? ' class="selected" ' : '';
			$image   = '<img id="' . $param_name . $i . '_img' . $key . '" src="' . $image_url . '" ' . $class . '/>';
			$checked = ( $key == $value ) ? ' checked="checked" ' : '';
			$output .= '<input name="' . $param_name . '_option" id="' . $param_name . $i . '" value="' . $key . '" type="radio" '
			           . 'onchange="document.getElementById(\'' . $param_name . '\').value=this.value;'
			           . 'jQuery(\'#' . $param_name . '_wrap img\').removeClass(\'selected\');'
			           . 'jQuery(\'#' . $param_name . $i . '_img' . $key . '\').addClass(\'selected\');" '
			           . $checked . ' style="display:none;" />';
			$output .= '<label for="' . $param_name . $i . '">' . $image . '</label>';
			$i ++;
		}
	}
	$output .= '</div>';

	return $output;
}

vc_add_shortcode_param( 'radioimage', 'gon_radioimage_settings_field' );

/**
 * Generate param type "preview"
 *
 * @param $settings
 * @param $value
 *
 * @return string
 */

function gon_preview_settings_field( $settings, $value ) {
	$dependency = vc_generate_dependencies_attributes( $settings );

	return ' <div class="images_preview" ><img src="' . $value . '" width="300px" height="250px" />
  		<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value ' . $settings['param_name'] . ' ' . $settings['type'] . '_field"  type="hidden" value="' . $value . '" ' . $dependency . '/></div>';
}

vc_add_shortcode_param( 'preview', 'gon_preview_settings_field' );


add_filter( 'vc_iconpicker-type-simplelineicons', 'vc_iconpicker_type_simplelineicons' );
function vc_iconpicker_type_simplelineicons( $icons ) {
	$simpleline_icons = array(
		array( 'icon-user' => esc_html__( 'user', 'gonthemes-helper' ) ),
		array( 'icon-people' => esc_html__( 'people', 'gonthemes-helper' ) ),
		array( 'icon-plane' => esc_html__( 'plane', 'gonthemes-helper' ) ),
		array( 'icon-user-female' => esc_html__( 'user-female', 'gonthemes-helper' ) ),
		array( 'icon-user-follow' => esc_html__( 'user-follow', 'gonthemes-helper' ) ),
		array( 'icon-user-following' => esc_html__( 'user-following', 'gonthemes-helper' ) ),
		array( 'icon-user-unfollow' => esc_html__( 'user-unfollow', 'gonthemes-helper' ) ),
		array( 'icon-login' => esc_html__( 'login', 'gonthemes-helper' ) ),
		array( 'icon-logout' => esc_html__( 'logout', 'gonthemes-helper' ) ),
		array( 'icon-emotsmile' => esc_html__( 'emotsmile', 'gonthemes-helper' ) ),
		array( 'icon-phone' => esc_html__( 'phone', 'gonthemes-helper' ) ),
		array( 'icon-call-end' => esc_html__( 'call-end', 'gonthemes-helper' ) ),
		array( 'icon-call-out' => esc_html__( 'call-out', 'gonthemes-helper' ) ),
		array( 'icon-refresh' => esc_html__( 'refresh', 'gonthemes-helper' ) ),
		array( 'icon-earphones-alt' => esc_html__( 'earphones-alt', 'gonthemes-helper' ) ),
		array( 'icon-present' => esc_html__( 'present', 'gonthemes-helper' ) ),
		array( 'icon-location-pin' => esc_html__( 'location-pin', 'gonthemes-helper' ) ),
		array( 'icon-envelope-open' => esc_html__( 'envelope-open', 'gonthemes-helper' ) ),
	);

	return array_merge( $icons, $simpleline_icons );
}


/**
 * Register scripts
 */
function gon_register_backend_scripts() {
	wp_register_style( 'gon_simplelineicons', GON_URL . 'css/font-icon/simple-line-icons/simple-line-icons.css', false, 'screen' );
	wp_register_style( 'gon_iconbox', GON_URL . 'css/icon-box/icon-box.css', false, 'screen' );
}

add_action( 'vc_base_register_front_css', 'gon_register_backend_scripts' );
add_action( 'vc_base_register_admin_css', 'gon_register_backend_scripts' );


/**
 * Include backend scripts
 */
function gon_enqueue_backend_scripts() {
	wp_enqueue_style( 'gon_simplelineicons' );
	wp_enqueue_style( 'gon_iconbox' );
}

add_action( 'vc_backend_editor_enqueue_js_css', 'gon_enqueue_backend_scripts' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'gon_enqueue_backend_scripts' );

/**
 * Include Simple Line Icons CSS
 */
function gon_enqueue_scripts() {
	wp_enqueue_style( 'gon_simplelineicons', GON_URL . 'css/font-icon/simple-line-icons/simple-line-icons.css', false, 'screen' );
}

add_action( 'init', 'gon_enqueue_scripts' );

/**
 * Get post categories array
 *
 * @return array
 */
function gon_get_categories() {
	$args       = array(
		'type'   => 'post',
		'parent' => 0,
	);
	$categories = get_categories( $args );
	$filter     = array(
		__( 'No filter', 'gonthemes-helper' ) => '',
	);
	foreach ( $categories as $category ) {
		$filter[ $category->name ] = $category->term_id;
	}

	return $filter;
}

/**
 * Custom excerpt
 *
 * @param $length
 *
 * @return string
 */
function gon_get_the_excerpt( $length ) {
	$excerpt = get_the_excerpt();

	if ( ! $excerpt ) {
		$excerpt = esc_html__( 'Sometimes, a picture is worth a thousand words.', 'gonthemes-helper' );

		return $excerpt;
	} else {
		if ( strlen( $excerpt ) < $length ) {
			return $excerpt;
		}

		$words   = explode( ' ', $excerpt );
		$excerpt = '';

		foreach ( $words as $word ) {
			if ( strlen( $excerpt ) < $length ) {
				$excerpt .= $word . ' ';
			} else {
				break;
			}
		}
	}

	return $excerpt;
}