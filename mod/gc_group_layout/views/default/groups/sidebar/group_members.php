<?php
/**
 * Group members sidebar
 *
 * @package ElggGroups
 *
 * @uses $vars['entity'] Group entity
 * @uses $vars['limit']  The number of members to display
 */

$limit = elgg_extract('limit', $vars, 14);


//Commented out member count to improve performance. This would query for all users of the group and their metadata - Nick
//$members = $vars['entity']->getMembers(array('limit' => 0));

//$membersCount = '(' . count($members) . ')';

$all_link = elgg_view('output/url', array(
	'href' => 'groups/members/' . $vars['entity']->guid,
	'text' => elgg_echo('groups:members:more'),
	'is_trusted' => true,
    'class' => 'text-center btn btn-default center-block',
));

$body = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => $limit,
	'pagination' => false,
    'size' => 'small',
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users gallery-margin',
));



$footer = "<div class='text-right'>$all_link</div>";

echo elgg_view_module('aside', elgg_echo('groups:members'), $body, array('footer' => $footer));
