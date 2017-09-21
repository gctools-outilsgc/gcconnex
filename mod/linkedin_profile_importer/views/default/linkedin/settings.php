<?php

elgg_load_css('linkedin.css');

$user = elgg_get_page_owner_entity();

$current_user = elgg_get_logged_in_user_entity()->guid;

if($user->guid !== $current_user)
	return;

$providers = unserialize(elgg_get_plugin_setting('providers', 'linkedin_profile_importer'));

foreach ($providers as $provider => $settings) {

	if ($settings['enabled']) {

		$adapter = false;

		$ha = new ElggHybridAuth();

		try {
			$adapter = $ha->getAdapter($provider);
		} catch (Exception $e) {
			// do nothing
		}

		if ($adapter) {
			$title = elgg_view_icon(strtolower("auth-$provider")) . " " . $provider;

			if (elgg_get_plugin_user_setting("$provider:uid", $user->guid, 'linkedin_profile_importer')) {
				$mod = '<p class="hybridauth-diagnostics-success">' . elgg_echo('hybridauth:provider:user:authenticated') . '</p>';

				$mod .= '<div class="col-xs-6 col-sm-3">' . elgg_view('output/url', array(
					'href' => "action/linkedin/deauthorize?provider=$provider&guid=$user->guid",
					'is_action' => true,
					'text' => elgg_echo('hybridauth:provider:user:deauthorize'),
					'class' => 'elgg-button elgg-button-action btn btn-default'
				)) . '</div>';

				$mod .= '<div class="col-xs-6 col-sm-9">' . elgg_view('output/url', array(
					'text' => elgg_view_icon('linkedin') . '<span>' . elgg_echo('linkedin:import') . '</span>',
					'href' => 'linkedin/import',
					'class' => 'elgg-button elgg-button-action btn btn-primary'
				));
			} else {
				$forward_url = urlencode(elgg_normalize_url("linkedin/import"));
				$mod = '<p class="hybridauth-diagnostics-success">' . elgg_echo('hybridauth:provider:user:default') . '</p>';
				$mod .= elgg_view('output/url', array(
					'href' => "linkedin/authenticate?provider=$provider&elgg_forward_url=$forward_url",
					'text' => elgg_echo('hybridauth:provider:user:authenticate'),
					'class' => 'elgg-button elgg-button-action btn btn-primary'
				));
			}

			echo elgg_view_module('info', $title, $mod, array('class' => 'mrgn-bttm-0'));
		}
	}
}