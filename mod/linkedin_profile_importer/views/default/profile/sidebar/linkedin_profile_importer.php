<?php
$user_guid = elgg_get_logged_in_user_guid();
$owner_guid = elgg_get_page_owner_guid();

if($user_guid == $owner_guid){
    echo elgg_view_module('aside', elgg_echo('linkedin:profile'), elgg_view('widgets/profile/content'));
}
