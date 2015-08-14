<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the about-me section of the current user's profile
 * Requires: extended_tinymce plugin, and requires us to load the extended_tinymce js files
 */
elgg_load_js('extended_tinymce');
elgg_load_js('elgg.extended_tinymce');


if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
// wrap the about-me field in a wrapper for css styling
echo '<div class="gcconnex-profile-about-me-display">';

if ($user->canEdit() && ($user->description == NULL || empty($user->description))) {
    echo elgg_echo('gcconnex_profile:about_me:empty');
}
else {
    echo $user->description;
}

echo '</div>'; // close div class="gcconnex-profile-about-me-display"

//echo '</div>'; // close div class=gcconnex-profile-section-wrapper
