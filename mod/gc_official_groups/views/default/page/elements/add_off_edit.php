<?php


$user = elgg_get_logged_in_user_entity();

if (!empty($user) && $user->isAdmin()) {
	$group = elgg_extract("entity", $vars);
    
    echo $group->guid;
}