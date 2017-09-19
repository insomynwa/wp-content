<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also includes all of the dependencies used by
 * the plugin, and defines a function that starts the plugin.
 *
 * @link              http://code.tutsplus.com/tutorials/adding-custom-fields-to-simple-products-with-woocommerce--cms-27904
 * @package           CWF
 *
 * @wordpress-plugin
 * Plugin Name: Woofreendor
 * Description: Woocommerce multiple vendor plugin
 * Version: 1.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

if (! defined( 'WPINC' )) {
	die;
}

function woofreendor_autoload( $class ) {
    if ( stripos( $class, 'Woofreendor_' ) !== false ) {
        $class_name = str_replace( array( 'Woofreendor_', '_' ), array( '', '-' ), $class );
        $file_path = __DIR__ . '/includes/classes/woofreendor-' . strtolower( $class_name ) . '.php';

        if ( file_exists( $file_path ) ) {
            require_once $file_path;
        }
    }
}

spl_autoload_register( 'woofreendor_autoload' );

// if( ! in_array('groups/groups.php', apply_filters('active_plugins', get_option('active_plugins'))) ){
// 	die;
// 	require_once plugin_dir_path( __FILE__ ) . 'classes/woofreendor-installer.php';

// 	register_activation_hook(__FILE__, array('Woofreendor_Installer', 'woofreendor_activate'));

// 	require_once plugin_dir_path( __FILE__ ) . 'includes/woofreendor-main.php';

// 	function run_woofreendor() {
// 		$wfd = new Woofreendor_Main();
// 		$wfd->run();
// 	}

// 	run_woofreendor();
	
// }

final class Woofreendor{

    public function __construct() {

        if ( ! function_exists( 'WC' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            deactivate_plugins( plugin_basename( __FILE__ ) );

            wp_die( '<div class="error"><p>' . sprintf( __( '<b>Woofreendor</b> requires %sWoocommerce%s to be installed & activated!', 'woofreendor' ), '<a target="_blank" href="https://wordpress.org/plugins/woocommerce/">', '</a>' ) . '</p></div>' );
        }
        // if ( ! in_array('groups/groups.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
        //     require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        //     deactivate_plugins( plugin_basename( __FILE__ ) );

        //     wp_die( '<div class="error"><p>' . sprintf( __( '<b>Woofreendor</b> requires %sGroups%s to be installed & activated!', 'woofreendor' ), '<a target="_blank" href="#">', '</a>' ) . '</p></div>' );
        // }
        if ( ! class_exists( 'WeDevs_Dokan' ) ) {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            deactivate_plugins( plugin_basename( __FILE__ ) );

            wp_die( '<div class="error"><p>' . sprintf( __( '<b>Woofreendor</b> requires %sDokan-Lite%s to be installed & activated!', 'woofreendor' ), '<a target="_blank" href="https://wordpress.org/plugins/dokan-lite/">', '</a>' ) . '</p></div>' );
        }
        $this->defined();

        // spl_autoload_register( array( $this, 'woofreendor_autoload' ) );

        $this->includes();
        $this->instantiate_class();
        // init actions and filter
        $this->load_actions();
        $this->load_filters();

        // initialize classes
        //$this->init_classes();

        //for reviews ajax request
        $this->init_ajax();
    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor();
        }

        return $instance;
    }

    public static function activate() {
        if ( ! function_exists( 'WC' ) ) {
            return;
        }

        require_once __DIR__ . '/includes/woofreendor-functions.php';
        // require_once __DIR__ . '/includes/classes/woofreendor-installer.php';

        $installer = new Woofreendor_Installer();
        $installer->do_install();
    }

    public static function deactivate() {

    }


    public function defined() {
        define( 'WOOFREENDOR_DIR', dirname( __FILE__) );
        define( 'WOOFREENDOR_INC', dirname( __FILE__) . '/includes/' );
        define( 'WOOFREENDOR_ADMIN_DIR', WOOFREENDOR_INC . 'admin/' );
        define( 'WOOFREENDOR_CLASS', WOOFREENDOR_INC . 'classes/' );
        define( 'WOOFREENDOR_PLUGIN_ASSEST', plugins_url( 'assets', __FILE__ ) );
    }

