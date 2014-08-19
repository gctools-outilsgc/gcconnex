<?php


$limit = $vars['entity']->numdisplay ? $vars['entity']->numdisplay : 5;
$order = $vars['entity']->order ? $vars['entity']->order : 'default';

$group = elgg_get_page_owner_entity();

echo au_subgroups_list_subgroups($group, $limit, $order == 'alpha');