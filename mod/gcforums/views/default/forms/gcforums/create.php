<?php

$current_entity = get_entity($vars['current_entity']);
$entity_type = $vars['entity_type'];
$group_guid = $vars['group_guid'];
$object = $current_entity;

/// main code
$subtype = $entity_type;

switch ($subtype) {

	case 'hjforumcategory':
		$content = general_information_form($object);
		break;

	case 'hjforum':
		$content = array_merge(general_information_form($object), forums_information_form($object));
		break;

	case 'hjforumtopic':
		$content = array_merge(general_information_form($object), forums_topic_form($object));
		break;

	case 'hjforumpost':
		$content = general_information_form($object);
		break;
}


$labels = array('title', 'description', 'category_filing', 'sticky', 'enable_category', 'enable_posting', 'is_sticky', 'access');

echo "<div class='tab-content tab-content-border'>";
foreach ($labels as $label) {
	if (!is_array($content[$label])) {
		continue;
	}

	$form_input = ($label === 'enable_posting' || $label === 'enable_category' || $label === 'is_sticky')
		? "<p>{$content[$label][1]}</p>"
		: "<p><label> {$content[$label][0]} </label> {$content[$label][1]}</p>";

	echo $form_input;
}


/// hidden forms to pass additional information to the action
$hidden_forms = hidden_information_form($object);
foreach ($hidden_forms as $form) {
	echo $form;
}

$hidden_subtype = elgg_view('input/hidden', array(
	'name' => 'subtype',
	'value' => $subtype,
));

echo $hidden_subtype;

/// save button
$btnSave = elgg_view('input/submit', array(
	'value' => elgg_echo('gcforums:save_button'),
	'name' => 'save'
));

echo "<p>$btnSave</p>";

echo "</div>";



// this deals with comments or replies
/// title, description, and access
function general_information_form($object = null)
{
	$sub_return = array();

	// don't show field for title and access for forum post
	if ($object && $object->getSubtype() !== 'hjforumtopic') {
		$lblTitle = elgg_echo('gforums:title_label');
		$txtTitle = elgg_view('input/text', array(
			'name' => 'txtTitle',
			'value' => '',
			'required' => true
		));
		$sub_return = array('title' => array($lblTitle, $txtTitle));

		$access_id = (!$object->access_id) ? ACCESS_DEFAULT : $object->access_id;
		$lblAccess = elgg_echo('gcforums:access_label');
		$ddAccess = elgg_view('input/access', array(
			'name' => 'ddAccess',
			'value' => $access_id
		));

		$lblDescription = elgg_echo('gforums:description_label');
	}

	// for forum post... make sure the access id matches the topic
	if ($object && $object->getSubtype() === 'hjforumpost') {
		$ddAccess = $object->getContainerEntity()->access_id;
	}

	$txtDescription = elgg_view('input/longtext', array(
		'name' => 'txtDescription',
		'value' => '',
		'required' => true
	));

	$return = array(
		'description' => array($lblDescription, $txtDescription),
		'access' => array($lblAccess, $ddAccess)
	);


	$return = array_merge($return, $sub_return);

	return $return;
}

function forums_topic_form($object)
{
	$is_sticky = 0;
	$lblIsSticky = elgg_echo('gcforums:is_sticky');
	$chkIsSticky = elgg_view('input/checkboxes', array(
		'name' => 'chkIsSticky',
		'class' => 'list-unstyled',
		'options' => array($lblIsSticky => 1),
		'value' => $is_sticky,
	));

	$return = array(
		'is_sticky' => array($lblIsSticky, $chkIsSticky),
	);

	return $return;
}

/// category filing, enable subcategories, and disable posting
function forums_information_form($object)
{
	/// todo: identify if this object is new or not
	$dbprefix = elgg_get_config('dbprefix');

	$sub_return = array();
	$enable_subcategories = 0;
	$lblEnableCategory = elgg_echo('gcforums:enable_categories_label');
	$chkEnableCategory = elgg_view('input/checkboxes', array(
		'name' => 'chkEnableCategory',
		'class' => 'list-unstyled',
		'options' => array($lblEnableCategory => 1),
		'value' => $enable_subcategories,
	));

	$enable_posting = 0;
	$lblEnablePost = elgg_echo('gcforums:enable_posting_label');
	$chkEnablePost = elgg_view('input/checkboxes', array(
		'name' => 'chkEnablePost',
		'class' => 'list-unstyled',
		'options' => array($lblEnablePost => 1),
		'value' => $enable_posting,
	));

	// category option only available if the subcategory is enabled or first level forum in group
	if ($object->enable_subcategories || $object instanceof ElggGroup) {

		// retrieve a list of available categories
		$query = "	SELECT oe.guid, oe.title
					FROM {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity oe, {$dbprefix}entity_subtypes es
					WHERE e.subtype = es.id AND es.subtype = 'hjforumcategory' AND e.guid = r.guid_one AND e.container_guid = {$object->getGUID()} AND e.guid = oe.guid";

		$categories = get_data($query);
		$category_list = array();
		foreach ($categories as $category) {
			$category_list[$category->guid] = $category->title;
		}

		$lblCategoryFiling = elgg_echo('gcforums:file_under_category_label');
		$ddCategoryFiling = elgg_view('input/dropdown', array(
			'options_values' => $category_list,
			'name' => 'ddCategoryFiling',
		));

		$sub_return = array('category_filing' => array($lblCategoryFiling, $ddCategoryFiling));
	}

	$return = array(
		'enable_category' => array($lblEnableCategory, $chkEnableCategory),
		'enable_posting' => array($lblEnablePost, $chkEnablePost),
	);

	$return = array_merge($return, $sub_return);

	return $return;
}

function hidden_information_form($object)
{
	// hidden field for guid
	$hidden_object = elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $object->getGUID(),
	));

	$hidden_group = elgg_view('input/hidden', array(
		'name' => 'group_guid',
		'value' => $group_guid,
	));

	$base_url = elgg_get_site_entity()->getURL();

	// hidden field for forward url
	$forward_url = "{$base_url}gcforums/view/{$object->getGUID()}";
	$hidden_forward_url = elgg_view('input/hidden', array(
		'name' => 'hidden_forward_url',
		'value' => str_replace('amp;', '', $forward_url),
	));

	$return = array('group_guid' => $hidden_group, 'entity_guid' => $hidden_object, 'forward_url' => $hidden_forward_url);

	return $return;
}
