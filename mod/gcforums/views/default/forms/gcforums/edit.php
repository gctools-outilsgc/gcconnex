<?php

$object = get_entity($vars['entity_guid']);
 //TODO: sticky topic

/// title, description, and access
function general_information_form($object) {

	if ($object->getSubtype() !== 'hjforumpost') {
		$lblTitle = elgg_echo('gforums:title_label');
		$txtTitle = elgg_view('input/text', array(
			'name' => 'txtTitle',
			'value' => $object->title,
			'required' => true
		));
		$sub_return = array('title' => array($lblTitle, $txtTitle));
	}

	$lblDescription = elgg_echo('gforums:description_label');
	$txtDescription = elgg_view('input/longtext', array(
		'name' => 'txtDescription',
		'value' => $object->description,
		'required' => true
	));

	$lblAccess = elgg_echo('gcforums:access_label');
	$ddAccess = elgg_view('input/access', array(
		'name' => 'ddAccess',
		'value' => $object->access_id
	));


	$return = array( 
		'description' => array($lblDescription, $txtDescription),
		'access' => array($lblAccess, $ddAccess)
	);

	if ($sub_return) $return = array_merge($return, $sub_return);

	return $return;
}

/// category filing, enable subcategories, and disable posting
function forums_information_form($object) {
	$dbprefix = elgg_get_config('dbprefix');

	$lblEnableCategory = elgg_echo('gcforums:enable_categories_label');
	$chkEnablePost = elgg_view('input/checkboxes', array(
		'name' => 'chkEnableCategory',
		'class' => 'list-unstyled',
		'options' => array($lblEnableCategory => 1),
		'value' => $object->enable_subcategories,
	));

	$lblEnablePost = elgg_echo('gcforums:enable_posting_label');
	$chkEnablePost = elgg_view('input/checkboxes', array(
		'name' => 'chkEnablePost',
		'class' => 'list-unstyled',
		'options' => array($lblEnablePost => 1),
		'value' => $object->enable_posting,
	));

	// category option only available if the subcategory is enabled or first level forum in group
	if ($object->getContainerEntity()->enable_subcategories || $object->getContainerEntity() instanceof ElggGroup) {

		// retrieve a list of available categories
		if ($object->getGUID() && $object->getGUID() !== 0) { 
			$query = "	SELECT  oe.guid, oe.title
						FROM {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity oe, {$dbprefix}entity_subtypes es
						WHERE e.subtype = es.id AND es.subtype = 'hjforumcategory' AND e.guid = r.guid_one AND e.container_guid = {$object->getContainerGUID()} AND e.guid = oe.guid";

		}
		$categories = get_data($query);

		$category_list = array();
	 	foreach ($categories as $category)
	 		$category_list[$category->guid] = $category->title;


		// retrieve the current category that the forum is listed under
		$query = "	SELECT guid_two FROM {$dbprefix}entity_relationships WHERE guid_one = {$object->getGUID()} AND relationship = 'filed_in'";
		$currently_filed_under = get_data($query);

		$lblCategoryFiling = elgg_echo('gcforums:file_under_category_label');
		$ddCategoryFiling = elgg_view('input/dropdown', array(
			'options_values' => $category_list,
			'name' => 'ddCategoryFiling',
			'value' => $currently_filed_under[0]->guid_two,
		));

		$sub_return = array('category_filing' => array($lblCategoryFiling, $ddCategoryFiling));
	}

	$return = array(
		'enable_category' => array($lblEnableCategory, $chkEnableCategory),
		'enable_posting' => array($lblEnablePost, $chkEnablePost),
	);

	if ($sub_return) $return = array_merge($return, $sub_return);

	return $return;
}

function hidden_information_form($object) {

	// hidden field for guid
	$hidden_object = elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $object->getGUID(),
	));

	$base_url = elgg_get_site_entity()->getURL();

	// hidden field for forward url
	$forward_url = "{$base_url}gcforums/view/{$object->getGUID()}"; 
	$hidden_forward_url = elgg_view('input/hidden', array(
		'name' => 'hidden_forward_url',
		'value' => str_replace('amp;','',$forward_url),
	));

	$return = array('entity_guid' => $hidden_object, 'forward_url' => $hidden_forward_url);

	return $return;
}

$subtype = $object->getSubtype();
switch($subtype) {

	case 'hjforumcategory':
	$content = general_information_form($object);
	break;

	case 'hjforum':
	$content = array_merge(general_information_form($object), forums_information_form($object));
	break;

	case 'hjforumtopic':
	$content = general_information_form($object);
	break;

	case 'hjforumpost':
	$content = general_information_form($object);
	break;

	default:
}


$labels = array('title', 'description', 'category_filing', 'sticky', 'enable_category', 'enable_posting', 'access');

echo "<div class='tab-content tab-content-border'>";
foreach ($labels as $label) {
	if (!is_array($content[$label])) continue;
	echo "<p><label> {$content[$label][0]} </label> {$content[$label][1]}</p>";
}


/// hidden forms to pass additional information to the action
$hidden_forms = hidden_information_form($object);
foreach ($hidden_forms as $form) echo $form;

/// save button
$btnSave = elgg_view('input/submit', array(
	'value' => elgg_echo('gcforums:save_button'),
	'name' => 'save'
));

echo "<p>$btnSave</p>";

echo "</div>";


