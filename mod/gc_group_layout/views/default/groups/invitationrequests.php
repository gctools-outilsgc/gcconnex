<?php
/**
* A user"s group invitations
*
* @uses $vars["invitations"] Array of ElggGroups
*/

$user = elgg_extract("user", $vars);
$invitations = elgg_extract("invitations", $vars);
$email_invites = elgg_extract("email_invitations", $vars, false);
$lang = get_current_language();

if ((!empty($invitations) && is_array($invitations)) || (!empty($email_invites) && is_array($email_invites))) {

	echo "<ul class='elgg-list clearfix mbm list-unstyled'>";

	// normal invites
	if (!empty($invitations)) {
		foreach ($invitations as $group) {
			if ($group instanceof ElggGroup) {
				$icon = elgg_view_entity_icon($group, "medium", array("use_hover" => "true", 'class' => 'img-responsive'));

				$group_title = elgg_view("output/url", array(
					"href" => $group->getURL(),
					"text" => gc_explode_translation($group->name,$lang),
					"is_trusted" => true,
				));

				$url = "action/groups/join?user_guid=" . $user->getGUID() . "&group_guid=" . $group->getGUID();
				$accept_button = elgg_view("output/url", array(
					"href" => $url,
					"text" => elgg_echo('group:accept:invitation', array($group->name)),
					"class" => "elgg-button elgg-button-submit",
					"is_trusted" => true,
					"is_action" => true
				));

				$url = "action/groups/killinvitation?user_guid=" . $user->getGUID() . "&group_guid=" . $group->getGUID();
				$delete_button = elgg_view("output/url", array(
					"href" => $url,
					"confirm" => elgg_echo("groups:invite:remove:check"),
					"text" => elgg_echo('group:decline:invitation', array(gc_explode_translation($group->name,$lang))),
					"class" => "elgg-button elgg-button-delete mlm",
				));
				$group_description = gc_explode_translation($group->briefdescription,$lang);
				$body = "<div class='col-xs-9'><h2 style='border-bottom: none;'>$group_title</h2>";
				$body .= "<p class='elgg-subtext'>$group_description</p></div>";

				$alt = $accept_button . $delete_button;

        $body .= "<div class='col-xs-3 text-right'>" . $alt . "</div>";

				echo "<li class='pvs'>";
				echo elgg_view_image_block($icon, $body, array());
				echo "</li>";
			}
		}
	}

	// auto detected email invitations
	if (!empty($email_invites)) {
		foreach ($email_invites as $group) {
			$icon = elgg_view_entity_icon($group, "medium", array("use_hover" => "true", 'class' => 'img-responsive'));

			$group_title = elgg_view("output/url", array(
				"href" => $group->getURL(),
				"text" => gc_explode_translation($group->name,$lang),
				"is_trusted" => true,
			));

			$url = "action/groups/email_invitation?invitecode=" . group_tools_generate_email_invite_code($group->getGUID(), $user->email);
			$accept_button = elgg_view("output/url", array(
				"href" => $url,
				"text" => elgg_echo('group:accept:invitation', array(gc_explode_translation($group->name,$lang))),
				"class" => "elgg-button elgg-button-submit",
				"is_trusted" => true,
				"is_action" => true
			));

			$url = "action/groups/decline_email_invitation?invitecode=" . group_tools_generate_email_invite_code($group->getGUID(), $user->email);
			$delete_button = elgg_view("output/url", array(
				"href" => $url,
				"confirm" => elgg_echo("groups:invite:remove:check"),
				"text" => elgg_echo('group:decline:invitation', array(gc_explode_translation($group->name,$lang))),
				"class" => "elgg-button elgg-button-delete mlm",
			));

			$body = "<div class='col-xs-9'><h2 style='border-bottom: none;'>$group_title</h2>";
			$body .= "<p class='elgg-subtext'>".gc_explode_translation($group->briefdescription,$lang)."</p></div>";

			$alt = $accept_button . $delete_button;

            $body .= "<div class='col-xs-3 text-right'>" . $alt . "</div>";

			echo "<li class='pvs'>";
			echo elgg_view_image_block($icon, $body, array());
			echo "</li>";
		}
	}

	echo "</ul>";
} else {
	echo "<p class='mtm'>" . elgg_echo("groups:invitations:none") . "</p>";
}

// list membership requests
if (elgg_get_context() == "groups") {
	// get requests
	$requests = elgg_extract("requests", $vars);

	$title = elgg_echo("group_tools:group:invitations:request");

	if (!empty($requests) && is_array($requests)) {
		$content = "<ul class='elgg-list'>";

		foreach ($requests as $group) {
			$icon = elgg_view_entity_icon($group, "medium", array("use_hover" => "true", 'class' => 'img-responsive'));

			$group_title = elgg_view("output/url", array(
				"href" => $group->getURL(),
				"text" => $group->name,
				"is_trusted" => true,
			));

			$url = "action/groups/killrequest?user_guid=" . $user->getGUID() . "&group_guid=" . $group->getGUID();
			$delete_button = elgg_view("output/url", array(
				"href" => $url,
				"confirm" => elgg_echo("group_tools:group:invitations:request:revoke:confirm"),
				"text" => elgg_echo("group_tools:revoke"),
				"class" => "elgg-button elgg-button-delete mlm",
			));

			$body = "<div class='col-xs-10'><h4>$group_title</h4>";
			$body .= "<p class='elgg-subtext'>$group->briefdescription</p></div>";

			$body .= "<div class='col-xs-2'>" . $delete_button . "</div>";

			$content .= "<li class='pvs'>";
			$content .= elgg_view_image_block($icon, $body, array());
			$content .= "</li>";
		}

		$content .= "</ul>";
	} else {
		$content = elgg_echo("group_tools:group:invitations:request:non_found");
	}

	echo elgg_view_module("info", $title, $content);

	// show e-mail invitation form
	if (elgg_extract("invite_email", $vars, false)) {
		// make the form for the email invitations
		$form_body = "<div>" . elgg_echo("group_tools:groups:invitation:code:description") . "</div>";
		$form_body .= elgg_view("input/text", array(
			"name" => "invitecode",
			"value" => get_input("invitecode"),
			"class" => "mbm"
		));

		$form_body .= "<div>";
		$form_body .= elgg_view("input/submit", array("value" => elgg_echo("submit")));
		$form_body .= "</div>";

		$form = elgg_view("input/form", array(
			"body" => $form_body,
			"action" => "action/groups/email_invitation"
		));

		echo elgg_view_module("info", elgg_echo("group_tools:groups:invitation:code:title"), $form);
	}
}
