<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();
// nick p - removing language from account settings. It doesn't really work, users should just use lang toggle
if ($user) {
	$title = elgg_echo('user:set:language');
	$content = '<label for="language">' . elgg_echo('user:language:label') . ': </label>';
	$content .= elgg_view("input/select", array(
		'name' => 'language',
        'id' => 'language',
		'value' => $user->language,
		'options_values' => get_installed_translations()
	));
	echo elgg_view_module('info', $title, $content);
}
