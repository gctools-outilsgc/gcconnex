<?php
/**
 * A topbar link to return to original user.
 *
 * @uses $vars['user_guid'] The GUID of the original user
 */

$original_user_guid = elgg_extract('user_guid', $vars);
$original_user = get_entity($original_user_guid);
if ($original_user) {
	$logged_in_user = elgg_get_logged_in_user_entity();
	$logged_in_user_icon = $logged_in_user->getIconURL('small');
	$original_user_icon = $original_user->getIconURL('small');

	echo <<<HTML
	<img class="img-circle" src="$logged_in_user_icon" />
	<span><i style="vertical-align: middle" class="fa fa-2x fa-sign-out" aria-hidden="true"></i></span>
HTML;
}
