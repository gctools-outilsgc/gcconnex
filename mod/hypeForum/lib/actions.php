<?php

$shortcuts = hj_framework_path_shortcuts('hypeForum');
// Actions
elgg_register_action('edit/object/hjforum', $shortcuts['actions'] . 'edit/object/hjforum.php');
elgg_register_action('edit/object/hjforumtopic', $shortcuts['actions'] . 'edit/object/hjforumtopic.php');
elgg_register_action('edit/object/hjforumpost', $shortcuts['actions'] . 'edit/object/hjforumpost.php');
elgg_register_action('edit/object/hjforumcategory', $shortcuts['actions'] . 'edit/object/hjforumcategory.php');

elgg_register_action('forum/order/categories', $shortcuts['actions'] . 'order/categories.php');

elgg_register_action('forum/bookmark', $shortcuts['actions'] . 'forum/bookmark/default.php');
elgg_register_action('forum/bookmark/create', $shortcuts['actions'] . 'forum/bookmark/create.php');
elgg_register_action('forum/bookmark/remove', $shortcuts['actions'] . 'forum/bookmark/remove.php');

elgg_register_action('forum/subscription', $shortcuts['actions'] . 'forum/subscription/default.php');
elgg_register_action('forum/subscription/create', $shortcuts['actions'] . 'forum/subscription/create.php');
elgg_register_action('forum/subscription/remove', $shortcuts['actions'] . 'forum/subscription/remove.php');