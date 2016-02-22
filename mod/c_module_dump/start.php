<?php

elgg_register_event_handler('init', 'system', 'c_module_dump_init');


function c_module_dump_init() {
	elgg_unregister_page_handler('messages', 'messages_page_handler');
	elgg_register_page_handler('messages', 'messages_page_handler_2');
	$action_path = elgg_get_plugins_path() . 'c_module_dump/actions/';
	//elgg_register_action('messages/send', "$action_path/send.php");

	elgg_register_js('jquery-c_stats-min', 'mod/c_module_dump/vendors/jquery/jquery-1.7.1.min.js');
	elgg_register_js('jquery-c_stats', 'mod/c_module_dump/vendors/jquery/jquery-1.7.1.js');

	elgg_register_widget_type('group_ideas', elgg_echo('groups:ideas'), elgg_echo('widgets:group_ideas'), 'groups', false);

	register_notification_object('object','groupforumtopic',elgg_echo('there is a new discussion reply'));
	
	$plugin_list = elgg_get_plugins('active', 1);

	// this is the famous loop within a loop
	foreach ($plugin_list as $plugin_form)
	{
		$filepath = elgg_get_plugins_path().$plugin_form['title'].'/views/default/forms/'.$plugin_form['title'];
		if (file_exists($filepath))
		{
			$dir = scandir($filepath);
			//print_r($dir);
			foreach ($dir as $form_file)
			{
				//elgg_log('cyu - plugin:'.$plugin_form['title'], 'NOTICE');
				if ( (strstr($form_file,'edit') || strstr($form_file,'save') || strstr($form_file, 'upload')) && (!strstr($form_file, '.old'))) 
				{
					//elgg_log('cyu - form_file:'.$form_file, 'NOTICE');
					$remove_php = explode('.',$form_file);
					//elgg_log('cyu - << replacing ...:'.'forms/'.$plugin_form['title'].'/'.$remove_php[0].' >>' , 'NOTICE');
					elgg_extend_view('forms/'.$plugin_form['title'].'/'.$remove_php[0], 'forms/save2', 600);

					if ($plugin_form['title'] === 'polls')
					{
						elgg_extend_view('forms/'.$plugin_form['title'].'/'.$remove_php[0],'forms/save_poll',101);
					}
				}
			}
		}
	}

	// everything below are rebels
    // nick p -2016-02-18: changed priority to have friendly message at bottom of content
	elgg_extend_view('forms/photos/image/save', 'forms/save2', 900);
	elgg_extend_view('forms/photos/batch/edit', 'forms/save2', 900);
	//elgg_extend_view('forms/photos/batch/edit/image', 'forms/save2', 600);
	elgg_extend_view('forms/photos/album/save', 'forms/save2', 900);
	elgg_extend_view('forms/discussion/save', 'forms/save2', 900);
	elgg_extend_view('forms/file_tools/upload/multi', 'forms/save2', 900);
	elgg_extend_view('forms/file_tools/upload/zip', 'forms/save2', 900);

	// cyu - 02/12/2015: fixes to the group visibility
	$action_base = elgg_get_plugins_path().'c_module_dump/actions/groups';
	elgg_unregister_action("groups/edit");
	elgg_register_action("groups/edit","$action_base/edit.php");

	// cyu - 01-20-2015 modified: enhancement for the widget manager module, default URL will point to the users profile instead
	elgg_unregister_plugin_hook_handler('widget_url', 'widget_manager', "widget_manager_widgets_url");
	elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "c_widget_manager_widgets_url");

	// cyu - 02/10/2015: override the tasks_page_handler
	elgg_unregister_page_handler('tasks', 'tasks_page_handler');
	elgg_register_page_handler('tasks', 'c_tasks_page_handler');
}


/**
 * cyu - 02/10/2015: modified to work with displaying the tasks assigned to user
 */
function c_tasks_page_handler($task) {
	elgg_load_library('elgg:tasks');
	
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');

	if (!isset($task[0])) {
		$task[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('tasks'), 'tasks/all');

	$base_dir = elgg_get_plugins_path().'tasks/pages/tasks';
	$c_base_dir = elgg_get_plugins_path().'c_module_dump/pages/c_module_dump';

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
		case 'my_tasks':
			set_input('username', $task[1]);
			include "$c_base_dir/my_tasks.php";
			break;
		default:
			return false;
	}
	return true;
}


