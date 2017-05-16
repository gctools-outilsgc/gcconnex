<?php

/**
* Friend request
*
* @author ColdTrick IT Solutions
*/

$content = "";

$entities = elgg_extract("entities", $vars, false);
if (!empty($entities)) {
	$content .= "<ul class='elgg-list elgg-list-entity'>";

	foreach ($entities as $entity) {
		$icon = elgg_view_entity_icon($entity, "medium");

		$info = elgg_view("output/url", array(
			"href" => $entity->getURL(),
			"text" => $entity->name
		));
		$info .= "<br />";
		$info .= elgg_view("output/url", array(
			"href" => "action/friend_request/approve?guid=" . $entity->getGUID(),
			"text" => elgg_echo("friend_request:approve", array($entity->name)),
			"is_action" => true
		));
		$info .= "&nbsp;|&nbsp;";
		$info .= elgg_view("output/url", array(
			"href" => "action/friend_request/decline?guid=" . $entity->getGUID(),
			"text" => elgg_echo("friend_request:decline", array($entity->name)),
			"is_action" => true
		));

		$content .= "<li class='elgg-item elgg-item-user'>";
		$content .= elgg_view_image_block($icon, $info);
		$content .= "</li>";
	}

	$content .= "</ul>";

} else {
	$content = elgg_echo("friend_request:received:none");
}

echo elgg_view_module("info", elgg_echo("friend_request:received:title"), $content, array("class" => "mbm"));
