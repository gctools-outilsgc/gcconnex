<?php

/**
 * Create Community page that will display customized widgets
 */

$community_url = get_input('community_url');
$community_en = get_input('community_en');
$community_fr = get_input('community_fr');
elgg_set_context('gc_communities-' . $community_url);
elgg_set_page_owner_guid(elgg_get_config('site_guid'));

$customwidgets = elgg_get_widgets(elgg_get_page_owner_guid(), elgg_get_context());
$widgets = isset($customwidgets[1]) ? $customwidgets[1] : false;
$widget_types = elgg_get_widget_types();

$widgets_view = gc_communities_build_widgets($widgets, $widget_types);

$content = elgg_view_layout('index', array('widgets' => $widgets_view));

echo elgg_view_page( (get_current_language() == 'fr' ? $community_fr : $community_en), $content );
