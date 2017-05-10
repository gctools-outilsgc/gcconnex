<?php

/* GCForums
 * 
 * @author Christine Yu <internalfire5@live.com>
 * 
 */

elgg_register_event_handler('init','system','gcforums_init');

function gcforums_init() {
	elgg_register_library('elgg:gcforums:functions', elgg_get_plugins_path() . 'gcforums/lib/functions.php');

	$action_path = elgg_get_plugins_path().'gcforums/actions/gcforums';

	elgg_register_css('gcforums-css','mod/gcforums/css/gcforums-table.css');						// styling the forums table
	elgg_register_plugin_hook_handler('register','menu:owner_block','gcforums_owner_block_menu');	// register menu item in group
	elgg_register_page_handler('gcforums', 'gcforums_page_handler');								// page handler for forums
	add_group_tool_option('forums', elgg_echo('gcforums:enable_group_forums'), false);				// add option for user to enable

	// actions for forum creation/editing/deletion (.../action/gcforums/[action]/...)
	elgg_register_action('gcforums/edit',$action_path.'/edit.php');
	elgg_register_action('gcforums/delete',$action_path.'/delete.php');
	elgg_register_action('gcforums/create',$action_path.'/create.php');
	elgg_register_action('gcforums/subscribe',$action_path.'/subscribe.php');

	// put a menu item in the site navigation (JMP request), placed in career dropdown
	elgg_register_menu_item('subSite', array(
		'name' => 'Forum',
		'text' => elgg_echo('gcforums:jmp_menu'),
		'href' => elgg_echo('gcforums:jmp_url'),
	));
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


/* Page Handler
 */
function gcforums_page_handler($page) {
	$vars = array();

	//elgg_push_breadcrumb('GCforums', "gcforums/group/151");
	//elgg_push_breadcrumb($crumbs_title, "blog/group/$container->guid/all");

	switch($page[0]) {
		case 'create':
			gatekeeper();	// group members and admins only
			$vars['subtype'] = $page[1];
			$vars['group_guid'] = $page[2];
			$vars['container_guid'] = $page[3]; // when we're not in the main page for the forums in the group
			$title = elgg_echo("gcforums:new_{$page[1]}");
			$content = elgg_view_form('gcforums/create', array(), $vars); // pass some variables to the form (2nd param is empty)
			$body = elgg_view_layout('forum-full',array(
				'content' => $content,
				'title' => $title,
				'filter' => '',	// removes the owner, mine, friends tabs
				));
			echo elgg_view_page($title,$body);

			break;
		case 'edit':
			gatekeeper();	// group members and admins only
			$vars['forum_guid'] = $page[1];
			$entity = get_entity($page[1]);
			$title = $entity->title;
			$content = elgg_view_form('gcforums/edit', array(),$vars);	
			$body = elgg_view_layout('forum-full',array(
				'content' => $content,
				'title' => $entity->title,
				'filter' => '',					
				));
			echo elgg_view_page($entity->title,$body);

			break;
		case 'group':
			$vars['forum_guid'] = $page[2];
			$vars['topic'] = $page[3];
			$entity = get_entity($page[2]);
			$title = $entity->title;

			$content = elgg_view('gcforums/gcforums_content', $vars);
			$body = elgg_view_layout('forum-full',array(
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


/* Display Topic and the corresponding comments
 * @params topic
 */
function gcforums_topic_content($topic_guid, $group_guid) {
	elgg_load_css('gcforums-css');
	$dbprefix = elgg_get_config('dbprefix');

	$topic = get_entity($topic_guid);

	$user_information = get_user($topic->owner_guid);
	$topic_content = '';

	$user = elgg_get_logged_in_user_entity();
	
	// cyu - using different notification system (if applicable)
	if (elgg_is_active_plugin('cp_notifications')) {
		if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $topic->guid) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $topic->guid))
			$subscribe_text = elgg_echo('gcforums:unsubscribe');
		else
			$subscribe_text = elgg_echo('gcforums:subscribe');;
	} else {
		if (check_entity_relationship($user->guid, 'subscribed', $topic->guid))
			$subscribe_text = elgg_echo(elgg_echo('gcforums:unsubscribe'));
		else
			$subscribe_text = elgg_echo(elgg_echo('gcforums:subscribe'));
	}

	elgg_view('output/url', array('is_action' => TRUE));
	elgg_view('input/securitytoken');
	$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/subscribe?guid={$topic->guid}");
	$subscribe_url = "<a href='{$url}'>{$subscribe_text}</a><br/>";

	// cyu - patched TFS #unknown (moderator unable to delete a topic)
	// get the topic information and display it
	$topic_content .= "<table class='gcforums-table'>
						<tr class='gcforums-tr'>
							<th class='gcforums-th-topic' width='25%'> <strong>".$user_information->email."</strong> </th>
							<th class='gcforums-th-topic'> <strong>".elgg_echo('gcforums:posted_on',array( date('Y-m-d H:i:s', $topic->time_created) ))."</strong> </th>
							<th class='gcforums-th-topic-options'>".gcforums_category_edit_options($topic->guid,$group_guid)."  {$subscribe_url}"."</th> 
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
		'limit' => 0,
	));

	$topic_content .= "<br/><br/>"; // TODO: style this
	$topic_content .= "<table class='gcforums-table'>";


	if (!$comments && elgg_is_logged_in()) {
		$topic_content .= "<tr class='gcforums-tr'>
								<th colspan='5' class='gcforums-td-category'>".elgg_echo('gcforums:no_comments')."</th>
							</tr>";
	} else {

		foreach ($comments as $comment) {
			$user_information = get_user($comment->owner_guid);

			elgg_view('output/url', array('is_action' => TRUE));
			elgg_view('input/securitytoken');
			$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$comment->guid}");
			$url_edit = elgg_get_site_url()."gcforums/edit/{$comment->guid}";

			$comment_menu_content = "<table class='gcforums-comment-table'>
									<tr class='gcforums-comment-tr'>
										<th class='gcforums-comments-menu'>
											<a href='{$url_edit}'>Edit</a>
											<a href='{$url}'>Delete</a>
										</th>
									</tr>
									<tr class='gcforums-tr'>
										<td class='gcforums-comment-td'>
											{$comment->description}
										</td>
									</tr>
								</table>";

			$topic_content .= "	<tr class='gcforums-tr'>
								<th class='gcforums-td-topic' width='25%'>".elgg_view_entity_icon($user_information, 'small')."<br/>{$user_information->email} <br/>".date("Y-m-d H:m:s",$comment->time_created)."</td>
								<th colspan='2' class='gcforums-td-topic'>".$comment_menu_content."</th>
							</tr> ";

			$topic_content .= "";
		}
	}

	$topic_content .= "</table>";
	$topic_content .= "<br/><br/><br/>";

	$vars['group_guid'] = $group_guid;
	$vars['topic_guid'] = $topic_guid;
	$vars['topic_access'] = $topic->access_id;
	$vars['subtype'] = 'hjforumpost';
	$topic_content .= elgg_view_form('gcforums/create', array(), $vars);	// get the longtext input from form

	return $topic_content;
}

