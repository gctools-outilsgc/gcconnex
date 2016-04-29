<?php
/**
 * Members sidebar
 */


// english or french page
$gc_language = $_COOKIE['connex_lang'];
if ($gc_language === '' || $gc_language === 'en' || !$gc_language)
	$action = 'http://intranet.canada.ca/search-recherche/query-recherche-eng.aspx';
else
	$action = 'http://intranet.canada.ca/search-recherche/query-recherche-fra.aspx';

$params = array(
	'method' => 'get',
	//'action' => 'search', // change form action to search to perform the GSA search action
	'disable_security' => true,
	'action' => $action, // cyu - patched so that the application uses the federated search (gcintranet)
);

$body = elgg_view_form('members/search', $params);

echo elgg_view_module('aside', elgg_echo('members:search'), $body);
echo elgg_view('widgets/suggested_friends/content'); // add suggested colleagues to members sidebar
