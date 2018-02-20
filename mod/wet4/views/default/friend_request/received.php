<?php
/**
 * Received Friend Request User Display - referenced from Elgg user display
 *
 * @uses $vars['entity'] ElggUser entity
 * @uses $vars['title']  Optional override for the title
 *
 * @author BMRGould - Brandon Gould
 *
 *
 */

$entity = $vars['entity'];


$icon = elgg_view_entity_icon($entity, "medium");
$name = elgg_extract('title', $vars);
$approve = elgg_view("output/url", array(
	"href" => "action/friend_request/approve?guid=" . $entity->getGUID(),
	"text" => elgg_echo("friend_request:approve", array($entity->name)),
	"is_action" => true
));
$decline =elgg_view("output/url", array(
	"href" => "action/friend_request/decline?guid=" . $entity->getGUID(),
	"text" => elgg_echo("friend_request:decline", array($entity->name)),
	"is_action" => true
));

if (!$name) {
	$link_params = array(
		'href' => $entity->getUrl(),
		'text' => $entity->name,
	);
	$name = elgg_view('output/url', $link_params);
}

if ($entity->isBanned()) {
	$banned = elgg_echo('banned');
	$params = array(
		'entity' => $entity,
		'title' => $name,
	);
} else {
	$params = array(
		'entity' => $entity,
		'title' => $name,
		'subtitle' => $entity->job,
		'content' => $approve . " | " . $decline,
	);
}
$list_body = elgg_view('user/elements/summary', $params);
echo elgg_view_image_block($icon, $list_body, $vars);
