<?php

namespace Beck24\MemberSelfDelete;

/**
 *  check if the user is inactive
 *  if so we're not sending email
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return boolean
 */
function email_system($hook, $type, $return, $params) {
	$email = $params['to'];

	$user = get_user_by_email($email);

	if ($user[0]->member_selfdelete == "anonymized") {
		return false;
	}

	return $return;
}


/**
 * called on 'register', 'menu:user_hover'
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return type
 */
function hover_menu($hook, $type, $return, $params) {

	if (is_array($return) && $params['entity']->member_selfdelete == "anonymized") {
		foreach ($return as $key => $item) {
			if ($item->getSection() != "admin") {
				unset($return[$key]);
			}
		}
	}

	return $return;
}

// ...
function suspended_user_profile_handler($hook, $type, $returnvalue, $params) {

	// basically remove everything in between the div with class pull-right clearfix, 
	if (!elgg_is_admin_logged_in()) {
		$returnvalue = preg_replace("/<div class=\"pull-right clearfix\">.*<\/div>/is", "<div class='pull-right clearfix'> hello? </div>", $returnvalue);
	}

	return $returnvalue;

}

// ...
function send_to_suspended_user_handler($hook, $type, $returnvalue, $params) {

	$recipient_username = (get_input('colleagueCircle')) ? get_input('messageCollection') : get_input('recipient_username');
	$user = get_user_by_username($recipient_username);

	if (get_user_by_username($recipient_username)->gcdeactivate == true) {
		// TODO: translate this
		register_error('this user is deactivated');
		return false;
	}

}