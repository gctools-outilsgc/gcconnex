<?php

/* hypeFramework
 * Provides classes, libraries and views for hypeJunction plugins
 *
 * @package hypeJunction
 * @subpackage hypeFramework
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 * @copyright Copyrigh (c) 2011-2013, Ismayil Khayredinov
 */

define('HYPEFRAMEWORK_RELEASE', 1356044864);

define('HYPEFRAMEWORK_INTERFACE_AJAX', elgg_get_plugin_setting('interface_ajax', 'hypeFramework'));
define('HYPEFRAMEWORK_INTERFACE_LOCATION', elgg_get_plugin_setting('interface_location', 'hypeFramework'));
define('HYPEFRAMEWORK_FILES_KEEP_ORIGINALS', elgg_get_plugin_setting('files_keep_originals', 'hypeFramework'));

elgg_register_event_handler('init', 'system', 'hj_framework_init', 100);

function hj_framework_init() {

	$path_libraries = elgg_get_root_path() . 'mod/hypeFramework/lib/';

	elgg_register_library('framework:base', $path_libraries . 'base.php');
	elgg_load_library('framework:base');

	hj_framework_check_release('hypeFramework', HYPEFRAMEWORK_RELEASE);

	// Classes
	elgg_register_classes(elgg_get_root_path() . 'mod/hypeFramework/classes/');
	
	// Libraries
	$libraries = array(
		'forms',
		'page_handlers',
		'actions',
		'assets',
		'views',
		'ajax',
		'menus',
		'files',
		'lists',
		'hierarchies',
		'location',
		'knowledge',
		'deprecated'
	);

	foreach ($libraries as $lib) {
		$path = "{$path_libraries}{$lib}.php";
		if (file_exists($path)) {
			elgg_register_library("framework:library:$lib", $path);
			elgg_load_library("framework:library:$lib");
		}
	}

	// Vendor Libraries
	// DomPDF library is not included by default
	// Download and unzip to vendors/dompdf
	$dompdf = elgg_get_root_path() . 'mod/hypeFramework/vendors/dompdf/dompdf_config.inc.php';
	if (file_exists($dompdf)) {
		elgg_register_library('framework:dompdf', $dompdf);
	}
}

function elgg_clean_vars($var) {
	return _elgg_clean_vars($var);
}