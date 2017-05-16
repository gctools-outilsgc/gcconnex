<?php
$group = get_entity($vars['group_guid']);
$db_prefix = elgg_get_config('dbprefix');

if (elgg_is_logged_in() && $group->isMember(elgg_get_logged_in_user_entity())) {

	// if this is within a group, set owner to group
	if (!elgg_get_page_owner_guid())
		elgg_set_page_owner_guid($vars['group_guid']);

	$gcf_subtype = $vars['subtype'];
	$gcf_group = $vars['group_guid'];
	$gcf_container = $vars['container_guid'];
	
	// variables are passed in the .../gcforums/start.php (form is embedded in the content file)
	$gcf_topic_access = $vars['topic_access']; 
	$gcf_topic_guid = $vars['topic_guid']; // post only
	$hjforumpost_title = "RE: $gcf_topic_guid";	// post only

	$object = get_entity($object_guid);
	
	if (!$gcf_container)
		$gcf_container = $gcf_topic_guid;

	
	if ($gcf_container == 0 || !$gcf_container)
		$gcf_container = $gcf_group;

	if ($gcf_subtype === "hjforumpost")
		$gcf_container = $gcf_topic_guid;

	// debug error_log (will be displayed above forms) comment-out for production!
	//if ($gcf_subtype === "hjforumpost")
	//	echo "create.php :: group: {$gcf_group} / subtype: {$gcf_subtype} / topic_access: {$gcf_topic_access} / topic_guid: {$gcf_topic_guid} / container: {$gcf_container} / title: {$hjforumpost_title}";
	//else
	//	echo "create.php :: subtype: {$gcf_subtype} / group: {$gcf_group} / container: {$gcf_container}";


	// title, description and access (visible)
	if ($gcf_subtype === 'hjforum' || $gcf_subtype === 'hjforumcategory' || $gcf_subtype === 'hjforumtopic') {

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

		// save as sticky topic
		if (($gcf_subtype === 'hjforumtopic' && in_array($gcf_current_user_guid, $gcf_moderator_user)) || elgg_is_admin_logged_in()) {
			$gcf_sticky_topic_label = elgg_echo('gcforums:sticky_topic');
			$gcf_sticky_topic_input = elgg_view('input/checkboxes', array(
				'name' => 'gcf_sticky',
				'id' => 'gcf_sticky',
                'class' => 'list-unstyled mrgn-tp-sm',
				'options' => array(
					$gcf_sticky_topic_label => 1),
			));
		}

		// title (required)
		$gcf_title_label = elgg_echo("gcforums:title_label_{$gcf_subtype}");
		$gcf_title_input = elgg_view('input/text', array(
			'name' => 'gcf_title',
			'required' => true
		));

		// access level
		$gcf_access_label = elgg_echo('gcforums:access_label');
		$gcf_access_input = elgg_view('input/access', array(
			'name' => 'gcf_access',
		));

		// enable categories and postings
		if ($gcf_subtype === 'hjforum') { 
			$gcf_enable_categories_label = elgg_echo('gcforums:enable_categories_label');
			$gcf_enable_categories_input = elgg_view('input/checkboxes', array(
				'name' => 'gcf_allow_categories',
				'id' => 'categories_id',
                'class' => 'list-unstyled mrgn-tp-sm',
				'options' => array(
					$gcf_enable_categories_label => 1),
			));

			$gcf_enable_posting_label = elgg_echo('gcforums:enable_posting_label');
			$gcf_enable_posting_input = elgg_view('input/checkboxes', array(
				'name' => 'gcf_allow_posting',
				'id' => 'posting_id',
                'class' => 'list-unstyled mrgn-tp-sm',
				'options' => array(
					$gcf_enable_posting_label => 1),
			));
		}


		if ($gcf_subtype === 'hjforum' && (get_entity($gcf_container)->enable_subcategories || get_entity($gcf_container) instanceof ElggGroup) ) {

			// cyu - patched 03/21/2016
			if ($gcf_container && $gcf_container != 0) { // this is within the nested forums
				$query = "SELECT  oe.guid, oe.title
						FROM {$db_prefix}entities e, {$db_prefix}entity_relationships r, {$db_prefix}objects_entity oe, {$db_prefix}entity_subtypes es
						WHERE e.subtype = es.id AND e.guid = r.guid_one AND e.container_guid = {$gcf_container} AND e.guid = oe.guid AND es.subtype='hjforumcategory'";

			} else { // first page of group
				$query = "SELECT oe.guid, oe.title
						FROM {$db_prefix}entities e, {$db_prefix}entity_relationships r, {$db_prefix}objects_entity oe, {$db_prefix}entity_subtypes es
						WHERE e.subtype = es.id AND e.guid = r.guid_one AND e.container_guid = {$gcf_group} AND e.guid = oe.guid AND es.subtype='hjforumcategory'";
			}


			$categories = get_data($query);
			// cyu - patched issue with forum without category
			if (!$categories) {
				register_error(elgg_echo('gcforums:categories_requred'));
				forward(REFERER);
			}

			$category_list = array();
			foreach ($categories as $category)
				$category_list[$category->guid] = $category->title;

			$gcf_file_under_category_label = elgg_echo('gcforums:file_under_category_label');
			$gcf_file_under_category_input = elgg_view('input/dropdown', array(
				'options_values' => $category_list,
				'name' => 'gcf_file_in_category',

			));
		}
	}

	if (!$gcf_subtype || $gcf_subtype === 'hjforumpost')
		$gcf_description_label = elgg_echo('gcforums:topic_reply'); // reply to topic
	else
		$gcf_description_label = elgg_echo('gcforums:description'); // description

	// description
	$gcf_description_input = elgg_view('input/longtext', array(
		'name' => 'gcf_description',
		'id' => 'gcf_description',
		'required' => true
	));


	$gcf_submit_button = elgg_view('input/submit', array(
		'value' => elgg_echo('gcforums:submit'),
		'name' => 'gcf_submit',
	));


	// hidden field for guid
	$gcf_container_input = elgg_view('input/hidden', array(
		'name' => 'gcf_container',
		'value' => $gcf_container,
		));

	if ($gcf_subtype === 'hjforumpost') {
		// hidden field for title
		$gcf_title_input = elgg_view('input/hidden', array(
			'name' => 'gcf_title',
			'value' => $hjforumpost_title,
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

	$gcf_group_input = elgg_view('input/hidden', array(
		'name' => 'gcf_group',
		'value' => $gcf_group
		));

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
		'value' => elgg_get_logged_in_user_entity()->getGUID(),
		));

	// hidden field for forward url
	$gcf_forward = $_SERVER['HTTP_REFERER'];
	$gcf_forward_url_input = elgg_view('input/hidden', array(
		'name' => 'gcf_forward_url',
		'value' => $gcf_forward,
		));


	if ($gcf_subtype === 'hjforumpost') { // posts

		echo <<<___HTML
		
<div>
	<label for="gcf_post_reply">$gcf_description_label</label>
	$gcf_description_input
</div>

	<!-- hidden input fields -->
	$gcf_group_input
	$gcf_guid_input
	$gcf_container_input
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
	$gcf_sticky_topic_input
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
	$gcf_group_input
	$gcf_guid_input
	$gcf_container_input
	$gcf_type_input
	$gcf_subtype_input
	$gcf_forward_url_input
	$gcf_owner_input

<div class="mrgn-tp-md">
	$gcf_submit_button
</div>

___HTML;



	}

}