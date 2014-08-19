<?php

// formats a replacement array of breadcrumbs
// note that the array is built backwards due to the recursive
// getting of parents
function au_subgroups_breadcrumb_override($params) {
  switch ($params['segments'][0]) {
    case 'profile':
      $group = get_entity($params['segments'][1]);
      
      $breadcrumbs[] = array('title' => elgg_echo('groups'), 'link' => elgg_get_site_url() . 'groups/all');
      $parentcrumbs = au_subgroups_parent_breadcrumbs($group, false);
      
      foreach ($parentcrumbs as $parentcrumb) {
        $breadcrumbs[] = $parentcrumb;
      }
      
      $breadcrumbs[] = array(
          'title' => $group->name,
          'link' => NULL
      );
      
      set_input('au_subgroups_breadcrumbs', $breadcrumbs);
      break;
      
    case 'edit':
      $group = get_entity($params['segments'][1]);
      
      $breadcrumbs[] = array('title' => elgg_echo('groups'), 'link' => elgg_get_site_url() . 'groups/all');
      $parentcrumbs = au_subgroups_parent_breadcrumbs($group, false);
      
      foreach ($parentcrumbs as $parentcrumb) {
        $breadcrumbs[] = $parentcrumb;
      }
      $breadcrumbs[] = array('title' => $group->name, 'link' => $group->getURL());
      $breadcrumbs[] = array('title' => elgg_echo('groups:edit'), 'link' => NULL);
      
      set_input('au_subgroups_breadcrumbs', $breadcrumbs);
      break;
  }
}

/**
 * Clones the custom layout of a parent group, for a newly created subgroup
 * @param type $group
 * @param type $parent
 */
function au_subgroups_clone_layout($group, $parent) {
  if (!elgg_is_active_plugin('group_custom_layout') || !group_custom_layout_allow($parent)) {
    return false;
  }
  
  // get the layout object for the parent
  if($parent->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION) <= 0) {
    return false;
  }
  
  $parentlayout = $parent->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
  $parentlayout = $parentlayout[0];
  
  $layout = new ElggObject();
	$layout->subtype = GROUP_CUSTOM_LAYOUT_SUBTYPE;
	$layout->owner_guid = $group->getGUID();
	$layout->container_guid = $group->getGUID();
	$layout->access_id = ACCESS_PUBLIC;

	$layout->save();
  
  // background image
  $layout->enable_background = $parentlayout->enable_background;
  $parentimg = elgg_get_config('dataroot') . 'group_custom_layout/backgrounds/' . $parent->getGUID() . '.jpg';
  $groupimg = elgg_get_config('dataroot') . 'group_custom_layout/backgrounds/' . $group->getGUID() . '.jpg';
  if(file_exists($parentimg)) {
		copy($parentimg, $groupimg);
	}
  
  $layout->enable_colors = $parentlayout->enable_colors;
  $layout->background_color = $parentlayout->background_color;
  $layout->border_color = $parentlayout->border_color;
  $layout->title_color = $parentlayout->title_color;
  $group->addRelationship($layout->getGUID(), GROUP_CUSTOM_LAYOUT_RELATION);
}


function au_subgroups_delete_entities($result, $getter, $options) {
  $result->delete();
}

/**
 * recursively travels down all routes to gather all guids of
 * groups that are children of the supplied group
 * 
 * @param type $group
 * @param type $guids
 * @return type
 */
function au_subgroups_get_all_children_guids($group, $guids = array()) {
  // get children and delete them
  $children = au_subgroups_get_subgroups($group, 0);
  
  if (!$children) {
    return $guids;
  }
  
  foreach ($children as $child) {
    $guids[] = $child->guid;
  }
  
  foreach ($children as $child) {
    $guids = au_subgroups_get_all_children_guids($child, $guids);
  }
  
  return $guids;
}

/**
 * Determines if a group is a subgroup of another group
 * 
 * @param type $group
 * return ElggGroup | false
 */
function au_subgroups_get_parent_group($group) {
  if (!elgg_instanceof($group, 'group')) {
    return false;
  }
  
  $parent = elgg_get_entities_from_relationship(array(
            'types' => array('group'),
            'limit' => 1,
            'relationship' => AU_SUBGROUPS_RELATIONSHIP,
            'relationship_guid' => $group->guid,
          ));
  
  if (is_array($parent)) {
    return $parent[0];
  }
  
  return false;
}


function au_subgroups_get_subgroups($group, $limit = 10, $sortbytitle = false) {
  $options = array(
    'types' => array('group'),
    'relationship' => AU_SUBGROUPS_RELATIONSHIP,
    'relationship_guid' => $group->guid,
    'inverse_relationship' => true,
    'limit' => $limit,
  );
  
  if ($sortbytitle) {
    $options['joins'] = array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid");
    $options['order_by'] = "g.name ASC";
  }
  
  return elgg_get_entities_from_relationship($options);
}


