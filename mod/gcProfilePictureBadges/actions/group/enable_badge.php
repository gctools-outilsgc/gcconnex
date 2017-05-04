<?php
/**
 * gcProfilePictureBadges Enable Badge Action
 *
 * @package gcProfilePictureBadges
 *
 * gets form inout to enable init badge
 */

$group_guid = (int) get_input("group_guid");
$badge = get_input('badge');
$enable = get_input("enable_badge");
$widget = get_input("display_widget");

$group = get_entity($group_guid);

//set settings for badge
$group->setPrivateSetting("group:badge:".$badge, $enable);
$group->setPrivateSetting("group:badge:".$badge.":display_widget", $widget);

system_message('Badge settings saved');
forward(REFERER);
?>
