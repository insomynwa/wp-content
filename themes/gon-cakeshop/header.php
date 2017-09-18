<?php
/**
 * @version    1.0
 * @package    GonThemes
 * @author     GonThemes <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2017 GonThemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.com
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<?php 
	$gon_options  = gon_get_global_variables();
	$woocommerce 	= gon_get_global_variables('woocommerce');  
	$gon_options['page_style'] = isset($gon_options['page_style']) ? $gon_options['page_style'] : '';
	$gon_options['header_layout'] = isset($gon_options['header_layout']) ? $gon_options['header_layout'] : 'layout-1';
	$gon_options['gon_loading'] = isset($gon_options['gon_loading']) ? $gon_options['gon_loading'] : false;
?>

<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>

<!-- Body Start Block -->
<body <?php body_class(); ?>>

<!-- Page Loader Block -->
<?php if ($gon_options['gon_loading']) : ?>
<div id="pageloader">
	<div id="loader"></div>
	<div class="loader-section left"></div>
	<div class="loader-section right"></div>
</div>
<?php endif; ?>

<?php 
	$layout_class = "";
	if($gon_options['header_layout']=='layout-2'){
		$layout_class = 'layout-2';
	}
?>
<div id="yith-wcwl-popup-message"><div id="yith-wcwl-message"></div></div>
<div class="wrapper <?php echo esc_attr($layout_class); ?> <?php if($gon_options['page_style']=='box'){echo 'box-layout';}?>">
	<?php
		if ( $gon_options['header_layout']=='layout-1' || !isset($gon_options['header_layout'])) {
			get_header('layout-1');
		} else {
			get_header($gon_options['header_layout']);
		}
	?>
