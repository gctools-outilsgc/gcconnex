<?php
require_once __DIR__ . '/vendor/autoload.php';
use EUAutomation\GraphQL\Client;

elgg_register_event_handler('init', 'system', 'paas_integration_init');

function paas_integration_init() {

    elgg_register_action("avatar/upload", elgg_get_plugins_path() . "paas_integration/actions/avatar/upload.php");
    elgg_register_plugin_hook_handler("action", "b_extended_profile/edit_profile", "edit_profile_paas_mutation");
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
    $dev_url = elgg_get_plugin_setting("dev_url", "paas_integration");

    $session = elgg_get_session();
    $token = $session->get('token');

    $result = get_data_row("SELECT pleio_guid FROM {$dbprefix}users_entity WHERE guid = $guid");
    if ($result->pleio_guid) {
        $gcID = $result->pleio_guid;
    }

    if($dev_url){
        $site_url = $dev_url;
    } else {
        $site_url = elgg_get_site_url();
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

    $variables = array(
        'gcID' => $gcID,
        'data' => array(
            'name' => $profile_fields['name'],
            'titleEn' => copy_value_to_object_if_defined('job', $profile_fields['job']),
            'titleFr' => copy_value_to_object_if_defined('jobfr', $profile_fields['jobfr']),
            'mobilePhone' => copy_value_to_object_if_defined('mobile', $profile_fields['mobile']),
            'officePhone' => copy_value_to_object_if_defined('phone', $profile_fields['phone']),
            'address' => array(
                'streetAddress' => $profile_fields['streetaddress'],
                'city' => $profile_fields['city'],
                'province' => $profile_fields['province'],
                'postalCode' => $profile_fields['postalcode'],
                'country' => $profile_fields['country'],
            )
        )
    );
    
    // Send data to PaaS
    $response = $client->response($query, $variables, $headers);

    // Error check
    if($response->errors()){
        return false;
    }

    // Mutation has gone through
    return true;
  }

  function copy_value_to_object_if_defined($field, $value){
    if($value != null && $value != "undefined"){
        return $value;
    } else {
        return null;
    }
  }