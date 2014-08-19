<?php
/**
 *	BP2020 Ideas plugin
 *	@package ideas
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license Dual licensed under the MIT and GNU Affero General Public License, version 3 or late
 *	@copyright (c) Emmanuel Salomon 2012
 *	@link http://
 **/

elgg_register_event_handler('init', 'system', 'ideas_init');

function ideas_init() {

	$root = dirname(__FILE__);
	elgg_register_library('ideas:utilities', "$root/lib/utilities.php");

	// actions
	$action_base = "$root/actions/ideas";
	elgg_register_action('ideas/saveidea', "$action_base/saveidea.php");
	elgg_register_action('ideas/editidea', "$action_base/editidea.php");
	elgg_register_action("ideas/rateidea", "$action_base/rateidea.php");
	elgg_register_action('ideas/delete', "$action_base/deleteidea.php");
	elgg_register_action('ideas/settings', "$action_base/settings.php");

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'ideas_owner_block_menu');

	elgg_register_page_handler('ideas', 'ideas_page_handler');

	// Extend view
	elgg_extend_view('css/elgg', 'ideas/css');
	elgg_extend_view('js/elgg', 'ideas/js');

	// Register widgets
	elgg_register_widget_type(
			'ideas',
			elgg_echo('ideas:widget:title'),
			elgg_echo('ideas:widget:description')
	);
    /*
	elgg_register_widget_type(
			'points_left',
			elgg_echo('ideas:widget:points_left:title'),
			elgg_echo('ideas:widget:points_left:description'),
			'dashboard'
	);
    */
    
	// Register granular notification for this type
	register_notification_object('object', 'ideas', elgg_echo('ideas:new'));

	// Listen to notification events and supply a more useful message
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'ideas_notify_message');

	// Register a URL handler for ideas
	elgg_register_entity_url_handler('object', 'idea', 'idea_url');

	// Register entity type for search
	elgg_register_entity_type('object', 'idea');
    
    // Temporary disable notifications REMOVE THIS BEFORE SENDING TO PROD
  //  elgg_register_plugin_hook_handler('email', 'system', 'ideas_mailer');
    
	// Groups
	add_group_tool_option('ideas', elgg_echo('ideas:enableideas'), true);
	elgg_extend_view('groups/tool_latest', 'ideas/group_module');
}

function ideas_mailer($hook, $type, $return, $params) {
    // elgg_send_email('dave.samojlenko@ssc-spc.gc.ca', 'dave.samojlenko@ssc-spc.gc.ca', 'blocked email', 'just blocked an email');
   return true;
}

/**
 * Dispatcher for ideas.
 *
 * @param array $page
 */
function ideas_page_handler($page) {
	elgg_load_library('ideas:utilities');

	elgg_push_breadcrumb(elgg_echo('ideas'), 'ideas/all');

	$pages = dirname(__FILE__) . '/pages/ideas';

	switch ($page[0]) {
		case "read":
		case "view":
			set_input('guid', $page[1]);
			include "$pages/view.php";
			break;
		case "add":
			gatekeeper();
			include "$pages/saveidea.php";
			break;
		case "edit":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/editidea.php";
			break;
		case "all":
			include "$pages/all.php";
			break;
		case "owner":
			include "$pages/owner.php";
			break;
		case "friends":
			include "$pages/friends.php";
			break;
		case 'group':
			group_gatekeeper();
			switch ($page[2]) {
				case "all":
                    include "$pages/all_group.php";
                    break;
				case "top":
					include "$pages/top.php";
					break;
				case "hot":
					include "$pages/hot.php";
					break;
				case "new":
					include "$pages/new.php";
					break;
                case "tagcloud":
                    include "$pages/tagcloud.php";
                    break;
				case "settings":
					include "$pages/settings.php";
					break;
				default:
					forward(elgg_get_site_url() . 'ideas/group/' . $page[1] . '/top');
					break;
			}
			break;

		default:
			return false;
			break;
	}

	elgg_pop_context();

	return true;
}


/**
 * Populates the ->getUrl() method for idea objects
 *
 * @param ElggEntity $entity The idea object
 * @return string idea item URL
 */
function idea_url($entity) {
	global $CONFIG;

	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return $CONFIG->url . "ideas/view/" . $entity->getGUID() . "/" . $title;
}

/**
 * Add a menu item to an ownerblock
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function ideas_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "ideas/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('ideas', elgg_echo('ideas'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->ideas_enable != 'no') {
			$url = "ideas/group/{$params['entity']->guid}/top";
			$item = new ElggMenuItem('ideas', elgg_echo('ideas:group:idea'), $url);
			// if (elgg_in_context('ideas')) $item->setSelected();
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Returns the body of a notification message
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function ideas_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'idea')) {
		$descr = $entity->description;
		$title = $entity->title;

		$url = elgg_get_site_url() . "view/" . $entity->guid;
		if ($method == 'sms') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("ideas:via") . ': ' . $url . ' (' . $title . ')';
		}
		if ($method == 'email') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("ideas:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
		if ($method == 'web') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("ideas:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}

	}
	return null;
}
