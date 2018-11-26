<?php
/**
 * ideas group settings page
 *
 * @package ideas
 */
gatekeeper();
group_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
$lang = get_current_language();
elgg_push_breadcrumb(gc_explode_translation($page_owner->name,$lang), "ideas/group/$page_owner->guid/top");
elgg_push_breadcrumb(elgg_echo('ideas:settings'));

$vars = ideas_group_settings_prepare_form_vars($page_owner);

$content = elgg_view_form('ideas/settings', array(), $vars);

$title = elgg_echo('ideas:group:settings:title', array(gc_explode_translation($page_owner->name,$lang)));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);