<?php
require_once __DIR__ . '/vendor/autoload.php';
use EUAutomation\GraphQL\Client;

elgg_register_event_handler('init', 'system', 'paas_integration_init');

function paas_integration_init() {

    elgg_register_action("avatar/upload", elgg_get_plugins_path() . "paas_integration/actions/avatar/upload.php");
    elgg_register_plugin_hook_handler("action", "b_extended_profile/edit_profile", "edit_profile_paas_mutation");

    elgg_register_action('b_extended_profile/edit_profile', elgg_get_plugins_path() . 'paas_integration/actions/b_extended_profile/edit_profile.php');
}

/**
 * Send modifyProfile mutation to PaaS
 *
 * @return bool
 */
function edit_profile_paas_mutation($hook, $entity_type, $returnvalue, $params) {
    $guid = get_input('guid');
    $owner = get_entity($guid);

    $dbprefix = elgg_get_config("dbprefix");
    $service_url = elgg_get_plugin_setting("graphql_client", "paas_integration");

    $session = elgg_get_session();
    $token = $session->get('token');

    $result = get_data_row("SELECT pleio_guid FROM {$dbprefix}users_entity WHERE guid = $guid");
    if ($result->pleio_guid) {
        $gcID = $result->pleio_guid;
    }

    $client = new Client($service_url);

    $headers = [
        "Authorization" => "Bearer $token"
    ];

    $query = 'mutation ($gcID: ID!, $data: ModifyProfileInput!) {
        modifyProfile(gcID: $gcID, data: $data) {
            gcID
            name
            email
            titleEn
            titleFr
            avatar
            mobilePhone
            officePhone
            address {
                streetAddress
                city
                postalCode
                province
                country
            }
        }
    }';

    $profile_fields = get_input('profile');

    $address = array(
        'streetAddress' => copy_value_to_object_if_defined($profile_fields['streetaddress']),
        'city' => copy_value_to_object_if_defined($profile_fields['city']),
        'province' => copy_value_to_object_if_defined($profile_fields['province']),
        'postalCode' => copy_value_to_object_if_defined($profile_fields['postalcode']),
        'country' => copy_value_to_object_if_defined($profile_fields['country']),
    );

    $variables = array(
        'gcID' => $gcID,
        'data' => array(
            'name' => $profile_fields['name'],
            'titleEn' => copy_value_to_object_if_defined('job', $profile_fields['job']),
            'titleFr' => copy_value_to_object_if_defined('jobfr', $profile_fields['jobfr']),
            'mobilePhone' => copy_value_to_object_if_defined('mobile', $profile_fields['mobile']),
            'officePhone' => copy_value_to_object_if_defined('phone', $profile_fields['phone']),
            'address' => address_validation($address),
        )
    );
    
    // Send data to PaaS
    $response = $client->response($query, $variables, $headers);

    // Error check
    if($response->errors()){
        return false;
    }

    // Contact details
    $owner->name = $response->modifyProfile->name;
    $owner->job = $response->modifyProfile->titleEn;
    $owner->jobfr = $response->modifyProfile->titleFr;
    $owner->mobile = $response->modifyProfile->mobilePhone;
    $owner->phone = $response->modifyProfile->officePhone;

    // Address details
    $owner->streetaddress = $response->modifyProfile->address->streetAddress;
    $owner->city = $response->modifyProfile->address->city;
    $owner->province = $response->modifyProfile->address->province;
    $owner->postalcode = $response->modifyProfile->address->postalCode;
    $owner->country = $response->modifyProfile->address->country;

    $owner->save();

    // Mutation has gone through
    return true;
  }

  // Set value to null if not set
  function copy_value_to_object_if_defined($field, $value){
    if($value != null && $value != "undefined"){
        return $value;
    } else {
        return null;
    }
  }

  // Set array to null if all fields are null
  function address_validation($address) {

    foreach($address as $k => $v ) {
        if($v != null) {
            return $address;
        }
    }

    return null;
  }