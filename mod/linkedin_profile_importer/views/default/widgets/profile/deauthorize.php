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
            echo '<label>' . elgg_echo('hybridauth:provider:user:deauthorize') . '</label>';
            echo elgg_view('output/url', array(
                'href' => "action/linkedin/deauthorize?provider=$provider&guid=$user->guid",
                'is_action' => true,
                'text' => elgg_echo('hybridauth:provider:user:deauthorize'),
                'class' => 'elgg-button elgg-button-action btn btn-default'
            ));
        }
    }
}