// cyu - 02/05/2015: override page handler for river
function c_elgg_river_page_handler($page) {
	global $CONFIG;

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	// make a URL segment available in page handler script
	$page_type = elgg_extract(0, $page, 'all');
	$page_type = preg_replace('[\W]', '', $page_type);

	// cyu - 02/05/2015: modified so that it redirects to the correct page
	if (is_numeric($page_type))
	{
		set_input('page_type', $page_type);
		require_once(elgg_get_plugins_path()."c_module_dump/pages/river.php");
		return true;
	}

	if ($page_type == 'owner') {
		$page_type = 'mine';
	}
	set_input('page_type', $page_type);

	// cyu - 02/24/2015: modified to let it point to the correct page, to remove avatar update and friending activity
	require_once(elgg_get_plugins_path()."c_module_dump/pages/river.php");
	//require_once("{$CONFIG->path}pages/river.php");
	return true;
}


	// cyu - 01-20-2015 modified: this is the same function from widget_manager, slighly modified though
	function c_widget_manager_widgets_url($hook_name, $entity_type, $return_value, $params){
		$result = $return_value;
		$widget = $params["entity"];
		
		if(empty($result) && ($widget instanceof ElggWidget)){
			$owner = $widget->getOwnerEntity();
			switch($widget->handler){
				case "friends":
					$result = "/friends/" . $owner->username;
					break;
				case "album_view":
					if($owner instanceof ElggGroup){
						$result = "/photos/group/" . $owner->getGUID() . "/all";
					} else {
						$result = "/photos/owner/" . $owner->username;
					}
					break;
				case "latest":
					$result = "/photos/owner/" . $owner->username;
					break;
				case "latest_photos":
					$result = "/photos/owner/" . $owner->username;
					break;
				case "messageboard":
					$result = "/messageboard/" . $owner->username;
					break;
				case "event_calendar":
					$result = "/event_calendar/list";
					break;
				case "izap_videos":
					$result = "/izap_videos/" . $owner->username;
					break;
				case "river_widget":

					// cyu - 02/05/2015: added new snippet
					$user = elgg_get_page_owner_entity();
					if ($user instanceof ElggUser)
						$result = "/activity/".$user->guid;
					else 
						$result = "/activity";
					
					break;
				case "bookmarks":
					if($owner instanceof ElggGroup){
						$result = "/bookmarks/group/" . $owner->getGUID() . "/all";
					} else {
						$result = "/bookmarks/owner/" . $owner->username;
					}
					break;
			}
		}
		return $result;
	}

function messages_page_handler_2($page) {

	$current_user = elgg_get_logged_in_user_entity();
	if (!$current_user) {
		register_error(elgg_echo('noaccess'));
		$_SESSION['last_forward_from'] = current_page_url();
		forward('');
	}

	elgg_load_library('elgg:messages');

	elgg_push_breadcrumb(elgg_echo('messages'), 'messages/inbox/' . $current_user->username);

	if (!isset($page[0])) {
		$page[0] = 'inbox';
	}

	// Support the old inbox url /messages/<username>, but only if it matches the logged in user.
	// Otherwise having a username like "read" on the system could confuse this function.
	if ($current_user->username === $page[0]) {
		$page[1] = $page[0];
		$page[0] = 'inbox';
	}

	if (!isset($page[1])) {
		$page[1] = $current_user->username;
	}

	$base_dir = elgg_get_plugins_path() . 'messages/pages/messages';
	$base_dir2 = elgg_get_plugins_path() . 'c_module_dump/pages/messages';
	switch ($page[0]) {
		case 'inbox':
			set_input('username', $page[1]);
			include("$base_dir2/inbox.php");
			break;
		case 'sent':
			set_input('username', $page[1]);
			include("$base_dir/sent.php");
			break;
		case 'read':
			set_input('guid', $page[1]);
			include("$base_dir/read.php");
			break;
		case 'compose':
		case 'add':
			include("$base_dir/send.php");
			break;
		default:
			return false;
	}
	return true;
}