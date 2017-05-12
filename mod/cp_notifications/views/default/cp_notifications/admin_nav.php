<?php
// NOTIFICATIONS
$url = current_page_url();
$url_split = explode('?', $url);
$pieces = explode('#', array_shift($url_split)); // quick separation of query/fragment elements
$current_url = $pieces[0];

$tabs = array(
	array(
		'name' => 'tab_settings',
		'text' => elgg_echo('Notifications Settings'),
		'href' => 'admin/plugin_settings/cp_notifications',
		'selected' => (elgg_http_url_is_identical($current_url, elgg_normalize_url('admin/plugin_settings/cp_notifications')))
	),

	array(
		'name' => 'tab_scripts',
		'text' => elgg_echo('Notifications Scripts'),
		'href' => 'admin/administer_utilities/notification_scripts',
		'selected' => (elgg_http_url_is_identical($current_url, elgg_normalize_url('admin/administer_utilities/notification_scripts')))
	),

	array(
		'name' => 'tab_troubleshoot',
		'text' => elgg_echo('Notifications Troubleshoot'),
		'href' => 'admin/administer_utilities/notification_troubleshoot',
		'selected' => (elgg_http_url_is_identical($current_url, elgg_normalize_url('admin/administer_utilities/notification_troubleshoot')))
	)
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));