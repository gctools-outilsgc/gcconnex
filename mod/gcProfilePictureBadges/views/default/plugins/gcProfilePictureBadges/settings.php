<?php
/*
 * settings.php
 *
 * Set group GUID of certain badges. Mainly for testing badges before launch.
 *
 * @package gcProfilePictureBadges
 * @author Ethan Wallace <>
 */

 elgg_get_plugin_setting("mentalHealth_group", "gcProfilePictureBadges");

 echo '<div style="margin-top:15px">';

 echo '<label for="mentalHealth-group">Mental Health Group GUID:</label>';
 echo '<p>Default GUID: 20934966</p>';

$params = array(
    'name' => 'params[mentalHealth_group]',
    'id' => 'mentalHealth-group',
    'class' => 'mrgn-bttm-sm',
    'value' => $vars['entity']->mentalHealth_group,
);

echo '<div class="basic-profile-field">';
echo elgg_view("input/text", $params);
echo '</div>';

 echo '</div>';