    // public function woofreendor_autoload( $class ) {
    //     if ( stripos( $class, 'Woofreendor_' ) !== false ) {
    //         $class_name = str_replace( array( 'Woofreendor_', '_' ), array( '', '-' ), $class );
    //         $file_path = __DIR__ . '/includes/classes/woofreendor-' . strtolower( $class_name ) . '.php';

    //         if ( file_exists( $file_path ) ) {
    //             require_once $file_path;
    //         }
    //     }
    // }

    function includes(){

        if ( is_admin() ) {
            require_once WOOFREENDOR_ADMIN_DIR . 'woofreendor-admin.php';
        }else{
        	require_once WOOFREENDOR_INC . 'woofreendor-template-tags.php';
        }

        require_once WOOFREENDOR_INC . 'woofreendor-functions.php';
        require_once WOOFREENDOR_INC . 'woofreendor-template-utility.php';
        require_once WOOFREENDOR_INC . 'admin/woofreendor-setup-wizard.php';
        require_once WOOFREENDOR_INC . 'widgets/tenant-contact.php';
        require_once WOOFREENDOR_INC . 'widgets/tenant-location.php';
    }

    function instantiate_class(){
        if ( is_admin() ) {
            new Woofreendor_Admin_User_Profile();
        }
        // new Woofreendor_Pageviews();
        new Woofreendor_Rewrites();
        // new Dokan_Tracker();
        // Dokan_Email::init();
        //Woofreendor_Ajax::init()->init_ajax();

        if ( is_user_logged_in() ) {
            Woofreendor_Template_Main::init();
            Woofreendor_Template_Dashboard::init();
            Woofreendor_Template_Products::init();
            Woofreendor_Template_Outlets::init();
            Woofreendor_Tenants::init();
            Woofreendor_Outlets::init();
            Woofreendor_Template_Settings::init();
            Woofreendor_Woocommerce::init();
            //Dokan_Template_Withdraw::init();
            Woofreendor_Template_Shortcodes::init();
            //Dokan_Template_Settings::init();
        }
    }

