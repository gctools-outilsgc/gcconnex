<?php
/**
 * Al helper functions for this plugin are bundled here
 */

/**
 * Check is TheWire is enabled for groups
 *
 * @return boolean
 */
function thewire_tools_groups_enabled() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		if (elgg_get_plugin_setting("enable_group", "thewire_tools") == "yes") {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Get the max number of characters allowed in a wire post
 *
 * @return int the number of characters
 */
function thewire_tools_get_wire_length() {
	static $result;
	
	if (!isset($result)) {
		$result = 140;
		
		$setting = (int) elgg_get_plugin_setting("wire_length", "thewire_tools");
		if ($setting > 0) {
			$result = $setting;
		}
	}
	
	return $result;
}

/**
 * Save a wire post, overrules the default function because we need to support groups
 *
 * @param string $text        the text of the post
 * @param int    $userid      the owner of the post
 * @param int    $access_id   the access level of the post
 * @param int    $parent_guid is this a reply on another post
 * @param string $method      which method was used
 *
 * @return bool|int the GUID of the new wire post or false
 */
function thewire_tools_save_post($text, $userid, $access_id, $parent_guid = 0, $method = "site") {
	
	// set correct container
	$container_guid = $userid;
	
	// check the access id
	if ($access_id == ACCESS_PRIVATE) {
		// private wire posts aren"t allowed
		$access_id = ACCESS_LOGGED_IN;
	} elseif (thewire_tools_groups_enabled()) {
		// allow the saving of a wire post in a group (if enabled)
		if (!in_array($access_id, array(ACCESS_FRIENDS, ACCESS_LOGGED_IN, ACCESS_PUBLIC))) {
			// try to find a group with access_id
			$group_options = array(
				"type" => "group",
				"limit" => 1,
				"metadata_name_value_pairs" => array(
					"group_acl" => $access_id
				)
			);
			
			$groups = elgg_get_entities_from_metadata($group_options);
			if (!empty($groups)) {
				$group = $groups[0];
					
				if ($group->thewire_enable == "no") {
					// not allowed to post in this group
					register_error(elgg_echo("thewire_tools:groups:error:not_enabled"));
						
					// let creation of object fail
					return false;
				} else {
					$container_guid = $group->getGUID();
				}
			}
		}
	}
	
	// create the new post
	$post = new ElggObject();

	$post->subtype = "thewire";
	$post->owner_guid = $userid;
	$post->container_guid = $container_guid;
	$post->access_id = $access_id;

	// only xxx characters allowed (see plugin setting)
	$text = elgg_substr($text, 0, thewire_tools_get_wire_length());

	// no html tags allowed so we escape
	$post->description = htmlspecialchars($text, ENT_NOQUOTES, "UTF-8");

	$post->method = $method; //method: site, email, api, ...

	$tags = thewire_get_hashtags($text);
	if (!empty($tags)) {
		$post->tags = $tags;
	}

	// must do this before saving so notifications pick up that this is a reply
	if ($parent_guid) {
		$post->reply = true;
	}

	$guid = $post->save();

	// set thread guid
	if ($parent_guid) {
		$post->addRelationship($parent_guid, "parent");
		
		// name conversation threads by guid of first post (works even if first post deleted)
		$parent_post = get_entity($parent_guid);
		$post->wire_thread = $parent_post->wire_thread;
	} else {
		// first post in this thread
		$post->wire_thread = $guid;
	}

	if ($guid) {
		add_to_river("river/object/thewire/create", "create", $post->getOwnerGUID(), $post->getGUID());

		// let other plugins know we are setting a user status
		$params = array(
			"entity" => $post,
			"user" => $post->getOwnerEntity(),
			"message" => $post->description,
			"url" => $post->getURL(),
			"origin" => "thewire",
		);
		elgg_trigger_plugin_hook("status", "user", $params);
	}
	
	return $guid;
}
