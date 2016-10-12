<?php

/**
 * sidebar for group discussion.
 *
 * sidebar description.
 *
 * @version 1.0
 * @author Nick P
 */

$group = get_entity(elgg_get_page_owner_guid());

$options = array(
    'type' => 'object',
    'subtype' => 'groupforumtopic',
    'container_guid' => $group->getGUID(),
    'limit' => 3,
    'full_view' => false,
    'pagination' => false,
    'distinct' => false,
    'list-class'=>' ',
    'no_results' => elgg_echo('discussion:none'),
);
$content = elgg_list_entities($options);

echo elgg_view_module('aside',elgg_echo('gprofile:discussion'), $content);
?>
