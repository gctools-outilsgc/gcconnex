<?php

$system_messages = $vars['sysmessages'];
unset($vars['sysmessages']);

$output = elgg_clean_vars($vars);

function hj_framework_decode_xhr_view_outputs($val) {
	if (is_array($val)) {
		foreach ($val as $k => $v) {
			$output[$k] = hj_framework_decode_xhr_view_outputs($v);
		}
	} else if (is_string($val) && $json = json_decode($val, true)) {
		if (is_array($json)) {
			$output = hj_framework_decode_xhr_view_outputs($json);
		} else {
			$output = $json;
		}
	} else {
		$output = $val;
	}

	return $output;
}

$output = hj_framework_decode_xhr_view_outputs($output);

$js = elgg_get_loaded_js();
$js_foot = elgg_get_loaded_js('footer');

$js = array_merge($js, $js_foot);

$css = elgg_get_loaded_css();

$resources = array(
	'js' => array(),
	'css' => array()
);

/** @hack	Prevent js/css from loading again if cached in default viewtype * */
$lastcached_xhr = datalist_get("simplecache_lastcached_xhr");
$lastcached_default = datalist_get("simplecache_lastcached_default");

foreach ($js as $script) {
	if (elgg_is_simplecache_enabled()) {
		$script = str_replace('cache/js/xhr', 'cache/js/default', $script);
	} else {
		$script = str_replace('view=xhr', 'view=default', $script);
	}
	$script = str_replace($lastcached_xhr, $lastcached_default, $script);
	$resources['js'][] = html_entity_decode($script);
}

foreach ($css as $link) {
	if (elgg_is_simplecache_enabled()) {
		$link = str_replace('cache/css/xhr', 'cache/css/default', $link);
	} else {
		$link = str_replace('view=xhr', 'view=default', $link);
	}
	$link = str_replace($lastcached_xhr, $lastcached_default, $link);
	$resources['css'][] = html_entity_decode($link);
}

$params = array(
	'output' => $output,
	'status' => 0,
	'system_messages' => array(
		'error' => array(),
		'success' => array()
	),
	'resources' => $resources,
	'href' => full_url()
);

if (isset($system_messages['success']) && count($system_messages['success'])) {
	$params['system_messages']['success'] = $system_messages['success'];
}

if (isset($system_messages['error']) && count($system_messages['error'])) {
	$params['system_messages']['error'] = $system_messages['error'];
	$params['status'] = -1;
}

$response = json_encode($params);

if (!get_input('X-PlainText-Response')) {
	header("Content-type: application/json");
	print $response;
} else {
	print '<textarea>' . $response . '</textarea>'; // workaround for IE bugs
}
exit();