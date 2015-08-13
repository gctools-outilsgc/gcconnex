<?php
/**
 * Add users to a group
 *
 * @package ElggGroups
 */

$logged_in_user = elgg_get_logged_in_user_entity();

$user_guid = get_input('user_guid');
if (!is_array($user_guid)) {
	$user_guid = array($user_guid);
}
$group_guid = get_input('group_guid');
$group = get_entity($group_guid);

if (sizeof($user_guid)) { 
	foreach ($user_guid as $u_id) {
		$user = get_user($u_id);

		if ($user && $group && $group->canEdit()) {
			if (!$group->isMember($user)) {
				if (groups_join_group($group, $user)) {

					$subj_line = c_validate_string(utf8_encode(html_entity_decode($group->name, ENT_QUOTES | ENT_HTML5 )));
					if (!is_array($subj_line))
					{
						$lang01 = $subj_line;
						$lang02 = $subj_line;
					} else {
						$lang01 = $subj_line[0];
						$lang02 = $subj_line[1];
					}
				
					// send welcome email to user
					notify_user($user->getGUID(), $group->owner_guid,
							elgg_echo('groups:welcome:subject', array($lang01,$lang02)),
							elgg_echo('groups:welcome:body', array(
								$user->name,
								$group->name,
								$group->getURL(),
								elgg_get_site_url().'notifications/group/'.$user->name,

								$user->name,
								$group->name,
								$group->getURL(),
								elgg_get_site_url().'notifications/group/'.$user->name,
								)));

					system_message(elgg_echo('groups:addedtogroup'));
				} else {
					// huh
				}
			}
		}
	}
}

forward(REFERER);
