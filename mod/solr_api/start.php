<?php
/* File: .../solr_api/start.php
 *
 * REFERENCE: http://learn.elgg.org/en/stable/guides/web-services.html#api-authentication
 * To get the API Key, web services must be enabled: Admin > Web Services > Create API Keys
 * Please note that the API calls will display limit of 10
 *
 * Author: Christine Yu <internalfire5@live.com>
 * Company: Government of Canada
 * Date: June 1st 2018
 *
 */


elgg_register_event_handler('init','system','solr_api_init');

function solr_api_init() {

	//$method, $function, array $parameters = NULL, $description = "",
	//	$call_method = "GET", $require_api_auth = false, $require_user_auth = false

	elgg_ws_expose_function(
		'delete.updated_index_list',
		'delete_updated_index_list',
		[
			'guids' => [
				'type' => 'array',
				'required' => false,
				'description' => 'deletes records based on collection of entity guids'
			]
		],
		'deletes record that already updated the solr index',
		'POST',
		true,
		false
	);


	elgg_ws_expose_function(
        'get.entity_list',
        'get_entity_list',
        [
            'type' => [
                'type' => 'string',
                'required' => true,
                'description' => 'the type of entity in string format',
            ],
            'subtype' => [
                'type' => 'string',
                'required' => false,
                'description' => 'the subtype of entity in string format, not required',
            ],
			'offset' => [
                'type' => 'int',
                'required' => true,
                'description' => 'the subtype of entity in string format, not required',
            ],

        ],
        'retrieves all entities filtered by type [and subtype]',
        'GET',
        true,
        false
	);


	elgg_ws_expose_function(
        'get.user_list',
        'get_user_list',
        [
        	'offset' => [
        		'type' => 'int',
        		'required' => true,
        		'description' => 'paging mechanism'
        	]
        ],
        'retrieves a user list',
        'GET',
        true,
        false
	);

	elgg_ws_expose_function(
        'get.group_list',
        'get_group_list',
        [
        	'offset' => [
        		'type' => 'int',
        		'required' => true,
        		'description' => 'api loads 20 groups at a time'
        	]
        ],
        'retrieves a group list',
        'GET',
        true,
        false
	);


	elgg_ws_expose_function(
		'get.list_of_deleted_records',
		'get_list_of_deleted_records',
		null,
		'retrieves a list of deleted content',
		'GET',
		true,
		false
	);
}


function delete_updated_index_list($guids) {
	$ids = array();
	foreach ($guids as $guid) {
		// guid must be an integer
		if (is_numeric($guid)) 
			$ids[] = $guid;
		else
			return "there is an issue deleting a record in the database, please see function delete_updated_index_list()";
	}

	if (sizeof($ids) > 0) {
		$ids = implode(",", $ids);
		$query = "DELETE FROM deleted_object_tracker WHERE id IN ({$ids})";
		$result = delete_data($query);
	}

	$arr[] = array('message' => 'deleted the following guid');
	$arr[] = $ids;

	return $arr;
}


// this is not an api call, this is a hook that will initiate once user attempts deletion
function intercept_object_deletion($event, $type, $object) {
	$unixtime = time();

	$query = "INSERT INTO deleted_object_tracker (id, time_deleted) VALUES ({$object->guid}, {$unixtime})";

	// just in case for some reason, the user is able to delete the same thing twice
	try {
		$insert_record = insert_data($query);
	} catch (Exception $e) {
		error_log("error occurred: {$e}");
	}

	$query = "SELECT * FROM deleted_object_tracker";
	$deleted_records = get_data($query);

	return true;
}


function get_list_of_deleted_records() {
	$query = "SELECT * FROM deleted_object_tracker";
	$deleted_records = get_data($query);

	foreach ($deleted_records as $deleted_record) {
		$arr[] = array(
			'guid' => $deleted_record->id,
			'time_deleted' => $deleted_record->time_deleted
		);
	}
	return $arr;
}


