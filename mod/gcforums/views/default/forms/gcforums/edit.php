<?php

//elgg_push_breadcrumb('step 1');

$object = get_entity($vars['forum_guid']);
$vars['entity'] = $object;
$db_prefix = elgg_get_config('dbprefix');

// category | topic
if ($object->getSubtype() !== 'hjforumpost') {
	$gcf_title_label = elgg_echo('gforums:title_label');
	$gcf_title_input = elgg_view('input/text', array(
		'name' => 'gcf_title',
		'value' => $object->title,
		'required' => true
	));

	$gcf_access_label = elgg_echo('gcforums:access_label');
	$gcf_access_input = elgg_view('input/access', array(
		'name' => 'gcf_access_id',
		'id' => 'gcf_access_id',
		'value' => $object->access_id
	));
}

$gcf_description_label = elgg_echo('gforums:description_label');
$gcf_description_input = elgg_view('input/longtext', array(
	'name' => 'gcf_description',
	'id' => 'blog_description',
	'value' => $object->description,
	'required' => true
));


// cyu - patched that only group owner/moderators/admin can do sticky topics
$gcf_current_user_guid = elgg_get_logged_in_user_guid();
$gcf_moderator_users_guid = array();

$gcf_moderator_user[] = get_entity($vars['group_guid'])->owner_guid;
$group_operators = elgg_get_entities_from_relationship(array(
	'relationship' => 'operator',
	'relationship_guid' => $vars['group_guid'],
	'inverse_relationship' => true
));

foreach ($group_operators as $group_operator)
	$gcf_moderator_user[] = $group_operator->guid;

if (($object->getSubtype() === 'hjforumtopic' && in_array($gcf_current_user_guid, $gcf_moderator_user)) || elgg_is_admin_logged_in()) {

	$gcf_sticky_topic_label = elgg_echo('gcforums:is_sticky');
	$gcf_sticky_topic_input = elgg_view('input/checkboxes', array(
		'name' => 'gcf_sticky',
		'id' => 'gcf_sticky',
		'class' => 'list-unstyled mrgn-tp-sm',
		'options' => array(
		$gcf_sticky_topic_label => 1),
		'value' => $object->sticky,
	));
}

if ($object->getSubtype() === 'hjforum') {
	$gcf_enable_categories_label = elgg_echo('gcforums:enable_categories_label');
	$gcf_enable_categories_input = elgg_view('input/checkboxes', array(
		'name' => 'gcf_allow_categories',
		'id' => 'categories_id',
		'class' => 'list-unstyled',
		'options' => array(
			$gcf_enable_categories_label => 1),
		'value' => $object->enable_subcategories,
	));

	$gcf_enable_posting_label = elgg_echo('gcforums:enable_posting_label');
	$gcf_enable_posting_input = elgg_view('input/checkboxes', array(
		'name' => 'gcf_allow_posting',
		'id' => 'posting_id',
		'class' => 'list-unstyled',
		'options' => array(
			$gcf_enable_posting_label => 1),
		'value' => $object->enable_posting,
		));

	$query = "SELECT guid_two
				FROM {$db_prefix}entity_relationships
				WHERE guid_one = {$vars['forum_guid']} AND relationship = 'filed_in'";
	$shelved_in = get_data($query);
	
	//echo print_r($shelved_in);
	//echo " // {$shelved_in[0]->guid_two}";

	// this is forum object then check to see if categories is enabled
	if ($object->enable_subcategories || get_entity($object->getContainerGUID()) instanceof ElggGroup) {
		
		if ($vars['forum_guid'] && $vars['forum_guid'] != 0) { // this is within the nested forums
			$query = "SELECT  oe.guid, oe.title
					FROM {$db_prefix}entities e, {$db_prefix}entity_relationships r, {$db_prefix}objects_entity oe, {$db_prefix}entity_subtypes es
					WHERE e.subtype = es.id AND es.subtype = 'hjforumcategory' AND e.guid = r.guid_one AND e.container_guid = {$object->getContainerGUID()} AND e.guid = oe.guid";
		}

	 	$categories = get_data($query);

	 	$category_list = array();
	 	foreach ($categories as $category)
	 		$category_list[$category->guid] = $category->title;

		$gcf_file_under_category_label = elgg_echo('gcforums:file_under_category_label');
		$gcf_file_under_category_input = elgg_view('input/dropdown', array(
			'options_values' => $category_list,
			'name' => 'gcf_file_in_category',
			'value' => $shelved_in[0]->guid_two,
		));
	}
}

// hidden field for guid
$gcf_guid_input = elgg_view('input/hidden', array(
	'name' => 'gcf_guid',
	'value' => $object->getGUID(),
	));
// hidden field for category guid
$gcf_container_input = elgg_view('input/hidden', array(
	'name' => 'gcf_container',
	'value' => $object->getContainerGUID(),
	));
// hidden field for subtype
$gcf_type_input = elgg_view('input/hidden', array(
	'name' => 'gcf_type',
	'value' => $object->getSubtype()
	));

// hidden field for group guid
$gcf_group_input = elgg_view('input/hidden', array(
	'name' => 'gcf_group',
	'value' => $gcf_group
	));

// hidden field for forward url
$gcf_forward = trim($_SERVER['HTTP_REFERER']);
$gcf_forward_url_input = elgg_view('input/hidden', array(
	'name' => 'gcf_forward_url',
	'value' => str_replace('amp;','',$gcf_forward),
	));

$gcf_save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('gcforums:save_button'),
	'name' => 'save'
));


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
 	<label for="gcf_file_under_category_input">$gcf_file_under_category_label</label>
 	$gcf_file_under_category_input
</div>

<div>
	$gcf_sticky_topic_input
</div>

<div>
	$gcf_enable_categories_input
</div>

<div>
	$gcf_enable_posting_input
</div>

<div>
	<label for="gcf_blog_description">$gcf_access_label</label>
	$gcf_access_input
</div>

	<!-- hidden input fields -->
	$gcf_group_input
	$gcf_guid_input
	$gcf_container_input
	$gcf_type_input
	$gcf_forward_url_input

<div class="mrgn-tp-md">
	$gcf_save_button
</div>

___HTML;

