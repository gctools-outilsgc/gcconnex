<?php
/**
 * Elgg Etherpad lite plugin
 *
 * @package etherpad
 */
 
elgg_register_event_handler('init', 'system', 'etherpad_init');


function etherpad_init() {
	
	$actions_base = elgg_get_plugins_path() . 'etherpad/actions/docs';
	elgg_register_action("docs/save", "$actions_base/save.php");
	elgg_register_action("docs/delete", "$actions_base/delete.php");
	
	elgg_register_page_handler('docs', 'etherpad_page_handler');
	
	// Language short codes must be of the form "etherpad:key"
	// where key is the array key below
	elgg_set_config('etherpad', array(
		'title' => 'text',
		'tags' => 'tags',
		'access_id' => 'access',
		'write_access_id' => 'write_access',
	));
	
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'etherpad_entity_menu');
	
	elgg_register_entity_type('object', 'etherpad', 'ElggPad');
	elgg_register_entity_type('object', 'subpad', 'ElggPad');
	
	// write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'etherpad_write_permission_check');
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'etherpad_container_permission_check');
	
	//Widget
	elgg_register_widget_type('etherpad', elgg_echo('etherpad'), elgg_echo('etherpad:profile:widgetdesc'), array("dashboard", "profile", "groups"));
	
	// icon url override
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'etherpad_icon_url_override');
	
	if(elgg_get_plugin_setting('integrate_in_pages', 'etherpad') != 'yes') {
		$item = new ElggMenuItem('etherpad', elgg_echo('etherpad'), 'docs/all');
		elgg_register_menu_item('site', $item);
		
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'etherpad_owner_block_menu');
		
		// add to groups
		add_group_tool_option('etherpad', elgg_echo('groups:enablepads'), true);
		elgg_extend_view('groups/tool_latest', 'etherpad/group_module');
		
		// Register a URL handler for bookmarks
		elgg_register_entity_url_handler('object', 'etherpad', 'etherpad_url');
		elgg_register_entity_url_handler('object', 'subpad', 'etherpad_url');
	} else {
		// override pages library
		elgg_register_library('elgg:pages', elgg_get_plugins_path() . 'etherpad/lib/pages.php');
		
		elgg_register_page_handler('pages', 'etherpad_page_handler');

		// Register a URL handler for bookmarks
		elgg_register_entity_url_handler('object', 'etherpad', 'pages_url');
		elgg_register_entity_url_handler('object', 'subpad', 'pages_url');
	}
}


function etherpad_page_handler($page, $handler) {
	
	elgg_load_library('elgg:pages');
	
	if($handler == 'pages'){	
		// add the jquery treeview files for navigation
		elgg_load_js('jquery-treeview');
		elgg_load_css('jquery-treeview');
	}

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo("etherpad:$handler"), "$handler/all");
	
	$base_dir = elgg_get_plugins_path() . "etherpad/pages/$handler";

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			include "$base_dir/owner.php";
			break;
		case 'history':
			set_input('guid', $page[1]);
			include "$base_dir/history.php";
			break;
		case 'revision':
			set_input('id', $page[1]);
			include "$base_dir/revision.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Add timeslider to entity menu
 */
function etherpad_entity_menu($hook, $type, $return, $params) {
	
	$entity = $params['entity'];
	
	if (elgg_in_context('widgets')) {
		return $return;
	}
	
	if(!in_array($entity->getSubtype(), array('etherpad', 'subpad'))){
		return $return;
	}
	
	// timeslider button, show only if pages integration is enabled.
	$handler = elgg_get_plugin_setting('integrate_in_pages', 'etherpad') == 'yes' ? 'pages' : 'docs';
	if($handler == 'pages') {
		$options = array(
			'name' => 'etherpad-timeslider',
			'text' => elgg_echo('etherpad:timeslider'),
			'href' => elgg_get_site_url() . "$handler/history/" . $entity->guid,
			'priority' => 200,
		);
	} else if(elgg_get_plugin_setting('show_fullscreen', 'etherpad') == 'yes'){
		// fullscreen button
		$entity = new ElggPad($entity->guid);
		$options = array(
			'name' => 'etherpadfs',
			'text' => elgg_echo('etherpad:fullscreen'),
			'href' => $entity->getPadPath(),
			'target' => '_blank',
			'priority' => 200,
		);
	} 
	$return[] = ElggMenuItem::factory($options);

	return $return;
}

/**
* Returns a more meaningful message
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function etherpad_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && (($entity->getSubtype() == 'etherpad'))) {
		$descr = $entity->description;
		$title = $entity->title;
		//@todo why?
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		$owner = $entity->getOwnerEntity();
		return $owner->name . ' ' . elgg_echo("pages:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
	}
	return null;
}

/**
 * Override the etherpad url
 * 
 * @param ElggObject $entity Pad object
 * @return string
 */
function etherpad_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "docs/view/$entity->guid/$title";
}

/**
 * Override the default entity icon for docs
 *
 * @return string Relative URL
 */
function etherpad_icon_url_override($hook, $type, $returnvalue, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'etherpad') ||
		elgg_instanceof($entity, 'object', 'subpad')) {
		switch ($params['size']) {
			case 'small':
				return 'mod/etherpad/images/etherpad.png';
				break;
			case 'medium':
				return 'mod/etherpad/images/etherpad_lrg.png';
				break;
		}
	}
}

/**
 * Add a menu item to the user ownerblock
 */
function etherpad_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "docs/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('etherpad', elgg_echo('etherpad'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->pages_enable != "no") {
			$url = "docs/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('etherpad', elgg_echo('etherpad:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Extend permissions checking to extend can-edit for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function etherpad_write_permission_check($hook, $entity_type, $returnvalue, $params)
{
	if ($params['entity']->getSubtype() == 'etherpad' || $params['entity']->getSubtype() == 'subpad') {

		$write_permission = $params['entity']->write_access_id;
		$user = $params['user'];

		if( ($write_permission) && ($user) ){
			// $list = get_write_access_array($user->guid);
			$list = get_access_array($user->guid); // get_access_list($user->guid);

			if( ($write_permission!=0) && (in_array($write_permission,$list)) ){
				if( $params['entity'] instanceof ElggPad ) {
					return true;
				}
			}
		}
	}
}

/**
 * Extend container permissions checking to extend can_write_to_container for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function etherpad_container_permission_check($hook, $entity_type, $returnvalue, $params) {

	if (elgg_get_context() == "etherpad") {
		if( elgg_get_page_owner_guid() ){
			if( can_write_to_container(elgg_get_logged_in_user_guid(), elgg_get_page_owner_guid()) ) return true;
		}
		if( $page_guid = get_input('page_guid',0) ){
			$entity = get_entity($page_guid);
		} else if ($parent_guid = get_input('parent_guid',0)) {
			$entity = get_entity($parent_guid);
		}
		if ($entity instanceof ElggObject) {
			if( can_write_to_container(elgg_get_logged_in_user_guid(), $entity->container_guid) || in_array($entity->write_access_id, get_access_list()) ){
				return true;
			}
		}
	}

}
