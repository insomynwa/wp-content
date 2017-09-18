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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="postinfo-wrapper">
		<?php if (has_post_thumbnail()) { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<?php } ?>
		<div class="post-info">
			<header class="entry-header">
				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h3>
			</header>
			<div class="entry-meta-small">
				<div class="entry-date"><?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span> <span class="month">'.get_the_date('F', $post->ID).'</span>' ;?></div>
				<?php gon_entry_meta_small(); ?>
			</div>
			<div class="entry-summary">
				<div class="description"><?php echo wp_trim_words( get_the_content(), 9, '...' ); ?></div>
				<div class="read-more"><a href="<?php the_permalink(); ?>" class="more-link" rel="bookmark"><?php echo esc_html__('Read more', 'gon-cakeshop'); ?></a></div>
			</div>
		</div>
	</div>
</article>