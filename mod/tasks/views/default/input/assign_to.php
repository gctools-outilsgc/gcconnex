<?php

$user  = elgg_get_logged_in_user_entity();
$value = elgg_extract("value", $vars);

$result = "<select name='" . elgg_extract("name", $vars) . "' id='assigned_to' class='elgg-input-dropdown'>";

// add yourself
$result .= "<option value='" . $user->getGUID() . "'>" . elgg_echo("tasks:transfer:myself") . " (" . $user->name .")" . "</option>";

// add friends
$friends_options = array(
	"type" => "user",
	"limit" => false,
	"relationship" => "friend",
	"relationship_guid" => $user->getGUID(),
	"joins" => array("JOIN " . elgg_get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
	"order_by" => "ue.name"
);

$batch = new ElggBatch("elgg_get_entities_from_relationship", $friends_options);
$batch->rewind();
if ($batch->valid()) {
	$add_friends = false;
	$friends_block = "<optgroup label='" . htmlspecialchars(elgg_echo("friends"), ENT_QUOTES, "UTF-8", false) . "'>";
	
	foreach ($batch as $friend) {
		if ($user->getGUID() != $friend->getGUID()) {
			$add_friends = true;
			if ($value == $friend->getGUID()) {
				$friends_block .= "<option selected='selected' value='" . $friend->getGUID() . "'>" . $friend->name . "</option>";
			} else {
				$friends_block .= "<option value='" . $friend->getGUID() . "'>" . $friend->name . "</option>";
			}
		}
	}
	
	$friends_block .= "</optgroup>";
	
	if ($add_friends) {
		$result .= $friends_block;
	}
}

// check for group, so we can add members
$container = elgg_get_page_owner_entity();
if (elgg_instanceof($container, "group")) {
	
	$member_options = array(
		"type" => "user",
		"limit" => false,
		"relationship" => "member",
		"relationship_guid" => $container->getGUID(),
		"inverse_relationship" => true,
		"joins" => array("JOIN " . elgg_get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
		"order_by" => "ue.name"
	);
	
	$batch = new ElggBatch("elgg_get_entities_from_relationship", $member_options);
	$batch->rewind();
	if ($batch->valid()) {
		$add_members = false;
		
		$members_block = "<optgroup label='" . htmlspecialchars(elgg_echo("groups:members"), ENT_QUOTES, "UTF-8", false) . "'>";
		
		foreach ($batch as $member) {
			if (($container->getOwnerGUID() != $member->getGUID()) && ($user->getGUID() != $member->getGUID())) {
				$add_members = true;
				
				if ($value == $member->getGUID()) {
					$members_block .= "<option selected='selected' value='" . $member->getGUID() . "'>" . $member->name . "</option>";
				} else {
					$members_block .= "<option value='" . $member->getGUID() . "'>" . $member->name . "</option>";
				}
			}
		}
		
		$members_block .= "</optgroup>";
		
		if ($add_members) {
			$result .= $members_block;
		}
	}
	
}

$result .= "</select>";
echo $result;
