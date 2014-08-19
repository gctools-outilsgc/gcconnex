<?php
/**
 *	Elgg user status
 *	Author : Mohammed Aqeel | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package User status plugin for Elgg
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */
 
 // badges by group
 $badgesbg = array (
	'940679' => "test",
 );
 
 
$size = $vars['size'];
$user = $vars['user'];
$a = elgg_get_plugin_user_setting("file_tools_time_display", null, "file_tools");
echo $a;
/*if ( $user->username == "ilia.salem@tbs-sct.gc.ca" )
	$user->active_badge = 'test';
else
	$user->active_badge = '';*/

$badge = $user->active_badge; 		// which badge
$last_action = $user->last_action;
$title = $badge;
if ( $badge != '' ) {
	$status_url = $vars['url'] . "mod/gcProfilePictureBadges/graphics/$badge/$size.png";
	echo "<img src=\"$status_url\" class=\"gcProfilePictureBadges_$size\" title=\"$title\" />";
}
?>