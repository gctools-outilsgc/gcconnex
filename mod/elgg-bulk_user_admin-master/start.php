<?php
/**
 * Allow bulk delete operations
 */

/**
 * Init
 */
function bulk_user_admin_init() {
	elgg_register_event_handler('pagesetup', 'system', 'bulk_user_admin_admin_page_setup');

	elgg_extend_view('admin/user_opt/search', 'bulk_user_admin/search_by_domain');
	elgg_extend_view('css/admin', 'bulk_user_admin/css');

	elgg_register_action('bulk_user_admin/delete', dirname(__FILE__) . '/actions/bulk_user_admin/delete.php', 'admin');
	elgg_register_action('bulk_user_admin/delete_by_domain', dirname(__FILE__) . '/actions/bulk_user_admin/delete_by_domain.php', 'admin');

}

function bulk_user_admin_get_users_by_email_domain($domain, $options = array()) {
	$domain = sanitise_string($domain);
	$db_prefix = elgg_get_config('dbprefix');
	
	$where = "ue.email LIKE '%@$domain'";
	if (!isset($options['wheres'])) {
		$options['wheres'] = array($where);
	} else {
		if (!is_array($options['wheres'])) {
			$options['wheres'] = array($options['wheres']);
		}
		$options['wheres'][] = $where;
	}

	$join = "JOIN {$db_prefix}users_entity ue on e.guid = ue.guid";
	if (!isset($options['joins'])) {
		$options['joins'] = array($join);
	} else {
		if (!is_array($options['joins'])) {
			$options['joins'] = array($options['joins']);
		}
		$options['joins'][] = $join;
	}

	$options['type'] = 'user';

	return elgg_get_entities($options);
}

/**
 * Sets up admin menu. Triggered on pagesetup.
 */
function bulk_user_admin_admin_page_setup() {
	if (elgg_get_context() == 'admin' && elgg_is_admin_logged_in()) {
	    elgg_register_admin_menu_item('administer', 'email_domain_stats', 'users');
	}
}

function bulk_user_admin_get_email_domain_stats() {
	$db_prefix = elgg_get_config('dbprefix');
	$q = "SELECT email, substring_index(email, '@', -1) as domain, count(*) as count
		FROM {$db_prefix}users_entity ue
		JOIN {$db_prefix}entities e ON ue.guid = e.guid
		WHERE e.enabled = 'yes'
		group by domain order by count desc, domain asc;";
		
	return get_data($q);
}

elgg_register_event_handler('init', 'system', 'bulk_user_admin_init');