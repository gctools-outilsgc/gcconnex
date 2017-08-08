<?php

$user = elgg_extract('user', $vars);

$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();

$notification_settings = thewire_tools_get_notification_settings($user->getGUID());

$cells = elgg_format_element('td', ['class' => 'namefield'], elgg_view('output/longtext', ['value' => elgg_echo('thewire_tools:usersettings:notify_mention')]));

$i = 0;
foreach ($NOTIFICATION_HANDLERS as $method) {
	
	$checkbox_settings = [
		'id' => "thewire_tools_{$method}_checkbox",
		'name' => "thewire_tools_{$method}",
		'value' => $method,
		'onclick' => "adjust{$method}('thewire_tools_{$method}')",
	];
	
	if (in_array($method, $notification_settings)) {
		$checkbox_settings['checked'] = true;
	}
	
	if ($i > 0) {
		$cells .= elgg_format_element('td', ['class' => 'spacercolumn'], '&nbsp;');
	}
	
	$checkbox = elgg_view('output/url', [
		'border' => '0',
		'id' => "thewire_tools_{$method}",
		'class' => "{$method}toggleOff",
		'onclick' => "adjust{$method}_alt('thewire_tools_{$method}')",
		'text' => elgg_view('input/checkbox', $checkbox_settings),
	]);
	
	$cells .= elgg_format_element('td', ['class' => "{$method}togglefield"], $checkbox);

	$i++;
}

$cells .= elgg_format_element('td', [], '&nbsp;');

echo elgg_format_element('table', ['id' => 'thewire-tools-notification-settings', 'class' => 'hidden'], elgg_format_element('tr', [], $cells));

elgg_require_js('thewire_tools/notifications');