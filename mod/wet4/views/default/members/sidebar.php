<?php
/**
 * Members sidebar
 */

$params = array(
	'method' => 'get',
	'action' => 'members/search',
	'disable_security' => true,
);

$body = elgg_view_form('members/search', $params);

echo elgg_view_module('aside', elgg_echo('members:search'), $body);
echo elgg_view('widgets/suggested_friends/content'); // add suggested colleagues to members sidebar
