<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Installer {

    function do_install() {

        // installs
        $this->createUserRoles();


        // $groups_name = array( 'Wf_Tenant', 'Wf_Outlet' );
        // $this->createGroups($groups_name);

        $this->setupPages();

        if( class_exists( 'Woofreendor_Rewrites' )){
            Woofreendor_Rewrites::init()->register_rule();
        }

        flush_rewrite_rules();
    }
	/**
	 * Registering wordpress custom for this plugin
	 */
	// public static function woofreendor_activate(){

	// 	/*CREATE NEW ROLES*/
	// 	self::createUserRoles();

	// 	/*SETUP USER GROUP*/
	// 	$groups_name = array( 'Wf_Tenant', 'Wf_Outlet' );
	// 	self::createGroups($groups_name);

	// 	/*SETUP PAGE*/
	// 	self::setupPages();
	// }

	/**
	 * Create custom user roles 
	 * @return null
	 */
	function createUserRoles(){
		/*
		CREATE NEW ROLES
		*/
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$user_global_cap = array(
			'read'                   => true,
            'publish_posts'          => true,
            'edit_posts'             => true,
            'delete_published_posts' => true,
            'edit_published_posts'   => true,
            'delete_posts'           => true,
            'manage_categories'      => true,
            'moderate_comments'      => true,
            'unfiltered_html'        => true,
            'upload_files'           => true,
            'edit_shop_orders'       => true,
            'dokandar'               => true
			);

		$tenant_cap_wp = $user_global_cap;

        if(! $this->role_exists('woofreendor_tenant_role')){
            add_role('woofreendor_tenant_role', __( 'Tenant' ), $tenant_roles_wp);
        }

		/*
			ADD CAPABILITIES TO THE NEW ROLES
		*/
		$wp_roles->add_cap( 'woofreendor_tenant_role', 'woofreendor_tenant');
		$wp_roles->add_cap( 'seller', 'woofreendor_outlet');
		$wp_roles->add_cap( 'shop_manager', 'dokandar' );
        $wp_roles->add_cap( 'administrator', 'dokandar' );
	}

	/**
	 * Create groups
	 * @param  group name
	 * @return null
	 */
	// function createGroups($groups_name){
	// 	foreach($groups_name as $group_name){
	// 		if ( !( $group = Groups_Group::read_by_name( $group_name ) ) ) {
	// 			$group_id = Groups_Group::create( array( 'name' => $group_name ) );
	// 		}
	// 	}
	// }

	function setupPages(){
		$meta_key = '_wp_page_template';

        // return if pages were created before
        $page_created = get_option( 'woofreendor_pages_created', false );
        if ( $page_created ) {
            return;
        }

        $pages = array(
            array(
                'post_title' => __( 'Tenant Dashboard', 'woofreendor' ),
                'slug'       => 'tenant-dashboard',
                'page_id'    => 'tenant_dashboard',
                'content'    => '[woofreendor-tenant-dashboard]'
            ),
            array(
                'post_title' => __( 'Tenant List', 'woofreendor' ),
                'slug'       => 'tenant-listing',
                'page_id'    => 'tenant_listing',
                'content'    => '[woofreendor-tenants]'
            ),
            array(
                'post_title' => __( 'My Outlets', 'woofreendor' ),
                'slug'       => 'my-outlets',
                'page_id'    => 'my_outlets',
                'content'    => '[woofreendor-my-outlets]'
            ),
        );

        $woofreendor_page_settings = array();

        if ( $pages ) {
            foreach ($pages as $page) {
                $page_id = $this->createPages( $page );

                if ( $page_id ) {
                    $woofreendor_page_settings[$page['page_id']] = $page_id;

                    if ( isset( $page['child'] ) && count( $page['child'] ) > 0 ) {
                        foreach ($page['child'] as $child_page) {
                            $child_page_id = $this->createPages( $child_page );

                            if ( $child_page_id ) {
                                $woofreendor_page_settings[$child_page['page_id']] = $child_page_id;

                                wp_update_post( array( 'ID' => $child_page_id, 'post_parent' => $page_id ) );
                            }
                        }
                    } // if child
                } // if page_id
            } // end foreach
        } // if pages

        update_option( 'woofreendor_pages', $woofreendor_page_settings );
        update_option( 'woofreendor_pages_created', true );
	}

    function createPages( $page ) {
        $meta_key = '_wp_page_template';
        $page_obj = get_page_by_path( $page['post_title'] );

        if ( ! $page_obj ) {
            $page_id = wp_insert_post( array(
                'post_title'     => $page['post_title'],
                'post_name'      => $page['slug'],
                'post_content'   => $page['content'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed'
            ) );

            if ( $page_id && !is_wp_error( $page_id ) ) {

                if ( isset( $page['template'] ) ) {
                    update_post_meta( $page_id, $meta_key, $page['template'] );
                }

                return $page_id;
            }
        }

        return false;
    }

    function role_exists($role){
        if(!empty($role)){
            return $GLOBALS['wp_roles']->is_role($role);
        }
        return false;
    }

    // public static function setup_page_redirect( $plugin ) {

    //     if ( !get_transient( '_woofreendor_setup_page_redirect' ) ) {
    //         return;
    //     }
    //     // Delete the redirect transient
    //     delete_transient( '_woofreendor_setup_page_redirect' );

    //     wp_safe_redirect( add_query_arg( array( 'page' => 'dokan-setup' ), admin_url( 'index.php' ) ) );
    //     exit;
    // }

}