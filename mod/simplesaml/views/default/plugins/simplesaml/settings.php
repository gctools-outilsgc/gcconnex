<?php

elgg_require_js('simplesaml/settings');

$plugin = elgg_extract('entity', $vars);

// path to simplesaml
$path = elgg_echo('simplesaml:settings:simplesamlphp_path');
$path .= elgg_view('input/text', [
	'name' => 'params[simplesamlphp_path]',
	'value' => $plugin->simplesamlphp_path,
]);
$path .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:simplesamlphp_path:description'));
echo elgg_format_element('div', [], $path);

// URI to simplesaml
$uri = elgg_echo('simplesaml:settings:simplesamlphp_directory');
$uri .= elgg_view('input/text', [
	'name' => 'params[simplesamlphp_directory]',
	'value' => $plugin->simplesamlphp_directory,
]);
$uri .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:simplesamlphp_directory:description', [elgg_get_site_url()]));
echo elgg_format_element('div', [], $uri);

// can we load SimpleSAMLPHP
if (!is_callable('simplesaml_get_configured_sources')) {
	// SimpleSAMLPHP is not yet loaded
	echo elgg_format_element('div', [], elgg_echo('simplesaml:settings:warning:configuration:simplesamlphp'));
	return;
}

// list all the configured service provider configs
$sources = simplesaml_get_configured_sources();
$souces_title = elgg_echo('simplesaml:settings:sources');

if (!empty($sources)) {
	$enabled_sources = [];
	$first_source = true;
	
	$content = '<table class="elgg-table mbm" id="simplesaml-settings-sources">';
	
	$content .= '<tr>';
	$content .= elgg_format_element('th', ['class' => 'center'], elgg_echo('enable'));
	$content .= elgg_format_element('th', [], elgg_echo('simplesaml:settings:sources:name'));
	$content .= elgg_format_element('th', [], elgg_echo('simplesaml:settings:sources:type'));
	$content .= elgg_format_element('th', ['class' => 'center'], elgg_echo('simplesaml:settings:sources:allow_registration'));
	$content .= elgg_format_element('th', ['class' => 'center'], elgg_echo('simplesaml:settings:sources:auto_create_accounts'));
	$content .= elgg_format_element('th', ['class' => 'center'], elgg_echo('simplesaml:settings:sources:save_attributes'));
	$content .= elgg_format_element('th', ['class' => 'center'], elgg_echo('simplesaml:settings:sources:force_authentication'));
	$content .= elgg_format_element('th', ['class' => 'center'], elgg_echo('simplesaml:settings:sources:remember_me'));
	$content .= '</tr>';
	
	foreach ($sources as $source) {
		
		$source_auth_id = $source->getAuthId();
		$enabled = false;
		$source_type_label = '';
		
		// check class for correct label
		switch (get_class($source)) {
			case 'sspmod_saml_Auth_Source_SP':
				$source_type = 'saml';
				$source_type_label = elgg_echo('simplesaml:source:type:saml');
				break;
			case 'sspmod_cas_Auth_Source_CAS':
				$source_type = 'cas';
				$source_type_label = elgg_echo('simplesaml:source:type:cas');
				break;
			default:
				$source_type = false;
				$source_type_label = elgg_echo('simplesaml:source:type:unknown');
				break;
		}
		
		if ($plugin->getSetting("{$source_auth_id}_enabled")) {
			$enabled = true;
			
			if ($source_type !== false) {
				if (!isset($enabled_sources[$source_type])) {
					$enabled_sources[$source_type] = [];
				}
				
				$enabled_sources[$source_type][] = $source_auth_id;
			}
		}
		
		$content .= elgg_view('simplesaml/settings/service_provider_basic', [
			'plugin' => $plugin,
			'source' => $source,
			'first_source' => $first_source,
			'enabled' => $enabled,
			'source_type_label' => $source_type_label,
		]);
		
		// set a flag so we know we had at least 1 source
		$first_source = false;
	}
	
	$content .= '</table>';
	
	echo elgg_view_module('inline', $souces_title, $content);
	
	// settings for enabled sources
	if (!empty($enabled_sources)) {
		// build options to automaticly link accounts based on profile information
		$auto_link_options = [
			'0' => elgg_echo('simplesaml:settings:sources:configuration:auto_link:none'),
			'username' => elgg_echo('username'),
			'email' => elgg_echo('email'),
		];
		// add profile fields
		$profile_fields = elgg_get_config('profile_fields');
		if (!empty($profile_fields) && is_array($profile_fields)) {
			foreach ($profile_fields as $name => $type) {
				$profile_label = $name;
				
				if (elgg_language_key_exists("profile:{$name}")) {
					$profile_label = elgg_echo("profile:{$name}");
				}
				
				$auto_link_options[$name] = $profile_label;
			}
		}
		
		$access_type_options = [
			'allow' => elgg_echo('simplesaml:settings:sources:configuration:access_type:allow'),
			'deny' => elgg_echo('simplesaml:settings:sources:configuration:access_type:deny'),
		];
		
		$access_matching_options = [
			'exact' => elgg_echo('simplesaml:settings:sources:configuration:access_matching:exact'),
			'regex' => elgg_echo('simplesaml:settings:sources:configuration:access_matching:regex'),
		];
		
		// enabled sources are grouped by type
		foreach ($enabled_sources as $source_type => $sources) {
			// make sure we have sources of this type
			if (empty($sources) || !is_array($sources)) {
				continue;
			}
			
			// go through all sources of this type
			foreach ($sources as $source_id) {
				echo elgg_view('simplesaml/settings/service_provider_advanced', [
					'plugin' => $plugin,
					'source_id' => $source_id,
					'source_id_type' => $source_type,
					'auto_link_options' => $auto_link_options,
					'access_type_options' => $access_type_options,
					'access_matching_options' => $access_matching_options,
				]);
			}
		}
	}
} else {
	// SimpleSAMLPHP is not yet configured for service providers
	$content = elgg_view('output/longtext', [
		'value' => elgg_echo('simplesaml:settings:warning:configuration:sources'),
	]);
	
	echo elgg_view_module('inline', $souces_title, $content);
}

// list all the IDP configurations
$idp_configurations = simplesaml_get_configured_idp_sources();

if (!empty($idp_configurations)) {
	
	foreach ($idp_configurations as $idp) {
		
		echo elgg_view('simplesaml/settings/identity_provider', [
			'plugin' => $plugin,
			'idp' => $idp,
		]);
	}
}
