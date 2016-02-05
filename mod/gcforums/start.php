<?php

/* GCForums
 * 
 * @author Christine Yu <internalfire5@live.com>
 * 
 */


elgg_register_event_handler('init','system','gcforums_init');

function gcforums_init() {
	$action_path = elgg_get_plugins_path().'gcforums/actions/gcforums';

	elgg_register_css('gcforums-css','mod/gcforums/css/gcforums-table.css');						// styling the forums table
	elgg_register_plugin_hook_handler('register','menu:owner_block','gcforums_owner_block_menu');	// register menu item in group
	elgg_register_page_handler('gcforums', 'gcforums_page_handler');								// page handler for forums
	add_group_tool_option('forums', elgg_echo('gcforums:enable_group_forums'), false);				// add option for user to enable

	// actions for forum creation/editing/deletion (.../action/gcforums/[action]/...)
	elgg_register_action('gcforums/edit',$action_path.'/edit.php');
	elgg_register_action('gcforums/delete',$action_path.'/delete.php');
	elgg_register_action('gcforums/create',$action_path.'/create.php');	
}

function gcforums_owner_block_menu($hook,$type,$return,$params) {
	$entity = elgg_extract('entity', $params);
	if ($entity->type === 'group' && $entity->forums_enable === 'yes') { // display only in group menu and only when user selected to enable forums in group
		$url = "gcforums/group/{$params['entity']->guid}";
		$item = new ElggMenuItem('gcforums',elgg_echo('gcforums:group_nav_label'),$url);
		$return[] = $item;
		return $return;
	}
}

/* 
 * Page Handler
 * 
 */
function gcforums_page_handler($page) {
	$vars = array();
//elgg_push_breadcrumb($crumbs_title, "blog/group/$container->guid/all");
	error_log(print_r($page,true));
	switch($page[0]) {
		case 'create':
			error_log('create');
			gatekeeper();	// group members and admins only

			$vars['subtype'] = $page[1];
			$vars['group_guid'] = $page[2];
			$vars['container_guid'] = $page[3]; // when we're not in the main page for the forums in the group
			$title = elgg_echo("gcforums:new_{$page[1]}");
			$content = elgg_view_form('gcforums/create', array(), $vars); // pass some variables to the form (2nd param is empty)
			$body = elgg_view_layout('content',array(
				'content' => $content,
				'title' => $title,
				'filter' => '',	// removes the owner, mine, friends tabs
				));
			echo elgg_view_page($title,$body);

			break;
		case 'edit':
			error_log('edit');
			gatekeeper();	// group members and admins only
		
			$vars['forum_guid'] = $page[1];
			$entity = get_entity($page[1]);
			$title = $entity->title;
			$content = elgg_view_form('gcforums/edit', array(),$vars);	
			$body = elgg_view_layout('content',array(
				'content' => $content,
				'title' => $entity->title,
				'filter' => '',					
				));
			echo elgg_view_page($entity->title,$body);

			break;
		case 'group':

			error_log('group');

			$vars['forum_guid'] = $page[2];
			$vars['topic'] = $page[3];
			$entity = get_entity($page[2]);
			$title = $entity->title;

			// if ($page[2])
			// 	elgg_push_breadcrumb($title,"gcforums/{$page[0]}/{$page[1]}/{$page[2]}");
			// else
			// 	elgg_push_breadcrumb("GCforums","gcforums/{$page[0]}/{$page[1]}");

			$content = elgg_view('gcforums/gcforums_content', $vars);
			$body = elgg_view_layout('content',array(
				'content' => $content,
				'title' => $title,
				'filter' => '',
				));
			echo elgg_view_page($title,$body);

			break;
		default:
			return false;
	}

	return true;
}


/*
 * TODO: Transferred to Lib Directory
 */

/* Display Topic and the corresponding comments
 * @params topic
 */
