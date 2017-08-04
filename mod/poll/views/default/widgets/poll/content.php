<?php
/**
 * Elgg poll plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

elgg_load_library('elgg:poll');

$widget = elgg_extract("entity", $vars);

// get the num of polls the user want to display
$limit = (int) $widget->limit;
// if no number has been set, default to 4
if($limit < 1) {
	$limit = 4;
}

// the page owner
$owner = $widget->getOwnerEntity();

$options = array(
	'type' => 'object',
	'subtype' => 'poll',
	'container_guid' => $owner->getGUID(),
	'limit' => $limit
);

echo '<h3 class="poll_widget-title">' . elgg_echo('poll:widget:think', array($owner->name)) . "</h3>";

if ($polls = elgg_get_entities($options)){
	foreach($polls as $pollpost) {
		echo elgg_view("poll/widget", array('entity' => $pollpost));
	}
	$more_link = elgg_view('output/url', array(
		'href' => "/poll/owner/{$owner->username}/all",
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo "<p>" . elgg_echo('poll:widget:no_poll', array($owner->name)) . "</p>";
}
