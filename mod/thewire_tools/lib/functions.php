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
		
		$setting = (int) elgg_get_plugin_setting("limit", "thewire");
		if ($setting >= 0) {
			$result = $setting;
		}
	}
	
	return $result;
}

/**
 * Save a wire post, overrules the default function because we need to support groups
 *
 * @param string $text         the text of the post
 * @param int    $userid       the owner of the post
 * @param int    $access_id    the access level of the post
 * @param int    $parent_guid  is this a reply on another post
 * @param string $method       which method was used
 * @param int    $reshare_guid is the a (re)share of some content item
 *
 * @return bool|int the GUID of the new wire post or false
 */
function thewire_tools_save_post($text, $userid, $access_id, $parent_guid = 0, $method = "site", $reshare_guid = 0) {
	
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

	// only xxx characters allowed (see plugin setting of thewire, 0 is unlimited)
	$max_length = thewire_tools_get_wire_length();
	if ($max_length) {
		$text = elgg_substr($text, 0, $max_length);
	}

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

	if ($guid) {
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
		
		// add reshare
		if ($reshare_guid) {
			$post->addRelationship($reshare_guid, "reshare");
		}
		
		// add to river
		elgg_create_river_item(array(
			'view' => 'river/object/thewire/create',
			'action_type' => 'create',
			'subject_guid' => $post->getOwnerGUID(),
			'object_guid' => $post->getGUID(),
		));
		
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

/**
 * Replace urls, hash tags, and @'s by links
 *
 * @see thewire_filter()
 *
 * @param string $text The text of a post
 *
 * @return string
 */
function thewire_tools_filter($text) {
	static $mention_display;
	$site_url = elgg_get_site_url();

	if (!isset($mention_display)) {
		$mention_display = "username";
		if (elgg_get_plugin_setting("mention_display", "thewire_tools") == "displayname") {
			$mention_display = "displayname";
		}
	}
	
	$text = ' ' . $text;

	// email addresses
	$text = preg_replace(
			'/(^|[^\w])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i',
			'$1<a href="mailto:$2@$3">$2@$3</a>',
			$text);

	// links
	$text = parse_urls($text);

	// usernames
	if ($mention_display == "displayname") {
		$matches = array();
		$match_count = preg_match_all(
			'/(^|[^\w])@([\p{L}\p{Nd}._]+)/u',
			$text,
			$matches,
			PREG_SET_ORDER
		);
		
		if ($match_count > 0) {
			$proccessed_usernames = array();
			
			foreach ($matches as $set) {
				$replaces = 0;
				
				if (in_array($set[2], $proccessed_usernames)) {
					continue;
				}
				
				$user = get_user_by_username($set[2]);
				if (empty($user)) {
					continue;
				}
				
				$replace = " " . elgg_view("output/url", array(
					"text" => "@" . $user->name,
					"href" => "thewire/owner/" . $user->username,
					"is_trusted" => true
				));
				
				$text = str_ireplace($set[0], $replace, $text, $replaces);
				if ($replaces > 0) {
					$proccessed_usernames[] = $set[2];
				}
			}
		}
	} else {
		$text = preg_replace(
				'/(^|[^\w])@([\p{L}\p{Nd}._]+)/u',
				'$1<a href="' . $site_url . 'thewire/owner/$2">@$2</a>',
				$text);
	}

	// hashtags
	$text = preg_replace(
			'/(^|[^\w])#(\w*[^\s\d!-\/:-@]+\w*)/',
			'$1<a href="' . $site_url . 'thewire/tag/$2">#$2</a>',
			$text);

	$text = trim($text);

	return $text;
}

/**
 * Get the subscription methods of the user
 *
 * @param int $user_guid the user_guid to check (default: current user)
 *
 * @return array
 */
function thewire_tools_get_notification_settings($user_guid = 0) {

	$user_guid = sanitise_int($user_guid, false);
	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}

	if (empty($user_guid)) {
		return array();
	}

	if (elgg_is_active_plugin("notifications")) {
		$saved = elgg_get_plugin_user_setting("notification_settings_saved", $user_guid, "thewire_tools");
		if (!empty($saved)) {
			$settings = elgg_get_plugin_user_setting("notification_settings", $user_guid, "thewire_tools");
				
			if (!empty($settings)) {
				return string_to_tag_array($settings);
			}
				
			return array();
		}
	}

	// default elgg settings
	$settings = get_user_notification_settings($user_guid);

	if (!empty($settings)) {
		$settings = (array) $settings;
		$res = array();

		foreach ($settings as $method => $value) {
			if (!empty($value)) {
				$res[] = $method;
			}
		}

		return $res;
	}

	return array();
}