function gcforums_topic_content($topic_guid) {
//get_latest_hjforumtopic($topic_guid); // testing...


	elgg_load_css('gcforums-css');
	$dbprefix = elgg_get_config('dbprefix');

	$topic = get_entity($topic_guid);

	$user_information = get_user($topic->owner_guid);
	$topic_content = '';

	// get the topic information and display it
	//$topic_content .= "<h1 class='gcforums-title'>".$topic->title."</h1>";
	$topic_content .= "<table class='gcforums-table'>
						<tr class='gcforums-tr'>
							<th class='gcforums-th-topic' width='25%'> <strong>".$user_information->email."</strong> </th>
							<th class='gcforums-th-topic'> <strong>".elgg_echo('gcforums:posted_on',array( date('Y-m-d H:i:s', $topic->time_created) ))."</strong> </th>
							<th class='gcforums-th-topic-options'>".gcforums_category_edit_options($topic->guid)."</th>
						</tr>
						<tr class='gcforums-tr'>
							<td class='gcforums-td-topic'>".gcforums_display_user($user_information)."</td>
							<td colspan='2' class='gcforums-td-topic'>".$topic->description."</td>
						</tr>
						<tr class='gcforums-tr'>
							<td class='gcforums-td-topic'> </td>
							<td colspan='2' class='gcforums-td-topic'> </td>
						</tr>
					</table>";


	// get the comments for this topic
	$comments = elgg_get_entities(array(
		'types' => 'object',
		'container_guids' => $topic->guid,
	));

	$topic_content .= "<br/><br/>"; // TODO: style this
	$topic_content .= "<table class='gcforums-table'>";


	if (!$comments && elgg_is_logged_in()) {
		$topic_content .= "<tr class='gcforums-tr'>
								<th colspan='5' class='gcforums-td-category'>".elgg_echo('gcforums:not_available')."</th>
							</tr>";
	} else {

		foreach ($comments as $comment) {
			$user_information = get_user($comment->owner_guid);
			$topic_content .= "	<tr class='gcforums-tr'>
								<th class='gcforums-td-topic' width='25%'>".elgg_view_entity_icon($user_information, 'small')."<br/>{$user_information->email} <br/>".date("Y-m-d H:m:s",$comment->time_created)."</td>
								<th colspan='2' class='gcforums-td-topic'>"."Edit | Delete <br/>{$comment->description}</td>
							</tr> ";
		}
	}

	$topic_content .= "</table>";
	$topic_content .= "<br/><br/><br/>";

	$vars['topic_guid'] = $topic_guid;
	$vars['topic_access'] = $topic->access_id;
	$vars['subtype'] = 'hjforumpost';
	$topic_content .= elgg_view_form('gcforums/create', array(), $vars);	// get the longtext input from form

	return $topic_content;
}

function get_total_posts() {
	$query = "SELECT
			FROM
			WHERE";
}

/* 
 * Topic & Comment - Display user card
 */
function gcforums_display_user($user_information) {
	$user_table = '';
	$user_table .= "<table class='gcf-user-table'>
				<tr class='gcf-user-tr'>
					<td class='gcf-user-td'>
						".elgg_view_entity_icon($user_information, 'medium')."
					</td>
				</tr>
				<tr class='gcf-user-tr'>
					<td class='gcf-user-td'>
						$user_information->name
					</td>
				</tr>
				<tr class='gcf-user-tr'>
					<td class='gcf-user-td'>
						$user_information->location
					</td>
				</tr>
				<tr class='gcf-user-tr'>
					<td class='gcf-user-td'>
						$user_information->department
					</td>
				</tr>
				</table>";

	return $user_table;
}



/* Display a list of topics within a forum
 */
function gcforums_topics_list($forum_guid, $is_sticky) {
	$forum_topic = '';
	$forum_entity = get_entity($forum_guid);

	if (!$forum_entity->enable_posting) {	// check if posting is enabled
		elgg_load_css('gcforums-css');
		
		$dbprefix = elgg_get_config('dbprefix');		

		$options = array(
				'relationship' => 'descendant',
				'subtypes' => array('hjforumtopic'),
				'relationship_guid' => $forum_guid,
				'inverse_relationship' => true,
				'types' => 'object',
			);
		$topics = elgg_get_entities_from_relationship($options);

		if ($is_sticky)
			$sticky_topic_title = elgg_echo('gcforums:sticky_topic');
		else
			$sticky_topic_title = elgg_echo('gcforums:topics');

		$forum_topic .= "<table class='gcforums-table'>
						<tr class='gcforums-tr'>
							<th class='gcforums-th' width='60%'>{$sticky_topic_title}</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:topic_starter')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:replies')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:last_posted')."</th>
						</tr>";

		if (!$topics) { 
			$forum_topic .= "<tr class='gcforums-tr'>
							<th colspan='5' class='gcforums-td-forums'>"."<i>Currently No Topics Available</i>"."</th>
						</tr>";
		} else {

			foreach ($topics as $topic) {

				if ($topic->sticky == $is_sticky) {
					// get number of replies
					$query = "SELECT e.guid, ue.username, e.time_created
					FROM {$dbprefix}entities e, {$dbprefix}users_entity ue
					WHERE e.container_guid = {$topic->guid} AND e.owner_guid = ue.guid;";
					$replies = get_data($query);

					$user = get_user($topic->owner_guid);
					$num_replies = count($replies);	// get number of replies of topic

					$time_posted = $replies[$num_replies-1]->time_created;
					if ($time_posted == '')
						$time_posted = '';
					else
						$time_posted = date('Y-m-d H:i:s',$time_posted);

					$last_post_info = "{$replies[$num_replies-1]->username} / {$time_posted}";
					if ($last_post_info === ' / ') 
						$last_post_info = elgg_echo('gcforums:no_posts');

					$url = "<strong><a href='".elgg_get_site_url()."gcforums/group/151/{$topic->guid}/hjforumtopic'>{$topic->title}</a></strong>";
					$forum_topic .=	"<tr class='gcforums-tr'>
										<td class='gcforums-td-topics'>{$url}</td>
										<td class='gcforums-td'>{$user->username}</td>
										<td class='gcforums-td'>{$num_replies}</td>
										<td class='gcforums-td'>{$last_post_info}</td>
									</tr>";
				}
			}
		}
		$forum_topic .= "</table>";
	}

	return $forum_topic;
}


