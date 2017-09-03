<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Multitenant_Admin {

	/**
	 * Registering wordpress custom for this plugin
	 */
	public static function dbsnet_woocp_activate(){
		/*CREATE NEW ROLES*/
		self::createCustomUserRoles();

		$groups_name = array( 'Tenant', 'Outlet' );
		self::createGroups($groups_name);
	}

	/**
	 * Create custom user roles 
	 * @return null
	 */
	static function createCustomUserRoles(){
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

		if(get_role('tenant_role') && get_role('outlet_role'))
			return;

		$tenant_roles_wp = array(
			'read'						=> true,
			'delete_posts'				=> true,
			'edit_posts'				=> true,
			'delete_published_posts	'	=> true,
			'publish_posts'				=> true,
			'upload_files'				=> true,
			'edit_published_posts'		=> true,
			);
		$outlet_roles_wp = array(
			'read'						=> true,
			'delete_posts'				=> true,
			'edit_posts'				=> true,
			'delete_published_posts	'	=> true,
			'publish_posts'				=> true,
			'upload_files'				=> true,
			'edit_published_posts'		=> true,
			);

		add_role('tenant_role', __( 'Tenant' ), $tenant_roles_wp);
		add_role('outlet_role', __( 'Outlet' ), $outlet_roles_wp);

		/*
			ADD CAPABILITIES TO THE NEW ROLES
		*/
		$capabilities['core'] = array(
			'manage_woocommerce',
			'view_woocommerce_reports',
		);
		$capability_types = array( 'product', 'shop_order', 'shop_coupon', 'shop_webhook' );
		foreach ( $capability_types as $capability_type ) {
			$capabilities[ $capability_type ] = array(
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",
				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms",
			);

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'tenant_role', $cap );
					$wp_roles->add_cap( 'outlet_role', $cap );
				}
			}
		}
	}

	/**
	 * Create groups
	 * @param  group name
	 * @return null
	 */
	static function createGroups($groups_name){
		foreach($groups_name as $group_name){
			if ( !( $group = Groups_Group::read_by_name( $group_name ) ) ) {
				$group_id = Groups_Group::create( array( 'name' => $group_name ) );
			}
		}
	}

	/**
	 * Get a group id
	 * @param  group name
	 * @return registeres group id
	 */
	private function getGroupId($group_name){
		$registered_group = Groups_Group::read_by_name($group_name);
		if ( !$registered_group ) {
			$registered_group_id = Groups_Group::create( array( 'name' => $group_name ) );
		} else {
			$registered_group_id = $registered_group->group_id;
		}
		return $registered_group_id;
	}

	/**
	 * Collecting new registered user's metadata
	 * @param user id
	 */
	public function dbsnet_woocp_grouping_new_user($user_id){
		$user_meta=get_userdata($user_id);
		$user_roles = $user_meta->roles;

		$obligate_group_name = "";
		$binder_group_name = "";
		$binder_group_id = 0;
			
		if(in_array("tenant_role", $user_roles)) {
			$obligate_group_name = "Tenant";
			$binder_group_name = $user_meta->user_login;
			$binder_group_id = $this->createGroup($binder_group_name);
			update_user_meta($user_id, 'binder_group', $binder_group_id);
		}
		else if(in_array("outlet_role", $user_roles)) {
			$obligate_group_name = "Outlet";
			if(isset($_POST['group-id'])){
				update_user_meta($user_id, 'binder_group', $_POST['group-id']);
			}
			$user_meta=get_userdata($user_id);
			$binder_group_id = $user_meta->binder_group;
		}
		$obligate_group_id = $this->getGroupId($obligate_group_name);
		$this->assignGroup($user_id, array($obligate_group_id,$binder_group_id));
	}

	/**
	 * Create a group
	 * @param  group name
	 * @return created group id or null
	 */
	private function createGroup($group_name){
		if ( !( $group = Groups_Group::read_by_name( $group_name ) ) ) {
			$group_id = Groups_Group::create( array( 'name' => $group_name ) );
			return $group_id;
		}
		return $group->group_id;
	}

	/**
	 * Assign new registered user to groups
	 * @param  new registered user id
	 * @param  groups id
	 * @return null
	 */
	private function assignGroup($user_id, $assinged_groups_id){
		foreach ($assinged_groups_id as $assinged_group_id) {
			Groups_User_Group::create(
				array(
					'user_id'	=> $user_id,
					'group_id'	=> $assinged_group_id
					)
				);
		}
	}

	/**
	 * Delete created group by deleted user
	 * Invoked after delete user
	 * @param deleted user id
	 */
	public function dbsnet_woocp_remove_deleted_user_component( $user_id ){

		$user_meta = get_userdata($user_id);
		$user_roles = $user_meta->roles;
		$is_tenant = in_array('tenant_role', $user_roles);
		$is_outlet = in_array('outlet_role', $user_roles);

		if($is_tenant){
			$member_role = "outlet_role";
			$tenant_group_name = $user_meta->user_login;
			if ( $group = Groups_Group::read_by_name( $tenant_group_name ) ) {
				$this->revokeGroupMember($group->group_id, $member_role);
				
				Groups_Group::delete( $group->group_id );
			}
		}
		else if($is_outlet){
			$args = array (
		        'numberposts' => -1,
		        'post_type' => array('product','product_variation'),
		        'author' => $user_id
		    );
		    // get all posts by this user: posts, pages, attachments, etc..
		    $user_posts = get_posts($args);

		    if (empty($user_posts)) return;

		    // delete all the user posts
		    foreach ($user_posts as $user_post) {
		        wp_update_post(array('ID'=> $user_post->ID,'post_status'=>'trash'));
		    }
		}
	}

	private function revokeGroupMember($group_id, $member_role){
		$binder_group = new Groups_Group($group_id);
		foreach($binder_group->users as $outlet){
			$member_meta = get_userdata($outlet->ID);
			if(in_array($member_role,$member_meta->roles)){
				update_user_meta($outlet->ID, 'binder_group', 0);
			}
		}
	}

	


	function debug_admin_menus() {
		if ( !is_admin())
	        return;

	    /*global $submenu, $menu, $pagenow;

		//	var_dump(get_taxonomy('product_cat'));die;
	    if ( current_user_can('manage_options') ) { // ONLY DO THIS FOR ADMIN
	        if( $pagenow == 'index.php' ) {  // PRINTS ON DASHBOARD
	            echo '<pre>'; print_r( $menu ); echo '</pre>'; // TOP LEVEL MENUS
	            echo '<pre>'; print_r( $submenu ); echo '</pre>'; // SUBMENUS
	        }
	    }*/
	}

}