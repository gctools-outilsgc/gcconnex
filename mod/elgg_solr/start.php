<?php

const ELGG_SOLR_UPGRADE_VERSION = 20141205;

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/events.php';

elgg_register_event_handler('init', 'system', 'elgg_solr_init');

/**
 *  Init elgg_solr plugin
 */
function elgg_solr_init() {

	elgg_extend_view('css/admin', 'css/admin/elgg_solr');

	// if the plugin is not configured lets leave search alone
	if (!elgg_solr_has_settings()) {
		return true;
	}
	
	$is_elgg18 = elgg_solr_is_elgg18();

	elgg_register_library('Solarium', dirname(__FILE__) . '/vendor/autoload.php');
	elgg_register_library('elgg_solr:upgrades', dirname(__FILE__) . '/lib/upgrades.php');

	if (elgg_get_plugin_setting('use_solr', 'elgg_solr') != 'no') {
		// unregister default search hooks
		elgg_unregister_plugin_hook_handler('search', 'object', 'search_objects_hook');
		elgg_unregister_plugin_hook_handler('search', 'user', 'search_users_hook');
		elgg_unregister_plugin_hook_handler('search', 'group', 'search_groups_hook');
		elgg_unregister_plugin_hook_handler('search', 'tags', 'search_tags_hook');

		elgg_register_plugin_hook_handler('search', 'object:file', 'elgg_solr_file_search');
		elgg_register_plugin_hook_handler('search', 'object', 'elgg_solr_object_search');
		elgg_register_plugin_hook_handler('search', 'user', 'elgg_solr_user_search');
		elgg_register_plugin_hook_handler('search', 'group', 'elgg_solr_group_search');
		//elgg_register_plugin_hook_handler('search', 'tags', 'elgg_solr_tag_search');


		//elgg_register_plugin_hook_handler('search', );

		if ($is_elgg18) {
			// this is elgg 1.8 need to handle comments as annotations
			elgg_unregister_plugin_hook_handler('search', 'comments', 'search_comments_hook');
			elgg_register_plugin_hook_handler('search', 'comments', 'elgg_solr_comment_search');
		}
	}

	elgg_register_plugin_hook_handler('cron', 'daily', 'elgg_solr_daily_cron');


	elgg_register_event_handler('create', 'all', 'elgg_solr_add_update_entity', 1000);
	elgg_register_event_handler('update', 'all', 'elgg_solr_add_update_entity', 1000);
	elgg_register_event_handler('delete', 'all', 'elgg_solr_delete_entity', 1000);
	elgg_register_event_handler('create', 'metadata', 'elgg_solr_metadata_update');
	elgg_register_event_handler('update', 'metadata', 'elgg_solr_metadata_update');
	elgg_register_event_handler('upgrade', 'system', 'elgg_solr_upgrades');
	elgg_register_event_handler('disable', 'all', 'elgg_solr_disable_entity');
	elgg_register_event_handler('enable', 'all', 'elgg_solr_enable_entity');
	elgg_register_event_handler('shutdown', 'system', 'elgg_solr_entities_sync');
	
	if ($is_elgg18) {
		elgg_register_event_handler('create', 'all', 'elgg_solr_add_update_annotation', 1000);
		elgg_register_event_handler('update', 'all', 'elgg_solr_add_update_annotation', 1000);
		elgg_register_event_handler('delete', 'annotations', 'elgg_solr_delete_annotation', 1000);
		elgg_register_event_handler('shutdown', 'system', 'elgg_solr_annotations_sync');
	}

	elgg_set_config('elgg_solr_sync', array());
	elgg_set_config('elgg_solr_delete', array());

	// when to update the user index
	elgg_register_plugin_hook_handler('usersettings:save', 'user', 'elgg_solr_user_settings_save', 1000);
	elgg_register_event_handler('profileupdate', 'user', 'elgg_solr_profile_update', 1000);


	// register functions for indexing
	elgg_solr_register_solr_entity_type('object', 'file', 'elgg_solr_add_update_file');
	elgg_solr_register_solr_entity_type('user', 'default', 'elgg_solr_add_update_user');
	elgg_solr_register_solr_entity_type('object', 'default', 'elgg_solr_add_update_object_default');
	elgg_solr_register_solr_entity_type('group', 'default', 'elgg_solr_add_update_group_default');

	elgg_register_action('elgg_solr/reindex', dirname(__FILE__) . '/actions/reindex.php', 'admin');
	elgg_register_action('elgg_solr/delete_index', dirname(__FILE__) . '/actions/delete_index.php', 'admin');
	elgg_register_action('elgg_solr/reindex_unlock', dirname(__FILE__) . '/actions/reindex_unlock.php', 'admin');
	elgg_register_action('elgg_solr/settings/save', dirname(__FILE__) . '/actions/plugin_settings.php', 'admin');
	elgg_register_action('elgg_solr/restart_reindex', dirname(__FILE__) . '/actions/restart_reindex.php', 'admin');
	elgg_register_action('elgg_solr/stop_reindex', dirname(__FILE__) . '/actions/stop_reindex.php', 'admin');

	elgg_register_admin_menu_item('administer', 'solr_index', 'administer_utilities');

	elgg_register_ajax_view('elgg_solr/ajax/progress');
}
