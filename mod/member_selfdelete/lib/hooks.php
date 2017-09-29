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
