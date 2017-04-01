<?php
// NOTIFICATIONS
echo elgg_view('cp_notifications/admin_nav');


elgg_register_menu_item('elgg_solr_controls', array(
	'name' => 'solr_delete_index',
	'text' => elgg_echo('Notifications Admin_Header'),
	//'href' => 'action/elgg_solr/delete_index',
	'is_action' => true,
	'is_trusted' => true,
	'link_class' => 'elgg-button elgg-button-action elgg-requires-confirmation',
	'confirm' => elgg_echo('elgg_solr:delete_index:confirm')
));


$title = elgg_echo('Admin Header');

$body = elgg_view_menu('elgg_solr_controls', array(
	'class' => 'elgg-menu-hz',
	'item_class' => 'mrm',
));


echo elgg_view_module('main', $title, $body);

