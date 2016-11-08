<?php
$user_guid = elgg_get_logged_in_user_guid();
$PageOwner=elgg_get_page_owner_guid();

if($user_guid==$PageOwner){
    echo elgg_view_module('aside', elgg_echo('ps:profilestrength'), elgg_view('widgets/profile_completness/content'));
}