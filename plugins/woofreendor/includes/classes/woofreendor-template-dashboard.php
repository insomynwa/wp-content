<?php
/**
 * Woofreendor Template Dashboard Class
 *
 * @author weDves
 */
class Woofreendor_Template_Dashboard {

    public $user_id;
    public $orders_count;
    public $post_counts;
    public $comment_counts;
    public $pageviews;
    public $earning;
    public $seller_balance;

    /**
     * Load autometically when class inistantiate
     * hooked up all actions and filters
     *
     * @since 2.4
     */
    function __construct() {

        $this->user_id        = get_current_user_id();
        // $this->orders_count   = $this->get_orders_count();
        // $this->post_counts    = $this->get_post_counts();
        $this->outlet_counts    = $this->get_outlet_counts();
        // $this->comment_counts = $this->get_comment_counts();
        // $this->pageviews      = $this->get_pageviews();
        // $this->earning        = $this->get_earning();
        // $this->seller_balance = $this->get_seller_balance();

        add_action( 'dokan_get_dashboard_nav', array($this, 'mod_dashboard_nav') );
        add_filter( 'dokan_get_dashboard_settings_nav', array( $this, 'mod_load_settings_menu' ), 10 );

        
        add_action( 'woofreendor_dashboard_left_widgets', array( $this, 'get_outlets_widgets' ), 10 );

        // add_action( 'woofreendor_dashboard_content_inside_before', array( $this, 'show_tenant_dashboard_notice' ), 10 );
        // add_action( 'dokan_dashboard_left_widgets', array( $this, 'get_big_counter_widgets' ), 10 );
        // add_action( 'dokan_dashboard_left_widgets', array( $this, 'get_orders_widgets' ), 15 );
        // add_action( 'dokan_dashboard_left_widgets', array( $this, 'get_products_widgets' ), 20 );
        // add_action( 'dokan_dashboard_right_widgets', array( $this, 'get_sales_report_chart_widget' ), 10 );

    }

    /**
     * Singleton method
     *
     * @return self
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Woofreendor_Template_Dashboard();
        }

        return $instance;
    }

    /**
     * Get Seller Dhasboard Notice
     *
     * @since 2.4
     *
     * @return void
     */
    // public function show_tenant_dashboard_notice() {
        // $user_id = get_current_user_id();

        // if ( ! dokan_is_seller_enabled( $user_id ) ) {
        //     echo dokan_seller_not_enabled_notice();
        // }
    // }

    /**
     * Get big counter widget in dashboard
     *
     * @since 2.4
     *
     * @return void
     */
    // public function get_big_counter_widgets() {

    //     dokan_get_template_part( 'dashboard/big-counter-widget', '', array(
    //             'pageviews'      => $this->pageviews,
    //             'orders_count'  => $this->orders_count,
    //             'earning'        => $this->earning,
    //             'seller_balance' => $this->seller_balance
    //         )
    //     );
    // }

    function mod_dashboard_nav($paramUrls){
        $title_link_args = array(
            'products'  =>  __( 'Produk', 'woofreendor'),
            'orders'    =>  __( 'Pemesanan', 'woofreendor'),
            'settings'  =>  __( 'Pengaturan', 'woofreendor'),
            );

        $paramUrls = $this->mod_title_url( $paramUrls, $title_link_args);

        if ( woofreendor_is_user_tenant( get_current_user_id() ) ) {
            // var_dump(dokan_is_seller_dashboard());

            // $paramUrls = $this->add_new_dashboard_url_nav( $paramUrls );
            // var_dump($paramUrls['settings']['url']);
            $mod_link_url = array(
                'dashboard'  =>  woofreendor_get_navigation_url(),
                'settings'   =>  woofreendor_get_navigation_url( 'settings/tenant' ),
                );

            $paramUrls = $this->mod_link_url( $paramUrls, $mod_link_url);

            // var_dump($paramUrls['settings']['url']);
            $rem_url = array( 'orders', 'withdraw');
            $paramUrls = $this->remove_tenant_nav( $paramUrls, $rem_url);
        }
        else {
            
        }

        return $paramUrls;
    }

    function mod_title_url( $paramUrls, $paramArrLink){
        foreach ($paramArrLink as $slug => $value) {
            $paramUrls[$slug]['title'] = $value;
        }

        return $paramUrls;
    }

    function mod_link_url( $paramUrls, $paramArrLink){
        foreach ($paramArrLink as $slug => $value) {
            $paramUrls[$slug]['url'] = $value;
        }

        return $paramUrls;
    }

