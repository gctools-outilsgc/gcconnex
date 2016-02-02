<?php

$user = elgg_get_page_owner_entity();

if(elgg_is_logged_in() && elgg_get_logged_in_user_guid() == $user->getGUID()){
elgg_register_menu_item('owner_block', array(
    'name' => 'badges',
    'href' => '#badgeProgress',
    'text' => 'Achievements',
    'title' => 'Achievements',
    'data-toggle' => 'tab',
    'class' => '',
    'priority' => '50',
    ));
}