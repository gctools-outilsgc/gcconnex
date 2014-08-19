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
				//elgg_log('cyu - plugin:'.$plugin['title'], 'NOTICE');
				if ( (strstr($form_file,'edit') || strstr($form_file,'save') || strstr($form_file, 'upload')) && (!strstr($form_file, '.old'))) 
				{
					//elgg_log('cyu - form_file:'.$form_file, 'NOTICE');
					$remove_php = explode('.',$form_file);
					//elgg_log('cyu - << replacing ...:'.'forms/'.$plugin_form['title'].'/'.$remove_php[0].' >>' , 'NOTICE');
					elgg_extend_view('forms/'.$plugin_form['title'].'/'.$remove_php[0], 'forms/save2', 100);
				}
			}
		}
	}

	// everything below are rebels
	elgg_extend_view('forms/photos/image/save', 'forms/save2', 100);
	elgg_extend_view('forms/photos/batch/edit', 'forms/save2', 100);
	//elgg_extend_view('forms/photos/batch/edit/image', 'forms/save2', 600);
	elgg_extend_view('forms/photos/album/save', 'forms/save2', 100);
	elgg_extend_view('forms/discussion/save', 'forms/save2', 100);
	elgg_extend_view('forms/file_tools/upload/multi', 'forms/save2', 100);
	elgg_extend_view('forms/file_tools/upload/zip', 'forms/save2', 100);
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