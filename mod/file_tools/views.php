<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

$vendors_path = __DIR__ . '/vendors/';

return [
	// viewtype
	'default' => [
		'js/jquery.serializejson.js' => $composer_path . 'vendor/bower-asset/jquery.serializeJSON/jquery.serializejson.min.js',
		'js/jstree/' => $composer_path . 'vendor/bower-asset/jstree/dist/',
		'js/jquery.hashchange.js' => $vendors_path . 'hashchange/jquery.hashchange.js',
	],
];
