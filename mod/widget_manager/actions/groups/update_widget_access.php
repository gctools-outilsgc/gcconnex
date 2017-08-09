<?php
/**
 * Update widgets access for group
 */

$group_guid = (int) get_input('group_guid');
$new_access = get_input('widget_access_level'); // can't cast directly to int because of ACCESS_PRIVATE

if (empty($group_guid) || $new_access === null) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$group = get_entity($group_guid);

if (!elgg_instanceof($group, 'group')) {
	register_error(elgg_echo('groups:notfound:details'));
	forward(REFERER);
}

if (!$group->canEdit()) {
	register_error(elgg_echo('groups:cantedit'));
	forward(REFERER);
}

$new_access = (int) $new_access;

$widgets = elgg_get_entities_from_private_settings([
	'type' => 'object',
	'subtype' => 'widget',
	'owner_guid' => $group->getGUID(),
	'private_setting_name' => 'context',
	'private_setting_value' => 'groups',
	'limit' => false,
]);

if ($widgets) {
	foreach ($widgets as $widget) {
		$widget->access_id = $new_access;
		$widget->save();
	}
}

system_message(elgg_echo('widget_manager:action:groups:update_widget_access:success'));
forward($group->getURL());
