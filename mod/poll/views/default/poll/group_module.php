<?php
/**
 * Group poll view
 *
 * @package Elggpoll_extended
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg <big_lizard_clyde@hotmail.com>
 * @copyright John Mellberg - 2009
 *
 */

elgg_load_library('elgg:poll');
elgg_require_js('elgg/poll/poll');

$group = elgg_get_page_owner_entity();

if (poll_activated_for_group($group)) {
	elgg_push_context('widgets');
	$all_link = elgg_view('output/url', array(
		'href' => "poll/group/$group->guid/all",
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true
	));
	$new_link = elgg_view('output/url', array(
		'href' => "poll/add/$group->guid",
		'text' => elgg_echo('poll:addpost'),
		'is_trusted' => true
	));

	$options = array('type' => 'object', 'subtype'=>'poll', 'limit' => 4, 'container_guid' => elgg_get_page_owner_guid());
	$content = '';
	if ($poll_found = elgg_get_entities($options)) {
		foreach ($poll_found as $poll) {
			$content .= elgg_view('poll/widget', array('entity' => $poll));
		}
	}
	elgg_pop_context();
	if (!$content) {
	  $content = '<p>'.elgg_echo("group:poll:empty").'</p>';
	}

	echo elgg_view('groups/profile/module', array(
		'title' => elgg_echo('poll:group_poll'),
		'content' => $content,
		'all_link' => $all_link,
		'add_link' => $new_link,
	));
}
