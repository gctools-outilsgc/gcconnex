<?php

$time = elgg_view_friendly_time($vars['annotation']->time_created);

$delete_url = elgg_add_action_tokens_to_url('action/selfdelete/feedback/delete?id=' . $vars['annotation']->id);
$delete_link = elgg_view('output/url', array(
	'text' => elgg_view_icon('delete'),
	'href' => $delete_url,
	'confirm' => true
));

$desc = elgg_view('output/longtext', array(
	'value' => $vars['annotation']->value
));

$desc .= elgg_view('output/longtext', array(
	'value' => $time,
	'class' => 'elgg-subtext'
));

echo elgg_view_image_block('', $desc, array(
	'image_alt' => $delete_link,
	'class' => 'elgg-divide-top'
));