<?php
/**
 * Elgg groups plugin edit action.
 *
 * @package ElggGroups
 */

elgg_make_sticky_form('groups');

/**
 * wrapper for recursive array walk decoding
 *
 * @param string &$v value
 *
 * @return string
 */
function profile_array_decoder(&$v) {
	$v = _elgg_html_decode($v);
}

// Get group fields
$input = array();
foreach (elgg_get_config('group') as $shortname => $valuetype) {
	$input[$shortname] = get_input($shortname);

	// @todo treat profile fields as unescaped: don't filter, encode on output
	if (is_array($input[$shortname])) {
		array_walk_recursive($input[$shortname], 'profile_array_decoder');
	} else {
		$input[$shortname] = _elgg_html_decode($input[$shortname]);
	}

	if ($valuetype == 'tags') {
		$input[$shortname] = string_to_tag_array($input[$shortname]);
	}
}

$input['name'] = htmlspecialchars(get_input('name', '', false), ENT_QUOTES, 'UTF-8');
$input['name2'] = htmlspecialchars(get_input('name2', '', false), ENT_QUOTES, 'UTF-8');
$input['title3'] = gc_implode_translation($input['name'], $input['name2']);
$input['description3'] = gc_implode_translation($input['description'], $input['description2']);
$input['briefdescription3'] = gc_implode_translation($input['briefdescription'], $input['briefdescription2']);

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
if (elgg_instanceof($group, "group") &&  !$group->canEdit()) {
	register_error(elgg_echo("groups:cantedit"));
	forward(REFERER);
}

// Assume we can edit or this is a new group
if (sizeof($input) > 0) {
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

		$group->$shortname = $value;
	}
	if(!$group->name){
		$group->name = $group->name2;
	}
}

// Validate create
if ((!$group->name)&& (!$group->name2)){
	register_error(elgg_echo("groups:notitle"));
	forward(REFERER);
}


// Set group tool options
$tool_options = elgg_get_config('group_tool_options');
if ($tool_options) {
	foreach ($tool_options as $group_option) {
		$option_toggle_name = $group_option->name . "_enable";
		$option_default = $group_option->default_on ? 'yes' : 'no';
		$group->$option_toggle_name = get_input($option_toggle_name, $option_default);
	}
}

// Group membership - should these be treated with same constants as access permissions?
$is_public_membership = (get_input('membership') == ACCESS_PUBLIC);
$group->membership = $is_public_membership ? ACCESS_PUBLIC : ACCESS_PRIVATE;

$group->setContentAccessMode(get_input('content_access_mode'));

if ($is_new_group) {
	$group->access_id = ACCESS_PUBLIC;
}

// default access
$default_access = (int) get_input('group_default_access');
$group->setPrivateSetting("elgg_default_access", $default_access);

if ($is_new_group) {
	// if new group, we need to save so group acl gets set in event handler
	$group->save();
}

// Invisible group support
// @todo this requires save to be called to create the acl for the group. This
// is an odd requirement and should be removed. Either the acl creation happens
// in the action or the visibility moves to a plugin hook
if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes') {
    $visibility = get_input('vis'); // without (int) cast

    if ($visibility == ACCESS_PRIVATE) { // ACCESS_PRIVATE or any string: for instance 'parent_group_acl'
        // Force all new group content to be available only to members
                if ($visibility === ACCESS_PRIVATE) { // Only for ACCESS_PRIVATE
                    $group->setContentAccessMode(ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY);
                }

        // Make this group visible only to group members. We need to use
        // ACCESS_PRIVATE on the form and convert it to group_acl here
        // because new groups do not have acl until they have been saved once.
        $visibility = $group->group_acl;
    }

    $group->access_id = $visibility;
}

$group->save();

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

$has_uploaded_icon = get_resized_image_from_uploaded_file("icon", 100, 100);

if ($has_uploaded_icon) {

	$icon_sizes = elgg_get_config('icon_sizes');

	$prefix = "groups/" . $group->guid;

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $group->owner_guid;
	$filehandler->setFilename($prefix . ".jpg");
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('icon'));
	$filehandler->close();
	$filename = $filehandler->getFilenameOnFilestore();

	$sizes = array('tiny', 'small', 'medium', 'large');

	$thumbs = array();
	foreach ($sizes as $size) {
		$thumbs[$size] = get_resized_image_from_existing_file(
			$filename,
			$icon_sizes[$size]['w'],
			$icon_sizes[$size]['h'],
			$icon_sizes[$size]['square']
		);
	}

	if ($thumbs['tiny']) { // just checking if resize successful
		$thumb = new ElggFile();
		$thumb->owner_guid = $group->owner_guid;
		$thumb->setMimeType('image/jpeg');

		foreach ($sizes as $size) {
			$thumb->setFilename("{$prefix}{$size}.jpg");
			$thumb->open("write");
			$thumb->write($thumbs[$size]);
			$thumb->close();
		}

		$group->icontime = time();
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
   $group->cover_photo = 'yessir'; //Nick - Yes there is a cover photo. Changed from the photo guid as this was not being set when a group admin / operator was trying to change the cover photo
}else if(isset($group->cover_photo) && $group->cover_photo !=='nope'){

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

		//transfer cover photo to new owner
		gc_group_layout_transfer_coverphoto($group, $new_owner);
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