function get_total_posts($container_guid) {
	$dbprefix = elgg_get_config('dbprefix');
	
	$query = "SELECT r.guid_one, r.relationship, r.guid_two, e.subtype, es.subtype
			FROM {$dbprefix}entity_relationships r, {$dbprefix}entities e, {$dbprefix}entity_subtypes es
			WHERE r.guid_one = e.guid AND e.subtype = es.id AND r.guid_two = {$container_guid} AND es.subtype = 'hjforumpost'";
	$num_post = 0;
	$posts = get_data($query);

	foreach ($posts as $post)
		$num_post++;

	return $num_post;
}

function get_total_topics($container_guid) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT r.guid_one, r.relationship, r.guid_two, e.subtype, es.subtype
			FROM {$dbprefix}entity_relationships r, {$dbprefix}entities e, {$dbprefix}entity_subtypes es
			WHERE r.guid_one = e.guid AND e.subtype = es.id AND r.guid_two = {$container_guid} AND es.subtype = 'hjforumtopic'";
	$num_topic = 0;
	$topics = get_data($query);

	foreach ($topics as $topic)
		$num_topic++;

	return $num_topic;
}

function get_recent_post($container_guid) {//also grabbed display name - Nick
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT r.guid_one, r.relationship, r.guid_two, e.subtype, es.subtype, max(e.time_created) AS time_created, ue.email, ue.username, ue.name
			FROM {$dbprefix}entity_relationships r, {$dbprefix}entities e, {$dbprefix}entity_subtypes es, {$dbprefix}users_entity ue
			WHERE r.guid_one = e.guid AND e.subtype = es.id AND r.guid_two = {$container_guid} AND es.subtype = 'hjforumtopic' AND ue.guid = e.owner_guid";
	$post = get_data($query);

	$recent_poster = elgg_echo("gcforums:no_posts");
	if ($post[0]->email) {
		$timestamp = date('Y-m-d',$post[0]->time_created);
		$recent_poster = "{$post[0]->name} ". elgg_echo('gcforums:time')." {$timestamp}"; //Output display name - nick
	}
	return $recent_poster;
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
function gcforums_topics_list($forum_guid, $group_guid, $is_sticky) {
	$forum_topic = '';
	$forum_entity = get_entity($forum_guid);

	if (!$forum_entity->enable_posting) {	// check if posting is enabled
		elgg_load_css('gcforums-css');
		
		$dbprefix = elgg_get_config('dbprefix');		

		if ($is_sticky) {
			$options = array(
					'relationship' => 'descendant',
					'subtypes' => array('hjforumtopic'),
					'relationship_guid' => $forum_guid,
					'inverse_relationship' => true,
					'types' => array('object'),
					'metadata_names' => array('sticky'),
					'metadata_values' => array(1),
					'limit' => 0,
				);
		} else { // empty metadata value (if not sticky)
			$options = array(
				'relationship' => 'descendant',
				'subtypes' => array('hjforumtopic'),
				'relationship_guid' => $forum_guid,
				'inverse_relationship' => true,
				'types' => array('object'),
				//'metadata_names' => array('sticky'),
				//'metadata_values' => array(''),
				//'metadata_values' => null,
				//'metadata_values' => array(0),
				'limit' => 0,
				);
		}

		//error_log(var_dump($topics));
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
							<th class='gcforums-th'>".'Options'."</th>
						</tr>";

		if (!$topics) { 
			$forum_topic .= "<tr class='gcforums-tr'>
							<th colspan='5' class='gcforums-td-forums'>".elgg_echo('gcforums:topics_not_available')."</th>
						</tr>";
		} else {

			// go through each topic
			foreach ($topics as $topic) {


$query = "
SELECT MAX(guid_two) AS max_forum_guid 
FROM elggentity_relationships 
WHERE relationship = 'descendant' AND guid_one = {$topic->getGUID()}
";
$relationship = get_data($query);

// correction to how the topics are displayed
if ($relationship[0]->max_forum_guid != $forum_guid)
	continue;

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

					//$user = elgg_get_logged_in_user_entity();
					
					// cyu - using different notification system (if applicable)
					if (elgg_is_active_plugin('cp_notifications')) {
						if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $topic->guid) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $topic->guid))
							$subscribe_text = elgg_echo('gcforums:unsubscribe');
						else
							$subscribe_text = elgg_echo('gcforums:subscribe');;
					} else {
						if (check_entity_relationship($user->guid, 'subscribed', $topic->guid))
							$subscribe_text = elgg_echo('gcforums:unsubscribe');
						else
							$subscribe_text = elgg_echo('gcforums:subscribe');
					}

					elgg_view('output/url', array('is_action' => TRUE));
					elgg_view('input/securitytoken');
					$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/subscribe?guid={$topic->guid}");
					$subscribe_url = "<a href='{$url}'>{$subscribe_text}</a><br/>";

					$url = "<strong><a href='".elgg_get_site_url()."gcforums/group/{$group_guid}/{$topic->guid}/hjforumtopic'>{$topic->title}</a></strong>";
					$forum_topic .=	"<tr class='gcforums-tr'>
										<td class='gcforums-td-topics'>{$url}</td>
										<td class='gcforums-td'>{$user->name} ".elgg_echo('gcforums:time')." ".elgg_view_friendly_time($topic->time_created)." </td>
										<td class='gcforums-td'>{$num_replies}</td>
										<td class='gcforums-td'>{$last_post_info}</td>
										<td class='gcforums-td-forums-options'>{$subscribe_url}</td>
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
function gcforums_category_content($guid, $group_guid, $forums=false) {
	elgg_load_css('gcforums-css');

	// * get all the categories
	$categories = elgg_get_entities(array(
		'types' => 'object',
		'subtypes' => 'hjforumcategory',
		'limit' => false,	// don't put a limit on it
		'container_guid' => $guid
	));
	$group = get_entity($guid);

	// * only show the edit options on the right side of table for group admins/operators/etc
	if (elgg_is_logged_in()) 
		$edit_option_string = elgg_echo('gcforums:edit');
	else 
		$edit_option_string = ' - ';


    $t_forum_category = ''; // testing

    // * forum header stuff
    $t_forum_category .= "<table class='gcforums-table'>
    					<tr class='gcforums-tr'>
    						<th class='gcforums-th' width='60%'>".elgg_echo('gcforums:forum_title')."</th>
    						<th class='gcforums-th'>".elgg_echo('gcforums:topics')."</th>
    						<th class='gcforums-th'>".elgg_echo('gcforums:posts')."</th>
    						<th class='gcforums-th'>".elgg_echo('gcforums:latest')."</th>
    						<th class='gcforums-th'> - </th>
    					</tr>";

    // * if there are no categories available, display a message about no categories available
	if (!$categories) { 
		$t_forum_category .= "<tr class='gcforums-tr'>
								<th colspan='5' class='gcforums-td-category'>".elgg_echo('gcforums:categories_not_available')."</th>
							</tr>";

	} else {


		// display the category title and description
		foreach ($categories as $category) { // putting this in a div outside of the table - nick

			// * display each category title and description
			$t_forum_category .= "<tr class='category-space'>

									<td colspan='5' class='gcforums-th-category'><h1>{$category->title}</h1><span class='forum-category-desc'>{$category->description}</span</td></tr>

									<th colspan='5' class='gcforums-th-category-options'>".gcforums_category_edit_options($category->guid)."</th>";
            
            // put category in
			// * for each category, lets display the forums filed under them
			$forums = elgg_get_entities_from_relationship(array(
				'relationship' => 'filed_in',
				'relationship_guid' => $category->guid,
				'container_guid' => $group->guid,
				'inverse_relationship' => true,
				'limit' => false,
			));

			// * if no forums are created, display a message that there are no forums
			if (!$forums) {//table
				$t_forum_category .= "<tr class='gcforums-tr'>
						<th colspan='5' class='gcforums-td-forums'>".elgg_echo('gcforums:forums_not_available')."</th>
					</tr>";
			} else {

				// display the forum in the category
				foreach ($forums as $forum) {
					$url = "<strong><a href='".elgg_get_site_url()."gcforums/group/{$group_guid}/{$forum->guid}'>{$forum->title}</a></strong>";

					$t_forum_category .= "
									<tr class='gcforums-tr'>
										<th class='gcforums-td-forums'>{$url}{$forum->description}</th>
										<th class='gcforums-td'>".get_total_topics($forum->guid)."</th>
										<th class='gcforums-td'>".get_total_posts($forum->guid)."</th>
										<th class='gcforums-td'>".get_recent_post($forum->guid)."</th>
										<th class='gcforums-td'>".gcforums_forums_edit_options($forum->guid, $group_guid)."</th>
									</tr>";
				}
			}
		}
	}

	$t_forum_category .= "</table>";
    //putting the table together with the category out of the table - nick
	return $t_forum_category;
}




/* Create list of options to modify forums
 */
function gcforums_forums_edit_options($object_guid,$group_guid) {
	$edit_options = '';
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

		// delete link
		elgg_view('output/url', array('is_action' => TRUE));
		elgg_view('input/securitytoken');
		$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$object_guid}");
		$edit_options .= "<a href='{$url}'>Delete</a><br/>";
	}

	// subscription functionality... users will get notified if any action occurs		
	$user = elgg_get_logged_in_user_entity();

		// cyu - using different notification system (if applicable)
	if (elgg_is_active_plugin('cp_notifications')) {
		if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $object_guid) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $object_guid))
			$subscribe_text = elgg_echo('gcforums:unsubscribe');
		else
			$subscribe_text = elgg_echo('gcforums:subscribe');

	} else {
		
		if (check_entity_relationship($user->guid, 'subscribed', $object_guid))
			$subscribe_text = elgg_echo('gcforums:unsubscribe');
		else
			$subscribe_text = elgg_echo('gcforums:subscribe');
	}

	elgg_view('output/url', array('is_action' => TRUE));
	elgg_view('input/securitytoken');
	$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/subscribe?guid={$object_guid}");
	$edit_options .= "<a href='{$url}'>{$subscribe_text}</a><br/>";
	
	return $edit_options;

}


