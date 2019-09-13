<?php

/*
User profile Sidebar
*/
$owner = elgg_get_page_owner_entity();

$options = array(
    'type' => 'user',
    'pagination' => FALSE,
    'relationship' => 'friend',
    'relationship_guid' => $owner->getGUID(),
    'list_type' => 'gallery',
    'limit' => 14,
    'size' => 'small'
);

// add secondary clause for mutual relationships
$options['wheres'][] = get_mutual_friendship_where_clause();
$list = elgg_list_entities_from_relationship($options);
$count = count(elgg_get_entities_from_relationship($options));

$all_link = elgg_view('output/url', array(
	'href' => 'friends/' . $owner->username,
	'text' => elgg_echo('profile:viewall:coll'),
	'is_trusted' => true,
    'class' => 'text-center btn btn-default center-block',
));

$footer = "<div class='text-right'>$all_link</div>";

if($count <= 0) {
    $friends = elgg_echo('gcprofile:nocoll', array($owner->getDisplayName()));
    $footer = '';
}

echo elgg_view_module('aside', elgg_echo('friends'), $list, array('footer' => $footer));


// checks for reciprical friend relationship
function get_mutual_friendship_where_clause() {
    $db_prefix = get_config('dbprefix');
    return "EXISTS (
        SELECT 1 FROM {$db_prefix}entity_relationships r2
            WHERE r2.guid_one = r.guid_two
            AND r2.relationship = 'friend'
            AND r2.guid_two = r.guid_one)";
}

/*
User Profile Groups
*/

$owner = elgg_get_page_owner_entity();

$groups = elgg_get_entities_from_relationship(array(
    'relationship'=> 'member', 
    'relationship_guid'=> $owner->guid, 
    'inverse_relationship'=> FALSE, 
    'type'=> 'group', 
    'limit'=> 3
));

$count = elgg_get_entities_from_relationship(array(
    'relationship'=> 'member',
    'relationship_guid'=> $owner->guid,
    'inverse_relationship'=> FALSE,
    'type'=> 'group',
    'limit'=> false,
    'count'=>true,
));

$options = array(
            'full_view' => false,
            'list_type' => 'list',
            'pagination' => false,
        );

$content = elgg_view_entity_list($groups, $options);

$groupCount = '(' . $count . ')';

$all_link = elgg_view('output/url', array(
	'href' => 'groups/member/' . $owner->username,
	'text' => elgg_echo('profile:viewall:groups') . $groupCount,
	'is_trusted' => true,
    'class' => 'text-center btn btn-default center-block',
));

$footer = "<div class='text-right'>$all_link</div>";

if(!($groups)) {

    $content = elgg_echo('gcprofile:nogroups', array($owner->getDisplayName()));
    $footer='';
}

echo elgg_view_module('aside', elgg_echo('groups'), $content, array('footer' => $footer));

//echo elgg_view('profile/sidebar/colleagues', $vars);
//echo elgg_view('profile/sidebar/user_groups', $vars);

?>