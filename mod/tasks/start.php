<?php
/**
 * Elgg Tasks
 *
 * @package ElggTasks
 */

elgg_register_event_handler('init', 'system', 'tasks_init');

/**
 * Initialize the tasks plugin.
 *
 */
function tasks_init() {

	// register a library of helper functions
	elgg_register_library('elgg:tasks', elgg_get_plugins_path() . 'tasks/lib/tasks.php');

	
	elgg_register_menu_item('site', array(
		'name' => 'tasks',
		'text' => elgg_echo('tasks'),
		'href' => "tasks/all"
		
	));

	// Register a task handler, so we can have nice URLs
	elgg_register_page_handler('tasks', 'tasks_page_handler');
	elgg_register_page_handler('calendars', 'calendars_page_handler');

	// Register a url handler
	elgg_register_entity_url_handler('object', 'task_top', 'tasks_url');
	elgg_register_entity_url_handler('object', 'task', 'tasks_url');
	elgg_register_annotation_url_handler('task', 'tasks_revision_url');

	// Register some actions
	$action_base = elgg_get_plugins_path() . 'tasks/actions/tasks';
	elgg_register_action("tasks/edit", "$action_base/edit.php");
	elgg_register_action("tasks/editwelcome", "$action_base/editwelcome.php");
	elgg_register_action("tasks/delete", "$action_base/delete.php");

	// Extend the main css view
	elgg_extend_view('css/elgg', 'tasks/css');

	// Register javascript needed for sidebar menu
	$js_url = 'mod/tasks/vendors/jquery-treeview/jquery.treeview.min.js';
	elgg_register_js('jquery-treeview', $js_url);
	$css_url = 'mod/tasks/vendors/jquery-treeview/jquery.treeview.css';
	elgg_register_css('jquery-treeview', $css_url);

	// Register entity type for search
	elgg_register_entity_type('object', 'task');
	elgg_register_entity_type('object', 'task_top');

	// Register granular notification for this type
	register_notification_object('object', 'task', elgg_echo('tasks:new'));
	register_notification_object('object', 'task_top', elgg_echo('tasks:new'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'task_notify_message');

	// add to groups
	add_group_tool_option('tasks', elgg_echo('groups:enabletasks'), true);
	elgg_extend_view('groups/tool_latest', 'tasks/group_module');

	//add a widget
	elgg_register_widget_type('tasks', elgg_echo('tasks'), elgg_echo('tasks:widget:description'), 'dashboard,profile,index,groups');
	elgg_register_plugin_hook_handler("widget_url", "widget_manager", "tasks_widget_url_handler");

	
	$css_fullcalendar = 'mod/tasks/vendors/fullcalendar/fullcalendar.css';
	$css_fullcalendar_print ='mod/tasks/vendors/fullcalendar/fullcalendar.print.css';
	$js_fullcalendar_moment='mod/tasks/vendors/fullcalendar/lib/moment.min.js';
	$js_fullcalendar='mod/tasks/vendors/fullcalendar/fullcalendar.for.elgg.js';
	
	elgg_register_js('fullcalendar_moment.js', $js_fullcalendar_moment);
	elgg_register_js('fullcalendar.js', $js_fullcalendar);
	
	elgg_register_css('fullcalendar.css', $css_fullcalendar);
	elgg_register_css('fullcalendar.css.print', $css_fullcalendar_print);
	
	
	// Language short codes must be of the form "tasks:key"
	// where key is the array key below
	elgg_set_config('tasks', array(
		'title' => 'text',
		'description' => 'longtext',
		
		'start_date' => 'date',
		'end_date' => 'date',
		'task_type' => 'text',
		'status' => 'text',
		'assigned_to' => 'assign_to',
		'percent_done' => 'text',
		'work_remaining' => 'text',
		
		'tags' => 'tags',
		'access_id' => 'access',
		'write_access_id' => 'write_access'
	));

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'tasks_owner_block_menu');

	// write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'tasks_write_permission_check');
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'tasks_container_permission_check');

	// icon url override
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'tasks_icon_url_override');

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'tasks_entity_menu_setup');

	// register ecml views to parse
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'tasks_ecml_views_hook');
	
	// Access permissions
	//elgg_register_plugin_hook_handler('access:collections:write', 'all', 'tasks_write_acl_plugin_hook');
	//elgg_register_plugin_hook_handler('access:collections:read', 'all', 'tasks_read_acl_plugin_hook');

	
}

