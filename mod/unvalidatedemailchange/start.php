<?php

/**
 * Unvalidatedemailchange plugin
 * (c) iionly 2012-2015
 * Contact: iionly@gmx.de
 * Website: https://github.com/iionly
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

elgg_register_event_handler('init', 'system', 'unvalidatedemailchange_init');

function unvalidatedemailchange_init() {
	elgg_register_action('unvalidatedemailchange/change_user_email', elgg_get_plugins_path() . "unvalidatedemailchange/actions/change_user_email.php", 'admin');
	elgg_register_ajax_view('unvalidatedemailchange/change_email');
}
