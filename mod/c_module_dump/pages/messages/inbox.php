<?php
/**
 * Elgg messages inbox page
 *
 * @package ElggMessages
*/

gatekeeper();
$page_owner = elgg_get_page_owner_entity();

if (!$page_owner || !$page_owner->canEdit()) {
	$guid = 0;
	if($page_owner){
		$guid = $page_owner->getGUID();
	}
	register_error(elgg_echo("pageownerunavailable", array($guid)));
	forward();
}

elgg_push_breadcrumb(elgg_echo('messages:inbox'));

elgg_register_title_button();

$title = elgg_echo('messages:user', array($page_owner->name));

if ($page_owner->isAdmin())
{
	$list = elgg_echo('message:displayposts', array('<a href="?num=10">10</a> | <a href="?num=25">25</a> | <a href="?num=100">100</a> | <a href="?num=250">250</a> | <a href="?num=500">500</a>'));
} else {
	$list = elgg_echo('message:displayposts', array('<a href="?num=10">10</a> | <a href="?num=25">25</a> | <a href="?num=100">100</a>'));
}



$display_num_post = $_GET['num'];

if ($display_num_post > 100)
{
	// check if this person is actually an admin...
	if (!$page_owner->isAdmin())
	{
		$display_num_post = 100;
	}
}


if (!isset($display_num_post))
{
	$display_num_post = 10;
}

$list .= elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'messages',
	'metadata_name' => 'toId',
	'metadata_value' => elgg_get_page_owner_guid(),
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
	'limit' => $display_num_post
));

$body_vars = array(
	'folder' => 'inbox',
	'list' => $list,
);

$content = elgg_view_form('messages/process', array(), $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => elgg_echo('messages:inbox'),
	'filter' => '',
));


echo elgg_view_page($title, $body);
