<?php
/**
 * Invite a user to join a group
 *
 * @package ElggGroups
 */
 /*
 * GC_MODIFICATION
 * Description: Invite now checks to see if group is a subgroup and if invited individuals are members of the parent group
 * Author: Ethan Wallace <Ethan.Wallace@tbs-sct.gc.ca>
 */

$logged_in_user = elgg_get_logged_in_user_entity();

$user_guids = get_input("user_guid");
if (!empty($user_guids) && !is_array($user_guids)) {
	$user_guids = array($user_guids);
}

// This fix a problem with array of colleague cercle
$array_users = $user_guids;
$string_users = implode(",", $array_users);

$array_users2  = $string_users;
$user_guids = explode(",", $array_users2);

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

$emails = json_decode(get_input("user_emails"));
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

    $parentGroup = elgg_get_entities_from_relationship(array(
		'types' => array('group'),
		'limit' => 1,
		'relationship' => 'au_subgroup_of',
		'relationship_guid' => $group->guid,
	));

    if (is_array($parentGroup)) {
		$parent = $parentGroup[0];
	}

    $invalid_users = array();


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

                        //if sub group
                        if($parent){
                            if($parent->isMember($user)){
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

                            } else {
                                $invalid_users[] = $user;
                            }
                        } else {

                            //normal invite
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
				}
			} else {
				// add users directly
				foreach ($user_guids as $u_id) {
					$user = get_user($u_id);
					if (!empty($user)) {
                        if($parent){
                            if($parent->isMember($user)){

                                if (!$group->isMember($user)) {
                                    if (group_tools_add_user($group, $user, $text)) {
                                        $join++;
                                    }
                                } else {
                                    $member++;
                                }
                            } else {
                                $invalid_users[] = $user;
                            }
                        } else {
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
		}

        if (count($invalid_users)) {
            $error_suffix = elgg_echo('group:invite:cannot');
			$error_suffix .= "<ul class='mrgn-tp-0 mrgn-bttm-0'>";
			foreach ($invalid_users as $user) {
				$error_suffix .= "<li>{$user->name}</li>";
			}
			$error_suffix .= "</ul>";

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
				system_message(elgg_echo("group_tools:action:invite:success:invite", array($invited, $already_invited, $member)) . ' ' . $error_suffix);
			} else {
				system_message(elgg_echo("group_tools:action:invite:success:add", array($join, $already_invited, $member)) . ' ' . $error_suffix);
			}
		} else {
			if (!$adding) {
				register_error(elgg_echo("group_tools:action:invite:error:invite", array($already_invited, $member)) . ' ' . $error_suffix);
			} else {
				register_error(elgg_echo("group_tools:action:invite:error:add", array($already_invited, $member)) . ' ' . $error_suffix);
			}
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:edit"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward(REFERER);
