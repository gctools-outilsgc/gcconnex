<?php
/**
 * Elgg Polls plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

elgg_load_library('elgg:polls');

//get the num of polls the user want to display
$limit = $vars['entity']->limit;

//if no number has been set, default to 3
if(!$limit) $limit = 3;

//the page owner
$owner = elgg_get_page_owner_entity();
$lang = get_current_language();
echo '<h3 class="poll-widget-title">'. sprintf(elgg_echo('polls:widget:think'),gc_explode_translation($owner->name, $lang)) . "</h3>";

$options = array(
		'type' => 'object',
		'subtype' => 'poll',
		'owner_guid' => $vars['entity']->owner_guid,
		'limit' => $limit
);
$polls = elgg_get_entities($options);

if( empty($polls) ){
	$options = array(
		'type' => 'object',
		'subtype' => 'poll',
		'container_guid' => $vars['entity']->container_guid,
		'limit' => $limit
	);
	$polls = elgg_get_entities($options);
}

if ($polls){
	foreach($polls as $pollpost) {
		echo elgg_view("polls/widget", array('entity' => $pollpost));
	}
}
else
{
	$lang = get_current_language();
	echo "<p>" . sprintf(elgg_echo('polls:widget:no_polls'),gc_explode_translation($owner->name,$lang)) . "</p>";
}
