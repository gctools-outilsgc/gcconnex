<?php

/*
 * .../views/default/cp_notifications/sidebar.php
 * sidebar that displays all the content (much like a table of content to quickly view the subscriptions)
 *
 */

$title = elgg_echo("cp_notify:quicklinks");
$content = "";

// set all the entities that we want to exclude
$no_notification_available = array('widget','hjforumcategory','messages','MySkill','experience','education','hjforumpost','hjforumtopic','hjforum');	

$user = elgg_get_page_owner_entity();
$options = array(
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'type' => 'group',
	'limit' => false,
);

$groups = elgg_get_entities_from_relationship($options);

// list all the contents with style
$content .= "<ul class='list-unstyled'>";

/*
 * group subscriptions (and their respective contents)
 */
$content .= "<li> <strong>".elgg_echo('cp_notify:sidebar:group_title')."</strong> <ul class='list-unstyled mrgn-lft-sm'>";

// list the group contents
foreach ($groups as $group)
	$content .= "<li>- <a style='font-size:15px;' href='#group-{$group->guid}'>{$group->name}</a></li>";
$content .= "</ul></li>";


$options = array(
	'relationship' => 'cp_subscribed_to_email',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => false,
	'limit' => 0
);
$interested_contents = elgg_get_entities_from_relationship($options);


/*
 * personal subscriptions (not in groups)
 */
$content .= "<br/> <li> <strong>".elgg_echo('cp_notify:sidebar:subs_title')."</strong> <ul class='list-unstyled'>";
$cp_sub_count = 0;

// list the personal interested contents that user has subscribed
foreach ($interested_contents as $interested_content) {
	if ($interested_content->owner_guid != $user->guid && !in_array($interested_content->getSubtype(), $no_notification_available) && $interested_content->title && $interested_content->getType() === 'object') {
		$content .= "<li>- <a style='font-size:15px;' href='#'>{$interested_content->title}</a></li>";
		$cp_sub_count++;
	}
}

if ($cp_sub_count == 0)
	$content .= '<li>'.elgg_echo('cp_notify:sidebar:no_subscriptions').'</li>';
$content .= "</ul>";

echo elgg_view_module('aside',$title,$content);
