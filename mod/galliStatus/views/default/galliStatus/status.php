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
$size = $vars['size'];
$user = $vars['user'];
$timeout = 60; // timeout in 1min
$last_action = $user->last_action;
$title = elgg_echo('gallistatus:online');
if (time() - $last_action < $timeout) {
	$status_url = $vars['url'] . "mod/galliStatus/graphics/online_$size.png";
	echo "<img src=\"$status_url\" class=\"galliStatus_$size\" title=\"$title\" />";
}	
?>