/* Categoried Forums
 */
function gcforums_category_content($guid, $forums=false) {

	elgg_load_css('gcforums-css');
	$categories = elgg_get_entities(array(
		'types' => 'object',
		'subtypes' => 'hjforumcategory',
		'limit' => false,	// don't put a limit on it
		'container_guid' => $guid
	));

	$group = get_entity($guid);

	if (elgg_is_logged_in()) 
		$edit_option_string = elgg_echo('gcforums:edit');
	else 
		$edit_option_string = ' - ';

	$forum_category = '';
	$forum_category .= "<table class='gcforums-table'>
						<tr class='gcforums-tr'>
							<th class='gcforums-th' width='60%'>".elgg_echo('gcforums:forum_title')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:topics')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:posts')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:latest')."</th>
							<th class='gcforums-th'>{$edit_option_string}</th>
						</tr>";

	if (!$categories) { // check if there are forums filed under category
		$forum_category .= "<tr class='gcforums-tr'>
								<th colspan='5' class='gcforums-td-category'>"."<i>Currently No Categories Available</i>"."</th>
							</tr>";
	} else {
		// display the category title and description
		foreach ($categories as $category) {
			$forum_category .= "<tr class='gcforums-tr'>
							<th class='gcforums-th-category'><strong> {$category->title} </strong> {$category->description} </th>
							<th colspan='4' class='gcforums-th-category-options'>".gcforums_category_edit_options($category->guid)."</th>
						</tr>";

			$forums = elgg_get_entities_from_relationship(array(
				'relationship' => 'filed_in',
				'relationship_guid' => $category->guid,
				'container_guid' => $group->guid,
				'inverse_relationship' => true,
			));

			if (!$forums) {
				$forum_category .= "<tr class='gcforums-tr'>
						<th colspan='5' class='gcforums-td-forums'>"."<i>Currently No Forums Available</i>"."</th>
					</tr>";
			} else {
				// display the forum in the category
				foreach ($forums as $forum) {
					$url = "<strong><a href='".elgg_get_site_url()."gcforums/group/151/{$forum->guid}'>{$forum->title}</a></strong>";

					$forum_category .= "<tr class='gcforums-tr'>
						<th class='gcforums-td-forums'>{$url}{$forum->description}</th>
						<th class='gcforums-td'>"."something.."."</th>
						<th class='gcforums-td'>".elgg_echo('gcforums:posts')."</th>
						<th class='gcforums-td'>".elgg_echo('gcforums:latest_posts')."</th>
						<th class='gcforums-td-forums-options'>".gcforums_forums_edit_options($forum->guid)."</th>
					</tr>";
				}
			}
		}
	}
	$forum_category .= "</table>";

	return $forum_category;
}




/* Create list of options to modify forums
 */
function gcforums_forums_edit_options($object_guid,$group_guid) {

	if (elgg_is_logged_in() && ( elgg_get_logged_in_user_entity()->isAdmin() || get_entity($group_guid)->getOwnerGUID() == elgg_get_logged_in_user_guid())) {
	
		$object_menu_items = array("New subforum", "New Posting", "Edit");

		$entity = get_entity($object_guid);
		
		// options given to users: New subforum / New Posting (if enabled) / Edit current / Delete current
		$edit_options = "<strong>".get_readable_access_level($entity->access_id)."</strong> <br/>";
		foreach ($object_menu_items as $menu_item) {
			if ($menu_item === 'New Posting' && $entity->enable_posting) { // check if new posting link and it is disabled (enabled == disabled)

			} else {
				$url = elgg_get_site_url()."gcforums/edit/{$object_guid}";
				$edit_options .= "<a href='{$url}'>{$menu_item}</a><br/>";
			}
		}
		elgg_view('output/url', array('is_action' => TRUE));
		elgg_view('input/securitytoken');
		$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$object_guid}");
		$edit_options .= "<a href='{$url}'>Delete</a>";

		return $edit_options;
	}
	return "";
}


/* Create list of options to modify categories
 */
