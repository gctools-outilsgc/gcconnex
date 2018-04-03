<?php
/**
 * Elgg friends page
 *
 * @package Elgg.Core
 * @subpackage Social.Friends
 */
 /*
 * GC_MODIFICATION
 * Description: Modified display limit to utilize datatables, also added suggested friend widget to sidebar.
 * Author: GCTools Team
 */
$owner = elgg_get_page_owner_entity();

$title = elgg_echo("friends:owned", array($owner->name));

$dbprefix = elgg_get_config('dbprefix');
$options = array(
	'relationship' => 'friend',
	'relationship_guid' => $owner->getGUID(),
	'inverse_relationship' => false,
	'type' => 'user',
	'joins' => array("JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid"),
	'order_by' => 'ue.name ASC',
	'full_view' => false,
	'no_results' => elgg_echo('friends:none'),
    //makes the limits for friends and stuff higher for data tables
    'limit' => '700',

);
$options['wheres'][] = get_mutual_friendship_where_clause();

$content = elgg_list_entities_from_relationship($options);

$params = array(
	'content' => $content,
	'title' => $title,
    'sidebar'=>elgg_view('widgets/suggested_friends/content'),
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);


// checks for reciprical friend relationship
function get_mutual_friendship_where_clause() {
    $db_prefix = get_config('dbprefix');
    return "EXISTS (
        SELECT 1 FROM {$db_prefix}entity_relationships r2
            WHERE r2.guid_one = r.guid_two
            AND r2.relationship = 'friend'
            AND r2.guid_two = r.guid_one)";
}

