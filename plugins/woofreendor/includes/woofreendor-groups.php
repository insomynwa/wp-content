<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class Woofreendor_Groups {

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
	public function woofreendor_new_user_group($user_id){
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
	public function woofreendor_remove_deleted_user_component( $user_id ){

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

}