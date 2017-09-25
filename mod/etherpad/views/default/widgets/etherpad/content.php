<?php
/**
 * Elgg etherpad widget
 *
 * @package etherpad
 */

$max = (int) $vars['entity']->max_display;

$options = array(
	'type' => 'object',
	'subtype' => 'etherpad',
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $max,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo elgg_view('output/url', array(
	'class' => 'btn btn-primary pull-right',
	'href' => "docs/add/" . elgg_get_page_owner_entity()->guid,
	'text' => elgg_echo('etherpad:add'),
	'is_trusted' => true
));

echo $content;

if ($content) {
	if( elgg_get_page_owner_entity() instanceof ElggUser ){
		$url = "docs/owner/" . elgg_get_page_owner_entity()->username;
		$more_link = elgg_view('output/url', array(
			'class' => 'btn btn-default btn-block',
			'href' => $url,
			'text' => elgg_echo('docs:more')
		));
	} else {
		$url = "docs/group/" . elgg_get_page_owner_entity()->guid;
		$more_link = elgg_view('output/url', array(
			'class' => 'btn btn-default btn-block',
			'href' => $url,
			'text' => elgg_echo('docs:more')
		));
	}
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('docs:none');
}
