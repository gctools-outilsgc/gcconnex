<?php
/**
 * New Group Ideas sidebar
 */
$user = elgg_get_logged_in_user_guid();
$page_owner = elgg_get_page_owner_guid();

$offset = (int)get_input('offset', 0);
$order_by = get_input('order', 'desc');

$ideas = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'idea',
    'container_guid' => $page_owner,
    'limit' => 0,
    'offset' => $offset,
    'pagination' => false,
    'order_by' => 'time_created ' . $order_by,
    'full_view' => false,
    'list_class' => 'ideas-list',
    'item_class' => 'elgg-item-idea'
));

if ($ideas) {
    $body = elgg_view_entity_list( $ideas, array(
        'full_view' => 'sidebar',
        'item_class' => 'elgg-item-idea pts pbs',
        'list_class' => 'sidebar-idea-list',
        'pagination' => false,
        'limit' => 10
    ));

    echo elgg_view_module('sidebar', elgg_echo('ideas:group:newideas'), $body);
}
