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

 //breaking barriers group guid
  echo '<div style="margin-top:15px">';

  echo '<label for="breakingBarriers-group">Breaking Barriers Group GUID:</label>';
  echo '<p>Default GUID: 24229563</p>';

 $params = array(
     'name' => 'params[breakingBarriers_group]',
     'id' => 'breakingBarriers-group',
     'class' => 'mrgn-bttm-sm',
     'value' => $vars['entity']->breakingBarriers_group,
 );

 echo '<div class="basic-profile-field">';
 echo elgg_view("input/text", $params);
 echo '</div>';

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
