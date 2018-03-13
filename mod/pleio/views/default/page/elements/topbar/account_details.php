<?php
	$user = elgg_get_logged_in_user_entity();
?>
<div class="clearfix">
	<?php
		echo elgg_view_entity_icon($user, "medium", array("use_hover" => false));
		echo "<label>" . $user->name . "</label>";
		echo "<br />";
		
		echo elgg_view("output/url", array(
			"href" => $user->getURL(),
			"text" => elgg_echo("profile"),
			"title" => elgg_echo("profile"),
			"is_trusted" => true
		));
		echo "<br />";
		
		if (elgg_is_active_plugin("messages")) {
			$unread = messages_count_unread();
			if (!$unread) {
				$unread = 0;
			}

			echo elgg_view("output/url", array(
				"href" => "/messages/inbox/" . $user->username,
				"text" => elgg_echo("messages:inbox") . " [" . $unread . "]",
				"title" => elgg_echo("messages:unreadcount", array(messages_count_unread())),
				"is_trusted" => true
			));
			echo "<br />";
		}

		if (elgg_is_active_plugin("friend_request")) {
			$request_count = "";
			
			$options = array(
				"type" => "user",
				"count" => true,
				"relationship" => "friendrequest",
				"relationship_guid" => $user->getGUID(),
				"inverse_relationship" => true
			);
			if ($count = elgg_get_entities_from_relationship($options)) {
				$request_count = " [" . $count . "]";
			}
			
			echo elgg_view("output/url", array(
				"href" => "friend_request/" . $user->username,
				"text" => elgg_echo("friend_request:menu") . $request_count,
				"title" => elgg_echo("friend_request:menu"),
				"is_trusted" => true
			));
			echo "<br />";
		}
		
		if (elgg_is_active_plugin("groups")) {
			$invite_count = "";
			
			$options = array(
				"type" => "group",
				"relationship" => "invited",
				"relationship_guid" => $user->getGUID(),
				"inverse_relationship" => true,
				"count" => true
			);
			
			if ($count = elgg_get_entities_from_relationship($options)) {
				$invite_count = " [" . $count . "]";
			}
			
			echo elgg_view("output/url", array(
				"href" => "groups/invitations/" . $user->username,
				"text" => elgg_echo("groups:invitations") . $invite_count,
				"title" => elgg_echo("groups:invitations"),
				"is_trusted" => true
			));
			echo "<br />";
		}

		echo elgg_view("output/url", array(
			"href" => "/settings/user/" . $user->username,
			"text" => elgg_echo("settings"),
			"title" => elgg_echo("settings"),
			"is_trusted" => true
		));
	?>
</div>
<div class="clearfix">
	<?php
		echo elgg_view("output/url", array(
			"href" => "/action/logout",
			"text" => elgg_echo("logout"),
			"title" => elgg_echo("logout"),
			"class" => "elgg-button elgg-button-action float-alt",
			"is_trusted" => true
		));
	?>
</div>