<?php 
/*
User profile Colleagues
*/

$owner = elgg_get_page_owner_entity();


$friends = $owner->listFriends('', $num, array(
        'size' => 'small',
        'pagination' => FALSE,
        'list_type' => 'gallery',
        'gallery_class' => 'elgg-gallery-users',
        'count' => TRUE,
        'limit' => '14',
        ));

$friendCount = '(' . count($owner->getFriends()) . ')';

$all_link = elgg_view('output/url', array(
	'href' => 'friends/' . $owner->username,
	'text' => elgg_echo('View All Colleagues') . $friendCount,
	'is_trusted' => true,
));

$footer = "<div class='text-right'>$all_link</div>";

echo elgg_view_module('aside', elgg_echo('friends'), $friends, array('footer' => $footer));

?>