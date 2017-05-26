<?php
/*
* Community and Tags input
*
*
*/

$community_array = array(
    'atip'=> elgg_echo('gctags:community:atip'),
    'communications'=> elgg_echo('gctags:community:communications'),
    'evaluators'=> elgg_echo('gctags:community:evaluators'),
);

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'tags',
	'value' => $vars['tags']
));

echo elgg_view('input/community', array());
echo $tags_input;