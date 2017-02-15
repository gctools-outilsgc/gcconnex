<?php

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}
error_log(">>>>>>>> supppppppppppppppppppppppp");
$user_guid = (int)get_input('user_guid');
$subtype = strtolower((string)get_input('subtype'));
elgg_load_library('elgg:gc_notification:functions');

$dbprefix = "elgg";
$query = "
SELECT e.guid, e.subtype as entity_subtype, es.subtype, o.title, o.description
FROM {$dbprefix}entity_subtypes es, {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o 
WHERE e.container_guid 
	NOT IN (SELECT guid 
			FROM {$dbprefix}groups_entity) 
	AND e.subtype = es.id 
	AND o.description <> '' 
	AND o.guid = e.guid 
	AND o.guid = r.guid_two 
	AND r.guid_one = {$user_guid} 
	AND r.relationship LIKE 'cp_subscribed_to_%' 
	AND (	es.subtype = '{$subtype}' )
";
// $query = "
// SELECT e.guid, e.subtype as entity_subtype, es.subtype, o.title, o.description
// FROM {$dbprefix}entity_subtypes es, {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o 
// WHERE e.container_guid 
// 	NOT IN (SELECT guid 
// 			FROM {$dbprefix}groups_entity) 
// 	AND e.subtype = es.id 
// 	AND o.description <> '' 
// 	AND o.guid = e.guid 
// 	AND o.guid = r.guid_two 
// 	AND r.guid_one = {$user_guid} 
// 	AND r.relationship LIKE 'cp_subscribed_to_%' 
// 	AND (	es.subtype = 'poll' OR
// 			es.subtype = 'blog' OR
// 			es.subtype = 'bookmark' OR
// 			es.subtype = 'event_calendar' OR
// 			es.subtype = 'file' OR
// 			es.subtype = 'photo' OR
// 			es.subtype = 'album' OR
// 			es.subtype = 'task' OR
// 			es.subtype = 'page' OR
// 			es.subtype = 'page_top' OR
// 			es.subtype = 'idea' OR
// 			es.subtype = 'thewire' )
// ";

$personal_contents = get_data($query);

$subscribed_objects = array();
foreach ($personal_contents as $personal_content) {

		$item_content = "<p><a href='#'> {$personal_content->title} </a></p> <sup>".cp_translate_subtype($personal_content->subtype)."</sup>";
		$item_left = "<div class='togglefield col-sm-10'>{$item_content}</div>";


        $unsubscribe_button = elgg_view('input/button', array(
            'class' =>'btn btn-default unsub-button',
            'id'=> $personal_content->guid .'_b',
            'value' => elgg_echo("cp_notify:unsubscribe"),
        ));
		$item_right = "<div class='col-sm-2'>{$unsubscribe_button}</div>";

		$subscribed_objects[$personal_content->guid] = "{$item_left}{$item_right}";
}


echo json_encode([
	'text3' => $subscribed_objects,
]);

