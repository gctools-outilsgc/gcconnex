<?php

if (elgg_is_active_plugin('event_calendar')) {
elgg_push_context('widgets');
$options = array(
    'type' => 'object',
    'subtype' => 'event_calendar',
    'limit' => 3,//$num,
    'full_view' => false,
    'list_type' => 'list',
    'pagination' => FALSE,
    );
$content = elgg_list_entities($options);
echo elgg_view_module('featured',  elgg_echo("Recent Events"), $content);
elgg_pop_context();

}