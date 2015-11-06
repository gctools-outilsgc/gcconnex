<?php

$entity = $vars['entity'];
$user = get_user($entity->owner_guid);
if (!$entity || !$user) {
	return true;
}

$user_icon = elgg_view_entity_icon($user, 'tiny');
$user_link = "<a href=\"{$user->getURL()}\">$user->name</a>";

$title = $entity->getDisplayName();
if (!$title) {
	if ($entity->description) {
		$title = elgg_get_excerpt($entity->description, 30);
	} else {
		$title = elgg_echo('untitled');
	}
}

$entity_link = "<a href=\"{$entity->getURL()}\">$title</a>";

$type_string = "{$entity->getSubtype()}:{$entity->getSubtype()}";
$entity_type = elgg_echo($type_string);

// If translation for subtype:subtype is not found use item:object:subtype
if ($entity_type == $type_string) {
	$entity_type = elgg_echo("item:object:{$entity->getSubtype()}");
}

$by = elgg_echo('byline', array($user_link));

$count = elgg_view('likes/count', array('entity' => $entity));

$body = <<<HTML
<span class="elgg-subtext">
	$entity_type $entity_link $by ($count)
</span>
HTML;

echo elgg_view_image_block($user_icon, $body);