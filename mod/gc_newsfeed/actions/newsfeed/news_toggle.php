<?php
$user = elgg_get_logged_in_user_entity();

if(!isset($user->newsfeedCard) || $user->newsfeedCard == '')
{
  $user->newsfeedCard = 'list';
  system_message(elgg_echo('newsfeed:listview'));
}else{
  $user->newsfeedCard = '';
  system_message(elgg_echo('newsfeed:cardview'));
}