/* Create list of options to modify categories
 */
function gcforums_category_edit_options($object_guid, $group_guid='') {
	// cyu - patched TFS #unknown (moderators unable to delete posting) 
	if (elgg_is_logged_in()) {
		if ($group_guid > 0)
			$is_operator = check_entity_relationship(elgg_get_logged_in_user_guid(),'operator',$group_guid);			
	
		$is_topic_access = false;
		if ($group_guid != '' || $group_guid > 0) {
			if (get_entity($group_guid)->getOwnerGUID() == elgg_get_logged_in_user_guid()) {
				$is_topic_access = true;
			}
		}

		if (elgg_get_logged_in_user_entity()->isAdmin() || $is_topic_access || !empty($is_operator) || get_entity($object_guid)->getOwnerGUID() == elgg_get_logged_in_user_guid()) {
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
			'limit' => 0,
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

	// cyu 03/20/2016: save array of forums...
	$list_of_forum_guid = array();
	foreach ($forums as $forum) {
		$list_of_forum_guid[] = $forum->guid;
	}
	
	if (!$forums) {
		$forum_list .= "<tr class='gcforums-tr'>
						<th colspan='5' class='gcforums-td-forums'>".elgg_echo('gcforums:forums_not_available')."</th>
					</tr>";
	} else {
		foreach ($forums as $forum) {

			// cyu - 03/20/2016: check if forums have another forum within
			// check if [forum 1] last descendant of [forum 2] first
			$display_forum = true;
			foreach ($list_of_forum_guid as $forums_val) {
				if ($has_it = check_entity_relationship($forum->guid,'descendant',$forums_val)) {
					//error_log("cyu - forum value: {$forums_val} descended from {$forum->guid} / YES");
					$display_forum = false;
					//break;
				}
				//error_log("cyu - forum value: {$forums_val} descended from {$forum->guid} / NO ");
			}

			if ($display_forum && $forum->title && !check_entity_relationship($forum->guid, 'descendant', $prev_guid)) {
					$url = "<strong><a href='".elgg_get_site_url()."gcforums/group/{$group_guid}/{$forum->guid}'>{$forum->title}</a></strong>";

					$forum_list .="	<tr class='gcforums-tr'>
								<td class='gcforums-td-forums'>{$url} {$forum->description}</td>
								<td class='gcforums-td'>".get_total_topics($forum->guid)."</td>
								<td class='gcforums-td'>".get_total_posts($forum->guid)."</td>
								<td class='gcforums-td'>".get_recent_post($forum->guid)."</td>
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

	elgg_load_css('gcforums-css');
	if (strcmp((string)"/gcforums/group/{$group_guid}",(string)$_SERVER["REQUEST_URI"]) !== 0)
		$go_back_link = "<a href='".elgg_get_site_url()."gcforums/group/{$group_guid}'>".elgg_echo('gcforums:gobacktomain')."</a>"; // ease of going back to main forum
	
	// cyu 03/22/2016: group members need to be able to post!
	if (elgg_is_logged_in() && check_entity_relationship(elgg_get_logged_in_user_guid(),'member',$group_guid) && !$is_topic) {

		if (!$forum_guid) $forum_guid = 0;
		$forum_object = get_entity($forum_guid);

		if (!$forum_object->enable_posting && $forum_guid) // check if postings is enabled and this is not the main first page of forum in group
			$new_forum_topic_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforumtopic'), "href" => "gcforums/create/hjforumtopic/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action btn btn-default'));

	}


	// user must be logged in AND (either an admin or group owner/admin/operator)
	if (elgg_is_logged_in() && ( empty($is_operator) != 1 || elgg_get_logged_in_user_entity()->isAdmin() || get_entity($group_guid)->getOwnerGUID() == elgg_get_logged_in_user_guid())) {

		if (!$forum_guid) $forum_guid = 0;
		$forum_object = get_entity($forum_guid);

		if (!$is_topic) { // if object is a hjforumtopic, then do not display menu
			// new category
			if ($forum_object->enable_subcategories || !$forum_guid) // check if subcategories is enabled or this is the main forum page in group
				$new_category_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforumcategory'), "href" => "gcforums/create/hjforumcategory/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action btn btn-default'));
			// new topic
			if (!$forum_object->enable_posting && $forum_guid) // check if postings is enabled and this is not the main first page of forum in group
				$new_forum_topic_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforumtopic'), "href" => "gcforums/create/hjforumtopic/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action btn btn-default'));
			// new current forum
			$new_forum_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:new_hjforum'), "href" => "gcforums/create/hjforum/{$group_guid}/{$forum_guid}", 'class' => 'elgg-button elgg-button-action btn btn-default'));
			
			if ($forum_guid != 0) {
				// edit current forum
				$edit_forum_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:edit_hjforum'), "href" => "gcforums/edit/{$forum_guid}", 'class' => 'elgg-button elgg-button-action btn btn-default'));
				
				// delete current forum
				elgg_view('output/url', array('is_action' => TRUE));
				elgg_view('input/securitytoken');
				$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$forum_guid}");
				$delete_forum_button = elgg_view('output/url', array("text" => elgg_echo('gcforums:forum_delete'), "href" => $url, 'class' => 'elgg-button elgg-button-action btn btn-default'));
				
				$separator = "  ";
			}
		}
        //styled this positioning with CSS - Nick
		return "{$go_back_link} <div class='gcforums-menu'>{$new_category_button} {$new_forum_button} {$new_forum_topic_button} {$separator} {$edit_forum_button} {$delete_forum_button}</div> ";
	}

	
	return "{$go_back_link} <div class='gcforums-menu'>{$new_forum_topic_button}</div>";
}