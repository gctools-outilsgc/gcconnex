<?php

$page_owner = elgg_get_page_owner_entity();

if (!$page_owner->canEdit()) {
  register_error(elgg_echo('au_subgroups:noedit'));
  forward($page_owner->getURL());
}

$title = elgg_echo('au_subgroups:add:subgroup');

// set up breadcrumb navigation
au_subgroups_parent_breadcrumbs($page_owner);
elgg_push_breadcrumb($page_owner->name, $page_owner->getURL());
elgg_push_breadcrumb(elgg_echo('au_subgroups:add:subgroup'));


$content = elgg_view('groups/edit');


$body = elgg_view_layout('content', array(
    'title' => $title,
    'content' => $content,
    'filter' => false
));

echo elgg_view_page($title, $body);