/**
 * Dispatcher for tasks.
 * URLs take the form of
 *  All tasks:        tasks/all
 *  User's tasks:     tasks/owner/<username>
 *  Friends' tasks:   tasks/friends/<username>
 *  View task:        tasks/view/<guid>/<title>
 *  New task:         tasks/add/<guid> (container: user, group, parent)
 *  Edit task:        tasks/edit/<guid>
 *  History of task:  tasks/history/<guid>
 *  Revision of task: tasks/revision/<id>
 *  Group tasks:      tasks/group/<guid>/all
 *
 * Title is ignored
 *
 * @param array $task
 * @return bool
 */
function tasks_page_handler($task) {

	elgg_load_library('elgg:tasks');
	
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');

	if (!isset($task[0])) {
		$task[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('tasks'), 'tasks/all');

	$base_dir = elgg_get_plugins_path() . 'tasks/pages/tasks';

	
	$task_type = $task[0];
	switch ($task_type) {
		case 'owner':
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $task[1]);
			include "$base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $task[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $task[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			include "$base_dir/owner.php";
			break;
		case 'history':
			set_input('guid', $task[1]);
			include "$base_dir/history.php";
			break;
		case 'revision':
			set_input('id', $task[1]);
			include "$base_dir/revision.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		case 'get-tasks':
			tasks_get_json(array(

				"owner"=>get_input('owner', elgg_get_logged_in_user_entity()->guid), 
				"filter"=>get_input('filter', 'all'),
				"start_date"=>get_input('start', date('Y-m-01')),
				"end_date"=>get_input('end',date('Y-m-t'))
			));
			break;
		default:
			return false;
	}
	return true;
}

function calendars_page_handler($task) {

	elgg_load_library('elgg:tasks');
	
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');

	if (!isset($task[0])) {
		$task[0] = 'all';
	}
	elgg_push_breadcrumb(elgg_echo('tasks'). " Calendar", 'tasks/all');
	$base_dir = elgg_get_plugins_path() . 'tasks/pages/calendar';


	$task_type = $task[0];
	switch ($task_type) {
		case 'group':
		case 'owner':
			include "$base_dir/owner.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		default:
			return false;
	}
	
	return true;
}

/**
 * Override the task url
 *
 * @param ElggObject $entity Page object
 * @return string
 */
function tasks_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "tasks/view/$entity->guid/$title";
}

/**
 * Override the task annotation url
 *
 * @param ElggAnnotation $annotation
 * @return string
 */
function tasks_revision_url($annotation) {
	return "tasks/revision/$annotation->id";
}

/**
 * Override the default entity icon for tasks
 *
 * @return string Relative URL
 */
function tasks_icon_url_override($hook, $type, $returnvalue, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'task_top') ||
		elgg_instanceof($entity, 'object', 'task')) {
		switch ($params['size']) {
			case 'small':
				return 'mod/tasks/images/tasks.gif';
				break;
			case 'medium':
				return 'mod/tasks/images/tasks_lrg.gif';
				break;
		}
	}
}

/**
 * Add a menu item to the user ownerblock
 */
function tasks_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "tasks/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('tasks', elgg_echo('tasks'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->tasks_enable != "no") {
			$url = "tasks/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('tasks', elgg_echo('tasks:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add links/info to entity menu particular to tasks plugin
 */
function tasks_entity_menu_setup($hook, $type, $return, $params) {

	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'tasks') {
		return $return;
	}

	// remove delete if not owner or admin
	if (!elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != $entity->getOwnerGuid()) {
		foreach ($return as $index => $item) {
			if ($item->getName() == 'delete') {
				unset($return[$index]);
			}
		}
	}

	$options = array(
		'name' => 'history',
		'text' => elgg_echo('tasks:history'),
		'href' => "tasks/history/$entity->guid",
		'priority' => 150,
	);
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
function task_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && (($entity->getSubtype() == 'task_top') || ($entity->getSubtype() == 'task'))) {
		$descr = $entity->description;
		$title = $entity->title;
		//@todo why?
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		$owner = $entity->getOwnerEntity();
		return $owner->name . ' ' . elgg_echo("tasks:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
	}
	return null;
}

