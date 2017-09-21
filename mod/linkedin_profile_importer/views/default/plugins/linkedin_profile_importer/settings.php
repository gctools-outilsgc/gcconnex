<?php

elgg_load_css('linkedin.css');

$diagnostics = array(
	'php_version' => (version_compare(PHP_VERSION, '5.2.0', '>=')),
	'elgg_oauth' => (!class_exists('OAuthException')),
	'curl' => (function_exists('curl_init')),
	'json' => (function_exists('json_decode')),
	'pecl_oauth' => (!extension_loaded('oauth'))
);

foreach ($diagnostics as $requirement => $status) {
	if ($status === false) {
		echo elgg_view('linkedin/admin/diagnostics', array(
			'diagnostics' => $diagnostics
		));
		return true;
	}
}

$providers = unserialize(elgg_get_plugin_setting('providers', 'linkedin_profile_importer'));

foreach ($providers as $provider => $settings) {

	$title = elgg_view_icon(strtolower("auth-$provider")) . " " . $provider;

	$mod = '<div>';
	$mod .= '<label>' . elgg_echo('hybridauth:provider:enable') . '</label>';
	$mod .= elgg_view('input/dropdown', array(
		'name' => "providers[$provider][enabled]",
		'value' => $settings['enabled'],
		'options_values' => array(
			0 => elgg_echo('hybridauth:provider:disabled'),
			1 => elgg_echo('hybridauth:provider:enabled')
		)
	));
	$mod .= '</div>';

	if (isset($settings['keys'])) {

		foreach ($settings['keys'] as $key_name => $key_value) {
			$mod .= '<div>';
			$mod .= '<label>' . elgg_echo("hybridauth:provider:$provider:$key_name") . '</label>';
			$mod .= elgg_view('input/text', array(
				'name' => "providers[$provider][keys][$key_name]",
				'value' => $key_value,
			));
			$mod .= '</div>';
		}
	}

	$footer = '';
	if ($settings['enabled']) {

		$ha = new ElggHybridAuth();

		try {
			$adapter = $ha->getAdapter($provider);
			$scope = (isset($settings['scope'])) ? $settings['scope'] : $adapter->adapter->scope;
			if ($scope) {
				$mod .= '<div>';
				$mod .= '<label>' . elgg_echo("hybridauth:provider:scope") . '</label>';
				$mod .= elgg_view('input/text', array(
					'name' => "providers[$provider][scope]",
					'value' => $scope,
				));
				$mod .= '</div>';
			}
			$footer = '<div class="hybridauth-diagnostics-pass ptm">' . elgg_echo('hybridauth:adapter:pass') . '</div>';
		} catch (Exception $e) {
			$footer = '<div class="hybridauth-diagnostics-fail ptm">' . $e->getMessage() . '</div>';
		}
	}

	echo elgg_view_module('widget', $title, $mod, array('footer' => $footer, 'class' => 'hybridauth-provider-settings mtl'));
}

$debug_mode = elgg_get_plugin_setting('debug_mode', 'linkedin_profile_importer');

echo '<div class="mtl">';
echo '<label>' . elgg_echo('hybridauth:debug_mode') . '</label>';
echo elgg_view('input/dropdown', array(
	'name' => 'debug_mode',
	'value' => $debug_mode,
	'class' => 'mls',
	'options_values' => array(
		0 => elgg_echo('hybridauth:debug_mode:disable'),
		1 => elgg_echo('hybridauth:debug_mode:enable')
	)
));
echo '</div>';

// refresh the endpoint
elgg_set_plugin_setting('base_url', elgg_normalize_url('linkedin/endpoint'), 'linkedin_profile_importer');