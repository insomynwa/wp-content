<?php

if ( !class_exists( 'Dokan_Settings_API' ) ) {
    require_once DOKAN_LIB_DIR . '/class.dokan-settings-api.php';
}

/**
 * WordPress settings API For Dokan Admin Settings class
 *
 * @author Tareq Hasan
 */
class Dokan_Admin_Settings {

    private $settings_api;

    /**
     * Constructor for the Dokan_Admin_Settings class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @return void
     */
    function __construct() {
        $this->settings_api = new Dokan_Settings_API();

        add_action( 'admin_init', array($this, 'do_updates') );
        add_action( 'admin_init', array($this, 'admin_init') );

        add_action( 'admin_menu', array($this, 'admin_menu') );

        add_action( 'admin_head', array( $this, 'welcome_page_remove' ) );

        add_action( 'admin_notices', array($this, 'update_notice' ) );
        // add_action( 'admin_notices', array($this, 'promotional_offer' ) );

        add_action( 'wp_before_admin_bar_render', array( $this, 'dokan_admin_toolbar' ) );
    }

    /**
     * Added promotion notice
     *
     * @since  2.5.6
     *
     * @return void
     */
    public function promotional_offer() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // check if it has already been dismissed
        $offer_key = 'dokan_4th_yr_aniv_44_perc_discount';
        $hide_notice = get_option( $offer_key . '_tracking_notice', 'no' );

        if ( 'hide' == $hide_notice ) {
            return;
        }

        $product_text = ( ! WeDevs_Dokan::init()->is_pro_exists() ) ? __( 'Pro upgrade and all extensions', 'dokan-lite' ) : __( 'all extensions', 'dokan-lite' );

        $offer_msg = sprintf( __( '<h2><span class="dashicons dashicons-awards"></span> weDevs 4th Year Anniversary Offer</h2>', 'dokan-lite' ) );
        $offer_msg .= sprintf( __( '<p>Get <strong class="highlight-text">44&#37; discount</strong> on %2$s also <a target="_blank" href="%1$s"><strong>WIN any product</strong></a> from our 4th year anniversary giveaway. Offer ending soon!</p>', 'dokan-lite' ), 'https://wedevs.com/in/4years', $product_text );
        ?>
            <div class="notice is-dismissible" id="dokan-promotional-offer-notice">
                <img src="https://ps.w.org/dokan-lite/assets/icon-256x256.png?rev=1595714" alt="">
                <?php echo $offer_msg; ?>
                <span class="dashicons dashicons-megaphone"></span>
            </div>

