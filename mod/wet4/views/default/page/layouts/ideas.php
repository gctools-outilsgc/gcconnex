<?php
/**
 * Main content area layout
 *
 * @uses $vars['content']        HTML of main content area
 * @uses $vars['sidebar']        HTML of the sidebar
 * @uses $vars['header']         HTML of the content area header (override)
 * @uses $vars['nav']            HTML of the content area nav (override)
 * @uses $vars['footer']         HTML of the content area footer
 * @uses $vars['filter']         HTML of the content area filter (override)
 * @uses $vars['title']          Title text (override)
 * @uses $vars['context']        Page context (override)
 * @uses $vars['filter_context'] Filter context: everyone, friends, mine
 * @uses $vars['class']          Additional class to apply to layout
 */

// give plugins an opportunity to add to content sidebars
$sidebar_content = elgg_extract('sidebar', $vars, '');
$params = $vars;
$params['content'] = $sidebar_content;
$sidebar = elgg_view('page/layouts/content/sidebar', $params);

$group_guid = elgg_get_page_owner_guid();
$group = get_entity($group_guid);

if(!$group->canWritetoContainer()) {
    $nonmembermsg = elgg_echo("ideas:group:nonmember");
}
// allow page handlers to override the default header
if (isset($vars['header'])) {
	$vars['header_override'] = $vars['header'];
}
$header = elgg_view('page/layouts/elements/header', $vars);

//hack fix for header and title menu
//remove title menu and add new menu in right place
elgg_unregister_menu_item('title', 'settings');

$page_owner = elgg_get_page_owner_entity();

if ($page_owner->canEdit() || elgg_is_admin_logged_in()) {
    elgg_register_menu_item('idea-title', array(
        'name' => 'settings',
        'href' => "ideas/group/$page_owner->guid/settings",
        'text' => elgg_echo('ideas:group_settings'),
        'class' => 'list-inline',
        'list_class' => 'clearfix',
        'link_class' => 'btn btn-default gwfb group_admin_only pull-right',
    ));

    $header .= '<div class="clearfix mrgn-bttm-sm">' . elgg_view_menu('idea-title', array('class' => 'list-unstyled')) . '</div>';
}

// allow page handlers to override the default filter
if (isset($vars['filter'])) {
	$vars['filter_override'] = $vars['filter'];
}
$filter = elgg_view('page/layouts/content/ideas_filter', $vars);

// ideasING
if (elgg_is_logged_in() && $group->canWritetoContainer()) {
    $form = elgg_view('page/layouts/content/searchandsubmitidea');    
}

// the all important content
$content = elgg_extract('content', $vars, '');

// optional footer for main content area
$footer_content = elgg_extract('footer', $vars, '');
$params = $vars;
$params['content'] = $footer_content;
$footer = elgg_view('page/layouts/content/footer', $params);

$body = $header . $nonmembermsg . $form . $filter . $content . $footer;

$params = array(
	'content' => $body,
	'sidebar' => $sidebar,
);
if (isset($vars['class'])) {
	$params['class'] = $vars['class'];
}
echo elgg_view_layout('one_sidebar', $params);
