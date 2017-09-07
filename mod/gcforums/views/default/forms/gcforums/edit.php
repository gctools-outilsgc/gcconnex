<?php

$object = get_entity($vars['entity_guid']);
 //TODO: sticky topic

/// title, description, and access
function general_information_form($object) {
	$return = array();
	$sub_return = array();

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
	$txtAccess = elgg_view('input/access', array(
		'name' => 'txtAccess',
		'value' => $object->access_id
	));


	$return = array( 
		'description' => array($lblDescription, $txtDescription),
		'access' => array($lblAccess, $txtAccess)
	);

	if ($sub_return) {
		$return = array_merge($return, $sub_return);
	}

	return $return;
}

/// category filing, enable subcategories, and disable posting
function forums_information_form($object) {
	$dbprefix = elgg_get_config('dbprefix');
	$return = array();
	$sub_return = array();

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
		
		// this is within the nested forums
		if ($vars['forum_guid'] && $vars['forum_guid'] != 0) { 
			$query = "SELECT  oe.guid, oe.title
					FROM {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity oe, {$dbprefix}entity_subtypes es
					WHERE e.subtype = es.id AND es.subtype = 'hjforumcategory' AND e.guid = r.guid_one AND e.container_guid = {$object->getContainerGUID()} AND e.guid = oe.guid";
		}

		$query = "	SELECT guid_two
					FROM {$dbprefix}entity_relationships
					WHERE guid_one = {$object->getGUID()} AND relationship = 'filed_in'";
		$shelved_in = get_data($query);


	 	$categories = get_data($query);

	 	$category_list = array();
	 	foreach ($categories as $category)
	 		$category_list[$category->guid] = $category->title;

		$lblCategoryFiling = elgg_echo('gcforums:file_under_category_label');
		$ddCategoryFiling = elgg_view('input/dropdown', array(
			'options_values' => $category_list,
			'name' => 'txtCategoryFiling',
			'value' => $shelved_in[0]->guid_two,
		));

		$sub_return = array('category_filing' => array($lblCategoryFiling, $ddCategoryFiling));
	}

	if (!$sub_return) {
		$return = array(
			'enable_category' => array($lblEnableCategory, $chkEnableCategory),
			'enable_posting' => array($lblEnablePost, $chkEnablePost),
		);

	} else {
		$return = array_merge($return, $sub_return);
	}

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

function hidden_information_form($object) {

	// hidden field for guid
	$hidden_object = elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $object->getGUID(),
	));

	$hidden_forwardurl = 


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

	return $return;
}




$labels = array('title', 'description', 'category_filing', 'sticky', 'enable_category', 'enable_posting', 'access');

echo "<div class='tab-content tab-content-border'>";
foreach ($labels as $label) {
	if (!is_array($content[$label])) continue;

	echo "<p><label> {$content[$label][0]} </label> {$content[$label][1]}</p>";
}
echo "</div>";

/// hidden forms to pass additional information to the action


	$gcf_save_button = elgg_view('input/submit', array(
		'value' => elgg_echo('gcforums:save_button'),
		'name' => 'save'
	));

	echo $gcf_save_button;



