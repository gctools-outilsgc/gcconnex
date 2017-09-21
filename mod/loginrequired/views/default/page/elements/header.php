<?php
/**
 * Elgg page header
 * In the default theme, the header lives between the topbar and main content area.
 */

if (!elgg_is_logged_in()) {

	// link back to main site.
	echo elgg_view('page/elements/header_logo', $vars);

	// drop-down login
	echo elgg_view('core/account/login_dropdown');
} else {

	// link back to main site.
	echo elgg_view('page/elements/header_logo', $vars);

	// drop-down login
	echo elgg_view('core/account/login_dropdown');

	// insert site-wide navigation
	if (!elgg_is_active_plugin('aalborg_theme')) {
		echo elgg_view_menu('site');
	}
}
