<?php
/**
 * Create or edit a pad
 *
 * @package ElggPad
 */

$variables = elgg_get_config('etherpad');
$input = array();
foreach ($variables as $name => $type) {
	$input[$name] = get_input($name);
	if ($name == 'title') {
		$input[$name] = strip_tags($input[$name]);
	}
	if ($type == 'tags') {
		$input[$name] = string_to_tag_array($input[$name]);
	}
}

// Get guids
$page_guid = (int)get_input('page_guid');
$container_guid = (int)get_input('container_guid');
$parent_guid = (int)get_input('parent_guid');

elgg_make_sticky_form('etherpad');

if (!$input['title']) {
	register_error(elgg_echo('pages:error:no_title'));
	forward(REFERER);
}

if ($page_guid) {
	$page = new ElggPad($page_guid);
	if (!$page || !$page->canEdit()) {
		register_error(elgg_echo('pages:error:no_save'));
		forward(REFERER);
	}
	$new_page = false;
} else {
	$page = new ElggPad();
	if ($parent_guid) {
		$page->subtype = 'subpad';
	}
	$new_page = true;
}

if (sizeof($input) > 0) {
	foreach ($input as $name => $value) {
		$page->$name = $value;
	}
}

// need to add check to make sure user can write to container
$page->container_guid = $container_guid;

if ($parent_guid) {
	$page->parent_guid = $parent_guid;
}

if ($page->save()) {

	$user = elgg_get_logged_in_user_entity();
	$options = array(
		'relationship' => 'cp_subscribed_to',
		'relationship_guid' => $user->getGUID()
	);
	add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $page->guid);
	add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $page->guid);

	elgg_clear_sticky_form('etherpad');

	// Now save description as an annotation
	//$page->annotate('page', $page->description, $page->access_id);

	system_message(elgg_echo('etherpad:saved'));

	if ($new_page) {
		add_to_river('river/object/etherpad/create', 'create', elgg_get_logged_in_user_guid(), $page->guid);
	}

	forward($page->getURL());
} else {
	register_error(elgg_echo('etherpad:error:no_save'));
	forward(REFERER);
}
