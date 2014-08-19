<?php

	if (!isset($vars['entity']->use_friendspicker)) {
		$vars['entity']->use_friendspicker = 'no';
	}
	if (!isset($vars['entity']->header_color)) {
		$vars['entity']->header_color = '';
	}
	if (!isset($vars['entity']->showlogo)) {
		$vars['entity']->showlogo = 'no';
	}
	if (!isset($vars['entity']->teaserstring)) {
		$vars['entity']->teaserstring = 'lang';
	}
	if (!isset($vars['entity']->teaseroutput)) {
		$vars['entity']->teaseroutput = $teaseroutput;
	}
	
echo '<div>';
echo elgg_echo('mobilize:label:fp');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[use_friendspicker]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
		),
	'value' => $vars['entity']->use_friendspicker,
));
echo '</div>';

echo '<div>';
echo elgg_echo('mobilize:label:color');
	echo elgg_view('input/text', array('name' => 'params[header_color]', 'value' => $vars['entity']->header_color));
echo '</div>';

echo '<div>';
echo elgg_echo('mobilize:label:logo');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[showlogo]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
		),
	'value' => $vars['entity']->showlogo,
));
echo '</div>';

echo elgg_view('input/dropdown', array(
	'name' => 'params[teaserstring]',
	'options_values' => array(
		'lang' => elgg_echo('mobilize:option:lang'),
		'field' => elgg_echo('mobilize:option:field'),
		'none' => elgg_echo('mobilize:option:none')
		),
	'value' => $vars['entity']->teaserstring,
));

echo '<div>';
	echo elgg_echo('mobilize:info:teaser');
echo '</div>';
echo '<div>';
	echo elgg_echo('mobilize:label:teaser');
	echo elgg_view('input/text',array('name' => 'params[teaseroutput]','value' => $vars['entity']->teaseroutput));
echo '</div>';
