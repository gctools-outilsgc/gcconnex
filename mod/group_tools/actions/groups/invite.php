<?php
/**
* Group Tools
*
* Invite a user to join a group
* 
* @author ColdTrick IT Solutions
* @package ElggGroups
*/	

$logged_in_user = elgg_get_logged_in_user_entity();

$user_guids = get_input("user_guid");
if (!empty($user_guids) && !is_array($user_guids)) {
	$user_guids = array($user_guids);
}

$adding = false;
if (elgg_is_admin_logged_in()) {
	// add all users?
	if (get_input("all_users") == "yes") {
		$site = elgg_get_site_entity();
		
		$options = array(
			"limit" => false,
			"callback" => "group_tools_guid_only_callback"
		);
		
		$user_guids = $site->getMembers($options);
	}
	
	// add users directly?
	if (get_input("submit") == elgg_echo("group_tools:add_users")) {
		$adding = true;
	}
}

$group_guid = (int) get_input("group_guid");
$text = get_input("comment");

$emails = get_input("user_guid_email");
if (!empty($emails) && !is_array($emails)) {
	$emails = array($emails);
}

$csv = get_uploaded_file("csv");
if (get_input("resend") == "yes") {
	$resend = true;
} else {
	$resend = false;
}
$group = get_entity($group_guid);

if ((!empty($user_guids) || !empty($emails) || !empty($csv)) && !empty($group)) {
	if (($group instanceof ElggGroup) && ($group->canEdit() || group_tools_allow_members_invite($group))) {
		// show hidden (unvalidated) users
		$hidden = access_get_show_hidden_status();
		access_show_hidden_entities(true);
		
		// counters
		$already_invited = 0;
		$invited = 0;
		$member = 0;
		$join = 0;
		
		// invite existing users
		if (!empty($user_guids)) {
			if (!$adding) {
				// invite users
				foreach ($user_guids as $u_id) {
					$user = get_user($u_id);
					if (!empty($user)) {
						if (!$group->isMember($user)) {
							if (!check_entity_relationship($group->getGUID(), "invited", $user->getGUID()) || $resend) {
								if (group_tools_invite_user($group, $user, $text, $resend)) {
									$invited++;
								}
							} else {
								// user was already invited
								$already_invited++;
							}
						} else {
							$member++;
						}
					}
				}
			} else {
				// add users directly
				foreach ($user_guids as $u_id) {
					$user = get_user($u_id);
					if (!empty($user)) {
						if (!$group->isMember($user)) {
							if (group_tools_add_user($group, $user, $text)) {
								$join++;
							}
						} else {
							$member++;
						}
					}
				}
			}
		}
		
		// Invite member by e-mail address
		if (!empty($emails)) {
			foreach ($emails as $email) {
				$invite_result = group_tools_invite_email($group, $email, $text, $resend);
				if ($invite_result === true) {
					$invited++;
				} elseif ($invite_result === null) {
					$already_invited++;
				}
			}
		}
		
		// invite from csv
		if (!empty($csv)) {
			$file_location = $_FILES["csv"]["tmp_name"];
			$fh = fopen($file_location, "r");
			
			if (!empty($fh)) {
				while (($data = fgetcsv($fh, 0, ";")) !== false) {
					/*
					 * data structure
					 * data[0] => displayname
					 * data[1] => e-mail address
					 */
					$email = "";
					if (isset($data[1])) {
						$email = trim($data[1]);
					}
					
					if (!empty($email) && is_email_address($email)) {
						$users = get_user_by_email($email);
						if (!empty($users)) {
							// found a user with this email on the site, so invite (or add)
							$user = $users[0];
							
							if (!$group->isMember($user)) {
								if (!$adding) {
									if (!check_entity_relationship($group->getGUID(), "invited", $user->getGUID()) || $resend) {
										// invite user
										if (group_tools_invite_user($group, $user, $text, $resend)) {
											$invited++;
										}
									} else {
										// user was already invited
										$already_invited++;
									}
								} else {
									if (group_tools_add_user($group, $user, $text)) {
										$join++;
									}
								}
							} else {
								$member++;
							}
						} else {
							// user not found so invite based on email address
							$invite_result = group_tools_invite_email($group, $email, $text, $resend);
							
							if ($invite_result === true) {
								$invited++;
							} elseif ($invite_result === null) {
								$already_invited++;
							}
						}
					}
				}
			}
		}
		
		// restore hidden users
		access_show_hidden_entities($hidden);
		
		// which message to show
		if (!empty($invited) || !empty($join)) {
			if (!$adding) {
				system_message(elgg_echo("group_tools:action:invite:success:invite", array($invited, $already_invited, $member)));
			} else {

				// cyu - 05/12/2016: modified to comform to the business requirements documentation
				// please note that this file is overwritting groups and group_tools
				if (elgg_is_active_plugin('cp_notifications')) {
					add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
					add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
				}

				system_message(elgg_echo("group_tools:action:invite:success:add", array($join, $already_invited, $member)));
			}
		} else {
			if (!$adding) {
				register_error(elgg_echo("group_tools:action:invite:error:invite", array($already_invited, $member)));
			} else {
				register_error(elgg_echo("group_tools:action:invite:error:add", array($already_invited, $member)));
			}
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:edit"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward(REFERER);
