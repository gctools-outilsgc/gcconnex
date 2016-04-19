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



$count2 = $owner->getFriends(array('limit'=>0, 'count'=>true,));
//$count2 = 'testing';

$friendCount = '(' . $count2 . ')';

$all_link = elgg_view('output/url', array(
	'href' => 'friends/' . $owner->username,
	'text' => elgg_echo('profile:viewall:coll') . $friendCount,
	'is_trusted' => true,
    'class' => 'text-center btn btn-default center-block',
));

$footer = "<div class='text-right'>$all_link</div>";


if(!($friends)) {

    $friends = elgg_echo('gcprofile:nocoll', array($owner->getDisplayName()));
    $footer='';

}
echo elgg_view_module('aside', elgg_echo('friends'), $friends, array('footer' => $footer));

?>