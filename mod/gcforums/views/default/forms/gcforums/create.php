<?php

$object_guid = get_input('gcf_guid');

$gcf_topic_guid = $vars['topic_guid'];
$gcf_topic_access = $vars['topic_access'];

$object_title = get_input('gcf_title', "RE: $gcf_topic_guid");	// post only
$object = get_entity($object_guid);

$gcf_subtype = $vars['subtype'];
$gcf_group = $vars['group_guid'];
elgg_set_page_owner_guid($gcf_group);	// set the page owner for this form view
$gcf_container = $vars['container_guid'];


echo ("create.php == topic access: {$gcf_topic_access} / topic guid: {$gcf_topic_guid} / object guid: {$object_guid} / title: {$object_title} / subtype: {$gcf_subtype} / group: {$gcf_group} / container: {$gcf_container}");

// title, description and access (visible)
if ($gcf_subtype === 'hjforum' || $gcf_subtype === 'hjforumcategory' || $gcf_subtype === 'hjforumtopic') {
	$gcf_title_label = elgg_echo("gcforums:title_label_{$gcf_subtype}");
	$gcf_title_input = elgg_view('input/text', array(
		'name' => 'gcf_title',
		));

	$gcf_access_label = elgg_echo('gcforums:access_label');
	$gcf_access_input = elgg_view('input/access', array(
		'name' => 'gcf_access',
		));

	if ($gcf_subtype === 'hjforum') { // enable categories and postings
		$gcf_enable_categories_label = elgg_echo('gcforums:enable_categories_label');
		$gcf_enable_categories_input = elgg_view('input/checkboxes', array(
			'name' => 'gcf_allow_categories',
			'id' => 'categories_id',
			'options' => array(
			$gcf_enable_categories_label => 1),
		));

		$gcf_enable_posting_label = elgg_echo('gcforums:enable_posting_label');
		$gcf_enable_posting_input = elgg_view('input/checkboxes', array(
			'name' => 'gcf_allow_posting',
			'id' => 'posting_id',
			'options' => array(
			$gcf_enable_posting_label => 1),
		));
	}


	if ($gcf_subtype === 'hjforum' && get_entity($gcf_container)->enable_subcategories) {

		if ($gcf_container && $gcf_container != 0) { // this is within the nested forums
			$query = "SELECT  oe.guid, oe.title
					FROM elggentities e, elggentity_relationships r, elggobjects_entity oe
					WHERE e.subtype = 28 AND e.guid = r.guid_one AND e.container_guid = {$gcf_container} AND e.guid = oe.guid";

		} else { // first page of group
			$query = "SELECT  oe.guid, oe.title
					FROM elggentities e, elggentity_relationships r, elggobjects_entity oe
					WHERE e.subtype = 28 AND e.guid = r.guid_one AND e.container_guid = {$gcf_group} AND e.guid = oe.guid";
		}

		$categories = get_data($query);

		$category_list = array();
		foreach ($categories as $category)
			$category_list[$category->guid] = $category->title;

		$gcf_file_under_category_label = elgg_echo('gcforums:file_under_category_label');
		$gcf_file_under_category_input = elgg_view('input/dropdown', array(
			'options' => $category_list,
		));
	}
} else {
	$gcf_title_input = elgg_view('input/hidden', array(
		'name' => 'gcf_title',
		'value' => $object_title,
	));
}

if (!$gcf_subtype)
	$gcf_description_label = elgg_echo('gcforums:topic_reply'); // reply to topic
else
	$gcf_description_label = elgg_echo('gcforums:description'); // description

$gcf_description_input = elgg_view('input/longtext', array(
	'name' => 'gcf_description',
	'id' => 'gcf_description',
));


$gcf_submit_button = elgg_view('input/submit', array(
	'value' => elgg_echo('gcforums:submit'),
	'name' => 'gcf_submit',
));


// hidden field for guid
$gcf_guid_input = elgg_view('input/hidden', array(
	'name' => 'gcf_guid',
	'value' => $object_guid,
	));

if ($gcf_subtype === 'hjforumpost') {
	// hidden field for title
	$gcf_title_input = elgg_view('input/hidden', array(
		'name' => 'gcf_title',
		));
	// hidden field for access id
	$gcf_access_input = elgg_view('input/hidden', array(
		'name' => 'gcf_access',
		'value' => $gcf_topic_access
	));
}
// hidden field for type
$gcf_type_input = elgg_view('input/hidden', array(
	'name' => 'gcf_type',
	'value' => 'object'
	));


// TODO: clean this up
if (!$gcf_subtype) {
	// hidden field for subtype
	$gcf_subtype_input = elgg_view('input/hidden', array(
		'name' => 'gcf_subtype',
		'value' => 'hjforumpost'
		));
} else {
	// hidden field for subtype
	$gcf_subtype_input = elgg_view('input/hidden', array(
		'name' => 'gcf_subtype',
		'value' => $gcf_subtype
		));
}

// hidden field for user
$gcf_owner_input = elgg_view('input/hidden', array(
	'name' => 'gcf_owner',
	'value' => get_loggedin_user()->getGUID(),
	));

// hidden field for forward url
$gcf_forward = $_SERVER['HTTP_REFERER'];
$gcf_forward_url_input = elgg_view('input/hidden', array(
	'name' => 'gcf_forward_url',
	'value' => $gcf_forward,
	));

//error_log('guid:'.$object_guid.' / container:'.$object->getContainerGUID());

if ($gcf_subtype === 'hjforumpost') { // posts

	echo <<<___HTML

		
<div>
	<label for="gcf_post_reply">$gcf_description_label</label>
	$gcf_description_input
</div>

	<!-- hidden input fields -->
	$gcf_guid_input
	$gcf_title_input
	$gcf_type_input
	$gcf_subtype_input
	$gcf_access_input
	$gcf_forward_url_input
	$gcf_owner_input

<div>
	$gcf_submit_button
</div>

___HTML;

} else { // category, topic and forum

	echo <<<___HTML

<div>
	<label for="gcf_title_input">$gcf_title_label</label>
	$gcf_title_input
</div>

<div>
	<label for="gcf_description_input">$gcf_description_label</label>
	$gcf_description_input
</div>

<div>
	$gcf_enable_categories_input
</div>

<div>
	$gcf_enable_posting_input
</div>

<div>
	<label for="gcf_file_under_category_input">$gcf_file_under_category_label</label>
	$gcf_file_under_category_input
</div>

<!-- TODO: display the access id of the container -->
<div>
	<label for="gcf_blog_description">$gcf_access_label</label>
	$gcf_access_input
</div>

	<!-- hidden input fields -->
	$gcf_guid_input
	$gcf_container_input
	$gcf_type_input
	$gcf_subtype_input
	$gcf_forward_url_input
	$gcf_owner_input

<div>
	$gcf_submit_button
</div>

___HTML;



}

