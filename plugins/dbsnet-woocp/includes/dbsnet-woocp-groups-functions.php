<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class DBSnet_Woocp_Group_Functions{

	public function __construct(){}

	public static function GetGroupMember($paramMemberId, $paramAllMember = true){
		//var_dump($paramMemberId);
		$group_id = get_user_meta($paramMemberId, 'binder_group', true);

		if(!$group_id)
			return false;
		$binder_group = new Groups_Group($group_id);

		$group_member = $binder_group->users;

		if(!$group_member) return "";

		if($paramAllMember)
			return $group_member;

		$other_member = array();
		foreach($group_member as $member){
			if($member->ID != $paramMemberId)
				$other_member[] = $member;
		}
		if(count($other_member)==0) return "You don't have any outlet yet. Create Now!";
		return $other_member;
	}

}