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

$gon_options  = gon_get_global_variables();

get_header();
?>
<?php 
$blog_style = 'style1';
if(isset($gon_options['blog_style']) && $gon_options['blog_style']!=''){
	$blog_style = $gon_options['blog_style'];
}
if(isset($_GET['style']) && $_GET['style']!=''){
	$blog_style = $_GET['style'];
}

$blogsidebar = 'right';
if(isset($gon_options['sidebarblog_pos']) && $gon_options['sidebarblog_pos']!=''){
	$blogsidebar = $gon_options['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$blogsidebar = $_GET['sidebar'];
}
switch($blogsidebar) {
	case 'right':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		break;
	case 'left':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		break;
	case 'none':
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		break;
	default:
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
}
?>
<div class="main-container page-category">
	<div class="breadcrumb-blog" <?php if(!empty($gon_options['breadcrumb_background']['url'])){ ?>style="background-image: url(<?php echo esc_url($gon_options['breadcrumb_background']['url']); ?>)" <?php } ?>>
		<div class="container">
			<h3><?php echo esc_html__('Blog Creative', 'gon-cakeshop'); ?></h3>
			<?php gon_breadcrumb(); ?>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			
			<div class="row <?php if($blogsidebar=='left') { echo 'sidebar-mobile'; } ?>">
				<?php if($blogsidebar=='left') : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
				
				<div class="col-xs-12 <?php echo 'col-md-'.esc_attr($blogcolclass); ?>">
				
					<div class="page-content blog-page <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?> <?php echo esc_attr($blog_style); ?>">
					
						<?php if (have_posts()) : ?>
							<?php if (category_description()) : // Show an optional category description ?>
								<div class="archive-meta"><?php echo category_description(); ?></div>
							<?php endif; ?>
							<div class="post-wrapper">
							<?php
							/* Start the Loop */
							while (have_posts() ) : the_post();

								/* Include the post format-specific template for the content. If you want to
								 * this in a child theme then include a file called called content-___.php
								 * (where ___ is the post format) and that will be used instead.
								 */
								get_template_part('content', get_post_format());

							endwhile;
							?>
							</div>
							<div class="pagination">
								<?php gon_pagination(); ?>
							</div>
							
						<?php else : ?>
							<?php get_template_part('content', 'none'); ?>
						<?php endif; ?>
					</div>
				</div>
				
				<?php if($blogsidebar=='right') : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>
			
		</div>
	</div>
</div>

<?php get_footer(); ?>