<?php

/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 15/9/2015
 * Time: 3:17 PM
 */
class GonThemes_Recent_Posts_Widget extends WP_Widget {

	// Constructor
	function __construct() {
		parent::__construct(
			'gon_recent_posts',
			__( 'GonThemes: Recent posts', 'gon-cakeshop' ),
			array( 'description' => esc_html__( 'Display recent posts', 'gon-cakeshop' ), )
		);
	}

	public function form( $instance ) {

		//Check values
		if ( $instance && $instance['number_posts'] && $instance['number_posts'] != '' ) {
			$number_posts = $instance['number_posts'];
			$title_widget = $instance['title_widget'];
			$display_time = $instance['display_time'];

			if ( $display_time != '' ) {
				$checked_display_time = 'checked="checked"';
			} else {
				$checked_display_time = '';
			}
		} else {
			//Default value
			$number_posts         = 3;
			$title_widget         = 'Recent posts';
			$checked_display_time = 'checked="checked"';
		}

		?>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id( 'title_widget' )); ?>"><?php esc_html_e( 'Title:', 'gon-cakeshop' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'title_widget' )); ?>"
			       name="<?php echo esc_attr($this->get_field_name( 'title_widget' )); ?>"
			       value="<?php echo esc_attr($title_widget); ?>">
		</p>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id( 'number_posts' )); ?>"><?php esc_html_e( 'Number of recent posts to show:', 'gon-cakeshop' ); ?></label>
			<input class="widefat" type="number" id="<?php echo esc_attr($this->get_field_id( 'number_posts' )); ?>"
			       name="<?php echo esc_attr($this->get_field_name( 'number_posts' )); ?>"
			       value="<?php echo esc_attr($number_posts); ?>">
		</p>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id( 'display_time' )); ?>"><?php esc_html_e( 'Display post date:', 'gon-cakeshop' ); ?></label>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'display_time' )); ?>"
			       name="<?php echo esc_attr($this->get_field_name( 'display_time' )); ?>"
				<?php echo esc_attr($checked_display_time); ?>>
		</p>
		<?php
	}

	// Update widget
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// Fields
		$instance['number_posts'] = strip_tags( $new_instance['number_posts'] );
		$instance['title_widget'] = strip_tags( $new_instance['title_widget'] );
		$instance['display_time'] = strip_tags( $new_instance['display_time'] );

		return $instance;
	}

	// Display widget
	public function widget( $args, $instance ) {
		echo ent2ncr($args['before_widget']);
		if ( !empty ( $instance['title_widget'] ) ) {
			echo ent2ncr($args['before_title'] . $instance['title_widget'] . $args['after_title']);
		}
		if ( !empty( $instance['number_posts'] ) ) {
			//Query
			$args_query = array(
				'post_type'      => 'post',
				'posts_per_page' => $instance['number_posts'],
				'order'          => 'DESC'
			);

			echo '<ul>';
			$query = new WP_Query( $args_query );
			while ( $query->have_posts() ) {
				$query->the_post(); ?>

				<li>
					<div class="post_thumbnail">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_post_thumbnail(array(70, 70)); ?></a>
					</div>
					<div class="post_info">
						<?php if ( $instance['display_time'] && $instance['display_time'] == 'on' ) { ?>
							<div
								class="time"><?php printf( esc_html__( '%s', 'gon-cakeshop' ), get_the_date( 'M d, Y' ) ); ?></div>
						<?php } ?>
						<div class="title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"
							   title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a>
						</div>
					</div>
				</li>

			<?php }
			echo '</ul>';

			wp_reset_postdata();
		}
		echo ent2ncr($args['after_widget']);
	}
}

// Register and load the widget
function gon_register_widget_recent_posts() {
	register_widget( 'GonThemes_Recent_Posts_Widget' );
}

add_action( 'widgets_init', 'gon_register_widget_recent_posts' );