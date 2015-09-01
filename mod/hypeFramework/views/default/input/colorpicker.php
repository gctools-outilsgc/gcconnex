<?php

elgg_load_js('jquery.minicolors.js');
elgg_load_css('jquery.minicolors.css');
elgg_load_js('framework.colorpicker');

if (isset($vars['class'])) {
	$vars['class'] = "{$vars['class']} hj-color-picker";
} else {
	$vars['class'] = 'hj-color-picker';
}

$vars['maxlength'] = '7';
$vars['size'] = '7';

echo elgg_view('input/text', $vars);
