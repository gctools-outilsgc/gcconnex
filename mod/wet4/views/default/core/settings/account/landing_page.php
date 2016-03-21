<?php
/**
 * Allow user to pick a preference of landing page between dashboard and news feed
 *
 */

$user = elgg_get_logged_in_user_entity();

if ($user->getGuid() == elgg_get_page_owner_entity()->getGuid()) {
	$title = elgg_echo('landingPage');
    $options = array('news' => 'News Feed', 'dash' => 'Dashboard');

	$content = '<label for="landingpage">' . elgg_echo('landingPage') . ': </label>';
	$content .= elgg_view("input/select", array(
		'name' => 'landingpage',
        'id' => 'landingpage',
		'value' => $user->landingpage,
		'options_values' => $options
	));
	echo elgg_view_module('info', $title, $content);

    echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
}
