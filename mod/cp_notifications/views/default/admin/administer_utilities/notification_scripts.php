<?php
//NOTIFICATION

echo '<p>'.elgg_view('cp_notifications/admin_nav').'</p>';

$title = elgg_echo('Scripts used to automate and migrate settings to New Subscription Functionality');
$dbprefix = elgg_get_config('dbprefix');




$body = "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Bulk-subscribe users to their content</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";
			
	$str_id = elgg_get_metastring_id('set_personal_subscription', true);
	$val_id = elgg_get_metastring_id('0');
	$query = "SELECT count(guid) as num_users FROM {$dbprefix}users_entity u LEFT JOIN (SELECT * FROM {$dbprefix}metadata WHERE name_id = {$str_id}) md ON u.guid = md.entity_guid WHERE md.value_id = {$val_id}";

	$count = get_data_row($query);

	$body .= elgg_view('admin/upgrades/view', array(
		'count' => $count->num_users,
		'action' => 'action/cp_notifications/set_personal_subscription',
	));

$body .= "</div>";
$body .= '</fieldset>';



$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Revert bulk-subscription of users to their conten</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

	$str_id = elgg_get_metastring_id('set_personal_subscription');
	$val_id = elgg_get_metastring_id('1');
	$query = "SELECT count(guid) as num_users FROM {$dbprefix}users_entity u LEFT JOIN (SELECT * FROM {$dbprefix}metadata WHERE name_id = {$str_id}) md ON u.guid = md.entity_guid WHERE md.value_id = {$val_id}";

	$count = get_data_row($query);
	$body .= elgg_view('admin/upgrades/view', array(
		'count' => $count->num_users,
		'action' => 'action/cp_notifications/reset_personal_subscription',
	));
		
$body .= "</div>";
$body .= '</fieldset>';



$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Bulk-subscribe users to group conten</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	$str_id = elgg_get_metastring_id('subscribed_to_all_group_content', true);	// get the metastring id, create the metastring if it does not exist
	$count = get_data_row("SELECT count(*) as users from {$dbprefix}users_entity u LEFT JOIN ( SELECT * from {$dbprefix}metadata WHERE name_id = {$str_id} ) md ON u.guid = md.entity_guid WHERE md.value_id IS NULL");

	$body .= elgg_view('admin/upgrades/view', array(
		'count' => $count->users,
		'action' => 'action/cp_notifications/subscribe_users_to_group_content',
	));
	access_show_hidden_entities($access_status);
			
$body .= "</div>";
$body .= '</fieldset>';



$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Revert bulk-subscription of users to group content</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	$str_id = elgg_get_metastring_id('subscribed_to_all_group_content', true);	// get the metastring id, create the metastring if it does not exist
	$count = get_data_row("SELECT count(*) as users from {$dbprefix}users_entity u LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid WHERE md.name_id = {$str_id}");

	$body .= elgg_view('admin/upgrades/view', array(
		'count' => $count->users,
		'action' => 'action/cp_notifications/undo_subscribe_users_to_group_content',
	));
	access_show_hidden_entities($access_status);
		
$body .= "</div>";
$body .= '</fieldset>';



$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Run Script for Personal-generated content subscription </legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

	$body .= elgg_view("output/confirmlink", array(
		'href' => elgg_get_site_url().'action/cp_notifications/set_personal_subscription',
		'text' => 'Click to Run Script',
		'confirm' => 'Are you sure you want to run the script?'
	));

$body .= "</div>";
$body .= '</fieldset>';




$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Run to fix inconsistent group subscriptions/members Script</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

	$str_id = elgg_get_metastring_id('fixing_notification_inconsistencies', true);
	$val_id = elgg_get_metastring_id('0');

	$query = "	SELECT COUNT(r1.guid_one) AS num_users
				FROM {$dbprefix}entity_relationships r1
				LEFT OUTER JOIN {$dbprefix}entity_relationships r2 ON r1.guid_two = r2.guid_two AND r2.relationship = 'member' AND r1.guid_one = r2.guid_one
				WHERE
					r1.guid_one IN (select guid FROM {$dbprefix}users_entity)
					AND r1.relationship LIKE 'cp_subscribed_to%'
					AND r1.guid_two IN (select guid FROM {$dbprefix}groups_entity)
					AND r2.relationship is null";

	$count = get_data_row($query);

	$body .= elgg_view('admin/upgrades/view', array(
		'count' => $count->num_users,
		'action' => 'action/cp_notifications/fix_inconsistent_subscription_script',
	));

$body .= "</div>";
$body .= '</fieldset>';



elgg_load_library('elgg:gc_notification:functions');

$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Fix all the invalid Forum subscriptions</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";
			
	// get all the forums subscribed by users
	$query = "  SELECT r1.guid_one, r1.guid_two, e.container_guid, es.subtype, r1.relationship
	            FROM elggentity_relationships r1 
	                LEFT JOIN elggentities e ON r1.guid_two = e.guid
	                LEFT JOIN elggentity_subtypes es ON es.id = e.subtype
	                LEFT JOIN elggusers_entity ue ON ue.guid = r1.guid_one
	            WHERE r1.relationship like 'cp_subscribed_to%' AND es.subtype like 'hj%'
	            GROUP BY r1.guid_one, r1.guid_two";

	// contains everything that is related to the forums
	$forums = get_data($query);
	$invalid_forums = array();

	// find all the invalid forums (users that are not members of a particular group that the forum resides in)
	foreach ($forums as $forum) {
	    $group_id = get_forum_in_group($forum->guid_two, $forum->guid_two);
	    $relationship = check_entity_relationship($forum->guid_one, 'member', $group_id);
	    
	    // check if the user is a member of the group indicated
	    if (!($relationship instanceof ElggRelationship)) {
	        $invalid_forums[] = "{$forum->guid_one}|{$forum->guid_two}|{$group_id}";
	    }
	}

	/*$body .= "<br/><br/>";
	foreach ($invalid_forums as $key => $value) {
		$body .= "<p>{$value} </p>";
	}
	$body .= "<br/><br/>";*/

	$body .= elgg_view('admin/upgrades/view', array(
		'count' => count($invalid_forums),
		'action' => 'action/cp_notifications/fix_forums_subscription',
	));

$body .= "</div>";
$body .= '</fieldset>';


/*
$body .= "<br/>";
$body .= '<fieldset class="elgg-fieldset" id="elgg-settings-advanced-system" style="padding-top:5px; padding-bottom:10px;">';
$body .= "<legend>Run to enable all users on site to use the Notification Digest</legend>";
$body .= "<div style='padding-top:10px; padding-bottom:10px;'>";

	$str_id = elgg_get_metastring_id('enable site-wide digest', true);
	$val_id = elgg_get_metastring_id('0');

	$query = "	SELECT COUNT(r1.guid_one) AS num_users
				FROM {$dbprefix}entity_relationships r1
				LEFT OUTER JOIN {$dbprefix}entity_relationships r2 ON r1.guid_two = r2.guid_two AND r2.relationship = 'member' AND r1.guid_one = r2.guid_one
				WHERE
					r1.guid_one IN (select guid FROM {$dbprefix}users_entity)
					AND r1.relationship LIKE 'cp_subscribed_to%'
					AND r1.guid_two IN (select guid FROM {$dbprefix}groups_entity)
					AND r2.relationship is null";

	$count = get_data_row($query);

	$body .= elgg_view('admin/upgrades/view', array(
		'count' => $count->num_users,
		'action' => 'action/cp_notifications/fix_inconsistent_subscription_script',
	));

$body .= "</div>";
$body .= '</fieldset>';
*/


echo elgg_view_module('main', $title, $body);


