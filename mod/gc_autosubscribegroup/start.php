<?php

/**
 * Elgg autosubscribegroup plugin
 * Allows admins to select groups for new users to automatically join
 *
 * @package autosubscribegroups
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author RONNEL Jérémy
 * @author Mark Wooff <mark.wooff@tbs-sct.gc.ca>
 * @copyright (c) Elbee 2008
 * @link /www.notredeco.com
 *
 * for Elgg 1.9 onwards by iionly (iionly@gmx.de)
 */

/**
 * Init
 */
elgg_register_event_handler('init', 'system', 'gc_autosubscribegroup_init');

function gc_autosubscribegroup_init() {
	// Listen to user registration
	elgg_register_event_handler('create', 'user', 'gc_autosubscribegroup_join', 502);
	elgg_register_event_handler('create', 'group', 'gc_autosubscribegroup_create', 502);

	elgg_register_ajax_view("organization_form/form");
}

/**
 * Autosubscribe new users upon registration
 * Autosubscribe new users by organization upon registration
 */
function gc_autosubscribegroup_join($event, $object_type, $object) {
	if( ($object instanceof ElggUser) && ($event == 'create') && ($object_type == 'user') ){
		//retrieve group ids from plugin
		$autogroups = elgg_get_plugin_setting('autogroups', 'gc_autosubscribegroup');
		$autogroups = split(',', $autogroups);

		//for each group id
		foreach($autogroups as $group){
			$ia = elgg_set_ignore_access(true);
			$groupEnt = get_entity($group);
			elgg_set_ignore_access($ia);
			//if group exists, submit to group
			if( $groupEnt ){
				//join group succeed?
				if( $groupEnt->join($object) ){
					add_entity_relationship($object->guid, 'cp_subscribed_to_email', $groupEnt->guid);
					add_entity_relationship($object->guid, 'cp_subscribed_to_site_mail', $groupEnt->guid);

					// Remove any invite or join request flags
					elgg_delete_metadata(array('guid' => $object->guid, 'metadata_name' => 'group_invite', 'metadata_value' => $groupEnt->guid, 'limit' => false));
					elgg_delete_metadata(array('guid' => $object->guid, 'metadata_name' => 'group_join_request', 'metadata_value' => $groupEnt->guid, 'limit' => false));
				}
			}
		}

		//retrieve group ids from plugin
		$organizationgroups = elgg_get_plugin_setting('organizationgroups', 'gc_autosubscribegroup');
		$organizationgroups = json_decode($organizationgroups, true);

		$meta_fields = array('user_type', 'federal', 'institution', 'university', 'college', 'provincial', 'ministry', 'municipal', 'international', 'ngo', 'community', 'business', 'media', 'retired', 'other');
		foreach($meta_fields as $field){
			$$field = get_input($field);
		}

		//for each group id
		foreach($organizationgroups as $group => $organizations){
			$ia = elgg_set_ignore_access(true);
			$groupEnt = get_entity($group);
			elgg_set_ignore_access($ia);

			foreach($organizations as $value){
				$match = false;
				$user_type2 = $institution2 = $organization2 = "";
				if( is_array($value) ){
					$user_type2 = array_keys($value)[0];
					$organization2 = array_values($value)[0];
				}
				if( is_array($organization2) ){
					$temp = $organization2;
					$institution2 = array_keys($temp)[0];
					$organization2 = array_values($temp)[0];
				}
				
				if( $user_type == $user_type2 ){
					if( empty(trim($organization2)) ){
						$match = true;
					} else if( $$user_type == trim($organization2) ){
						$match = true;
					} else if( $institution == $institution2 ){
						if($university == $organization2 || $college == $organization2){
							$match = true;
						}
					} else if( $provincial == $institution2 ){
						if($ministry == $organization2){
							$match = true;
						}
					}
					if( $match ){
						if( $groupEnt ){
							//join group succeed?
							if( $groupEnt->join($object) ){
								add_entity_relationship($object->guid, 'cp_subscribed_to_email', $groupEnt->guid);
								add_entity_relationship($object->guid, 'cp_subscribed_to_site_mail', $groupEnt->guid);

								// Remove any invite or join request flags
								elgg_delete_metadata(array('guid' => $object->guid, 'metadata_name' => 'group_invite', 'metadata_value' => $groupEnt->guid, 'limit' => false));
								elgg_delete_metadata(array('guid' => $object->guid, 'metadata_name' => 'group_join_request', 'metadata_value' => $groupEnt->guid, 'limit' => false));
							}
						}
					}
				}
			}
		}
	}
}

/**
 * Autosubscribe group admins upon group creation
 */
function gc_autosubscribegroup_create($event, $object_type, $object) {
	if( ($object instanceof ElggGroup) && ($event == 'create') && ($object_type == 'group') ){
		//retrieve group ids from plugin
		$groups = elgg_get_plugin_setting('admingroups', 'gc_autosubscribegroup');
		$groups = split(',', $groups);

		//for each group id
		foreach($groups as $groupId){
			$ia = elgg_set_ignore_access(true);
			$groupEnt = get_entity($groupId);
			elgg_set_ignore_access($ia);
			$userEnt = get_user($object->owner_guid);
			//if group exists, submit to group
			if( $groupEnt ){
				//join group succeed?
				if( $groupEnt->join($userEnt) ){
					add_entity_relationship($userEnt->guid, 'cp_subscribed_to_email', $groupEnt->guid);
					add_entity_relationship($userEnt->guid, 'cp_subscribed_to_site_mail', $groupEnt->guid);

					// Remove any invite or join request flags
					elgg_delete_metadata(array('guid' => $userEnt->guid, 'metadata_name' => 'group_invite', 'metadata_value' => $groupEnt->guid, 'limit' => false));
					elgg_delete_metadata(array('guid' => $userEnt->guid, 'metadata_name' => 'group_join_request', 'metadata_value' => $groupEnt->guid, 'limit' => false));
				}
			}
		}
	}
}
