<?php

// UI
elgg_register_css('jquery.ui', 'mod/hypeFramework/vendors/jquery.ui/css/jquery-ui.custom.css', 140);

elgg_register_simplecache_view('css/framework/base');
elgg_register_css('framework.base', elgg_get_simplecache_url('css', 'framework/base'));

elgg_load_css('jquery.ui');
elgg_load_css('framework.base');

// AJAX INTERFACE
if (HYPEFRAMEWORK_INTERFACE_AJAX) {
	$path = elgg_get_simplecache_url('js', 'framework/ajax');
	elgg_register_simplecache_view('js/framework/ajax');
	elgg_register_js('framework.ajax', $path);

	elgg_load_js('jquery.form');
	elgg_load_js('framework.ajax');
}

// FILEDROP
elgg_register_js('jquery.filedrop.js', 'mod/hypeFramework/vendors/filedrop/jquery.filedrop.js', 'footer');
elgg_register_js('framework.filedrop', elgg_get_simplecache_url('js', 'framework/filedrop'), 'footer');
elgg_register_simplecache_view('js/framework/filedrop');

elgg_register_css('framework.filedrop', elgg_get_simplecache_url('css', 'framework/filedrop'));
elgg_register_simplecache_view('css/framework/filedrop');

// MINICOLORS COLORPICKER
elgg_register_js('jquery.minicolors.js', 'mod/hypeFramework/vendors/minicolors/jquery.minicolors.js', 'footer');
elgg_register_css('jquery.minicolors.css', 'mod/hypeFramework/vendors/minicolors/jquery.minicolors.css');

elgg_register_js('framework.colorpicker', elgg_get_simplecache_url('js', 'framework/colorpicker'), 'footer');
elgg_register_simplecache_view('js/framework/colorpicker');