    function load_actions(){

        add_action( 'dokan_register_scripts', array( $this, 'register_scripts' ));
        // add_action( 'init', array( $this, 'register_scripts') ,10);
        add_action( 'dokan_enqueue_scripts', array( $this, 'enqueue_scripts' ), 11 );
        add_action( 'dokan_enqueue_admin_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'dokan_enqueue_admin_dashboard_script', array( $this, 'admin_dashboad_enqueue_scripts' ) );

        add_action( 'template_redirect', array( $this, 'redirect_if_not_logged_tenant' ), 11 );

        remove_action( 'woocommerce_register_form', 'dokan_seller_reg_form_fields' );

        // add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
        // remove_filter( 'dokan_localized_args', array( WeDevs_Dokan::init(), 'conditional_localized_args' ) );
        // add_filter( 'dokan_localized_args', array( $this, 'dokan_conditional_localized_args' ) );
        // add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        // add_filter( 'woofreendor_localized_args', array( $this, 'conditional_localized_args' ) );
    }

    function load_filters() {
        add_filter( 'dokan_force_load_extra_args', array( $this, 'force_load_extra_args'),10 );
        add_filter( 'dokan_forced_load_scripts', array($this, 'force_load_scripts'),10);
        add_filter( 'dokan_query_var_filter', array( $this, 'load_query_var' ), 10 );
        add_filter( 'dokan_set_template_path', array( $this, 'load_woofreendor_templates' ), 10, 3 );

        add_filter( 'body_class', array( $this, 'add_dashboard_template_class' ), 99 );
        add_filter( 'pre_get_document_title', array( $this, 'wp_title' ), 99999, 2 );
    }

    function init_ajax(){

        $doing_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;
        
        if ( $doing_ajax ) {
            Dokan_Ajax::init()->init_ajax();Woofreendor_Ajax::init()->init_ajax();
        }
    	
    }

    public function load_query_var( $query_vars ) {
        $query_vars[] = 'outlets';
        $query_vars[] = 'new-outlet';

        return $query_vars;
    }

    public function load_woofreendor_templates( $template_path, $template, $args ) {
        if ( isset( $args['pro'] ) && $args['pro'] ) {
            return $this->plugin_path() . '/templates';
        }

        return $template_path;
    }

    public function wp_title(  ) {
        global $paged, $page;
        // var_dump($paged);
        $title = '';
        $sep = "-";
        if ( is_feed() ) {
            return $title;
        }

        if ( woofreendor_is_tenant_page() ) {
            $site_title = get_bloginfo( 'name' );
            $tenant_user = get_userdata( get_query_var( 'author' ) );
            $tenant_info = woofreendor_get_tenant_info( $tenant_user->ID );
            $tenant_name = esc_html( $tenant_info['tenant_name'] );
            $title      = "$tenant_name $sep $site_title";

            // Add a page number if necessary.
            if ( $paged >= 2 || $page >= 2 ) {
                $title = "$title $sep " . sprintf( __( 'Page %s', 'woofreendor' ), max( $paged, $page ) );
            }

            return $title;
        }

        if ( dokan_is_store_page() ) {
            $site_title = get_bloginfo( 'name' );
            $store_user = get_userdata( get_query_var( 'author' ) );
            $store_info = dokan_get_store_info( $store_user->ID );
            $store_name = esc_html( $store_info['store_name'] );
            $title      = "$store_name $sep $site_title";

            // Add a page number if necessary.
            if ( $paged >= 2 || $page >= 2 ) {
                $title = "$title $sep " . sprintf( __( 'Page %s', 'dokan-lite' ), max( $paged, $page ) );
            }

            return $title;
        }

        return $title;
    }

    function add_dashboard_template_class( $classes ) {
        $page_id = dokan_get_option( 'tenant_dashboard', 'woofreendor_pages' );

        if ( ! $page_id ) {
            return $classes;
        }

        if ( is_page( $page_id ) || ( get_query_var( 'edit' ) && is_singular( 'outlet' ) ) ) {
            $classes[] = 'dokan-dashboard';
        }

        if ( woofreendor_is_tenant_page () ) {
            $classes[] = 'dokan-store';
        }

        $classes[] = 'dokan-theme-' . get_option( 'template' );

        return $classes;
    }

    public function register_scripts(){
        wp_register_script( 'woofreendor-script', plugins_url( 'assets/js/woofreendor-script.js', __FILE__ ), array( 'dokan-script'), null, true );
    	//wp_register_style( 'woofreendor-style', plugins_url( 'assets/css/style.css', __FILE__ ), false, null );
        // if ( is_rtl() ) {
        //     wp_register_style( 'woofreendor-rtl-style', plugins_url( 'assets/css/rtl.css', __FILE__ ), false, null );
        // }
		// wp_register_script( 'woofreendor-script', plugins_url( 'assets/js/woofreendor-script.js', __FILE__ ), false, null, true );

		// wp_enqueue_script('woofreendor-script');
    }

    public function enqueue_scripts() {
        global $wp;
        // var_dump($wp->query_vars);
        // var_dump(woofreendor_is_tenant_page());
        if ( ( woofreendor_is_tenant_dashboard()
            || ( get_query_var( 'edit' ) && is_singular( 'tenant' ) )
            || ( get_query_var( 'edit' ) && is_singular( 'product' ) )
            || ( get_query_var( 'edit' ) && is_singular( 'outlet' ) ) )
            || ( dokan_is_seller_dashboard()
            || ( get_query_var( 'edit' ) && is_singular( 'product' ) )
            || ( get_query_var( 'edit' ) && is_singular( 'tenant' ) )
            || ( get_query_var( 'edit' ) && is_singular( 'outlet' ) ) )
            || dokan_is_store_page()
            // || woofreendor_is_tenant_page()
            || dokan_is_store_review_page()
            || is_account_page()
        ) {

            $this->woofreendor_dashboard_scripts();
            if ( isset( $wp->query_vars['settings'] ) == 'tenant' ) {
                wp_enqueue_script( 'wc-country-select' );
            }
            // $dokan = WeDevs_Dokan::init();
            // if ( DOKAN_LOAD_STYLE ) {
            //     wp_enqueue_style( 'dokan-select2-css' );
            // // }

            // // if ( DOKAN_LOAD_SCRIPTS ) {

            //     $dokan->load_form_validate_script();
            //     $dokan->load_gmap_script();

            //     wp_enqueue_script( 'jquery-ui-sortable' );
                // wp_enqueue_script( 'jquery-ui-datepicker' );
            //     wp_enqueue_script( 'dokan-tooltip' );
            //     wp_enqueue_script( 'dokan-chosen' );
            //     wp_enqueue_script( 'dokan-form-validate' );
            //     wp_enqueue_script( 'dokan-script' );
            //     wp_enqueue_script( 'dokan-select2-js' );
            // }
            // wp_enqueue_style( 'dokan-pro-style' );
            wp_enqueue_style( 'woofreendor-style', WOOFREENDOR_PLUGIN_ASSEST . '/css/style.css', false, time(), 'all' );

            // Load accounting scripts
            // wp_enqueue_script( 'jquery-blockui', WC()->plugin_url() . '/assets/js/jquery-blockui/jquery.blockUI.min.js', array( 'jquery' ), null, true );
            wp_enqueue_script( 'accounting' );
            wp_enqueue_script( 'serializejson' );
            wp_enqueue_script( 'jquery-blockui', WC()->plugin_url() . '/assets/js/jquery-blockui/jquery.blockUI.min.js', array( 'jquery' ), null, true );
            // wp_enqueue_script( 'jquery-ui-sortable' );
            // wp_enqueue_script( 'jquery-ui-datepicker' );
            // wp_enqueue_script( 'dokan-tooltip' );
            // wp_enqueue_script( 'dokan-chosen' );
            // wp_enqueue_script( 'dokan-form-validate' );
            // wp_enqueue_script( 'dokan-script' );
            // wp_enqueue_script( 'dokan-select2-js' );
            //localize script for refund and dashboard image options
            $woofreendor_loc = woofreendor_locatize_data();
            // wp_localize_script( 'dokan-script', 'dokan', $woofreendor_loc );
            wp_localize_script( 'dokan-script', 'woofreendor', $woofreendor_loc );
            // wp_enqueue_script( 'woofreendor-script', WOOFREENDOR_PLUGIN_ASSEST . '/js/woofreendor-script.js', array( 'jquery', 'dokan-script' ), null, true );
        }

        if ( woofreendor_is_tenant_page() ) {
            $dokan = WeDevs_Dokan::init();
            if ( DOKAN_LOAD_STYLE ) {
                wp_enqueue_style( 'dokan-select2-css' );
            }

            if ( DOKAN_LOAD_SCRIPTS ) {

                $dokan->load_form_validate_script();
                $dokan->load_gmap_script();

                wp_enqueue_script( 'jquery-ui-sortable' );
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_enqueue_script( 'dokan-tooltip' );
                wp_enqueue_script( 'dokan-chosen' );
                wp_enqueue_script( 'dokan-form-validate' );
                wp_enqueue_script( 'dokan-script' );
                wp_enqueue_script( 'dokan-select2-js' );
            }
        }
        //Load in Single product pages only
        // if ( is_singular( 'product' ) && !get_query_var( 'edit' ) ) {
        //     wp_enqueue_script( 'dokan-product-shipping' );
        // }
    }

    public function force_load_extra_args( $paramDefaultArgs){
        
        if( woofreendor_is_tenant_dashboard()
        || woofreendor_is_tenant_page()
        // || ( get_query_var( 'edit' ) && is_singular( 'tenant' ) )
        || ( get_query_var( 'edit' ) && is_singular( 'outlet' ) )
        ){
            $paramDefaultArgs = true;
        }
        return $paramDefaultArgs;
    }

    public function force_load_scripts($paramDefaultArgs){
        if( woofreendor_is_tenant_dashboard()
        // || ( get_query_var( 'edit' ) && is_singular( 'tenant' ) )
        || ( get_query_var( 'edit' ) && is_singular( 'outlet' ) )
        ){
            $paramDefaultArgs = true;
        }
        // var_dump($paramDefaultArgs);die;
        return $paramDefaultArgs;
    }

    public function admin_enqueue_scripts() {
        wp_enqueue_script( 'woofreendor-admin', WOOFREENDOR_PLUGIN_ASSEST.'/js/woofreendor-admin.js', array( 'jquery' ) );
        wp_enqueue_script( 'woofreendor-bootstrap-script', WOOFREENDOR_PLUGIN_ASSEST.'/js/bootstrap.min.js', array( 'jquery' ) );

        // $dokan_refund = dokan_get_refund_localize_data();
        // wp_localize_script( 'dokan_slider_admin', 'dokan_refund', $dokan_refund );
    }

    public function admin_dashboad_enqueue_scripts() {
        wp_enqueue_style( 'woofreendor-bootstrap-style', WOOFREENDOR_PLUGIN_ASSEST . '/css/bootstrap.min.css' );
        wp_enqueue_style( 'woofreendor-admin-style', WOOFREENDOR_PLUGIN_ASSEST . '/css/admin-style.css' );
    }

    // public function scripts(){
		// if ( ! function_exists( 'WC' ) ) {
  //           return;
  //       }

  //       wp_enqueue_style( 'woofreendor-style' );
  //       if ( is_rtl() ) {
  //           wp_enqueue_style( 'woofreendor-rtl-style' );
  //       }

        // $default_script = array(
        //         'ajaxurl'     => admin_url( 'admin-ajax.php' ),
        //         'nonce'       => wp_create_nonce( 'woofreendor_reviews' ),
        //         'ajax_loader' => plugins_url( 'assets/images/ajax-loader.gif', __FILE__ ),
        //         'tenant'      => array(
        //             'available'    => __( 'Available', 'woofreendor' ),
        //             'notAvailable' => __( 'Not Available', 'woofreendor' )
        //         ),
        //         'delete_confirm' => __('Are you sure?', 'woofreendor' ),
        //         'wrong_message'  => __('Something went wrong. Please try again.', 'woofreendor' ),
        // 	);

        // $localize_script = apply_filters( 'woofreendor_localized_args', $default_script );

        // wp_localize_script( 'jquery', 'woofreendor', $localize_script );

        // if ( ( woofreendor_is_tenant_dashboard() || dokan_is_seller_dashboard() || ( get_query_var( 'edit' ) && is_singular( 'outlet' ) ) ) || apply_filters( 'woofreendor_forced_load_scripts', false ) ) {
        //     $this->woofreendor_dashboard_scripts();
        // }

        // if ( dokan_is_store_page() || dokan_is_store_review_page() || woofreendor_is_tenant_page() || is_account_page() ) {

        //     wp_enqueue_script( 'woofreendor-script' );
        // }
	// }

	public function redirect_if_not_logged_tenant() {
        global $post;

        $page_id = dokan_get_option( 'tenant_dashboard', 'woofreendor_pages' );

        if ( ! $page_id ) {
            return;
        }

        if ( is_page( $page_id ) || apply_filters( 'dokan_force_page_redirect', false, $page_id ) ) {
            dokan_redirect_login();
            woofreendor_redirect_if_not_tenant();
        }
    }

    public function woofreendor_dashboard_scripts(){
		// $dokan = WeDevs_Dokan::init();
		// $dokan->dokan_dashboard_scripts();
    	wp_enqueue_script( 'woofreendor-script' );
    }


    /*public function admin_enqueue_scripts( $hook ){

		wp_enqueue_style( 'woofreendor-bootstrap-style', plugins_url() . '/woofreendor/assets/css/bootstrap.min.css');
		wp_register_script( 'woofreendor-bootstrap-script', plugins_url() . '/woofreendor/assets/js/bootstrap.min.js',array('jquery') );
		wp_enqueue_script('woofreendor-bootstrap-script');
        wp_enqueue_script( 'woofreendor-admin', plugins_url() . '/woofreendor/assets/js/woofreendor-admin.js', array( 'jquery' ) );
    }*/

 //    public function conditional_localized_args( $paramDefaultArgs ){
	// 	if ( dokan_is_seller_dashboard()
	// 			|| woofreendor_is_tenant_dashboard()//woofreendor_is_tenant_page
 //                || ( get_query_var( 'edit' ) && is_singular( 'product' ) )
 //                || dokan_is_store_page()
 //                || is_account_page()
 //                || apply_filters( 'dokan_force_load_extra_args', false )
 //            ) {

	// 		$general_settings = get_option( 'dokan_general', array() );

 //            $banner_width     = ! empty( $general_settings['store_banner_width'] ) ? $general_settings['store_banner_width'] : 625;
 //            $banner_height    = ! empty( $general_settings['store_banner_height'] ) ? $general_settings['store_banner_height'] : 300;
 //            $has_flex_width   = ! empty( $general_settings['store_banner_flex_width'] ) ? $general_settings['store_banner_flex_width'] : true;
 //            $has_flex_height  = ! empty( $general_settings['store_banner_flex_height'] ) ? $general_settings['store_banner_flex_height'] : true;

 //            $custom_args             = array (
 //                'product_title_required'              => __( 'Nama produk harus diisi', 'dokan-lite' ),
 //                'product_category_required'           => __( 'Kategori produk harus dipilih', 'dokan-lite' ),
 //                'reload_batch_error'           => __( 'Terjadi kesalahan', 'dokan-lite' ),
 //                'store_banner_dimension'              => [ 'width' => $banner_width, 'height' => $banner_height, 'flex-width' => $has_flex_width, 'flex-height' => $has_flex_height ],
 //                'reload_batch_nonce'              => wp_create_nonce( 'reload-batch' ),
 //                'update_batch_nonce'              => wp_create_nonce( 'update-batch' ),
 //                'delete_batch_nonce'              => wp_create_nonce( 'delete-batch' ),
 //                'add_batch_nonce'                 => wp_create_nonce( 'add-batch' ),
 //                'add_outlet_nonce'                 => wp_create_nonce( 'add-outlet' ),
 //                'update_outlet_nonce'                 => wp_create_nonce( 'update-outlet' ),
 //                'delete_outlet_nonce'                 => wp_create_nonce( 'delete-outlet' )
 //            );

 //            $paramDefaultArgs = array_merge( $paramDefaultArgs, $custom_args );
 //        }

 //        return $paramDefaultArgs;
	// }

	// function dokan_conditional_localized_args( $default_args ) {

 //        if ( dokan_is_seller_dashboard()
 //        		|| woofreendor_is_tenant_dashboard()
 //                || ( get_query_var( 'edit' ) && is_singular( 'product' ) )
 //                || dokan_is_store_page()
 //                || is_account_page()
 //                || apply_filters( 'dokan_force_load_extra_args', false )
 //            ) {

 //            $general_settings = get_option( 'dokan_general', array() );

 //            $banner_width     = ! empty( $general_settings['store_banner_width'] ) ? $general_settings['store_banner_width'] : 625;
 //            $banner_height    = ! empty( $general_settings['store_banner_height'] ) ? $general_settings['store_banner_height'] : 300;
 //            $has_flex_width   = ! empty( $general_settings['store_banner_flex_width'] ) ? $general_settings['store_banner_flex_width'] : true;
 //            $has_flex_height  = ! empty( $general_settings['store_banner_flex_height'] ) ? $general_settings['store_banner_flex_height'] : true;

 //            $custom_args             = array (
 //                'i18n_choose_featured_img'            => __( 'Upload featured image', 'dokan-lite' ),
 //                'i18n_choose_file'                    => __( 'Choose a file', 'dokan-lite' ),
 //                'i18n_choose_gallery'                 => __( 'Add Images to Product Gallery', 'dokan-lite' ),
 //                'i18n_choose_featured_img_btn_text'   => __( 'Set featured image', 'dokan-lite' ),
 //                'i18n_choose_file_btn_text'           => __( 'Insert file URL', 'dokan-lite' ),
 //                'i18n_choose_gallery_btn_text'        => __( 'Add to gallery', 'dokan-lite' ),
 //                'duplicates_attribute_messg'          => __( 'Sorry, this attribute option already exists, Try a different one.', 'dokan-lite' ),
 //                'variation_unset_warning'             => __( 'Warning! This product will not have any variations if this option is not checked.', 'dokan-lite' ),
 //                'new_attribute_prompt'                => __( 'Enter a name for the new attribute term:', 'dokan-lite' ),
 //                'remove_attribute'                    => __( 'Remove this attribute?', 'dokan-lite' ),
 //                'dokan_placeholder_img_src'           => wc_placeholder_img_src(),
 //                'add_variation_nonce'                 => wp_create_nonce( 'add-variation' ),
 //                'link_variation_nonce'                => wp_create_nonce( 'link-variations' ),
 //                'delete_variations_nonce'             => wp_create_nonce( 'delete-variations' ),
 //                'load_variations_nonce'               => wp_create_nonce( 'load-variations' ),
 //                'save_variations_nonce'               => wp_create_nonce( 'save-variations' ),
 //                'bulk_edit_variations_nonce'          => wp_create_nonce( 'bulk-edit-variations' ),
 //                'i18n_link_all_variations'            => esc_js( sprintf( __( 'Are you sure you want to link all variations? This will create a new variation for each and every possible combination of variation attributes (max %d per run).', 'dokan-lite' ), defined( 'WC_MAX_LINKED_VARIATIONS' ) ? WC_MAX_LINKED_VARIATIONS : 50 ) ),
 //                'i18n_enter_a_value'                  => esc_js( __( 'Enter a value', 'dokan-lite' ) ),
 //                'i18n_enter_menu_order'               => esc_js( __( 'Variation menu order (determines position in the list of variations)', 'dokan-lite' ) ),
 //                'i18n_enter_a_value_fixed_or_percent' => esc_js( __( 'Enter a value (fixed or %)', 'dokan-lite' ) ),
 //                'i18n_delete_all_variations'          => esc_js( __( 'Are you sure you want to delete all variations? This cannot be undone.', 'dokan-lite' ) ),
 //                'i18n_last_warning'                   => esc_js( __( 'Last warning, are you sure?', 'dokan-lite' ) ),
 //                'i18n_choose_image'                   => esc_js( __( 'Choose an image', 'dokan-lite' ) ),
 //                'i18n_set_image'                      => esc_js( __( 'Set variation image', 'dokan-lite' ) ),
 //                'i18n_variation_added'                => esc_js( __( "variation added", 'dokan-lite' ) ),
 //                'i18n_variations_added'               => esc_js( __( "variations added", 'dokan-lite' ) ),
 //                'i18n_no_variations_added'            => esc_js( __( "No variations added", 'dokan-lite' ) ),
 //                'i18n_remove_variation'               => esc_js( __( 'Are you sure you want to remove this variation?', 'dokan-lite' ) ),
 //                'i18n_scheduled_sale_start'           => esc_js( __( 'Sale start date (YYYY-MM-DD format or leave blank)', 'dokan-lite' ) ),
 //                'i18n_scheduled_sale_end'             => esc_js( __( 'Sale end date (YYYY-MM-DD format or leave blank)', 'dokan-lite' ) ),
 //                'i18n_edited_variations'              => esc_js( __( 'Save changes before changing page?', 'dokan-lite' ) ),
 //                'i18n_variation_count_single'         => esc_js( __( '%qty% variation', 'dokan-lite' ) ),
 //                'i18n_variation_count_plural'         => esc_js( __( '%qty% variations', 'dokan-lite' ) ),
 //                'i18n_no_result_found'                => esc_js( __( 'No Result Found', 'dokan-lite' ) ),
 //                'variations_per_page'                 => absint( apply_filters( 'dokan_product_variations_per_page', 10 ) ),
 //                'store_banner_dimension'              => [ 'width' => $banner_width, 'height' => $banner_height, 'flex-width' => $has_flex_width, 'flex-height' => $has_flex_height ],
 //                'selectAndCrop'                       => __( 'Select and Crop', 'dokan-lite' ),
 //                'chooseImage'                         => __( 'Choose Image', 'dokan-lite' ),
 //                'product_title_required'              => __( 'Product title is required', 'dokan-lite' ),
 //                'product_category_required'           => __( 'Product category is required', 'dokan-lite' ),
 //                'search_products_nonce'               => wp_create_nonce( 'search-products' )
 //            );

 //            $default_args = array_merge( $default_args, $custom_args );
 //        }

 //        return $default_args;
 //    }

    public function template_path() {
        return apply_filters( 'woofreendor_template_path', 'woofreendor/' );
    }
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }
}

function  woofreendor_load_plugin(){
	Woofreendor::init();
}
add_action( 'plugins_loaded', 'woofreendor_load_plugin', 5 );
register_activation_hook( __FILE__, array( 'Woofreendor', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Woofreendor', 'deactivate' ) );
//add_action( 'activated_plugin', array( 'Woofreendor_Installer', 'setup_page_redirect' ) );
// require_once plugin_dir_path( __FILE__ ) . 'includes/customizer/dbsnet-woocp-my-account.php';
// new DBSnet_Woocp_My_Account();
// register_activation_hook(__FILE__, array('DBSnet_Woocp_My_Account','dbsnet_woocp_my_account_install'));

