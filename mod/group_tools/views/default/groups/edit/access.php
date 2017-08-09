<?php

/**
 * Group Tools
 *
 * Group edit form
 *
 * This view contains everything related to group access.
 * eg: how can people join this group, who can see the group, etc
 *
 * @package ElggGroups
 * @author ColdTrick IT Solutions
 * 
 */

// load js
elgg_require_js('group_tools/group_edit');

$entity = elgg_extract('entity', $vars, false);
$membership = elgg_extract('membership', $vars);
$visibility = elgg_extract('vis', $vars);
$owner_guid = elgg_extract('owner_guid', $vars);
$content_access_mode = elgg_extract('content_access_mode', $vars);
$default_access = elgg_extract('group_default_access', $vars, ACCESS_DEFAULT);

$show_visibility = group_tools_allow_hidden_groups();
$show_visibility = ($show_visibility && (empty($entity->guid) || ($entity->access_id !== ACCESS_PRIVATE)));

$show_motivation_option = group_tools_join_motivation_required();
$motivation_plugin_setting = elgg_get_plugin_setting('join_motivation', 'group_tools', 'no');
$show_motivation_option = ($show_motivation_option && (strpos($motivation_plugin_setting, 'yes') === 0));

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('groups:membership'),
	'name' => 'membership',
	'value' => $membership,
	'options_values' => [
		ACCESS_PRIVATE => elgg_echo('groups:access:private'),
		ACCESS_PUBLIC => elgg_echo('groups:access:public'),
	],
	'onchange' => 'elgg.group_tools.show_join_motivation(this);',
]);

if ($show_motivation_option) {
	$checked = ($motivation_plugin_setting === 'yes_on');
	if ($entity instanceof \ElggGroup) {
		$group_setting = $entity->getPrivateSetting('join_motivation');
		if (!empty($group_setting)) {
			$checked = ($group_setting === 'yes');
		}
	}
	
	$join_motivation = elgg_view_field([
		'#type' => 'checkbox',
		'#label' => elgg_echo('group_tools:join_motivation:edit:option:label'),
		'#help' => elgg_echo('group_tools:join_motivation:edit:option:description'),
		'name' => 'join_motivation',
		'default' => 'no',
		'value' => 'yes',
		'checked' => $checked,
	]);
	
	echo elgg_format_element('div', [
		'id' => 'group-tools-join-motivation',
		'class' => ($membership === ACCESS_PRIVATE) ? '' : 'hidden',
	], $join_motivation);
}

if ($show_visibility) {
	$visibility_options = [
		ACCESS_PRIVATE => elgg_echo('groups:access:group'),
		ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
		ACCESS_PUBLIC => elgg_echo('PUBLIC'),
	];

	if (elgg_get_config('walled_garden')) {
		unset($visibility_options[ACCESS_PUBLIC]);
		
		if ($visibility == ACCESS_PUBLIC) {
			$visibility = ACCESS_LOGGED_IN;
		}
	}

	echo elgg_view_field([
		'#type' => 'access',
		'#label' => elgg_echo('groups:visibility'),
		'name' => 'vis',
		'id' => 'groups-vis',
		'value' => $visibility,
		'options_values' => $visibility_options,
		'entity' => $entity,
		'entity_type' => 'group',
		'entity_subtype' => '',
	]);
}

$access_mode_params = [
	'#type' => 'select',
	'#label' => elgg_echo('groups:content_access_mode'),
	'name' => 'content_access_mode',
	'id' => 'groups-content-access-mode',
	'value' => $content_access_mode,
	'options_values' => [
		\ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED => elgg_echo('groups:content_access_mode:unrestricted'),
		\ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY => elgg_echo('groups:content_access_mode:membersonly'),
	],
];

if ($entity) {
	// Disable content_access_mode field for hidden groups because the setting
	// will be forced to members_only regardless of the entered value
	if ($entity->access_id === $entity->group_acl) {
		$access_mode_params['disabled'] = 'disabled';
	}
	
	if ($entity && $entity->getContentAccessMode() == \ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED) {
		// Warn the user that changing the content access mode to more
		// restrictive will not affect the existing group content
		$access_mode_params['#help'] = elgg_echo('groups:content_access_mode:warning');
	}
}

echo elgg_view_field($access_mode_params);

// default group access
if ($entity && ($default_access === ACCESS_DEFAULT)) {
	$new_default_access = $entity->getPrivateSetting('elgg_default_access');
	if ($new_default_access !== null) {
		$default_access = (int) $new_default_access;
	}
}

// make sure the full list can be shown
$ga = false;
if ($entity) {
	$ga = $entity->getContentAccessMode();
	$entity->setContentAccessMode(ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED);
}

echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('group_tools:default_access:title'),
	'#help' => elgg_echo('group_tools:default_access:description'),
	'name' => 'group_default_access',
	'value' => $default_access,
	'id' => 'groups-default-access',
]);

if ($ga !== false) {
	$entity->setContentAccessMode($ga);
}

// next stuff only when entity exists
if (!$entity) {
	return;
}

// transfer owner

// who can transfer
$admin_transfer = elgg_get_plugin_setting('admin_transfer', 'group_tools');

$transfer_allowed = false;
if (($admin_transfer == 'admin') && elgg_is_admin_logged_in()) {
	$transfer_allowed = true;
} elseif (($admin_transfer == 'owner') && (($entity->getOwnerGUID() == elgg_get_logged_in_user_guid()) || elgg_is_admin_logged_in())) {
	$transfer_allowed = true;
}

if ($transfer_allowed) {
	echo elgg_view('group_tools/forms/admin_transfer', ['entity' => $entity]);
}
