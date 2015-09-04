<?php
/**
 * group owner tranfser form
 */

$group = elgg_extract("entity", $vars);
$user = elgg_get_logged_in_user_entity();

if (!empty($group) && ($group instanceof ElggGroup) && !empty($user)) {
	
	if (($group->getOwnerGUID() == $user->getGUID()) || $user->isAdmin()) {
		
		$dbprefix = elgg_get_config("dbprefix");
		
		$friends_options = array(
			"type" => "user",
			"relationship" => "friend",
			"relationship_guid" => $user->getGUID(),
			"limit" => false,
			"count" => true,
			"joins" => array("JOIN " . $dbprefix . "users_entity ue ON e.guid = ue.guid"),
			"wheres" => array("(e.guid <> " . $group->getOwnerGUID() . ")"),
			"order_by" => "ue.name",
			"selects" => array("ue.name"),
		);
		
		$member_options = array(
			"type" => "user",
			"relationship" => "member",
			"relationship_guid" => $group->getGUID(),
			"inverse_relationship" => true,
			"limit" => false,
			"count" => true,
			"joins" => array("JOIN " . $dbprefix . "users_entity ue ON e.guid = ue.guid"),
			"wheres" => array("(e.guid NOT IN (" . $group->getOwnerGUID() . ", " . $user->getGUID() . "))"),
			"order_by" => "ue.name",
			"selects" => array("ue.name"),
		);
		
		$friends = elgg_get_entities_from_relationship($friends_options);
		$members = elgg_get_entities_from_relationship($member_options);
		
		if (!empty($friends) || !empty($members)) {
			
			$add_myself = false;
			$add_friends = false;
			$add_members = false;
			
			$result .= "<select name='owner_guid'>";
			$result .= "<option value='" . $group->getOwnerGUID() . "'>" . elgg_echo("group_tools:admin_transfer:current", array($group->getOwnerEntity()->name)) . "</option>";
			
			if ($group->getOwnerGUID() != $user->getGUID()) {
				$add_myself = true;
				
				$result .= "<option value='" . $user->getGUID() . "'>" . elgg_echo("group_tools:admin_transfer:myself") . "</option>";
			}
			
			if (!empty($friends)) {
				unset($friends_options["count"]);
				$friends_options["callback"] = "group_tool_admin_transfer_callback";
				
				$friends = new ElggBatch("elgg_get_entities_from_relationship", $friends_options);
				
				$add_friends = true;
				$friends_block = "<optgroup label='" . elgg_echo("friends") . "'>";
				
				foreach ($friends as $friend) {
					$friends_block .= "<option value='" . $friend["guid"] . "'>" . $friend["name"] . "</option>";
				}
				
				$friends_block .= "</optgroup>";
				
				// add friends to the select
				$result .= $friends_block;
			}
			
			if (!empty($members)) {
				unset($member_options["count"]);
				$member_options["callback"] = "group_tool_admin_transfer_callback";
				
				$members = new ElggBatch("elgg_get_entities_from_relationship", $member_options);
				
				$add_members = true;
				$members_block = "<optgroup label='" . elgg_echo("groups:members") . "'>";
				
				foreach ($members as $member) {
					$members_block .= "<option value='" . $member["guid"] . "'>" . $member["name"] . "</option>";
				}
				
				$members_block .= "</optgroup>";
				
				// add group members to the select
				$result .= $members_block;
			}
			
			$result .= "</select>";
			$result .= "<br />";
			
			if ($add_myself || $add_friends || $add_members) {
				
				echo "<div>";
				echo "<label for='groups-owner-guid'>" . elgg_echo("groups:owner") . "</label><br />";
				echo $result;
				
				if ($group->getOwnerGUID() == $user->getGUID()) {
					echo "<span class='elgg-text-help'>" . elgg_echo("groups:owner:warning") . "</span>";
				}
				
				echo "</div>";
				
			} 
		}
	}
}
