<?php
/**
 * Search for content in this group
 *
 * @uses vars['entity'] ElggGroup
 */

$url = elgg_get_site_url() . 'search';
$body = elgg_view_form('groups/search', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true,
), $vars);

echo elgg_view_module('GPmod', elgg_echo('groups:search_in_group'), $body);