function gcforums_category_edit_options($object_guid) {

	if (elgg_is_logged_in() && ( elgg_get_logged_in_user_entity()->isAdmin() || get_entity($group_guid)->getOwnerGUID() == elgg_get_logged_in_user_guid())) {
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT access_id
				FROM {$dbprefix}entities
				WHERE guid = {$object_guid};";
		$object_access = get_data_row($query);


		$edit_options = "<strong>".get_readable_access_level($object_access->access_id)."</strong> ";
		$url = elgg_get_site_url()."gcforums/edit/{$object_guid}";
		$edit_options .= "<a href='{$url}'>Edit</a> ";
		elgg_view('output/url', array('is_action' => TRUE));
		elgg_view('input/securitytoken');
		$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$object_guid}");
		$edit_options .= "<a href='{$url}'>Delete</a>";

		return $edit_options;
	}
	return "";
}

/* Uncategoried Forums
 */
function gcforums_forum_list($forum_guid, $group_guid) {
	elgg_load_css('gcforums-css');
	
	$forum_list = '';
	$dbprefix = elgg_get_config('dbprefix');

	$prev_guid = 0;

	$options = array(
			'relationship' => 'descendant',
			'subtypes' => array('hjforum'),
			'relationship_guid' => $forum_guid,
			'inverse_relationship' => true,
			'types' => 'object',
		);
	$forums = elgg_get_entities_from_relationship($options);

	$forum_list .= "<table class='gcforums-table'>
						<tr class='gcforums-tr'>
							<th class='gcforums-th' width='60%'>".elgg_echo('gcforums:forum_title')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:topics')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:posts')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:latest_posts')."</th>
							<th class='gcforums-th'>".elgg_echo('gcforums:edit')."</th>
						</tr>";

	if (!$forums) {
		$forum_list .= "<tr class='gcforums-tr'>
						<th colspan='5' class='gcforums-td-forums'>"."<i>Currently No Forums Available</i>"."</th>
					</tr>";
	} else {
		foreach ($forums as $forum) {
				if ($forum->title && !check_entity_relationship($forum->guid, 'descendant', $prev_guid)) {
					$url = "<strong><a href='".elgg_get_site_url()."gcforums/group/151/{$forum->guid}'>{$forum->title}</a></strong>";

					$forum_list .="	<tr class='gcforums-tr'>
								<td class='gcforums-td-forums'>{$url} {$forum->description}</td>
								<td class='gcforums-td'>".elgg_echo('gcforums:total_topics')."</td>
								<td class='gcforums-td'>".elgg_echo('gcforums:total_posts')."</td>
								<td class='gcforums-td'>".elgg_echo('gcforums:latest_posts')."</td>
								<th class='gcforums-td-forums-options'>".gcforums_forums_edit_options($forum->guid,$group_guid)."</td>
							</tr> ";
				}
			$prev_guid = $forum->guid;
		}
	}

	$forum_list .="</table>";
	return $forum_list;
}


function gcforums_menu_buttons($forum_guid,$group_guid, $is_topic=false) { // main page if forum_guid is not present
	// user must be logged in AND (either an admin or group owner/admin/operator)
	if (elgg_is_logged_in() && ( elgg_get_logged_in_user_entity()->isAdmin() || get_entity($group_guid)->getOwnerGUID() == elgg_get_logged_in_user_guid())) {

		elgg_load_css('gcforums-css');
		if (!$forum_guid) $forum_guid = 0;
		$forum_object = get_entity($forum_guid);

		//if ($forum_object && $forum_object->getSubtype() !== "hjforumtopic") { // if object is a hjforumtopic, then do not display menu
		if (!$is_topic) {
			// new category
			if ($forum_object->enable_subcategories || !$forum_guid) // check if subcategories is enabled or this is the main forum page in group
				$new_category_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforumcategory'), "href" => "gcforums/create/hjforumcategory/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action'));
			// new topic
			if (!$forum_object->enable_posting && $forum_guid) // check if postings is enabled and this is not the main first page of forum in group
				$new_forum_topic_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforumtopic'), "href" => "gcforums/create/hjforumtopic/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action'));
			// new current forum
			$new_forum_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforum'), "href" => "gcforums/create/hjforum/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action'));
			
			if ($forum_guid != 0) {
				// edit current forum
				$edit_forum_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:edit_hjforum'), "href" => "gcforums/edit/{$forum_guid}", 'class' => 'elgg-button elgg-button-action'));
				
				// delete current forum
				elgg_view('output/url', array('is_action' => TRUE));
				elgg_view('input/securitytoken');
				$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$forum_guid}");
				$delete_forum_button = elgg_view('output/url', array("text" => "Delete Forum", "href" => $url, 'class' => 'elgg-button elgg-button-action'));
				
				$separator = " | ";
			}
		}	
		return "<div class='gcforums-menu'>{$new_category_button} {$new_forum_button} {$new_forum_topic_button} {$separator} {$edit_forum_button} {$delete_forum_button}</div> <br/><br/>";
	}

	return "";
}