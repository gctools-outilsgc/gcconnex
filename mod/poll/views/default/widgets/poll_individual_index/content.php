<?php
/**
 * Individual featured poll view
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

elgg_load_library('elgg:poll');

$widget = elgg_extract("entity", $vars);

$options = array(
	'type' => 'object',
	'subtype' => 'poll',
	'metadata_name_value_pairs' => array(array('name' => 'front_page','value' => 1)),
	'limit' => 1
);

if($poll_found = elgg_get_entities_from_metadata($options)){
	$body = elgg_view('poll/poll_widget', array('entity' => $poll_found[0]));
} else {
	$body = elgg_echo('poll:widget:nonefound');
}

echo $body;
