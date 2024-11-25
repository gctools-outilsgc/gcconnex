<?php

echo elgg_view('cp_notifications/admin_nav');

$title = elgg_echo('Notifications Administrative Settings');

// pre defined values, if not set
if (!isset($vars['entity']->cp_notifications_email_addr))
	$vars['entity']->cp_notifications_email_addr = 'admin.gcconnex@tbs-sct.gc.ca';

if (!isset($vars['entity']->cp_notifications_display))
	$vars['entity']->cp_notifications_display = '1';

if (!isset($vars['entity']->cp_notifications_opt_out))
	$vars['entity']->cp_notifications_opt_out = 'no';

if (!isset($vars['entity']->cp_notifications_enable_bulk))
	$vars['entity']->cp_notifications_enable_bulk = 'no';

if (!isset($vars['entity']->cp_notifications_sidebar))
	$vars['entity']->cp_notifications_sidebar = 'no';

if (!isset($vars['entity']->cp_enable_minor_edit))
	$vars['entity']->cp_enable_minor_edit = 'no';

if (!isset($vars['entity']->cp_notifications_disable_content_notifications))
	$vars['entity']->cp_notifications_disable_content_notifications = 'no';


$body = "<br/>";

$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Back-end</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

// display and allow admin to change the reply email (will be modified in the header)
$body .= "<label> Email Address to be used </label>";
$body .= elgg_view('input/text', array(
	'name' => 'params[cp_notifications_email_addr]',
	'value' => $vars['entity']->cp_notifications_email_addr,
));

$body .= "<br/><br/>";

// display option to allow users to opt-out of the auto-subscription
$body .= "<label> Allow users to opt-out to have all their stuff subscribed </label>";
$body .=  elgg_view('input/select', array(
	'name' => 'params[cp_notifications_opt_out]',
	'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ),
	'value' => $vars['entity']->cp_notifications_opt_out,
));


$body .= "</div>";
$body .= '</fieldset>';



$body .= "<br/>";


$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Display settings for User Notifications Settings page</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";


// display quick links for users (in user settings page for notifications)
$body .= "<label> Enable Quick links sidebar for users </label>";
$body .= elgg_view('input/select', array(
	'name' => 'params[cp_notifications_sidebar]',
	'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')	),
	'value' => $vars['entity']->cp_notifications_sidebar,
));

$body .= "<br/><br/>";

// display option to allow users to enable bulk e-mail notifications
$body .= "<label> Enable Bulk Notifications </label>";
$body .= elgg_view('input/select', array(
	'name' => 'params[cp_notifications_enable_bulk]',
	'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')	),
	'value' => $vars['entity']->cp_notifications_enable_bulk,
));

$body .= "<br/><br/>";

// display option to enable minor edit option (otherwise send notifications when there are edits)
$body .= "<label> Enable Minor Edit option </label>";
$body .=  elgg_view('input/select', array(
	'name' => 'params[cp_enable_minor_edit]',
	'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ),
	'value' => $vars['entity']->cp_enable_minor_edit,
));

$body .= "<br/><br/>";

// disable new content notifications
$body .= "<label> DISABLE all new content notifications, excluding careers marketplace </label>";
$body .= elgg_view('input/select', array(
	'name' => 'params[cp_notifications_disable_content_notifications]',
	'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')	),
	'value' => $vars['entity']->cp_notifications_disable_content_notifications,
));

$body .= "<br/><br/>";

// control the number of groups being displayed
$body .= "<label> Display number of items in the Notifications Setting page </label>";
$body .= elgg_view('input/select', array(
	'name' => 'params[cp_notifications_display]',
	'options_values' => array(
		'5' => elgg_echo('option:5'),	// cyu - for testing
		'50' => elgg_echo('option:50'),
		'75' => elgg_echo('option:75'),
		'100' => elgg_echo('option:100'),
	),
	'value' => $vars['entity']->cp_notifications_display,
));

$body .= "</div>";
$body .= '</fieldset>';


echo elgg_view_module('main', $title, $body);

