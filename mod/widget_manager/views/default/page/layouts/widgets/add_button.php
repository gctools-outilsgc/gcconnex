<?php
/**
 * Button area for showing the add widgets panel
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$href_options = [
	'context' => elgg_extract('context', $vars),
	'context_stack' => elgg_get_context_stack(),
	'show_access' => elgg_extract('show_access', $vars),
	'exact_match' => elgg_extract('exact_match', $vars),
	'owner_guid' => elgg_get_page_owner_guid(),
];

$href = elgg_normalize_url(elgg_http_add_url_query_elements('ajax/view/page/layouts/widgets/add_panel', $href_options));

elgg_register_menu_item('title', [
	'id' => 'widgets-add-panel',
	'name' => 'widgets:add',
	'text' => elgg_echo('widgets:add'),
	'link_class' => 'elgg-button elgg-button-action elgg-lightbox',
	'href' => '#',
	'onclick' => 'require(["widget_manager/add_panel"]);',
	'data-colorbox-opts' => '{"href":"' . $href . '", "innerWidth": 600, "maxHeight": "80%"}'
]);
