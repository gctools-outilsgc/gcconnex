<?php

	function group_tools_check_group_email_invitation($invite_code, $group_guid = 0){
		$result = false;
		
		if(!empty($invite_code)){
			$options = array(
				"type" => "group",
				"limit" => 1,
				"site_guids" => false,
				"annotation_name_value_pairs" => array("email_invitation" => $invite_code)
			);
			
			if(!empty($group_guid)){
				$options["annotation_owner_guids"] = array($group_guid);
			}
			
			// find hidden groups
			$ia = elgg_set_ignore_access(true);
			
			if($groups = elgg_get_entities_from_annotations($options)){
				$result = $groups[0];
			}
			
			// restore access
			elgg_set_ignore_access($ia);
		}
		
		return $result;
	}
	
	function group_tools_invite_user(ElggGroup $group, ElggUser $user, $text = "", $resend = false){
		$result = false;
		
		if(!empty($user) && ($user instanceof ElggUser) && !empty($group) && ($group instanceof ElggGroup) && ($loggedin_user = elgg_get_logged_in_user_entity())){
			// Create relationship
			$relationship = add_entity_relationship($group->getGUID(), "invited", $user->getGUID());
			
			if($relationship || $resend){
				// Send email
				$url = elgg_get_site_url() . "groups/invitations/" . $user->username;
				
				$subject = elgg_echo("groups:invite:subject", array($user->name, $group->name));
				$msg = elgg_echo("group_tools:groups:invite:body", array($user->name, $loggedin_user->name, $group->name, $text, $url));
				
				if($res = notify_user($user->getGUID(), $group->getOwnerGUID(), $subject, $msg, null, "email")){
					$result = true;
				}
			}
		}
		
		return $result;
	}
	
	function group_tools_add_user(ElggGroup $group, ElggUser $user, $text = ""){
		$result = false;
		
		if(!empty($user) && ($user instanceof ElggUser) && !empty($group) && ($group instanceof ElggGroup) && ($loggedin_user = elgg_get_logged_in_user_entity())){
			// make sure all goes well
			$ia = elgg_set_ignore_access(true);
			
			if($group->join($user)){
				// Remove any invite or join request flags
				remove_entity_relationship($group->getGUID(), "invited", $user->getGUID());
				remove_entity_relationship($user->getGUID(), "membership_request", $group->getGUID());
					
				// notify user
				$subject = elgg_echo("group_tools:groups:invite:add:subject", array($group->name));
				$msg = elgg_echo("group_tools:groups:invite:add:body", array($user->name, $loggedin_user->name, $group->name, $text, $group->getURL()));
					
				if(notify_user($user->getGUID(), $group->getOwnerGUID(), $subject, $msg, null, "email")){
					$result = true;
				}
			}
			
			// restore access
			elgg_set_ignore_access($ia);
		}
		
		return $result;
	}
	
	function group_tools_invite_email(ElggGroup $group, $email, $text = "", $resend = false){
		$result = false;

		if(!empty($group) && ($group instanceof ElggGroup) && !empty($email) && is_email_address($email) && ($loggedin_user = elgg_get_logged_in_user_entity())){
			// generate invite code
			$invite_code = group_tools_generate_email_invite_code($group->getGUID(), $email);
			
			if(!($found_group = group_tools_check_group_email_invitation($invite_code, $group->getGUID())) || $resend){
				// make site email
				$site = elgg_get_site_entity();
				if(!empty($site->email)){
					if(!empty($site->name)){
						$site_from = $site->name . " <" . $site->email . ">";
					} else {
						$site_from = $site->email;
					}
				} else {
					// no site email, so make one up
					if(!empty($site->name)){
						$site_from = $site->name . " <noreply@" . get_site_domain($site->getGUID()) . ">";
					} else {
						$site_from = "noreply@" . get_site_domain($site->getGUID());
					}
				}
				
				if(empty($found_group)){
					// register invite with group
					$group->annotate("email_invitation", $invite_code, ACCESS_LOGGED_IN, $group->getGUID());
				}
				
				// make subject
				$subject = elgg_echo("group_tools:groups:invite:email:subject", array($group->name));
				
				// make body
				$body = elgg_echo("group_tools:groups:invite:email:body", array(
					$loggedin_user->name,
					$group->name,
					$site->name,
					$text,
					$site->name,
					elgg_get_site_url() . "register",
					elgg_get_site_url() . "groups/invitations/?invitecode=" . $invite_code,
					$invite_code)
				);
				
				$result = elgg_send_email($site_from, $email, $subject, $body);
			} else {
				$result = null;
			}
		}
		
		return $result;
	}

	function group_tools_verify_group_members($group_guid, $user_guids){
		$result = false;
		
		if(!empty($group_guid) && !empty($user_guids)){
			if(!is_array($user_guids)){
				$user_guids = array($user_guids);
			}
			
			if(($group = get_entity($group_guid)) && ($group instanceof ElggGroup)){
				$options = array(
					"type" => "user",
					"limit" => false,
					"relationship" => "member",
					"relationship_guid" => $group->getGUID(),
					"inverse_relationship" => true,
					"callback" => "group_tools_guid_only_callback"
				);
				
				if($member_guids = elgg_get_entities_from_relationship($options)){
					$result = array();
					
					foreach($user_guids as $user_guid){
						if(in_array($user_guid, $member_guids)){
							$result[] = $user_guid;
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	function group_tools_guid_only_callback($row){
		return (int) $row->guid;
	}
	
	/**
	 * Check if group creation is limited to site administrators
	 * Also this function caches the result
	 *
	 * @return boolean
	 */
	function group_tools_is_group_creation_limited(){
		static $result;
		
		if(!isset($result)){
			$result = false;
			
			if(elgg_get_plugin_setting("admin_create", "group_tools") == "yes"){
				$result = true;
			}
		}
		
		return $result;
	}
	
	function group_tools_get_invited_groups_by_email($email, $site_guid = 0){
		$result = false;
		
		if(!empty($email)){
			$dbprefix = elgg_get_config("dbprefix");
			$site_secret = get_site_secret();
			$email = sanitise_string($email);
			
			$email_invitation_id = add_metastring("email_invitation");
			
			if($site_guid === 0){
				$site_guid = elgg_get_site_entity()->getGUID();
			}
			
			$options = array(
				"type" => "group",
				"limit" => false,
				"site_guids" => $site_guid,
				"joins" => array(
					"JOIN " . $dbprefix . "annotations a ON a.owner_guid = e.guid",
					"JOIN " . $dbprefix . "metastrings msv ON a.value_id = msv.id"
				),
				"wheres" => array(
					"(a.name_id = " . $email_invitation_id . " AND msv.string = md5(CONCAT('" . $site_secret . $email . "', e.guid)))"
				)
			);
			
			// make sure we can see all groups
			$ia = elgg_set_ignore_access(true);
			
			if($groups = elgg_get_entities($options)){
				$result = $groups;
			}
			
			// restore access
			elgg_set_ignore_access($ia);
		}
		
		return $result;
	}
	
	function group_tools_generate_email_invite_code($group_guid, $email){
		$result = false;
		
		if(!empty($group_guid) && !empty($email)){
			// get site secret
			$site_secret = get_site_secret();
			
			// generate code
			$result = md5($site_secret . $email . $group_guid);
		}
		
		return $result;
	}
	
	function group_tools_get_missing_acl_users($group_guid = 0){
		$dbprefix = elgg_get_config("dbprefix");
		$group_guid = sanitise_int($group_guid, false);
		
		$query = "SELECT ac.id AS acl_id, ac.owner_guid AS group_guid, er.guid_one AS user_guid";
		$query .= " FROM " . $dbprefix . "access_collections ac";
		$query .= " JOIN " . $dbprefix . "entities e ON e.guid = ac.owner_guid";
		$query .= " JOIN " . $dbprefix . "entity_relationships er ON ac.owner_guid = er.guid_two";
		$query .= " JOIN " . $dbprefix . "entities e2 ON er.guid_one = e2.guid";
		$query .= " WHERE";
		
		if($group_guid > 0){
			// limit to the provided group
			$query .= " e.guid = " . $group_guid;
		} else {
			// all groups
			$query .= " e.type = 'group'";
		}
		
		$query .= " AND e2.type = 'user'";
		$query .= " AND er.relationship = 'member'";
		$query .= " AND er.guid_one NOT IN";
		$query .= " (";
		$query .= " SELECT acm.user_guid";
		$query .= " FROM " . $dbprefix . "access_collections ac2";
		$query .= " JOIN " . $dbprefix . "access_collection_membership acm ON ac2.id = acm.access_collection_id";
		$query .= " WHERE ac2.owner_guid = ac.owner_guid";
		$query .= " )";
		
		return get_data($query);
	}
	
	function group_tools_get_excess_acl_users($group_guid = 0){
		$dbprefix = elgg_get_config("dbprefix");
		$group_guid = sanitise_int($group_guid, false);
		
		$query = "SELECT ac.id AS acl_id, ac.owner_guid AS group_guid, acm.user_guid AS user_guid";
		$query .= " FROM " . $dbprefix . "access_collections ac";
		$query .= " JOIN " . $dbprefix . "access_collection_membership acm ON ac.id = acm.access_collection_id";
		$query .= " JOIN " . $dbprefix . "entities e ON ac.owner_guid = e.guid";
		$query .= " WHERE";
		
		if($group_guid > 0){
			// limit to the provided group
			$query .= " e.guid = " . $group_guid;
		} else {
			// all groups
			$query .= " e.type = 'group'";
		}
		
		$query .= " AND acm.user_guid NOT IN";
		$query .= " (";
		$query .= " SELECT r.guid_one";
		$query .= " FROM " . $dbprefix . "entity_relationships r";
		$query .= " WHERE r.relationship = 'member'";
		$query .= " AND r.guid_two = ac.owner_guid";
		$query .= " )";
		
		return get_data($query);
	}
	
	function group_tools_get_groups_without_acl(){
		$dbprefix = elgg_get_config("dbprefix");
		
		$options = array(
			"type" => "group",
			"limit" => false,
			"wheres" => array("e.guid NOT IN (
				SELECT ac.owner_guid
				FROM " . $dbprefix . "access_collections ac
				JOIN " . $dbprefix . "entities e ON ac.owner_guid = e.guid
				WHERE e.type = 'group'
				)")
		);
		
		return elgg_get_entities($options);
	}
	
	/**
	 * Remove a user from an access collection,
	 * can't use remove_user_from_access_collection() because user might not exists any more
	 *
	 * @param int $user_guid
	 * @param int $collection_id
	 * @return boolean
	 */
	function group_tools_remove_user_from_access_collection($user_guid, $collection_id){
		$collection_id = sanitise_int($collection_id, false);
		$user_guid = sanitise_int($user_guid, false);
		
		$collection = get_access_collection($collection_id);
	
		if (empty($user_guid) || !$collection) {
			return false;
		}
	
		$params = array(
			"collection_id" => $collection_id,
			"user_guid" => $user_guid
		);
	
		if (!elgg_trigger_plugin_hook("access:collections:remove_user", "collection", $params, true)) {
			return false;
		}
	
		$dbprefix = elgg_get_config("dbprefix");
		
		$query = "DELETE";
		$query .= " FROM " . $dbprefix . "access_collection_membership";
		$query .= " WHERE access_collection_id = " . $collection_id;
		$query .= " AND user_guid = " . $user_guid;
	
		return (bool) delete_data($query);
	}
	
	/**
	 * Custom callback to save memory and queries for group admin transfer
	 *
	 * @param stdClass $row from elgg_get_* function
	 * @return array
	 */
	function group_tool_admin_transfer_callback($row) {
		return array(
			"guid" => (int) $row->guid,
			"name" => $row->name
		);
	}
	
	function group_tools_allow_members_invite(ElggGroup $group) {
		$result = false;
		
		if (!empty($group) && elgg_instanceof($group, "group")) {
			// only for group members
			if ($group->isMember(elgg_get_logged_in_user_entity())) {
				// is this even allowed
				if (($setting = elgg_get_plugin_setting("invite_members", "group_tools")) && in_array($setting, array("yes_off", "yes_on"))) {
					$invite_members = $group->invite_members;
					if (empty($invite_members)) {
						$invite_members = "no";
						if ($setting == "yes_on") {
							$invite_members = "yes";
						}
					}
					
					if ($invite_members == "yes") {
						$result = true;
					}
				}
			}
		}
		
		return $result;
	}
	
	/**
	 * Custom annotations delete function because logged out users can't delete annotations
	 *
	 * @param array $annotations
	 */
	function group_tools_delete_annotations($annotations) {
	
		if (!empty($annotations) && is_array($annotations)) {
			$dbprefix = elgg_get_config("dbprefix");
				
			foreach ($annotations as $annotation) {
				if (elgg_trigger_event("delete", "annotation", $annotation)) {
					delete_data("DELETE from {$dbprefix}annotations where id=" . $annotation->id);
				}
			}
		}
	}

	/**
	 * Returns suggested groups
	 *
	 */
	function group_tools_get_suggested_groups($user = null, $limit = null) {
		$result = array();
		
		if (!elgg_instanceof($user, "user")) {
			$user = elgg_get_logged_in_user_entity();
		}
		
		if (is_null($limit)) {
			$limit = get_input("limit", 10);
		}
		$limit = sanitize_int($limit, false);
		
		if ($user && ($limit > 0)) {
			
			$dbprefix = elgg_get_config("dbprefix");
			$group_membership_where = "e.guid NOT IN (SELECT er.guid_two FROM {$dbprefix}entity_relationships er where er.guid_one = {$user->getGUID()} and er.relationship IN ('member', 'membership_request'))";

			if (elgg_get_plugin_setting("auto_suggest_groups","group_tools") !== "no") {
				$tag_names = elgg_get_registered_tag_metadata_names();
				if (!empty($tag_names)) {
					$user_metadata_options = array(
							"guid" => $user->getGUID(),
							"limit" => false,
							"metadata_names" => $tag_names
						);
					
					// get metadata
					$user_values = elgg_get_metadata($user_metadata_options);
					
					if (!empty($user_values)) {
						// transform to values
						$user_values = metadata_array_to_values($user_values);
						
						// find group with these metadatavalues
						$group_options = array(
							"type" => "group",
							"metadata_names" => $tag_names,
							"metadata_values" => $user_values,
							"wheres" => $group_membership_where,
							"group_by" => "e.guid",
							"order_by" => "count(msn.id) DESC",
							"limit" => $limit
						);
						
						$groups = elgg_get_entities_from_metadata($group_options);
						foreach ($groups as $group) {
							$result[$group->getGUID()] = $group;
							$limit--;
						}
					}
				}
			}
			
			// get admin defined suggested groups
			$group_guids = string_to_tag_array(elgg_get_plugin_setting("suggested_groups","group_tools"));
			if (!empty($group_guids) && ($limit > 0)) {
				$group_options = array(
						"guids" => $group_guids,
						"type" => "group",
						"wheres" => array($group_membership_where),
						"limit" => $limit
				);
				
				if (!empty($result)) {
					$suggested_guids = array_keys($result);
					$group_options["wheres"][] = "e.guid NOT IN (" . implode(",", $suggested_guids) . ")";
				}
				
				$groups = elgg_get_entities($group_options);
				foreach ($groups as $group) {
					$result[$group->getGUID()] = $group;
				}
			}
		}
		
		return $result;
	}
	