function au_subgroups_handle_mine_page() {
  $display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
  $display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
  $db_prefix = elgg_get_config('dbprefix');
	$page_owner = elgg_get_page_owner_entity();

	if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('groups:yours');
	} else {
		$title = elgg_echo('groups:user', array($page_owner->name));
	}
	elgg_push_breadcrumb($title);

	elgg_register_title_button();

	$options = array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => elgg_get_page_owner_guid(),
		'inverse_relationship' => false,
		'full_view' => false,
	);
    
  if ($display_subgroups != 'yes') {
    $options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
  }
  
  if ($display_alphabetically != 'no') {
    $options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
    $options['order_by'] = 'ge.name ASC';
  }
    
  $content = elgg_list_entities_from_relationship($options);
	if (!$content) {
		$content = elgg_echo('groups:none');
	}
  
  $sidebar = '';
  $display_sidebar = elgg_get_plugin_setting('display_featured', 'au_subgroups');
  if ($display_sidebar == 'yes') {
    $sidebar = elgg_view('groups/sidebar/featured');
  }

	$params = array(
		'content' => $content,
    'sidebar' => $sidebar,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}


function au_subgroups_handle_openclosed_tabs() {
  $display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
  $display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
  $db_prefix = elgg_get_config('dbprefix');
  // all groups doesn't get link to self
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('groups'));
	
	elgg_register_title_button();
	
	$selected_tab = get_input('filter');

	// default group options
	$group_options = array(
		"type" => "group", 
		"full_view" => false,
	);
  
  if ($display_subgroups != 'yes') {
    $group_options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
  }
  
  if ($display_alphabetically != 'no') {
    $group_options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
    $group_options['order_by'] = 'ge.name ASC';
  }
	
	switch ($selected_tab) {
		case "open":
			$group_options["metadata_name_value_pairs"] = array(
				"name" => "membership",
				"value" => ACCESS_PUBLIC
			);
			
			break;
		case "closed":
			$group_options["metadata_name_value_pairs"] = array(
				"name" => "membership",
				"value" => ACCESS_PUBLIC,
				"operand" => "<>"
			);
			
			break;
    
    case "alpha":
			$dbprefix = elgg_get_config("dbprefix");
			
			$group_options["joins"]	= array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid");
			$group_options["order_by"] = "ge.name ASC";
			
			break;
	}
	
	if(!($content = elgg_list_entities_from_metadata($group_options))){
		$content = elgg_echo("groups:none");
	}
	
	$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));

	$sidebar = elgg_view('groups/sidebar/find');
	$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => $filter,
	);
	
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page(elgg_echo('groups:all'), $body);
}


function au_subgroups_handle_owned_page() {
  $db_prefix = elgg_get_config('dbprefix');
	$page_owner = elgg_get_page_owner_entity();

	if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
		$title = elgg_echo('groups:owned');
	} else {
		$title = elgg_echo('groups:owned:user', array($page_owner->name));
	}
	elgg_push_breadcrumb($title);

	elgg_register_title_button();

	$options = array(
		'type' => 'group',
		'owner_guid' => elgg_get_page_owner_guid(),
		'full_view' => false,
	);
    
  $options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
  $options['order_by'] = 'ge.name asc';
  
  $options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
  
  $content = elgg_list_entities($options);
	if (!$content) {
		$content = elgg_echo('groups:none');
	}
  
  $sidebar = '';
  $display_sidebar = elgg_get_plugin_setting('display_featured', 'au_subgroups');
  if ($display_sidebar == 'yes') {
    $sidebar = elgg_view('groups/sidebar/featured');
  }

	$params = array(
		'content' => $content,
    'sidebar' => $sidebar,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}


function au_subgroups_list_subgroups($group, $limit = 10, $sortbytitle = false) {
  $options = array(
    'types' => array('group'),
    'relationship' => AU_SUBGROUPS_RELATIONSHIP,
    'relationship_guid' => $group->guid,
    'inverse_relationship' => true,
    'limit' => $limit,
    'full_view' => false
  );
  
  if ($sortbytitle) {
    $options['joins'] = array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid");
    $options['order_by'] = "g.name ASC";
  }
  
  return elgg_list_entities_from_relationship($options);
}


function au_subgroups_move_content($result, $getter, $options) {
  switch ($options['au_subgroups_content_policy']) {
    case 'owner':
      $result->container_guid = $result->owner_guid;
      $result->save();
      break;
    
    case 'parent':
      $result->container_guid = $options['au_subgroups_parent_guid'];
      $result->save();
      break;
  }
}

/**
 * Sets breadcrumbs from 'All groups' to current parent
 * iterating through all parent groups
 * @param type $group
 */
function au_subgroups_parent_breadcrumbs($group, $push = true) {
  $parents = array();
  
  while($parent = au_subgroups_get_parent_group($group)) {
    $parents[] = array('title' => $parent->name, 'link' => $parent->getURL());
    $group = $parent;
  }
  
  $parents = array_reverse($parents);
  
  if ($push) {
    elgg_push_breadcrumb(elgg_echo('groups'), elgg_get_site_url() . 'groups/all');
    foreach ($parents as $breadcrumb) {
      elgg_push_breadcrumb($breadcrumb['title'], $breadcrumb['link']);
    }
  }
  else {
    return $parents;
  }
}


// links the subgroup with the parent group
function au_subgroups_set_parent_group($group_guid, $parent_guid) {
  add_entity_relationship($group_guid, AU_SUBGROUPS_RELATIONSHIP, $parent_guid);
}