function get_user_list($offset) {
	// @TODO check if the site url is either localhost or local ip address, replace with elgg if it is
	$site_url = elgg_get_site_url();
	$platform = explode('.', $site_url);
	$db_prefix = elgg_get_config('dbprefix');

	$query = "	SELECT e.guid, ue.name, ue.username, ue.email, e.type, e.time_created, e.enabled
				FROM {$db_prefix}users_entity ue 
					LEFT JOIN {$db_prefix}entities e ON ue.guid = e.guid 
				WHERE e.enabled = 'yes'
				LIMIT 10 OFFSET {$offset}";

	$users = get_data($query);

	foreach ($users as $user) {
		$arr[] = array (
			'guid' => $user->guid,
			'name' => array('en' => $user->name, 'fr' => $user->name),
			'username' => $user->username,
			'email' => $user->email,
			'type' => $user->type,
			'date_created' => date("Y-m-d\TH:m:s\Z", $user->time_created),
			'date_modified' => date("Y-m-d\TH:m:s\Z", $user->time_created),
			'url' => "{$site_url}profile/{$user->username}",
			'platform' => $platform[0]
		);
	}
    return $arr;
}


function get_group_list($offset) {
	// @TODO use SQL query syntax instead of using function elgg_get_entities()
	$site_url = elgg_get_site_url();
	$platform = explode('.', $site_url);

	$groups = elgg_get_entities(array(
		'type' => 'group',
		'limit' => 10,
		'offset' => $offset
	));

	foreach ($groups as $group) {

		if (is_Json($group->name)) {
			$name_array = json_decode($group->name, true);
			$name_array['en'] = str_replace('"', '\"', $name_array['en']);
			$name_array['fr'] = str_replace('"', '\"', $name_array['fr']);
		} else {
			$name_array['en'] = $group->name_array;
			$name_array['fr'] = $group->name;
		}

		if (is_Json($group->description)) {
			$description_array = json_decode($group->description, true);
			$description_array['en'] = str_replace('"', '\"', $description_array['en']);
			$description_array['fr'] = str_replace('"', '\"', $description_array['fr']);
		} else {
			$description_array['en'] = $group->description;
			$description_array['fr'] = $group->description;
		}

		$arr[] = array(
			'guid' => $group->getGUID(),
			'name' => $name_array,
			'description' => $description_array,
			'type' => $group->getType(),
			'access_id' => $group->access_id,
			'date_created' => date("Y-m-d\TH:m:s\Z", $group->time_created),
			'date_modified' => date("Y-m-d\TH:m:s\Z", $group->time_updated),
			'url' => $group->getURL(),
			'platform' => $platform[0]
		);
	}
    return $arr;
}


function get_entity_list($type, $subtype, $offset) {
	$site_url = elgg_get_site_url();
	$platform = explode('.', $site_url);
	$entities = elgg_get_entities(array(
		'type' => $type,
		'subtype' => $subtype,
		'limit' => 10,
		'offset' => $offset
	));

	foreach ($entities as $entity) {
		
		if (is_Json($entity->title)) {
			$title_array['en'] = str_replace('"', '\"', gc_explode_translation($entity->title, 'en'));
			$title_array['fr'] = str_replace('"', '\"', gc_explode_translation($entity->title, 'fr'));
		} else {
			$title_array['en'] = $entity->title;
			$title_array['fr'] = $entity->title;
		}

		if (is_Json($entity->description)) {
			$description_array['en'] = str_replace('"', '\"', gc_explode_translation($entity->description, 'en'));
			$description_array['fr'] = str_replace('"', '\"', gc_explode_translation($entity->description, 'fr'));
		} else {
			$description_array['en'] = $entity->description;
			$description_array['fr'] = $entity->description;
		}

		$arr[] = array(
			'guid' => $entity->getGUID(), 
			'title' => $title_array,
			'description' => $description_array,
			'type' => $entity->getType(),
			'subtype' => $entity->getSubtype(),
			'access_id' => $entity->access_id,
			'date_created' => date("Y-m-d\TH:m:s\Z", $entity->time_created),
			'date_modified' => date("Y-m-d\TH:m:s\Z", $entity->time_updated),
			'url' => $entity->getURL(),
			'platform' => $platform[0]
		);
	}

	return $arr;
}


// @TODO check if this function already exist in other modules
function is_Json($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

