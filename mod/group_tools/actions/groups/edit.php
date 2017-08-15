<?php
/**
 * Elgg groups plugin edit action.
 *
 * If editing an existing group, only the "group_guid" must be submitted. All other form
 * elements may be omitted and the corresponding data will be left as is.
 *
 * @package ElggGroups
 */

elgg_make_sticky_form('groups');

// Get group fields
$input = array();
foreach (elgg_get_config('group') as $shortname => $valuetype) {
	$value = get_input($shortname);

	if ($value === null) {
		// only submitted fields should be updated
		continue;
	}

	$input[$shortname] = $value;

	// @todo treat profile fields as unescaped: don't filter, encode on output
	if (is_array($input[$shortname])) {
		array_walk_recursive($input[$shortname], function (&$v) {
			$v = elgg_html_decode($v);
		});
	} else {
		$input[$shortname] = elgg_html_decode($input[$shortname]);
	}

	if ($valuetype == 'tags') {
		$input[$shortname] = string_to_tag_array($input[$shortname]);
	}
}

// only set if submitted
$name = get_input('name', null, false);
if ($name !== null) {

	$input['name'] = htmlspecialchars(get_input('name', '', false), ENT_QUOTES, 'UTF-8');
	$input['name2'] = htmlspecialchars(get_input('name2', '', false), ENT_QUOTES, 'UTF-8');
	$input['title'] = gc_implode_translation($input['name'], $input['name2']);
	$input['description3'] = gc_implode_translation($input['description'], $input['description2']);
	$input['briefdescription3'] = gc_implode_translation($input['briefdescription'], $input['briefdescription2']);
}

$user = elgg_get_logged_in_user_entity();

$group_guid = (int)get_input('group_guid');
$is_new_group = $group_guid == 0;

if ($is_new_group
		&& (elgg_get_plugin_setting('limited_groups', 'groups') == 'yes')
		&& !$user->isAdmin()) {
	register_error(elgg_echo("groups:cantcreate"));
	forward(REFERER);
}

$group = $group_guid ? get_entity($group_guid) : new ElggGroup();
if (elgg_instanceof($group, "group") && !$group->canEdit()) {
	register_error(elgg_echo("groups:cantedit"));
	forward(REFERER);
}

// Assume we can edit or this is a new group
foreach ($input as $shortname => $value) {
	// update access collection name if group name changes
	if (!$is_new_group && $shortname == 'name' && $value != $group->name) {
		$group_name = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		$ac_name = sanitize_string(elgg_echo('groups:group') . ": " . $group_name);
		$acl = get_access_collection($group->group_acl);
		if ($acl) {
			// @todo Elgg api does not support updating access collection name
			$db_prefix = elgg_get_config('dbprefix');
			$query = "UPDATE {$db_prefix}access_collections SET name = '$ac_name'
				WHERE id = $group->group_acl";
			update_data($query);
		}
	}

	if ($value === '' && !in_array($shortname, ['name', 'description'])) {
		// The group profile displays all profile fields that have a value.
		// We don't want to display fields with empty string value, so we
		// remove the metadata completely.
		$group->deleteMetadata($shortname);
		continue;
	}

	$group->$shortname = $value;
}

// Validate create
if ((!$group->name)&& (!$group->name2)){
	register_error(elgg_echo("groups:notitle"));
	forward(REFERER);
}

// Set group tool options (only pass along saved entities)
$tool_entity = !$is_new_group ? $group : null;
$tool_options = groups_get_group_tool_options($tool_entity);
if ($tool_options) {
	foreach ($tool_options as $group_option) {
		$option_toggle_name = $group_option->name . "_enable";
		$option_default = $group_option->default_on ? 'yes' : 'no';
		$value = get_input($option_toggle_name);

		// if already has option set, don't change if no submission
		if ($group->$option_toggle_name && $value === null) {
			continue;
		}

		$group->$option_toggle_name = $value ? $value : $option_default;
	}
}

// Group membership - should these be treated with same constants as access permissions?
$value = get_input('membership');
if ($group->membership === null || $value !== null) {
	$is_public_membership = ($value == ACCESS_PUBLIC);
	$group->membership = $is_public_membership ? ACCESS_PUBLIC : ACCESS_PRIVATE;
}

$group->setContentAccessMode((string)get_input('content_access_mode'));

if ($is_new_group) {
	$group->access_id = ACCESS_PUBLIC;

	// if new group, we need to save so group acl gets set in event handler
	if (!$group->save()) {
		register_error(elgg_echo("groups:save_error"));
		forward(REFERER);
	}
}

// Invisible group support + admin approve check
// @todo this requires save to be called to create the acl for the group. This
// is an odd requirement and should be removed. Either the acl creation happens
// in the action or the visibility moves to a plugin hook
$admin_approve = (bool) (elgg_get_plugin_setting('admin_approve', 'group_tools', 'no') == 'yes');
$admin_approve = ($admin_approve && !elgg_is_admin_logged_in()); // admins don't need to wait

// new groups get access private, so an admin can validate it
$access_id = (int) $group->access_id;
if ($is_new_group && $admin_approve) {
	$access_id = ACCESS_PRIVATE;
	
	elgg_trigger_event('admin_approval', 'group', $group);
}

