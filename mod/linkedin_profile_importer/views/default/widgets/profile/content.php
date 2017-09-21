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
            $title = elgg_view_icon(strtolower("auth-$provider-large")) . " " . $provider;

            if (elgg_get_plugin_user_setting("$provider:uid", $user->guid, 'linkedin_profile_importer')) {
                $content = '<div class="ptm">' . elgg_view('output/url', array(
                    'href' => 'linkedin/import',
                    'text' =>  elgg_view_icon(strtolower("auth-$provider-large")),
                    'title' => elgg_echo('linkedin:import-linkedin'),
                )) . '</div>';
            } else {
                $forward_url = urlencode(elgg_normalize_url("linkedin/import"));
                $content = '<div class="ptm">' . elgg_view('output/url', array(
                    'href' => "linkedin/authenticate?provider=$provider&elgg_forward_url=$forward_url",
                    'text' =>  elgg_view_icon(strtolower("auth-$provider-large")),
                    'title' => elgg_echo('linkedin:import-linkedin'),
                )) . '</div>';
            }

            echo $content;
        }
    }
}
