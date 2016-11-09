<?php
/*
Profile Strength
*/

elgg_register_event_handler('init', 'system', 'profileStrength_init');

function profileStrength_init() {

    elgg_extend_view('profile/sidebar', 'profile/sidebar/profile_strength', 449);
    elgg_register_widget_type('profile_completness', elgg_echo('ps:profilestrength'), 'The "Profile Strength" widget', array('custom_index_widgets'),false);
}