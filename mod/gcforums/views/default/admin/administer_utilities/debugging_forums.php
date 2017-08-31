<?php


$title = elgg_echo('Debugging the GCconnex Forums');
$dbprefix = elgg_get_config('dbprefix');



$query = "	SELECT * FROM elggentity_relationships r 
				LEFT JOIN elggentities e ON e.guid = r.guid_one 
				LEFT JOIN elggobjects_entity o ON o.guid = e.guid
				LEFT JOIN elggentity_subtypes es ON es.id = e.subtype
			WHERE r.guid_two = 0";

$forums = get_data($query);

foreach ($forums as $forum) {
	echo "<p>";
	$container_entity = get_entity($forum->container_guid);
	echo "id:{$forum->guid} // title:{$forum->title} // container id:{$forum->container_guid} // container type:{$container_entity->type}";
	echo "</p>";
}


//echo print_r($forums,true);


echo elgg_view_module('main', $title, $body);


