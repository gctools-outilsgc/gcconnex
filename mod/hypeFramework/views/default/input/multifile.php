<?php

/**
 * Creates drag&drop file uploader
 * In non-html5 browsers falls back to regular file input
 *
 * On upload success, new file entity guid is stored in hidden inputs that submitted with the form in uploads[] array
 * @uses $vars['allowedfiletypes'] Options. Can be used to define allowed mimetypes
 *
 */

elgg_load_js('jquery.filedrop.js');
elgg_load_js('framework.filedrop');
elgg_load_css('framework.filedrop');

$name = preg_replace('/[^a-z0-9\-]/i', '-', $vars['name']);
$types = htmlentities(json_encode(elgg_extract('allowedfiletypes', $vars, '[]')));
if (isset($vars['data-callback'])) {
	$data_callback = "data-callback=\"{$vars['data-callback']}\"";
}
echo '<div data-toggle="filedrop">';

echo "<div id=\"filedrop-$name\" class=\"filedrop\" data-allowedfiletypes=\"$types\" $data_callback>";
echo '<span class="filedrop-message">' . elgg_echo('hj:framework:filedrop:instructions') . '</span>';
echo '</div>';

echo '<label>' . elgg_echo('hj:framework:filedrop:fallback') . '</label>';
echo "<div id=\"filedrop-fallback-$name\" class=\"filedrop-fallback \">";

for ($i=0;$i<5;$i++) {
	echo elgg_view('input/file', array(
		'name' => $vars['name'] . '[]'
	));
}

/** @todo: adding input files dynamically violates security policies in IE. Figure out a workaround */

//echo elgg_view('input/file', array(
//	'class' => 'filedrop-fallback-template hidden',
//	'name' => "{$vars['name']}[]"
//));
//echo elgg_view('output/url', array(
//	'href' => '#',
//	'text' => elgg_echo('hj:framework:input:file:add'),
//	'class' => 'filedrop-fallback-clone',
//));

echo '</div>';

echo '</div>';