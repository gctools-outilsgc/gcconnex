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
//mental health group guid
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


//checkbox to display pledge widget
 echo '<div style="margin-top:15px">';

$options = array(
  'name' => 'params[mentalHealth_group_display]',
  'id' => 'mentalHealth-group-display',
  'label'=>'Display Mental Health pledge widget in group sidebar',
);
if (elgg_get_plugin_setting('mentalHealth_group_display', 'gcProfilePictureBadges')) {
	$options['checked'] = 'checked';
}
 echo elgg_view ( "input/checkbox", $options);

 echo '</div>';

 //checkbox to display pledge widget
  echo '<div style="margin-top:15px">';

 $options = array(
   'name' => 'params[amb_badge_pledge]',
   'id' => 'amb_badge_pledge',
   'label'=>'Display Ambassador badge widget in Ambassador group',
 );
 if (elgg_get_plugin_setting('amb_badge_pledge', 'gcProfilePictureBadges')) {
 	$options['checked'] = 'checked';
 }
  echo elgg_view ( "input/checkbox", $options);

  echo '</div>';
