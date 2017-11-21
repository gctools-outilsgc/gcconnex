<?php 

/**
 * Retrieves all the members of a group
 * Functionality that replaces the Friend Picker in the Send Email to (all) group members
 * Author: Christine Yu (GitHub @Pandurx)
 * Date created: October 25, 2017
 **/

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$group_guid = (int)get_input('group_guid');
$page_selected = (int)get_input('page_selected');
$number_of_members_per_page = (int)get_input('number_of_members_per_page');
$save_selected = get_input('save_selected');

$save_selected_array = explode(',', $save_selected);


$offset = $number_of_members_per_page * $page_selected;
$query = "SELECT ue.name, r.guid_one FROM elggentity_relationships r, elggusers_entity ue WHERE r.guid_one = ue.guid AND r.relationship = 'member' AND r.guid_two = {$group_guid}";
$group_members = get_data($query);

$group_members = array_slice($group_members, $offset, $number_of_members_per_page);
$display_members = array();

foreach ($group_members as $member) {
	$member = get_entity($member->guid_one);
	$checked = (in_array($member->getGUID(), $save_selected_array)) ? true : false;
	$member_icon = "<img class='img-circle' src='{$member->getIconURL(array('size' => 'small'))}'/>";

	$checkbox = elgg_view('input/checkbox', array(
		'name' => 'chkMember',
		'value' => 	$member->getGUID(),
		'checked' => $checked,
	));
	$display_members[$member->getGUID()] =  "<div style='border-bottom:1px solid black; padding:5px 2px 2px 2px;'> {$checkbox} {$member_icon} {$member->name} ( {$member->getGUID()} ) </div>";
}


echo json_encode([
	'display_members' => $display_members,
]);

