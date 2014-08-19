<?php

$page_owner = elgg_get_page_owner_entity();
$title = elgg_echo('au_subgroups:subgroups');
elgg_set_context('au_subgroups');

// set up breadcrumb navigation
au_subgroups_parent_breadcrumbs($page_owner);
elgg_push_breadcrumb($page_owner->name, $page_owner->getURL());
elgg_push_breadcrumb(elgg_echo('au_subgroups:subgroups'));

$content = au_subgroups_list_subgroups($page_owner, 10, true);

if (!$content) {
  $content = elgg_echo('au_subgroups:nogroups');
}

$body = elgg_view_layout('content', array(
    'title' => $title,
    'content' => $content,
    'filter' => false
));

echo elgg_view_page($title, $body);