/**
 * Extend permissions checking to extend can-edit for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
 /*
function tasks_write_permission_check($hook, $entity_type, $returnvalue, $params)
{
	
	if ($params['entity']->getSubtype() == 'task'
		|| $params['entity']->getSubtype() == 'task_top') {

		$write_permission = $params['entity']->write_access_id;
		$user = $params['user'];

		if (($write_permission) && ($user)) {
			// $list = get_write_access_array($user->guid);
			$list = get_access_array($user->guid); // get_access_list($user->guid);

			if (($write_permission!=0) && (in_array($write_permission,$list))) {
				return true;
			}
			
			
		}
	}
}*/
function tasks_write_permission_check($hook, $entity_type, $returnvalue, $params) {
	if (!tasks_is_task($params['entity'])) {
		return null;
	}
	$entity = $params['entity'];
	/* @var ElggObject $entity */

	$write_permission = $entity->write_access_id;
	$user = $params['user'];

	if ($write_permission && $user) {
		switch ($write_permission) {
			case ACCESS_PRIVATE:
				// Elgg's default decision is what we want
				return null;
				break;
			case ACCESS_FRIENDS:
				$owner = $entity->getOwnerEntity();
				if (($owner instanceof ElggUser) && $owner->isFriendsWith($user->guid)) {
					return true;
				}
				break;
			default:
				$list = get_access_array($user->guid);
				if (in_array($write_permission, $list)) {
					// user in the access collection
					return true;
				}
				break;
		}
	}
}


function tasks_is_task($value) {
	return ($value instanceof ElggObject) && in_array($value->getSubtype(), array('task', 'task_top'));
}

/**
 * Extend container permissions checking to extend can_write_to_container for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function tasks_container_permission_check($hook, $entity_type, $returnvalue, $params) {

	if (elgg_get_context() == "tasks") {
		if (elgg_get_page_owner_guid()) {
			if (can_write_to_container(elgg_get_logged_in_user_guid(), elgg_get_page_owner_guid())) return true;
		}
		if ($task_guid = get_input('task_guid',0)) {
			$entity = get_entity($task_guid);
		} else if ($parent_guid = get_input('parent_guid',0)) {
			$entity = get_entity($parent_guid);
		}
		if ($entity instanceof ElggObject) {
			if (
					can_write_to_container(elgg_get_logged_in_user_guid(), $entity->container_guid)
					|| in_array($entity->write_access_id,get_access_list())
				) {
					return true;
			}
		}
	}

}

/**
 * Return views to parse for tasks.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $return_value
 * @param unknown_type $params
 */
function tasks_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/task'] = elgg_echo('item:object:task');
	$return_value['object/task_top'] = elgg_echo('item:object:task_top');

	return $return_value;
}

/**
 * Return an URL to put on the widget title (for Widget Manager)
 *
 * @param string $hook
 * @param stirng $entity_type
 * @param string $return_value
 * @param array $params
 */
function tasks_widget_url_handler($hook, $entity_type, $return_value, $params) {
	$result = $return_value;
	
	if (!$result && !empty($params) && is_array($params)) {
		$widget = elgg_extract("entity", $params);
	
		if (!empty($widget) && elgg_instanceof($widget, "object", "widget")) {
			switch ($widget->handler) {
				case "tasks":
					$owner = $widget->getOwnerEntity();
					
					if (elgg_instanceof($owner, "site")) {
						$result = "tasks/all";
					} elseif (elgg_instanceof($owner, "user")) {
						$result = "tasks/owner/" . $owner->username;
					} elseif (elgg_instanceof($owner, "group")) {
						$result = "tasks/group/" . $owner->getGUID() . "/all";
					}
					
					break;
			}
		}
	}
	
	return $result;
}
