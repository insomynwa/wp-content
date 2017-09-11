<?php
/**
 * Setup wizard class
 *
 * Walkthrough to the basic setup upon installation
 */

/**
 * The class
 */
class Woofreendor_Setup_Wizard {

    /**
     * Hook in tabs.
     */
    public function __construct() {
        if ( current_user_can( 'manage_options' ) ) {
            add_action( 'admin_init', array( $this, 'setup_wizard' ), 99 );
        }
    }

    /**
     * Show the setup wizard.
     */
    public function setup_wizard() {
        $options = get_option( 'woofreendor_general', [] );

        $options['custom_tenant_url']    = 'tenant';

        update_option( 'woofreendor_general', $options );
    }
}

new Woofreendor_Setup_Wizard();
