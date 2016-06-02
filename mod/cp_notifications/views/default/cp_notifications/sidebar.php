<?php

/*
 * .../views/default/cp_notifications/sidebar.php
 * sidebar that displays all the content (much like a table of content to quickly view the subscriptions)
 *
 */

$title = elgg_echo("cp_notify:quicklinks");
$content = "";

// set all the entities that we want to exclude
$no_notification_available = array('widget','hjforumcategory','messages','MySkill','experience','education','hjforumpost',);

/*
 * group subscriptions (and their respective contents)
 */

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


$content .= "<li> <strong>".elgg_echo('cp_notify:sidebar:group_title')."</strong> <ul class='list-unstyled mrgn-lft-sm'>";

// list the group contents
foreach ($groups as $group) {
	$shortened_name = $group->name;
	if (strlen($group->name) >= 30)
		$shortened_name = substr($group->name, 0, 35).'...';

	$content .= "<li>- <a style='font-size:15px;' href='#group-{$group->guid}'>{$shortened_name}</a></li>";
}
$content .= "</ul></li>";







/*
 * personal subscriptions (not in groups)
 */


$options = array(
	'relationship' => 'cp_subscribed_to_email',
	'relationship_guid' => elgg_get_logged_in_user_guid(),
	'inverse_relationship' => false,
	'limit' => 100
);

$interested_contents = elgg_get_entities_from_relationship($options);


$content .= "<br/> <li> <strong>".elgg_echo('cp_notify:sidebar:subs_title')."</strong> <ul class='list-unstyled'>";
$cp_sub_count = 0;

// list the personal interested contents that user has subscribed
foreach ($interested_contents as $interested_content) {
	if ($interested_content->owner_guid != $user->guid && !in_array($interested_content->getSubtype(), $no_notification_available) && $interested_content->title && $interested_content->getType() === 'object') {

		$subtype_name = cp_translate_subtype($interested_content->getSubtype());

		$shortened_name = $interested_content->title;
		if (strlen($interested_content->title) >= 30)
			$shortened_name = substr($interested_content->title, 0, 35).'...';
		
		$content .= "<div class='abcdg'> <li>- <a style='font-size:15px;' href='#'>{$shortened_name}</a> <sup>{$subtype_name}</sup> </li> </div>";
		$cp_sub_count++;
		
	}
}
if ($cp_sub_count == 0)
	$content .= '<li>'.elgg_echo('cp_notify:sidebar:no_subscriptions').'</li>';

$content .= "</ul>";
 


/*
 * forums and such
 */



/*
$options = array(
	'relationship' => 'subscribed',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => false,
	'limit' => 50
);

$cp_sub_count = 0;

$interested_contents = elgg_get_entities_from_relationship($options);

$content .= "<br/> <li> <strong>".elgg_echo('cp_notify:sidebar:forum_title')."</strong> <ul class='list-unstyled'>";

foreach ($interested_contents as $interested_content) {

	$subtype_name = cp_translate_subtype($interested_content->getSubtype());

	$shortened_name = $interested_content->title;
	if (strlen($interested_content->title) >= 30)
		$shortened_name = substr($interested_content->title, 0, 35).'...';
	
	// url for hjforumtopic and hjforum are different
	// .../gcforums/group/grp-id/entity-id/hjforumtopic vs .../gcforums/group/grp-id/container-id/entity-id
	if (strcmp($interested_content->getSubtype(),'hjforumtopic'))
		$content .= "<div> <li>- <a style='font-size:15px;' href='#'>{$shortened_name}</a> <sup>{$subtype_name}</sup> </li> </div>";

	$cp_sub_count++;
	
}

if ($cp_sub_count == 0)
	$content .= '<li>'.elgg_echo('cp_notify:sidebar:no_subscriptions').'</li>';


$content .= "</ul>";
*/

echo elgg_view_module('aside',$title,$content);

