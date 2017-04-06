<?php
/*
* wire_posts.php
*
* Calls The elgg
*/



$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => get_input('limit'),
	'offset' => get_input('offset'),
	'preload_owners' => true,
    'pagination' =>false,
));

echo $content;
?>