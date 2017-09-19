<?php

/**
 * Dokan Store Location Widget
 *
 * @since 1.0
 *
 * @package dokan
 */
class Woofreendor_Tenant_Location extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct() {
        $widget_ops = array( 'classname' => 'woofreendor-tenant-location', 'description' => __( 'Woofreendor Tenant Location', 'woofreendor' ) );
        parent::__construct( 'woofreendor-tenant-location', __( 'Woofreendor: Tenant Location', 'woofreendor' ), $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     *
     * @return void Echoes it's output
     */
    function widget( $args, $instance ) {

        if ( ! woofreendor_is_tenant_page() ) {
            return;
        }

        extract( $args, EXTR_SKIP );

        $title        = apply_filters( 'widget_title', $instance['title'] );
        $tenant_info   = woofreendor_get_tenant_info( get_query_var( 'author' ) );
        $map_location = isset( $tenant_info['location'] ) ? esc_attr( $tenant_info['location'] ) : '';
        
        if ( empty( $map_location ) ) {
            return;
        }

        echo $before_widget;

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        do_action('dokan-store-widget-before-map' , get_query_var( 'author' ));
        
        dokan_get_template_part( 'widgets/store-map', '', array(
            'store_info' => $tenant_info,
            'map_location' => $map_location,
        ) );
        
        do_action('dokan-store-widget-after-map', get_query_var( 'author' ));

        echo $after_widget;
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     *
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {

        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     *
     * @return void Echoes it's output
     */
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title' => __( 'Tenant Location', 'woofreendor' ),
        ) );

        $title = $instance['title'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'woofreendor' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }
}

add_action( 'widgets_init', create_function( '', "register_widget( 'Woofreendor_Tenant_Location' );" ) );