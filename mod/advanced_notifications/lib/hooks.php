<?php

	function advanced_notifications_route_hook($hooks, $type, $return_value, $params) {
		
		if (advanced_notifications_replace_site_notifications()) {
			$page = elgg_extract("segments", $return_value);
		
			if (!empty($page)) {
					
				switch ($page[0]) {
					case "notifications":
					case "groups":
						if (elgg_is_logged_in()) {
							elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
							set_input("page_type", $page[0]);
		
							require_once(dirname(dirname(__FILE__)) . "/pages/river.php");
							return false;
						} else {
							forward("activity");
						}
						break;
				}
			}
		}
	}
	
	function advanced_notifications_filter_menu_hook($hooks, $type, $return_value, $params) {
		$result = $return_value;
	
		if (advanced_notifications_replace_site_notifications()) {
			if (elgg_is_logged_in() && elgg_in_context("activity")) {
				// add new items
				if (elgg_is_active_plugin("groups")) {
					$result[] = ElggMenuItem::factory(array(
						"text" => elgg_echo("advanced_notifications:activity:groups"),
						"href" => "activity/groups",
						"name" => "groups",
						"contexts" => array("activity"),
						"priority" => 900,
						"title" => elgg_echo("advanced_notifications:activity:groups:info")
					));
				}
					
				if (elgg_is_active_plugin("messages")) {
					$result[] = ElggMenuItem::factory(array(
						"text" => elgg_echo("advanced_notifications:activity:notifications"),
						"href" => "activity/notifications",
						"name" => "notifications",
						"contexts" => array("activity"),
						"priority" => 910,
						"title" => elgg_echo("advanced_notifications:activity:notifications:info")
					));
				}
			}
		}
	
		return $result;
	}
	
	/**
	 * Return a new subject for group discussion replies
	 *
	 * @param string $hooks
	 * @param string $type
	 * @param string $return_value
	 * @param array $params
	 * @return string
	 */
	function advanced_notifications_discussion_reply_subject_hook($hooks, $type, $return_value, $params) {
		
		return elgg_echo("advanced_notifications:discussion:reply:subject");
	}
	
	/**
	 * Replace the message body of the notification with an url to the content (default behaviour)
	 *
	 * @param string $hooks
	 * @param string $type
	 * @param string $return_value
	 * @param array $params
	 * @return string
	 */
	function advanced_notifications_email_body_hook($hooks, $type, $return_value, $params) {
		$result = $return_value;
		
		if (!empty($params) && is_array($params)) {
			$method = elgg_extract("method", $params);
			
			// only replace email body
			if (!empty($method) && ($method == "email")) {
				// get the entity or annotation for the body
				$entity = elgg_extract("entity", $params);
				$annotation = elgg_extract("annotation", $params);
				
				if (!empty($entity) || !empty($annotation)) {
					// check if we need to replace the message
					if (advanced_notifications_no_mail_content()) {
						if (empty($entity) && !empty($annotation)) {
							// we have a comment on a discussion
							$entity = $annotation->getEntity();
						}
						
						// return the url to the entity
						$result = elgg_echo("advanced_notifications:notification:email:body", array($entity->getURL()));
					}
				}
			}
		}
		
		return $result;
	}
	
	/**
	 * In case we choose to replace the email body content, overrule the default action
	 *
	 * @param string $hooks
	 * @param string $type
	 * @param boolean $return_value
	 * @param array $params
	 * @return boolean
	 */
	function advanced_notifications_comment_action_hook($hooks, $type, $return_value, $params) {
		$result = $return_value;
		
		if (advanced_notifications_no_mail_content()) {
			// we'll take over because no mail content may leave the site
			$result = false;
			
			include(dirname(dirname(__FILE__)) . "/actions/comments/add.php");
		}
		
		return $result;
	}