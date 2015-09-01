<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
    return true;
}

$owner = get_entity($entity->owner_guid);

if (!elgg_instanceof($owner)) {
    return true;
}

$view = "object/hjannotation/$entity->annotation_name";
if (elgg_view_exists($view)) {
    echo elgg_view($view, $vars);
    return true;
}

$icon = elgg_view_entity_icon($owner, 'tiny', array('use_hover' => false));

$author = elgg_view('output/url', array(
    'text' => $owner->name,
    'href' => $owner->getURL(),
    'class' => 'hj-comments-item-comment-owner'
	));

$comment = '<span class="annotation_value">' . elgg_view('output/text', array(
    'value' => $entity->annotation_value
	)) . '</span>';

$comment = elgg_echo('hj:alive:comments:commentcontent', array($author, $comment));

$content = <<<HTML
    <div class="clearfix">
        $menu
        $comment
    </div>
HTML;

echo elgg_view_image_block($icon, $content);