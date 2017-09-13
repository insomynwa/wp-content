<?php

function woofreendor_dashboard_nav( $active_menu = '' ) {

    $nav_menu          = dokan_get_dashboard_nav();
    $active_menu_parts = explode( '/', $active_menu );

    if ( isset( $active_menu_parts[1] ) && $active_menu_parts[0] == 'settings' && array_key_exists( $active_menu_parts[1], $nav_menu['settings']['sub'] ) ) {
        $urls        = $nav_menu['settings']['sub'];
        $active_menu = $active_menu_parts[1];
    } else {
        $urls = $nav_menu;
    }

    $menu = '<ul class="dokan-dashboard-menu">';

    foreach ($urls as $key => $item) {
        $class = ( $active_menu == $key ) ? 'active ' . $key : $key;
        $menu .= sprintf( '<li class="%s"><a href="%s">%s %s</a></li>', $class, $item['url'], $item['icon'], $item['title'] );
    }

    if(woofreendor_is_user_tenant(get_current_user_id())) {
        $view_store_url = woofreendor_get_tenant_url( get_current_user_id());
        $edit_acc_url = woofreendor_get_navigation_url( 'edit-account' );
    }else{
        $view_store_url = dokan_get_store_url( get_current_user_id());
        $edit_acc_url = dokan_get_navigation_url( 'edit-account' );
    }
    
    $menu .= '<li class="dokan-common-links dokan-clearfix">
            <a title="' . __( 'Lihat Outlet', 'woofreendor' ) . '" class="tips" data-placement="top" href="' . $view_store_url .'" target="_blank"><i class="fa fa-external-link"></i></a>
            <a title="' . __( 'Edit Account', 'woofreendor' ) . '" class="tips" data-placement="top" href="' . $edit_acc_url . '"><i class="fa fa-user"></i></a>
            <a title="' . __( 'Log out', 'woofreendor' ) . '" class="tips" data-placement="top" href="' . wp_logout_url( home_url() ) . '"><i class="fa fa-power-off"></i></a>
        </li>';

    $menu .= '</ul>';

    return $menu;
}
function woofreendor_get_dashboard_nav() {

    $urls = array(
        'dashboard' => array(
            'title' => __( 'Dashboard', 'woofreendor'),
            'icon'  => '<i class="fa fa-tachometer"></i>',
            'url'   => woofreendor_get_navigation_url(),
            'pos'   => 10
        ),
        'outlets' => array(
            'title' => __( 'Outlets', 'woofreendor'),
            'icon'  => '<i class="fa fa-briefcase"></i>',
            'url'   => woofreendor_get_navigation_url( 'outlets' ),
            'pos'   => 30
        )
    );

    $settings = array(
        'title' => __( 'Pengaturan <i class="fa fa-angle-right pull-right"></i>', 'woofreendor'),
        'icon'  => '<i class="fa fa-cog"></i>',
        'url'   => woofreendor_get_navigation_url( 'settings/tenant' ),
        'pos'   => 200,
    );

    $settings_sub = array(
        'back' => array(
            'title' => __( 'Kembali ke dashboard', 'woofreendor'),
            'icon'  => '<i class="fa fa-long-arrow-left"></i>',
            'url'   => woofreendor_get_navigation_url(),
            'pos'   => 10
        ),
        'tenant' => array(
            'title' => __( 'Tenant', 'woofreendor'),
            'icon'  => '<i class="fa fa-university"></i>',
            'url'   => woofreendor_get_navigation_url( 'settings/tenant' ),
            'pos'   => 30
        )
    );


    /**
     * Filter to get the seller dashboard settings navigation.
     *
     * @since 2.2
     *
     * @param array.
     */
    $settings['sub']  = apply_filters( 'woofreendor_get_dashboard_settings_nav', $settings_sub );


    uasort( $settings['sub'], 'dokan_nav_sort_by_pos' );

    $urls['settings'] = $settings;

    $nav_urls = apply_filters( 'woofreendor_get_dashboard_nav', $urls );

    uasort( $nav_urls, 'dokan_nav_sort_by_pos' );

    /**
     * Filter to get the final seller dashboard navigation.
     *
     * @since 2.2
     *
     * @param array $urls.
     */
    return $nav_urls;
}
function woofreendor_tenants() {
    $attr = shortcode_atts( apply_filters( 'woofreendor_tenant_listing_per_page', array(
        'per_page' => 10,
        'search'   => 'yes',
        'per_row'  => 3,
    ) ), $atts );
    $paged   = max( 1, get_query_var( 'paged' ) );
    $limit   = $attr['per_page'];
    $offset  = ( $paged - 1 ) * $limit;

    $tenant_args = array(
        'number' => $limit,
        'offset' => $offset
    );

    // if search is enabled, perform a search
    if ( 'yes' == $attr['search'] ) {
        $search_term = isset( $_GET['woofreendor_tenant_search'] ) ? sanitize_text_field( $_GET['woofreendor_tenant_search'] ) : '';
        if ( '' != $search_term ) {

            $tenant_args['meta_query'] = array(
                 array(
                    'key'     => 'woofreendor_tenant_name',
                    'value'   => $search_term,
                    'compare' => 'LIKE'
                )
            );
        }
    }

    $tenants = woofreendor_get_tenants( apply_filters( 'woofreendor_tenant_listing_args', $tenant_args ) );

    /**
     * Filter for store listing args
     *
     * @since 2.4.9
     */
    $template_args = apply_filters( 'woofreendor_tenant_list_args', array(
        'tenants'    => $tenants,
        'limit'      => $limit,
        'offset'     => $offset,
        'paged'      => $paged,
        'image_size' => 'full',
        'search'     => $attr['search'],
        'per_row'    => $attr['per_row']
    ) );
    ob_start();
    woofreendor_get_template_part( 'tenant-lists', false, $template_args );
    $content = ob_get_clean();

    return apply_filters( 'woofreendor_tenant_listing', $content, $attr );
}
add_shortcode( 'woofreendor-tenants', 'woofreendor_tenants');