<?php
$module = elgg_extract('module', $vars, 'aside');
$title = elgg_extract('title', $vars, elgg_echo('login'));
$description = elgg_extract("description", $vars);

echo elgg_view_module($module, $title, "<p>" . $description . "</p>" . elgg_view_form("login"));
