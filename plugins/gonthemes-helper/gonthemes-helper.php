<?php
/**
 * Plugin Name: GonThemes Helper
 * Plugin URI: http://gonthemes.com
 * Description: The helper plugin for GonThemes.
 * Version: 1.0.0
 * Author: GonThemes
 * Author URI: http://gonthemes.com
 * Text Domain: gonthemes-helper
 * License: GPL/GNU.
 /*  Copyright 2014  gonthemes  (email : gonthemes@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function gon_shortcode_custom_css_class( $param_value, $prefix = '' ) {
	$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';

	return $css_class;
}

// Add shortcodes
function gon_brands_shortcode( $atts ) {
	global $bpk_options;
	$bpk_options['brand_logos'] = isset($bpk_options['brand_logos']) ? $bpk_options['brand_logos'] : '';
	$brand_index = 0;
	$brandfound=count($bpk_options['brand_logos']);

	$atts = shortcode_atts( array('rowsnumber' => '1'), $atts, 'ourbrands' );

	$rowsnumber = $atts['rowsnumber'];

	$html = '';
	
	if($bpk_options['brand_logos']) {
		$html .= '<div class="brands-carousel rows-'.$rowsnumber.'">';
			foreach($bpk_options['brand_logos'] as $brand) {
				$brand_index ++;
				
				switch ($rowsnumber) {
					case "one":
						$html .= '<div class="group">';
						break;
					case "two":
						if ( (0 == ( $brand_index - 1 ) % 2 ) || $brand_index == 1) {
							$html .= '<div class="group">';
						}
						break;
					case "four":
						if ( (0 == ( $brand_index - 1 ) % 4 ) || $brand_index == 1) {
							$html .= '<div class="group">';
						}
						break;
				}
				
				$html .= '<div class="brands-inner">';
				$html .= '<a href="'.$brand['url'].'" title="'.$brand['title'].'">';
					$html .= '<img src="'.$brand['image'].'" alt="'.$brand['title'].'" />';
				$html .= '</a>';
				$html .= '</div>';
				
				switch ($rowsnumber) {
					case "one":
						$html .= '</div>';
						break;
					case "two":
						if ( ( ( 0 == $brand_index % 2 || $brandfound == $brand_index ))  ) { /* for odd case: $cover_productsfound == $woocommerce_loop['loop'] */
							$html .= '</div>';
						}
						break;
					case "four":
						if ( ( ( 0 == $brand_index % 4 || $brandfound == $brand_index ))  ) { /* for odd case: $cover_productsfound == $woocommerce_loop['loop'] */
							$html .= '</div>';
						}
						break;
				}

			}
		$html .= '</div>';
	}
	
	return $html;
}
add_shortcode( 'ourbrands', 'gon_brands_shortcode' );

function gon_icon_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'icon' => ''
	), $atts, 'cover_icon' );
	
	$html = '<i class="fa '.$atts['icon'].'"></i>';
	
	
	return $html;
}
add_shortcode( 'themeicon', 'gon_icon_shortcode' );

//Add less compiler
function compileLessFile($input, $output, $params) {
    // include lessc.inc
    require_once( GON_PATH.'less/lessc.inc.php' );
	
	$less = new lessc;
	$less->setVariables($params);
	
    // input and output location
    $inputFile = get_template_directory().'/less/'.$input;
    $outputFile = get_template_directory().'/css/'.$output;

    $less->compileFile($inputFile, $outputFile);
}

function gon_excerpt_by_id($post, $length = 10, $tags = '<a><em><strong>') {
 
	if(is_int($post)) {
		// get the post object of the passed ID
		$post = get_post($post);
	} elseif(!is_object($post)) {
		return false;
	}
 
	if(has_excerpt($post->ID)) {
		$the_excerpt = $post->post_excerpt;
		return apply_filters('the_content', $the_excerpt);
	} else {
		$the_excerpt = $post->post_content;
	}
 
	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
	$excerpt_waste = array_pop($the_excerpt);
	$the_excerpt = implode($the_excerpt);
 
	return apply_filters('the_content', $the_excerpt);
}

function gon_blog_sharing() {
	global $post;
	
	$share_url = get_permalink( $post->ID );
	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
	$postimg = $large_image_url[0];
	$posttitle = get_the_title( $post->ID );
	?>
	<div class="widget widget_socialsharing_widget">
		<ul class="social-icons">
			<li><a class="facebook social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>'); return false;" title="<?php echo esc_html('Facebook','gonthemes-helper'); ?>" target="_blank"><i class="fa fa-facebook"></i> <?php echo esc_html('Facebook','gonthemes-helper'); ?></a></li>
			<li><a class="twitter social-icon" href="#" title="<?php echo esc_html('Twitter','gonthemes-helper'); ?>" onclick="javascript: window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>'); return false;" target="_blank"><i class="fa fa-twitter"></i> <?php echo esc_html('Twitter','gonthemes-helper'); ?></a></li>
			<li><a class="gplus social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>'); return false;" title="<?php echo esc_html('Google','gonthemes-helper'); ?>" target="_blank"><i class="fa fa-google-plus"></i> <?php echo esc_html('Google','gonthemes-helper'); ?></a></li>
			<li><a class="pinterest social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>'); return false;" title="<?php echo esc_html('Pinterest','gonthemes-helper'); ?>" target="_blank"><i class="fa fa-pinterest"></i> <?php echo esc_html('Pinterest','gonthemes-helper'); ?></a></li>
		</ul>
	</div>
	<?php
}

