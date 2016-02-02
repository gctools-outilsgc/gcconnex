<?php 
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
    'limit'=> false
));

$options = array(
            'full_view' => false,
            'list_type' => 'list',
            'pagination' => false,
        );

$content = elgg_view_entity_list($groups, $options);

$groupCount = '(' . count($count) . ')';

$all_link = elgg_view('output/url', array(
	'href' => 'groups/member/' . $owner->username,
	'text' => elgg_echo('View All Groups') . $groupCount,
	'is_trusted' => true,
    'class' => 'text-center btn btn-default center-block',
));

$footer = "<div class='text-right'>$all_link</div>";

echo elgg_view_module('aside', elgg_echo('groups'), $content, array('footer' => $footer));

?>