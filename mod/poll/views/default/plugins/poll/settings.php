<?php

elgg_load_library('elgg:poll');

if (poll_is_upgrade_available()) {
	echo '<div class="mtl mbl elgg-admin-notices">';
	echo '<p>';
	echo elgg_view('output/url', array(
		'text' => elgg_echo('poll:upgrade'),
		'href' => 'action/poll/upgrade',
		'is_action' => true,
	));
	echo '</p>';
	echo '</div>';
}

$group_options = array(' '.elgg_echo('poll:settings:group_poll_default')=>'yes_default',
	' '.elgg_echo('poll:settings:group_poll_not_default')=>'yes_not_default',
	' '.elgg_echo('poll:settings:no')=>'no'
);
$yn_options = array(
	' '.elgg_echo('poll:settings:yes') => 'yes',
	' '.elgg_echo('poll:settings:no') => 'no'
);

// check if there are still polls with the former response data structure and offer upgrade if there are any
$old_polls_count = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'metadata_name' => 'responses',
	'count' => true
));

if ($old_polls_count > 0) {
	echo '<div class="mtl mbl">';
	echo '<p class="mbs">' . elgg_echo('poll:convert:description', array($old_polls_count)) . "</p>";
	echo elgg_view("output/url", array(
		'href' => elgg_get_site_url() . "action/poll/convert",
		'text' => elgg_echo('poll:convert'),
		'confirm' => elgg_echo('poll:convert:confirm'),
		'is_action' => true,
		'class' => 'elgg-button elgg-button-action'
	));
	echo "</div>";
}

$body = '';

$poll_send_notification = elgg_get_plugin_setting('send_notification', 'poll');
if (!$poll_send_notification) {
	$poll_send_notification = 'yes';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:send_notification:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[send_notification]', 'value' => $poll_send_notification, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:send_notification:desc') . '</p>';
$body .= "</div>";


$notification_on_vote = elgg_get_plugin_setting('notification_on_vote', 'poll');
if (!$notification_on_vote) {
	$notification_on_vote = 'no';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:notification_on_vote:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[notification_on_vote]', 'value' => $notification_on_vote, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:notification_on_vote:desc') . '</p>';
$body .= "</div>";


$poll_create_in_river = elgg_get_plugin_setting('create_in_river', 'poll');
if (!$poll_create_in_river) {
	$poll_create_in_river = 'yes';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:create_in_river:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[create_in_river]', 'value' => $poll_create_in_river, 'options' => $yn_options));
$body .= "</div>";


$poll_vote_in_river = elgg_get_plugin_setting('vote_in_river', 'poll');
if (!$poll_vote_in_river) {
	$poll_vote_in_river = 'yes';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:vote_in_river:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[vote_in_river]', 'value' => $poll_vote_in_river, 'options' => $yn_options));
$body .= "</div>";


$poll_group_poll = elgg_get_plugin_setting('group_poll', 'poll');
if (!$poll_group_poll) {
	$poll_group_poll = 'yes_default';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:group:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[group_poll]', 'value' => $poll_group_poll, 'options' => $group_options));
$body .= "</div>";


$poll_group_access_options = array(' '.elgg_echo('poll:settings:group_access:admins') => 'admins',
	' '.elgg_echo('poll:settings:group_access:members') => 'members',
);
$poll_group_access = elgg_get_plugin_setting('group_access', 'poll');
if (!$poll_group_access) {
	$poll_group_access = 'admins';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:group_access:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[group_access]', 'value' => $poll_group_access, 'options' => $poll_group_access_options));
$body .= "</div>";


$poll_site_access_options = array(' '.elgg_echo('poll:settings:site_access:admins') => 'admins',
	' '.elgg_echo('poll:settings:site_access:all') => 'all',
);
$poll_site_access = elgg_get_plugin_setting('site_access', 'poll');
if (!$poll_site_access) {
	$poll_site_access = 'all';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:site_access:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[site_access]', 'value' => $poll_site_access, 'options' => $poll_site_access_options));
$body .= "</div>";


$poll_front_page = elgg_get_plugin_setting('front_page', 'poll');
if (!$poll_front_page) {
	$poll_front_page = 'no';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:front_page:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[front_page]', 'value' => $poll_front_page, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:front_page:desc') . '</p>';
$body .= "</div>";


$allow_close_date = elgg_get_plugin_setting('allow_close_date', 'poll');
if (!$allow_close_date) {
	$allow_close_date = 'no';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:allow_close_date:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[allow_close_date]', 'value' => $allow_close_date, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:allow_close_date:desc') . '</p>';
$body .= "</div>";


$allow_open_poll = elgg_get_plugin_setting('allow_open_poll', 'poll');
if (!$allow_open_poll) {
	$allow_open_poll = 'no';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:allow_open_poll:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[allow_open_poll]', 'value' => $allow_open_poll, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:allow_open_poll:desc') . '</p>';
$body .= "</div>";


$multiple_answer_polls = elgg_get_plugin_setting('multiple_answer_polls', 'poll');
if (!$multiple_answer_polls) {
	$multiple_answer_polls = 'no';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:multiple_answer_polls:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[multiple_answer_polls]', 'value' => $multiple_answer_polls, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:multiple_answer_polls:desc') . '</p>';
$body .= "</div>";


$allow_poll_reset = elgg_get_plugin_setting('allow_poll_reset', 'poll');
if (!$allow_poll_reset) {
	$allow_poll_reset = 'no';
}
$body .= "<div class='mbm'>";
$body .= "<label>" . elgg_echo('poll:settings:allow_poll_reset:title') . "</label>";
$body .= '<br>';
$body .= elgg_view('input/radio', array('name' => 'params[allow_poll_reset]', 'value' => $allow_poll_reset, 'options' => $yn_options));
$body .= '<p class="elgg-subtext">' . elgg_echo('poll:settings:allow_poll_reset:desc') . '</p>';
$body .= "</div>";


echo $body;