if (group_tools_allow_hidden_groups()) {
	$value = get_input('vis');
	if ($is_new_group || $value !== null) {
		$visibility = (int)$value;
		
		if ($visibility == ACCESS_PRIVATE) {
			// Make this group visible only to group members. We need to use
			// ACCESS_PRIVATE on the form and convert it to group_acl here
			// because new groups do not have acl until they have been saved once.
			$visibility = (int) $group->group_acl;
			
			// Force all new group content to be available only to members
			$group->setContentAccessMode(ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY);
		}
		
		if (($access_id === ACCESS_PRIVATE) && $admin_approve) {
			// admins has not yet approved the group, store wanted access
			$group->intended_access_id = $visibility;
		} else {
			// already approved group
			$access_id = $visibility;
		}
	}
}

// set access
$group->access_id = $access_id;

if (!$group->save()) {
	register_error(elgg_echo("groups:save_error"));
	forward(REFERER);
}

// join motivation
if (!$group->isPublicMembership() && group_tools_join_motivation_required()) {
	$join_motivation = get_input('join_motivation');
	$group->setPrivateSetting('join_motivation', $join_motivation);
} else {
	$group->removePrivateSetting('join_motivation');
}

// default access
$default_access = get_input('group_default_access');
if ($default_access === null) {
	$default_access = (int) $group->group_acl;
}
$default_access = (int) $default_access;

if (($group->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY) && (($default_access === ACCESS_PUBLIC) || ($default_access === ACCESS_LOGGED_IN))) {
	system_message(elgg_echo('group_tools:action:group:edit:error:default_access'));
	$default_access = (int) $group->group_acl;
}
$group->setPrivateSetting("elgg_default_access", $default_access);


// group saved so clear sticky form
elgg_clear_sticky_form('groups');

// group creator needs to be member of new group and river entry created
if ($is_new_group) {

	// @todo this should not be necessary...
	elgg_set_page_owner_guid($group->guid);

	$group->join($user);
	elgg_create_river_item(array(
		'view' => 'river/group/create',
		'action_type' => 'create',
		'subject_guid' => $user->guid,
		'object_guid' => $group->guid,
	));
}

$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));

if ($has_uploaded_icon) {
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $group->owner_guid;
	$filehandler->setFilename("groups/$group->guid.jpg");
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('icon'));
	$filehandler->close();

	if ($filehandler->exists()) {
		// Non existent file throws exception
		$group->saveIconFromElggFile($filehandler);
	}
}

/**
* Group Tools
*
* Added action for user to upload a coverphoto to their group profile
* 
* @author Nick - https://github.com/piet0024
*/	

$c_photo = $_FILES['c_photo'];

foreach($c_photo as $c){
    $printing_files .= $c .' , ';
}
if(reset($c_photo) ){
    $prefix = "groups_c_photo/" . $group->guid;

    $filehandler2 = new ElggFile();
	$filehandler2->owner_guid = $group->owner_guid;
    $filehandler2->container_guid = $group->guid;
    $filehandler2->subtype = 'c_photo';
	$filehandler2->setFilename($prefix . ".jpg");
	$filehandler2->open("write");
	$filehandler2->write(get_uploaded_file('c_photo'));
	$filehandler2->close();
    $filehandler2->save();
    
    $c_photo_guid = $filehandler2->getGUID();
    $subtype_testing = $filehandler2->getSubtype();
   $group->cover_photo =$c_photo_guid; //Nick - Set Cover photo metadata
}else if(isset($group->cover_photo) && $group->cover_photo !='nope'){

}else{ 
$group->cover_photo = 'nope';
}

$remove_c_photo = get_input('remove_photo'); //Nick - Checkbox will set cover photo metadata to 'nope'
if($remove_c_photo){
    $group->cover_photo = 'nope';
}

// owner transfer
$old_owner_guid = $is_new_group ? 0 : $group->owner_guid;
$new_owner_guid = (int) get_input('owner_guid');

if (!$is_new_group && $new_owner_guid && ($new_owner_guid != $old_owner_guid)) {
	// who can transfer
	$admin_transfer = elgg_get_plugin_setting("admin_transfer", "group_tools");
	
	$transfer_allowed = false;
	if (($admin_transfer == "admin") && elgg_is_admin_logged_in()) {
		$transfer_allowed = true;
	} elseif (($admin_transfer == "owner") && (($group->getOwnerGUID() == $user->getGUID()) || elgg_is_admin_logged_in())) {
		$transfer_allowed = true;
	}
	
	if ($transfer_allowed) {
		// get the new owner
		$new_owner = get_user($new_owner_guid);
		
		// transfer the group to the new owner
		group_tools_transfer_group_ownership($group, $new_owner);
	}
}

// cyu - 05/12/2016: modified to comform to the business requirements documentation
if (elgg_is_active_plugin('cp_notifications')) {
	$user = elgg_get_logged_in_user_entity();
	add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
	add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
}

system_message(elgg_echo("groups:saved"));

forward($group->getUrl());
