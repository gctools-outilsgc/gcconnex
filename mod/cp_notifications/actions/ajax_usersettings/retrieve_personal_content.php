<?php

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$user_guid = (int)get_input('user_guid');
$subtype = strtolower((string)get_input('subtype'));
elgg_load_library('elgg:gc_notification:functions');
$dbprefix = elgg_get_config('dbprefix');


$query_subtype = " AND es.subtype = '{$subtype}'";
if ($subtype === 'photo')
	$query_subtypes = " AND (es.subtype = '{$subtype}' OR es.subtype = 'album' OR es.subtype = 'image')";

if ($subtype === 'page')
	$query_subtypes = " AND (es.subtype = '{$subtype}' OR es.subtype = 'page_top')";


$query = "
SELECT e.guid, e.subtype as entity_subtype, es.subtype, o.title, o.description
FROM {$dbprefix}entity_subtypes es, {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o 
WHERE e.container_guid 
	NOT IN (SELECT guid 
			FROM {$dbprefix}groups_entity) 
	AND e.subtype = es.id 
	
	AND o.guid = e.guid 
	AND o.guid = r.guid_two 
	AND r.guid_one = {$user_guid} 
	AND r.relationship LIKE 'cp_subscribed_to_%' 
";

$query = ($query_subtypes) ? $query . $query_subtypes : $query . $query_subtype;

$personal_contents = get_data($query);
$subscribed_objects = array();

foreach ($personal_contents as $personal_content) {
	$content_url = create_url($personal_content->subtype, $personal_content->guid, $personal_content->title);
	$content_title = $personal_content->title;

	// wire post does not have a title	
	if ($subtype === 'thewire')
		$content_title = elgg_echo('cp_notifications:subtype:thewire').": {$personal_content->description}";


	$item_content = "<p><a href='{$content_url}'> {$content_title} </a></p> <sup>".elgg_echo('cp_notifications:subtype:'.$personal_content->subtype)."</sup>";
	$item_left = "<div class='togglefield col-sm-10'>{$item_content}</div>";


    $unsubscribe_button = elgg_view('input/button', array(
        'class' =>'btn btn-default unsub-button',
        'id'=> $personal_content->guid .'_unsub',
        'value' => elgg_echo('cp_notifications:unsubscribe'),
    ));
	$item_right = "<div class='col-sm-2'>{$unsubscribe_button}</div>";

	$subscribed_objects[$personal_content->guid] = "{$item_left}{$item_right}";
}


echo json_encode([
	'text3' => $subscribed_objects,
]);


function create_url($subtype, $guid, $title) {
	$site = elgg_get_site_entity();
	$url = $site->getURL()."{$subtype}/view/{$guid}/{$title}";

	return $url;
}

