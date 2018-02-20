<?php

namespace Beck24\MemberSelfDelete;

/**
 * set up admin/page links
 */
function pagesetup() {
	if (elgg_get_plugin_setting('feedback', PLUGIN_ID) == "yes") {
		elgg_register_admin_menu_item('administer', 'member_selfdelete/reasons', 'users');
	}
	//GCTools - list deactivated users
	elgg_register_admin_menu_item('administer', 'member_selfdelete/deactivated_users', 'users');
}