    // function add_new_dashboard_url_nav( $paramUrls ){
    //     $paramUrls['tenant_dashboard'] = array(
    //         'title' => __( 'Dashboard', 'woofreendor' ),
    //         'icon'  => '<i class="fa fa-line-chart"></i>',
    //         'url'   => woofreendor_get_navigation_url(),
    //         'pos'   => 10
    //     );

    //     return $paramUrls;
    // }

    function remove_tenant_nav( $paramUrls, $paramArrSlug ){
        foreach ($paramArrSlug as $slug) {
            unset( $paramUrls[$slug] );
        }

        return $paramUrls;
    }


    public function mod_load_settings_menu( $sub_settings ) {

        if ( woofreendor_is_user_tenant( get_current_user_id() ) ) {
            $mod_link_url = array(
                'back'  =>  woofreendor_get_navigation_url(),
                );

            $sub_settings = $this->mod_settings_link_url( $sub_settings, $mod_link_url);

            $rem_url = array( 'store', 'payment');
            $sub_settings = $this->remove_settings_tenant_nav( $sub_settings, $rem_url);
        }
        else{

        }

        return $sub_settings;
    }

    function remove_settings_tenant_nav( $sub_settings, $paramArrSlug ){
        foreach ($paramArrSlug as $slug) {
            unset( $sub_settings[$slug] );
        }

        return $sub_settings;
    }

    function mod_settings_link_url( $sub_settings, $paramArrLink){
        foreach ($paramArrLink as $slug => $value) {
            $sub_settings[$slug]['url'] = $value;
        }

        return $sub_settings;
    }

    /**
     * Get order widget in Dashboard
     *
     * @since 2.4
     *
     * @return void
     */
    // public function get_orders_widgets() {

    //     $order_data = array(
    //         array( 'value' => $this->orders_count->{'wc-completed'}, 'color' => '#73a724' ),
    //         array( 'value' => $this->orders_count->{'wc-pending'}, 'color' => '#999' ),
    //         array( 'value' => $this->orders_count->{'wc-processing'}, 'color' => '#21759b' ),
    //         array( 'value' => $this->orders_count->{'wc-cancelled'}, 'color' => '#d54e21' ),
    //         array( 'value' => $this->orders_count->{'wc-refunded'}, 'color' => '#e6db55' ),
    //         array( 'value' => $this->orders_count->{'wc-on-hold'}, 'color' => '#f0ad4e' ),
    //     );

    //     dokan_get_template_part( 'dashboard/orders-widget', '', array(
    //             'order_data'=> $order_data,
    //             'orders_count'  => $this->orders_count,
    //             'orders_url'=> woofreendor_get_navigation_url('orders'),
    //         )
    //     );
    // }

    /**
     * Get product widgets in dashboard
     *
     * @since 2.4
     *
     * @return void
     */
    public function get_outlets_widgets() {
        woofreendor_get_template_part( 'dashboard/outlets-widget', '', array(
                'outlet_counts'=> $this->outlet_counts,
                'outlets_url'=> woofreendor_get_navigation_url('outlets'),
            )
        );
    }

    /**
     * Get sales report chart widget in dashboard
     *
     * @since 2.4
     *
     * @return void
     */
    // public function get_sales_report_chart_widget() {
    //     dokan_get_template_part( 'dashboard/sales-chart-widget', '' );
    // }

    /**
     * Get orders Count
     *
     * @since 2.4
     *
     * @return integer
     */
    // public function get_orders_count() {
    //     return dokan_count_orders( $this->user_id );
    // }

    /**
     * Get Post Count
     *
     * @since 2.4
     *
     * @return integer
     */
    public function get_outlet_counts() {
        return woofreendor_count_outlets( $this->user_id );
    }

    /**
     * Get Comments Count
     *
     * @since 2.4
     *
     * @return integer
     */
    // public function get_comment_counts() {
    //     return dokan_count_comments( 'product', $this->user_id );
    // }

    /**
     * Get Pageview Count
     *
     * @since 2.4
     *
     * @return integer
     */
    // public function get_pageviews() {
    //     return (int) dokan_author_pageviews( $this->user_id );
    // }

    /**
     * Get Author Sales Count
     *
     * @since 2.4
     *
     * @return integer
     */
    // public function get_earning() {
    //     return dokan_author_total_sales( $this->user_id );
    // }

    /**
     * Get Seller Balance
     *
     * @since 2.4
     *
     * @return integer
     */
    // public function get_seller_balance() {
    //     return dokan_get_seller_balance( $this->user_id );
    // }
}