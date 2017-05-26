<?php
/**
 * This file is loaded when all the active plugins get loaded
 */

define('QUESTIONS_EXPERT_ROLE', 'questions_expert');

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/events.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/page_handlers.php');

elgg_register_event_handler('init', 'system', 'questions_init');

/**
 * This function is executed when the system is initialized
 *
 * @return void
 */
function questions_init() {
	
	// extend CSS/JS
	elgg_extend_view('css/elgg', 'css/questions/site');
	elgg_extend_view('js/elgg', 'js/questions/site');
	
	elgg_register_menu_item('site', [
		'name' => 'questions',
		'text' => elgg_echo('questions'),
		'href' => 'questions/all',
	]);
	
	// make question searchable
	elgg_register_entity_type('object', 'question');
	elgg_register_plugin_hook_handler('search', 'object:question', '\ColdTrick\Questions\Search::handleQuestionsSearch');
	elgg_register_plugin_hook_handler('search_params', 'search:combined', '\ColdTrick\Questions\SearchAdvanced::combinedParams');
	
	// register widget
	elgg_register_widget_type('questions', elgg_echo('widget:questions:title'), elgg_echo('widget:questions:description'), ['index', 'profile', 'dashboard', 'groups'], true);
	
	// register page handler for nice urls
	elgg_register_page_handler('questions', 'questions_page_handler');
	elgg_register_page_handler('answers', 'answers_page_handler');
	
	// register group options
	add_group_tool_option('questions', elgg_echo('questions:enable'), false);
	elgg_extend_view('groups/tool_latest', 'questions/group_module');
	
	elgg_extend_view('groups/edit', 'questions/groups_edit');
	
	// plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'questions_owner_block_menu_handler');
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'questions_user_hover_menu_handler');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'questions_entity_menu_handler');
	elgg_register_plugin_hook_handler('register', 'menu:filter', 'questions_filter_menu_handler');
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'questions_container_permissions_handler');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'questions_permissions_handler');
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\Questions\WidgetManager::widgetURL');
	elgg_register_plugin_hook_handler('cron', 'daily', 'questions_daily_cron_handler');
	
	elgg_register_plugin_hook_handler('index_entity_type_subtypes', 'elasticsearch', '\ColdTrick\Questions\Elasticsearch::indexTypes');
	
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:' . \ElggQuestion::SUBTYPE, '\Elgg\Values::getTrue');
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:' . \ElggAnswer::SUBTYPE, '\Elgg\Values::getTrue');
	
	// notifications
	elgg_register_notification_event('object', ElggQuestion::SUBTYPE, ['create', 'move']);
	elgg_register_notification_event('object', ElggAnswer::SUBTYPE, ['create', 'correct']);
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:' . ElggQuestion::SUBTYPE, '\ColdTrick\Questions\Notifications::createQuestion');
	elgg_register_plugin_hook_handler('prepare', 'notification:move:object:' . ElggQuestion::SUBTYPE, '\ColdTrick\Questions\Notifications::moveQuestion');
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:' . ElggAnswer::SUBTYPE, '\ColdTrick\Questions\Notifications::createAnswer');
	elgg_register_plugin_hook_handler('prepare', 'notification:correct:object:' . ElggAnswer::SUBTYPE, '\ColdTrick\Questions\Notifications::correctAnswer');
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:comment', '\ColdTrick\Questions\Notifications::createCommentOnAnswer');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\Questions\Notifications::addExpertsToSubscribers');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\Questions\Notifications::addQuestionOwnerToAnswerSubscribers');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\Questions\Notifications::addAnswerOwnerToAnswerSubscribers');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\Questions\Notifications::addQuestionSubscribersToAnswerSubscribers');
	
	elgg_register_plugin_hook_handler('entity_types', 'content_subscriptions', '\ColdTrick\Questions\ContentSubscriptions::getEntityTypes');
	elgg_register_event_handler('create', 'object', '\ColdTrick\Questions\ContentSubscriptions::createAnswer');
	elgg_register_event_handler('create', 'object', '\ColdTrick\Questions\ContentSubscriptions::createCommentOnAnswer');
	
	// events
	elgg_register_event_handler('leave', 'group', 'questions_leave_group_handler');
	elgg_register_event_handler('delete', 'relationship', 'questions_leave_site_handler');
	
	// actions
	elgg_register_action('questions/toggle_expert', dirname(__FILE__) . '/actions/toggle_expert.php');
	elgg_register_action('questions/group_settings', dirname(__FILE__) . '/actions/group_settings.php');
	
	// question
	$actions_base = dirname(__FILE__) . '/actions/object/question';
	elgg_register_action('object/question/save', "{$actions_base}/save.php");
	elgg_register_action('object/question/move_to_discussions', "{$actions_base}/move_to_discussions.php");
	elgg_register_action('questions/delete', "{$actions_base}/delete.php");
	
	// answer
	$actions_base = dirname(__FILE__) . '/actions/object/answer';
	elgg_register_action('object/answer/add', "{$actions_base}/save.php");
	elgg_register_action('object/answer/edit', "{$actions_base}/save.php");
	elgg_register_action('answers/delete', "{$actions_base}/delete.php");
	elgg_register_action('answers/toggle_mark', "{$actions_base}/toggle_mark.php");
	
}
