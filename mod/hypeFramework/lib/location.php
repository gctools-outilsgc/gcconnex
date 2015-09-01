<?php

if (!HYPEFRAMEWORK_INTERFACE_LOCATION) {
	return true;
}

// elgg_geocode_location() hook
elgg_register_plugin_hook_handler('geocode', 'location', 'hj_framework_geocode_location');

// geocode $entity->location when created and/or updated
elgg_register_event_handler('all', 'metadata', 'hj_framework_geocode_location_metadata');

/**
 * Make use of Elgg's geocode cache
 *
 * @param str $hook 'geocode'
 * @param str $type 'location'
 * @param false|array $return false or array($lat,$long)
 * @param mixed $params
 *
 * @return array|false Array of lat,long or false if geocoding fails
 */
function hj_framework_geocode_location($hook, $type, $return, $params) {

	$location = elgg_extract('location', $params, false);

	if (!$location) {
		return false;
	}

	$params = array(
		'address' => $location,
		'sensor' => 'true'
	);

	$query = http_build_query($params);

	$url = "http://maps.googleapis.com/maps/api/geocode/json?$query";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	$data = curl_exec($curl);
	curl_close($curl);

	$data = json_decode($data, true);

	if (!is_array($data)) {
		error_log("An unknown error occured when trying to geocode '$address'");
		return false;
	}

	$status = elgg_extract('status', $data);

	switch ($status) {

		default :
			error_log("An unknown error occured when trying to geocode '$address'");
			return false;
			break;

		case 'OK' : // we have valid geocoding results
			$lat = $data['results'][0]['geometry']['location']['lat'];
			$long = $data['results'][0]['geometry']['location']['lng'];
			return array('lat' => $lat, 'long' => $long);
			break;

		case 'ZERO_RESULTS' :
			error_log("Google Maps API query for '$address' returned no results");
			return false;
			break;

		case 'OVER_QUERY_LIMIT' :
			error_log("Query limit for Google Maps API service has been exceeded");
			return false;
			break;

		case 'REQUEST_DENIED' :
			error_log("Request to Google Maps API service has been denied");
			return false;
			break;

		case 'INVALID_REQUEST' :
			error_log("Invalid request to Google Maps API service. Queary: $url");
			return false;
			break;

	}

}

/**
 * Geocode entity location and set latitude and longitude when 'location' metadata is created/updated
 *
 * @param type $event
 * @param type $type
 * @param type $metadata
 */
function hj_framework_geocode_location_metadata($event, $type, $metadata) {

	if ($metadata->name != 'location') {
		return true;
	}

	switch ($event) {

		case 'create' :
		case 'update' :
			$location = $metadata->value;
			if (is_array($location)) {
				$location = implode(', ', $location);
			}
			$coordinates = elgg_geocode_location($metadata->value);
			if ($coordinates) {
				$entity = get_entity($metadata->entity_guid);
				$entity->setLatLong($coordinates['lat'], $coordinates['long']);
			} else {
				register_error(elgg_echo('hj:framework:geocode:error'));
			}
				break;

		default :
			return true;
			break;
	}

}