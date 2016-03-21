<?php

$title = elgg_echo("cp_notify:quicklinks");
$content = "";

//$user = elgg_get_logged_in_user();
$no_notification_available = array('widget','hjforumcategory','messages','MySkill','experience','education','hjforumpost','hjforumtopic','hjforum');	// set all the entities that we want to exclude


$user = elgg_get_page_owner_entity();
$options = array(
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'type' => 'group',
	'limit' => false,
);

$groups = elgg_get_entities_from_relationship($options);

$content .= "<ul>";
$content .= "<li>".elgg_echo('cp_notify:sidebar:group_title')."<ul>";
foreach ($groups as $group) {
	$content .= "<li><a href='#group-{$group->guid}'>{$group->name}</a></li>";
}
$content .= "</ul></li>";

$options = array(
	'relationship' => 'cp_subscribed_to_email',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => false,
	'limit' => 0	// no limit
);
$interested_contents = elgg_get_entities_from_relationship($options);

$content .= "<li>".elgg_echo('cp_notify:sidebar:subs_title')."<ul>";
$cp_sub_count = 0;
foreach ($interested_contents as $interested_content) {
	if ($interested_content->owner_guid != $user->guid && !in_array($interested_content->getSubtype(), $no_notification_available) && $interested_content->title && $interested_content->getType() === 'object') {
		$content .= "<li>{$interested_content->title}</li>";
		$cp_sub_count++;
	}
}

if ($cp_sub_count == 0) {
	$content .= '<li>'.elgg_echo('cp_notify:sidebar:no_subscriptions').'</li>';
}
$content .= "</ul>";

echo elgg_view_module('aside',$title,$content);