            <style>
                #dokan-promotional-offer-notice {
                    background-color: #F35E33;
                    border-left: 0px;
                    padding-left: 83px;
                }

                #dokan-promotional-offer-notice h2{
                    font-size: 19px;
                    color: rgba(250, 250, 250, 0.77);
                    margin-bottom: 8px;
                    font-weight: normal;
                    margin-top: 15px;
                    -webkit-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -moz-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -o-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                }

                #dokan-promotional-offer-notice img{
                    position: absolute;
                    width: 80px;
                    top: 0px;
                    left: 0px;
                }

                #dokan-promotional-offer-notice h2 span {
                    position: relative;
                    top: -1px;
                }

                #dokan-promotional-offer-notice p{
                    color: rgba(250, 250, 250, 0.77);
                    font-size: 14px;
                    margin-bottom: 10px;
                    -webkit-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -moz-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -o-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                }

                #dokan-promotional-offer-notice p strong.highlight-text{
                    color: #fff;
                }

                #dokan-promotional-offer-notice p a {
                    color: #fafafa;
                }

                #dokan-promotional-offer-notice .notice-dismiss:before {
                    color: #fff;
                }

                #dokan-promotional-offer-notice span.dashicons-megaphone {
                    position: absolute;
                    top: 16px;
                    right: 119px;
                    color: rgba(253, 253, 253, 0.29);
                    font-size: 96px;
                    transform: rotate(-21deg);
                }

            </style>

            <script type='text/javascript'>
                jQuery('body').on('click', '#dokan-promotional-offer-notice .notice-dismiss', function(e) {
                    e.preventDefault();

                    wp.ajax.post('dokan-dismiss-promotional-offer-notice', {
                        dokan_promotion_dismissed: true
                    });
                });
            </script>
        <?php
    }


    /**
     * Get Post Type array
     *
     * @since 1.0
     *
     * @param  string $post_type
     *
     * @return array
     */
    public static function get_post_type( $post_type ) {
        $pages_array = array( '-1' => __( '- select -', 'dokan-lite' ) );
        $pages = get_posts( array('post_type' => $post_type, 'numberposts' => -1) );

        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_array[$page->ID] = $page->post_title;
            }
        }

        return $pages_array;
    }


    /**
     * Dashboard scripts and styles
     *
     * @since 1.0
     *
     * @return void
     */
    function dashboard_script() {
        wp_enqueue_style( 'dokan-admin-dash', DOKAN_PLUGIN_ASSEST . '/css/admin.css' );

        wp_enqueue_style( 'dokan-admin-report', DOKAN_PLUGIN_ASSEST . '/css/admin.css' );
        wp_enqueue_style( 'jquery-ui' );
        wp_enqueue_style( 'dokan-chosen-style' );

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'dokan-flot' );
        wp_enqueue_script( 'dokan-chart' );
        wp_enqueue_script( 'dokan-chosen' );

        do_action( 'dokan_enqueue_admin_dashboard_script' );
    }

    /**
     * Initialize Settings tab and sections content
     *
     * @since 1.0
     *
     * @return void
     */
    function admin_init() {
        Dokan_Admin_Withdraw::init()->bulk_action_handler();

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Load admin Menu
     *
     * @since 1.0
     *
     * @return void
     */
    function admin_menu() {
        $menu_position = apply_filters( 'dokan_menu_position', 17 );
        $capability    = apply_filters( 'dokan_menu_capability', 'manage_options' );
        $withdraw      = dokan_get_withdraw_count();
        $withdraw_text = __( 'Withdraw', 'dokan-lite' );

        if ( $withdraw['pending'] ) {
            $withdraw_text = sprintf( __( 'Withdraw %s', 'dokan-lite' ), '<span class="awaiting-mod count-1"><span class="pending-count">' . $withdraw['pending'] . '</span></span>' );
        }

        $dashboard = add_menu_page( __( 'Dokan', 'dokan-lite' ), __( 'Dokan', 'dokan-lite' ), $capability, 'dokan', array( $this, 'dashboard'), 'data:image/svg+xml;base64,' . base64_encode( '<svg width="58px" height="63px" viewBox="0 0 58 63" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="dokan-icon" fill-rule="nonzero" fill="#9EA3A8"><path d="M5.33867702,3.0997123 C5.33867702,3.0997123 40.6568031,0.833255993 40.6568031,27.7724223 C40.6568031,54.7115885 31.3258879,60.1194199 23.1436827,61.8692575 C23.1436827,61.8692575 57.1718639,69.1185847 57.1718639,31.1804393 C57.1718639,-6.75770611 13.7656892,-1.28321423 5.33867702,3.0997123 Z" id="Shape"></path><path d="M34.0564282,48.9704547 C34.0564282,48.9704547 30.6479606,59.4444826 20.3472329,60.7776922 C10.0465051,62.1109017 8.12571122,57.1530286 0.941565611,57.4946635 C0.941565611,57.4946635 0.357794932,52.5784532 6.1578391,51.8868507 C11.9578833,51.1952482 22.8235504,52.5451229 30.0547743,48.5038314 C30.0547743,48.5038314 34.3294822,46.5206821 35.1674756,45.5624377 L34.0564282,48.9704547 Z" id="Shape"></path><path d="M4.80198462,4.99953596 L4.80198462,17.9733318 L4.80198462,17.9733318 L4.80198462,50.2869992 C5.1617776,50.2053136 5.52640847,50.1413326 5.89420073,50.0953503 C7.92701701,49.903571 9.97004544,49.8089979 12.0143772,49.8120433 C14.1423155,49.8120433 16.4679825,49.7370502 18.7936496,49.5454014 L18.7936496,34.3134818 C18.7936496,29.2472854 18.426439,24.0727656 18.7936496,19.0149018 C19.186126,15.9594324 21.459175,13.3479115 24.697266,12.232198 C27.2835811,11.3792548 30.1586431,11.546047 32.5970015,12.6904888 C20.9498348,5.04953132 7.86207285,4.89954524 4.80198462,4.99953596 Z" id="Shape"></path></g></g></svg>' ), $menu_position );
        add_submenu_page( 'dokan', __( 'Dokan Dashboard', 'dokan-lite' ), __( 'Dashboard', 'dokan-lite' ), $capability, 'dokan', array( $this, 'dashboard' ) );
        add_submenu_page( 'dokan', __( 'Withdraw', 'dokan-lite' ), $withdraw_text, $capability, 'dokan-withdraw', array( $this, 'withdraw_page' ) );
        add_submenu_page( 'dokan', __( 'PRO Features', 'dokan-lite' ), __( 'PRO Features', 'dokan-lite' ), $capability, 'dokan-pro-features', array( $this, 'pro_features' ) );

        do_action( 'dokan_admin_menu', $capability, $menu_position );

        $settings = add_submenu_page( 'dokan', __( 'Settings', 'dokan-lite' ), __( 'Settings', 'dokan-lite' ), $capability, 'dokan-settings', array( $this, 'settings_page' ) );
        add_submenu_page( 'dokan', __( 'Add Ons', 'dokan-lite' ), __( 'Add-ons', 'dokan-lite' ), $capability, 'dokan-addons', array($this, 'addon_page' ) );

        /**
         * Welcome page
         *
         * @since 2.4.3
         */
        add_dashboard_page( __( 'Welcome to Dokan', 'dokan-lite' ), __( 'Welcome to Dokan', 'dokan-lite' ), $capability, 'dokan-welcome', array( $this, 'welcome_page' ) );

        add_action( $dashboard, array($this, 'dashboard_script' ) );
        add_action( $settings, array($this, 'dashboard_script' ) );
    }

    /**
     * Get all settings Sections
     *
     * @since 1.0
     *
     * @return array
     */
    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'dokan_general',
                'title' => __( 'General', 'dokan-lite' )
            ),
            array(
                'id'    => 'dokan_selling',
                'title' => __( 'Selling Options', 'dokan-lite' )
            ),
            array(
                'id'    => 'dokan_withdraw',
                'title' => __( 'Withdraw Options', 'dokan-lite' )
            ),
            array(
                'id'    => 'dokan_pages',
                'title' => __( 'Page Settings', 'dokan-lite' )
            ),
            array(
                'id'    => 'dokan_appearance',
                'title' => __( 'Appearance', 'dokan-lite' )
            )
        );
        return apply_filters( 'dokan_settings_sections', $sections );
    }

    /**
     * Returns all the settings fields
     *
     * @since 1.0
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $pages_array = self::get_post_type( 'page' );
        $slider_array = self::get_post_type( 'dokan_slider' );

        $settings_fields = array(
            'dokan_general' => array(
                'admin_access' => array(
                    'name'    => 'admin_access',
                    'label'   => __( 'Admin area access', 'dokan-lite' ),
                    'desc'    => __( 'Disable Vendors and Customers from accessing the wp-admin dashboard area', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                'custom_store_url' => array(
                    'name'    => 'custom_store_url',
                    'label'   => __( 'Vendor Store URL', 'dokan-lite' ),
                    'desc'    => sprintf( __( 'Define the seller store URL (%s<strong>[this-text]</strong>/[seller-name])', 'dokan-lite' ), site_url( '/' ) ),
                    'default' => 'store',
                    'type'    => 'text',
                ),
                'seller_enable_terms_and_conditions' => array(
                    'name'    => 'seller_enable_terms_and_conditions',
                    'label'   => __( 'Terms and Conditions', 'dokan-lite' ),
                    'desc'    => __( 'Enable Terms and Conditions for vendor stores', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'off'
                 ),
                'extra_fee_recipient' => array(
                    'name'    => 'extra_fee_recipient',
                    'label'   => __( 'Extra Fee Recipient', 'dokan-lite' ),
                    'desc'    => __( 'Should extra fees, such as Shipping and Tax, go to the Vendor or the Admin?', 'dokan-lite' ),
                    'type'    => 'select',
                    'options' => array( 'seller' => __( 'Vendor', 'dokan-lite' ), 'admin' => __( 'Admin', 'dokan-lite' ) ),
                    'default' => 'seller'
                ),
                'store_map'                  => array(
                    'name'    => 'store_map',
                    'label'   => __( 'Show Map on Store Page', 'dokan-lite' ),
                    'desc'    => __( 'Enable a Google Map of the Store Location in the store sidebar', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                'gmap_api_key'               => array(
                    'name'  => 'gmap_api_key',
                    'label' => __( 'Google Map API Key', 'dokan-lite' ),
                    'desc'  => __( '<a href="https://developers.google.com/maps/documentation/javascript/" target="_blank">API Key</a> is needed to display map on store page', 'dokan-lite' ),
                    'type'  => 'text',
                ),
                'contact_seller'             => array(
                    'name'    => 'contact_seller',
                    'label'   => __( 'Show Contact Form on Store Page', 'dokan-lite' ),
                    'desc'    => __( 'Enable Vendor Contact Form in the store sidebar', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                'enable_theme_store_sidebar' => array(
                    'name'    => 'enable_theme_store_sidebar',
                    'label'   => __( 'Enable Store Sidebar From Theme', 'dokan-lite' ),
                    'desc'    => __( 'Enable showing Store Sidebar From Your Theme.', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'off'
                ),
            ),
            'dokan_selling' => array(
                'new_seller_enable_selling' => array(
                    'name'    => 'new_seller_enable_selling',
                    'label'   => __( 'New Vendor Product Upload', 'dokan-lite' ),
                    'desc'    => __( 'Allow newly registered vendors to add products', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                'seller_percentage' => array(
                    'name'    => 'seller_percentage',
                    'label'   => __( 'Vendor Commission %', 'dokan-lite' ),
                    'desc'    => __( 'How much (%) a vendor will get from each order', 'dokan-lite' ),
                    'default' => '90',
                    'type'    => 'text',
                ),
                'order_status_change' => array(
                    'name'    => 'order_status_change',
                    'label'   => __( 'Order Status Change', 'dokan-lite' ),
                    'desc'    => __( 'Vendor can update order status', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                'disable_product_popup' => array(
                    'name'    => 'disable_product_popup',
                    'label'   => __( 'Disable Product Popup', 'dokan-lite' ),
                    'desc'    => __( 'Disable add new product in popup view', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'off'
                ),
                'disable_welcome_wizard' => array(
                    'name'    => 'disable_welcome_wizard',
                    'label'   => __( 'Disable Welcome Wizard', 'dokan-lite' ),
                    'desc'    => __( 'Disable welcome wizard for newly registered vendors', 'dokan-lite' ),
                    'type'    => 'checkbox',
                    'default' => 'off'
                ),
            ),
            'dokan_withdraw' => array(
                'withdraw_methods' => array(
                    'name'    => 'withdraw_methods',
                    'label'   => __( 'Withdraw Methods', 'dokan-lite' ),
                    'desc'    => __( 'Withdraw methods for vendors', 'dokan-lite' ),
                    'type'    => 'multicheck',
                    'default' => array( 'paypal' => 'paypal' ),
                    'options' => dokan_withdraw_get_methods()
                ),
                'withdraw_limit' => array(
                    'name'    => 'withdraw_limit',
                    'label'   => __( 'Minimum Withdraw Limit', 'dokan-lite' ),
                    'desc'    => __( 'Minimum balance required to make a withdraw request. Leave blank to set no minimum limits.', 'dokan-lite' ),
                    'default' => '50',
                    'type'    => 'text',
                ),
            ),
            'dokan_pages' => array(
                'dashboard' => array(
                    'name'    => 'dashboard',
                    'label'   => __( 'Dashboard', 'dokan-lite' ),
                    'type'    => 'select',
                    'options' => $pages_array
                ),
                'my_orders' => array(
                    'name'    => 'my_orders',
                    'label'   => __( 'My Orders', 'dokan-lite' ),
                    'type'    => 'select',
                    'options' => $pages_array
                ),
                'reg_tc_page' => array(
                    'name'    => 'reg_tc_page',
                    'label'   => __( 'Terms and Conditions Page', 'dokan-lite' ),
                    'type'    => 'select',
                    'options' => $pages_array
                )
            ),
            'dokan_appearance' => array(
                'setup_wizard_logo_url' => array(
                    'name'    => 'setup_wizard_logo_url',
                    'label'   => __( 'Vendor Setup Wizard Logo', 'dokan-lite' ),
                    'type'    => 'file',
                    'desc'    => __( 'Recommended Logo size ( 270px X 90px ). If no logo is uploaded, site title is shown by default.', 'dokan-lite' ),
                ),
                'store_header_template' => array(
                    'name'    => 'store_header_template',
                    'label'   => __( 'Store Header Template', 'dokan-lite' ),
                    'type'    => 'radio_image',
                    'options' => array(
                        'default' => DOKAN_PLUGIN_ASSEST . '/images/store-header-templates/default.png',
                        'layout1' => DOKAN_PLUGIN_ASSEST . '/images/store-header-templates/layout1.png',
                        'layout2' => DOKAN_PLUGIN_ASSEST . '/images/store-header-templates/layout2.png',
                        'layout3' => DOKAN_PLUGIN_ASSEST . '/images/store-header-templates/layout3.png'
                    ),
                    'default' => 'default',
                ),
            ),
        );

        return apply_filters( 'dokan_settings_fields', $settings_fields );
    }

    /**
     * Render Settings Page
     *
     * @since 1.0
     *
     * @return void
     */
    function settings_page() {
        echo '<div class="wrap">';
        settings_errors();

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Load Dashboard Template
     *
     * @since 1.0
     *
     * @return void
     */
    function dashboard() {
        include dirname(__FILE__) . '/dashboard.php';
    }

    /**
     * Load withdraw template
     *
     * @since 1.0
     *
     * @return void
     */
    function withdraw_page() {
        include dirname(__FILE__) . '/withdraw.php';
    }

    /**
     * Pro listing page
     *
     * @since 2.5.3
     *
     * @return void
     */
    function pro_features() {
        include dirname(__FILE__) . '/pro-features.php';
    }


    /**
     * Laad Addon template
     *
     * @since 1.0
     *
     * @return void
     */
    function addon_page() {
        include dirname(__FILE__) . '/add-on.php';
    }

    /**
     * Include welcome page template
     *
     * @since 2.4.3
     *
     * @return void
     */
    function welcome_page() {
        include_once DOKAN_INC_DIR . '/admin/welcome.php';
    }

    /**
     * Remove the welcome page dashboard menu
     *
     * @since 2.4.3
     *
     * @return void
     */
    function welcome_page_remove() {
        remove_submenu_page( 'index.php', 'dokan-welcome' );
    }

    /**
     * Add Menu in Dashboard Top bar
     * @return array [top menu bar]
     */
    function dokan_admin_toolbar() {
        global $wp_admin_bar;

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $args = array(
            'id'     => 'dokan',
            'title'  => __( 'Dokan', 'admin' ),
            'href'   => admin_url( 'admin.php?page=dokan' )
        );

        $wp_admin_bar->add_menu( $args );

        $wp_admin_bar->add_menu( array(
            'id'     => 'dokan-dashboard',
            'parent' => 'dokan',
            'title'  => __( 'Dokan Dashboard', 'dokan-lite' ),
            'href'   => admin_url( 'admin.php?page=dokan' )
        ) );

        $wp_admin_bar->add_menu( array(
            'id'     => 'dokan-withdraw',
            'parent' => 'dokan',
            'title'  => __( 'Withdraw', 'dokan-lite' ),
            'href'   => admin_url( 'admin.php?page=dokan-withdraw' )
        ) );

        $wp_admin_bar->add_menu( array(
            'id'     => 'dokan-pro-features',
            'parent' => 'dokan',
            'title'  => __( 'PRO Features', 'dokan-lite' ),
            'href'   => admin_url( 'admin.php?page=dokan-pro-features' )
        ) );

        $wp_admin_bar->add_menu( array(
            'id'     => 'dokan-settings',
            'parent' => 'dokan',
            'title'  => __( 'Settings', 'dokan-lite' ),
            'href'   => admin_url( 'admin.php?page=dokan-settings' )
        ) );

        /**
         * Add new or remove toolbar
         *
         * @since 2.5.3
         */
        do_action( 'dokan_render_admin_toolbar', $wp_admin_bar );
    }

    /**
     * Doing Updates and upgrade
     *
     * @since 1.0
     *
     * @return void
     */
    public function do_updates() {
        if ( isset( $_GET['dokan_do_update'] ) && $_GET['dokan_do_update'] == 'true' ) {
            $installer = new Dokan_Installer();
            $installer->do_upgrades();
        }
    }

    /**
     * Check is dokan need any update
     *
     * @since 1.0
     *
     * @return boolean
     */
    public function is_dokan_needs_update() {
        $installed_version = get_option( 'dokan_theme_version' );

        // may be it's the first install
        if ( ! $installed_version ) {
            return false;
        }

        if ( version_compare( $installed_version, '1.2', '<' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Show update notice in dokan dashboard
     *
     * @since 1.0
     *
     * @return void
     */
    public function update_notice() {
        if ( ! $this->is_dokan_needs_update() ) {
            return;
        }
        ?>
        <div id="message" class="updated">
            <p><?php _e( '<strong>Dokan Data Update Required</strong> &#8211; We need to update your install to the latest version', 'dokan-lite' ); ?></p>
            <p class="submit"><a href="<?php echo add_query_arg( 'dokan_do_update', 'true', admin_url( 'admin.php?page=dokan' ) ); ?>" class="dokan-update-btn button-primary"><?php _e( 'Run the updater', 'dokan-lite' ); ?></a></p>
        </div>

        <script type="text/javascript">
            jQuery('.dokan-update-btn').click('click', function(){
                return confirm( '<?php _e( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'dokan-lite' ); ?>' );
            });
        </script>
    <?php
    }
}

$settings = new Dokan_Admin_Settings();