function gon_product_sharing() {

	if(isset($_POST['data'])) { // for the quickview
		$postid = intval( $_POST['data'] );
	} else {
		$postid = get_the_ID();
	}
	
	$share_url = get_permalink( $postid );

	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
	$postimg = $large_image_url[0];
	$posttitle = get_the_title( $postid );
	?>
	<div class="widget widget_socialsharing_widget">
		<ul class="social-icons">
			<li><a class="facebook social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>'); return false;" title="<?php echo esc_html('Facebook','gonthemes-helper'); ?>" target="_blank"><i class="fa fa-facebook"></i> <?php echo esc_html('Facebook','gonthemes-helper'); ?></a></li>
			<li><a class="twitter social-icon" href="#" title="<?php echo esc_html('Twitter','gonthemes-helper'); ?>" onclick="javascript: window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>'); return false;" target="_blank"><i class="fa fa-twitter"></i> <?php echo esc_html('Twitter','gonthemes-helper'); ?></a></li>
			<li><a class="gplus social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>'); return false;" title="<?php echo esc_html('Google','gonthemes-helper'); ?>" target="_blank"><i class="fa fa-google-plus"></i> <?php echo esc_html('Google','gonthemes-helper'); ?></a></li>
			<li><a class="pinterest social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>'); return false;" title="<?php echo esc_html('Pinterest','gonthemes-helper'); ?>" target="_blank"><i class="fa fa-pinterest"></i> <?php echo esc_html('Pinterest','gonthemes-helper'); ?></a></li>
		</ul>
	</div>
	<?php
}

function gon_getCSSAnimation( $css_animation ) {
	$output = '';
	if ( $css_animation != '' ) {
		wp_enqueue_script( 'waypoints' );
		$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
	}

	return $output;
}

/**
 * Translations
 */
define( 'GON_PATH', plugin_dir_path( __FILE__ ) );
define( 'GON_URL', plugin_dir_url( __FILE__ ) );

function gon_init() {
	// Depend on Visual Composer
	if ( ! class_exists( 'Vc_Manager' ) ) {
		return;
	}

	// Prepare translation
	$locale        = apply_filters( 'plugin_locale', get_locale(), 'gonthemes-helper' );
	$lang_dir      = GON_PATH . 'languages/';
	$mofile        = sprintf( '%s.mo', $locale );
	$mofile_local  = $lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		load_textdomain( 'gonthemes-helper', $mofile_global );
	} else {
		load_textdomain( 'gonthemes-helper', $mofile_local );
	}
	$prefix = basename( dirname( plugin_basename( __FILE__ ) ) );
	$locale = get_locale();
	$dir    = GON_PATH . 'languages/';
	$mofile = false;

	$globalFile = WP_LANG_DIR . '/plugins/' . $prefix . '-' . $locale . '.mo';
	$pluginFile = $dir . '/' . $prefix . '-' . $locale . '.mo';

	if ( file_exists( $globalFile ) ) {
		$mofile = $globalFile;
	} else if ( file_exists( $pluginFile ) ) {
		$mofile = $pluginFile;
	}
	if ( $mofile ) {
		// In themes/plugins/mu-plugins directory
		load_textdomain( 'gonthemes-helper', $mofile );
	}

	// Map shortcodes to Visual Composer
	require_once( GON_PATH . 'shortcodes/vc-map.php' );

	// Register new parameters for shortcodes
	require_once( GON_PATH . 'shortcodes/functions.php' );

	// Embed stuff for Visual Composer
	require_once( GON_PATH . 'shortcodes/vc-embed.php' );
	
	require_once( GON_PATH . 'shortcodes/counter-box/counter-box.php' );
	require_once( GON_PATH . 'shortcodes/icon-box/icon-box.php' );
	require_once( GON_PATH . 'shortcodes/google-map/google-map.php' );
	require_once( GON_PATH . 'shortcodes/product-category/product-category.php' );
	require_once( GON_PATH . 'shortcodes/list-product/list-product.php' );
	require_once( GON_PATH . 'shortcodes/post-category/post-category.php' );
}

add_action( 'plugins_loaded', 'gon_init' );