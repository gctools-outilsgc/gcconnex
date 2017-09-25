<?php

echo elgg_view('elgg_solr/admin_nav');

$title = elgg_echo('elgg_solr:settings:title:adapter_options');

$body = '<label>' . elgg_echo('elgg_solr:settings:host') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[host]',
	'value' => $vars['entity']->host
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:host:help'),
	'class' => 'elgg-subtext'
));

$body .= '<label>' . elgg_echo('elgg_solr:settings:port') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[port]',
	'value' => $vars['entity']->port
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:port:help'),
	'class' => 'elgg-subtext'
));

$body .= '<label>' . elgg_echo('elgg_solr:settings:path') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[solr_path]',
	'value' => $vars['entity']->solr_path
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:path:help'),
	'class' => 'elgg-subtext'
));

$cores = elgg_solr_get_cores();

$body .= '<label>' . elgg_echo('elgg_solr:settings:core') . '</label>';
if ($cores) {
	$body .= elgg_view('input/dropdown', array(
		'name' => 'params[solr_core]',
		'value' => $vars['entity']->solr_core,
		'options' => $cores
	));
}
else {
	$body .= elgg_view('input/text', array(
		'name' => 'params[solr_core]',
		'value' => $vars['entity']->solr_core
	));
}
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:core:help'),
	'class' => 'elgg-subtext'
));

echo elgg_view_module('main', $title, $body);



$title = elgg_echo('elgg_solr:settings:title:query');

$body = '<label>' . elgg_echo('elgg_solr:settings:query:title_boost') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[title_boost]',
	'value' => $vars['entity']->title_boost,
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:query:title_boost:help'),
	'class' => 'elgg-subtext'
));


$body .= '<label>' . elgg_echo('elgg_solr:settings:query:description_boost') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[description_boost]',
	'value' => $vars['entity']->description_boost
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:query:description_boost:help'),
	'class' => 'elgg-subtext'
));

$body .= '<label>' . elgg_echo('elgg_solr:settings:query:time_boost') . '</label><br>';
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[use_time_boost]',
	'value' => $vars['entity']->use_time_boost,
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	)
));

$body .= '<br><br>';

$body .= '<label>' . elgg_echo('elgg_solr:settings:query:time_boost:settings') . '</label><br>';
$body .= elgg_echo('elgg_solr:settings:query:time_boost:period') . '&nbsp;&nbsp;';
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[time_boost_num]',
	'value' => $vars['entity']->time_boost_num,
	'options' => range(1,25)
));
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[time_boost_interval]',
	'value' => $vars['entity']->time_boost_interval,
	'options_values' => array(
		'day' => elgg_echo('elgg_solr:time:day'),
		'week' => elgg_echo('elgg_solr:time:week'),
		'month' => elgg_echo('elgg_solr:time:month'),
		'year' => elgg_echo('elgg_solr:time:year')
	)
));
$body .= '&nbsp;&nbsp;' . elgg_echo('elgg_solr:settings:query:time_boost:by') . '&nbsp;&nbsp;';
$body .= elgg_view('input/text', array(
	'name' => 'params[time_boost]',
	'value' => $vars['entity']->time_boost
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:query:time_boost:help'),
	'class' => 'elgg-subtext'
));
		
echo elgg_view_module('main', $title, $body);



$title = elgg_echo('elgg_solr:settings:title:misc');

$body = '<label>' . elgg_echo('elgg_solr:settings:batch_size') . '</label><br>';
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[reindex_batch_size]',
	'value' => $vars['entity']->reindex_batch_size,
	'options' => array(200,400,600,800,1000,2000)
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:batch_size:help'),
	'class' => 'elgg-subtext'
));


$body .= '<label>' . elgg_echo('elgg_solr:settings:extract') . '</label><br>';
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[extract_handler]',
	'value' => $vars['entity']->extract_handler,
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	)
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:extract:help'),
	'class' => 'elgg-subtext'
));

$body .= '<label>' . elgg_echo('elgg_solr:settings:highlight:prefix') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'hl_prefix',
	'value' => $vars['entity']->hl_prefix
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:highlight:prefix:help'),
	'class' => 'elgg-subtext'
));

$body .= '<label>' . elgg_echo('elgg_solr:settings:highlight:suffix') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'hl_suffix',
	'value' => $vars['entity']->hl_suffix
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:highlight:suffix:help'),
	'class' => 'elgg-subtext'
));


$body .= '<label>' . elgg_echo('elgg_solr:settings:fragsize') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'params[fragsize]',
	'value' => is_numeric($vars['entity']->fragsize) ? $vars['entity']->fragsize : 100
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:fragsize:help'),
	'class' => 'elgg-subtext'
));


$body .= '<label>' . elgg_echo('elgg_solr:settings:show_score') . '</label><br>';
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[show_score]',
	'value' => $vars['entity']->show_score ? $vars['entity']->show_score : 'no',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	)
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:show_score:help'),
	'class' => 'elgg-subtext'
));


$body .= '<label>' . elgg_echo('elgg_solr:settings:use_solr') . '</label><br>';
$body .= elgg_view('input/dropdown', array(
	'name' => 'params[use_solr]',
	'value' => $vars['entity']->use_solr ? $vars['entity']->use_solr : 'yes',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	)
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('elgg_solr:settings:use_solr:help'),
	'class' => 'elgg-subtext'
));
		
echo elgg_view_module('main', $title, $body);
