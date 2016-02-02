<?php

//elgg_push_breadcrumb('step 1');

$object = get_entity($vars['forum_guid']);
$vars['entity'] = $object;


// category | topic
$gcf_title_label = elgg_echo('gforums:title_label');
$gcf_title_input = elgg_view('input/text', array(
	'name' => 'gcf_title',
	'value' => $object->title,
));

$gcf_description_label = elgg_echo('gforums:description_label');
$gcf_description_input = elgg_view('input/longtext', array(
	'name' => 'gcf_description',
	'id' => 'blog_description',
	'value' => $object->description,
));

$gcf_access_label = elgg_echo('gforums:access_label');
$gcf_access_input = elgg_view('input/access', array(
	'name' => 'gcf_access_id',
	'id' => 'gcf_access_id',
	'value' => $object->access_id
));

if ($object->getSubtype() === 'hjforum') {
	$gcf_enable_categories_label = elgg_echo('gforums:enable_categories_label');
	$gcf_enable_categories_input = elgg_view('input/checkboxes', array(
		'name' => 'gcf_allow_categories',
		'id' => 'categories_id',
		'options' => array(
			$gcf_enable_categories_label => 1),
		'value' => $object->enable_subcategories,
	));

	$gcf_enable_posting_label = elgg_echo('gforums:enable_posting_label');
	$gcf_enable_posting_input = elgg_view('input/checkboxes', array(
		'name' => 'gcf_allow_posting',
		'id' => 'posting_id',
		'options' => array(
			$gcf_enable_posting_label => 1),
		'value' => $object->enable_posting,
		));
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
	$gcf_guid_input
	$gcf_container_input
	$gcf_type_input
	$gcf_forward_url_input

<div>
	$gcf_save_button
</div>

___HTML;

