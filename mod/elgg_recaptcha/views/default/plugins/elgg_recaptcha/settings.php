<?php

namespace Beck24\ReCaptcha;


echo '<div class="pas">';
echo "<label>" . elgg_echo("elgg_recaptcha:setting:public_key") . "</label>";
echo elgg_view('input/text', array(
	'name' => 'params[public_key]',
	'value' => $vars['entity']->public_key
));
$link = elgg_view('output/url', array(
	'text' => 'https://www.google.com/recaptcha/admin/create',
	'href' => 'https://www.google.com/recaptcha/admin/create',
	'target' => '_blank'
));
echo elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_recaptcha:setting:public_key:help', array($link)),
	'class' => 'elgg-subtext'
));
echo '</div>';


echo '<div class="pas">';
echo "<label>" . elgg_echo("elgg_recaptcha:setting:private_key") . "</label>";
echo elgg_view('input/text', array(
	'name' => 'params[private_key]',
	'value' => $vars['entity']->private_key
));
$link = elgg_view('output/url', array(
	'text' => 'https://www.google.com/recaptcha/admin/create',
	'href' => 'https://www.google.com/recaptcha/admin/create',
	'target' => '_blank'
));
echo elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_recaptcha:setting:private_key:help', array($link)),
	'class' => 'elgg-subtext'
));
echo '</div>';


echo '<div class="pas">';
echo "<label>" . elgg_echo("elgg_recaptcha:setting:theme") . "</label><br>";
echo elgg_view('input/dropdown', array(
	'name' => 'params[theme]',
	'value' => $vars['entity']->theme ? $vars['entity']->theme : 'light',
	'options_values' => array(
		'light' => elgg_echo("elgg_recaptcha:theme:option:light"),
		'dark' => elgg_echo("elgg_recaptcha:theme:option:dark")
	)
));
echo '</div>';

echo '<div class="pas">';
echo "<label>" . elgg_echo("elgg_recaptcha:setting:size") . "</label><br>";
echo elgg_view('input/dropdown', array(
	'name' => 'params[size]',
	'value' => $vars['entity']->size ? $vars['entity']->size : 'size',
	'options_values' => array(
		'normal' => elgg_echo("elgg_recaptcha:size:option:normal"),
		'compact' => elgg_echo("elgg_recaptcha:size:option:compact")
	)
));
echo '</div>';

echo '<div class="pas">';
echo "<label>" . elgg_echo("elgg_recaptcha:setting:recaptcha_type") . "</label><br>";
echo elgg_view('input/dropdown', array(
	'name' => 'params[recaptcha_type]',
	'value' => $vars['entity']->recaptcha_type ? $vars['entity']->recaptcha_type : 'image',
	'options_values' => array(
		'image' => elgg_echo("elgg_recaptcha:recaptcha_type:option:image"),
		'audio' => elgg_echo("elgg_recaptcha:recaptcha_type:option:audio")
	)
));
echo '</div>';

$platform = get_platform();
$browser = get_browser();

echo '<div class="pas">';
echo '<label>' . elgg_echo('elgg_recaptcha:settings:title:nojs') . '</label>';
echo elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_recaptcha:settings:nojs:help', array($platform, $browser)),
	'class' => 'elgg-text-help'
));

$platforms = get_platforms();
$browsers = get_browsers();

foreach ($platforms as $name => $label) {
	$title = $label;

	$break1 = ceil(count($browsers)/3);
	$break2 = $break1 * 2;
	$count = 0;
	
	$body = '<div class="elgg-col elgg-col-1of3">';
	foreach ($browsers as $n => $l) {
		$count++;
		
		$attr = $name . '_' . $n;
		
		$body .= '<div><label>';
		$body .= elgg_view('input/checkbox', array(
					'name' => "params[{$attr}]",
					'value' => 1,
					'checked' => (bool) $vars['entity']->$attr
				));
		$body .= $l . '</label></div>';
		
		if ($count == $break1 || $count == $break2) {
			$body .= '</div><div class="elgg-col elgg-col-1of3">';
		}
	}
	$body .= '</div>';
	
	
	echo elgg_view_module('main', $title, $body);
}


// actions to protect
$actions = array();
foreach (_elgg_services()->actions->getAllActions() as $action => $info) {
	$actions[] = $action;
}

sort($actions);

$checked_actions = get_recaptcha_actions();

$title = elgg_echo('elgg_recaptcha:setting:recaptcha_actions');

$body = elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_recaptcha:setting:recaptcha_actions:help'),
	'class' => 'elgg-subtext'
));

$body .= '<ul>';
foreach ($actions as $action) {
	$body .= '<li><label>';
	$options = array(
		'name' => 'recaptcha_options',
		'value' => $action,
		'default' => false,
		'class' => 'recaptcha-action'
	);
	
	if (in_array($action, $checked_actions)) {
		$options['checked'] = 'checked';
	}
	
	$body .= elgg_view('input/checkbox', $options);
	$body .= $action;
	$body .= '</label></li>';
}
$body .= '</ul>';

// store a comma delimited string
$body .= elgg_view('input/hidden', array(
	'name' => 'params[recaptcha_actions]',
	'value' => $vars['entity']->recaptcha_actions,
	'class' => 'recaptcha-action-values'
));

echo elgg_view_module('main', $title, $body);

elgg_require_js('elgg_recaptcha/settings');