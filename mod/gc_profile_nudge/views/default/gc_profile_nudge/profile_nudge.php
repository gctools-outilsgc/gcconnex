<?php
/*
 * Popup that asks user to update their profile information.
 */

$user = elgg_get_logged_in_user_entity();
$user->last_profile_nudge = time();
$user->save();

echo '<div class="verify-content" style="max-width:600px;">';

echo '<h1>'. elgg_echo('gc_profile_nudge:title') .'</h1>';

echo '<p class="mrgn-tp-md mrgn-bttm-md">'. elgg_echo('gc_profile_nudge:text') .'</p>';

echo "<p><a class='btn btn-primary' href='" . elgg_get_site_url() . "profile/" . $user->username . "'>" . elgg_echo('gc_profile_nudge:update') . "</a></p>";

echo '</div>';
