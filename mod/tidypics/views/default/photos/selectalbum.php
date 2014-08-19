<?php

/**
 * Tidypics plugin
 *
 * Selection of album to upload new images to
 *
 * (c) iionly 2013-2014
 * Contact: iionly@gmx.de
 * Website: https://github.com/iionly
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

$owner_guid = get_input('owner_guid', elgg_get_logged_in_user_guid());
$owner = get_entity($owner_guid);
if (!($owner instanceof ElggUser || $owner instanceof ElggGroup)) {
    $owner = elgg_get_logged_in_user_entity();
}

$action = "action/photos/image/selectalbum";

$albums = elgg_get_entities(array('type' => 'object', 'subtype' => 'album', 'container_guid' => $owner->getGUID(), 'limit' => false));

$album_options = array();
$album_options[-1] = elgg_echo('album:create');
if ($albums) {
    foreach ($albums as $album) {
        $album_title = $album->getTitle();
        if (strlen($album_title) > 50) {
                $album_title = substr($album_title, 0, 47).'...';
        }
        $album_options[$album->guid] = $album_title;
    }
}

$body = "<div style=\"width:400px; padding:17px;\">".elgg_echo('tidypics:album_select')."<br><br>";
$body .= elgg_view('input/hidden', array('name' => 'owner_guid','value' => $owner->guid));
$body .= elgg_view('input/dropdown', array('name' => 'album_guid',
                                           'value' => '',
                                           'options_values' => $album_options));
$body .= "<br><br>";

$body .= elgg_view('input/submit', array('value' => elgg_echo('tidypics:continue'))).'</div>';

echo elgg_view('input/form', array('action' => $action, 'body' => $body));
