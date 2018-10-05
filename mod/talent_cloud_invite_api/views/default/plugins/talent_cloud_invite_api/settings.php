<?php
/*
* settings.php
*
* Plugin settings to set personal message on invite email from Talent Cloud
*/


// Settings for name of person sending invite
echo '<div style="margin-top:15px; margin-bottom:15px">';

echo '<label for="en_name">' . elgg_echo('talent_cloud_invite_api:from_name_en') . '</label>';
echo elgg_view('input/text', array(
    'name' => 'params[en_name]',
    'id' => 'en_name',
	'value' => $vars['entity']->en_name,
	'class' => 'elgg-input-text',
));
echo '</div>';

echo '<div style="margin-top:15px; margin-bottom:15px">';

echo '<label for="fr_name">' . elgg_echo('talent_cloud_invite_api:from_name_fr') . '</label>';
echo elgg_view('input/text', array(
    'name' => 'params[fr_name]',
    'id' => 'fr_name',
	'value' => $vars['entity']->fr_name,
	'class' => 'elgg-input-text',
));
echo '</div>';

// Settings for registration link

echo '<div style="margin-top:15px; margin-bottom:15px">';

echo '<label for="en_link">' . elgg_echo('talent_cloud_invite_api:registration_link_en') . '</label>';
echo elgg_view('input/text', array(
    'name' => 'params[en_link]',
    'id' => 'en_link',
	'value' => $vars['entity']->en_link,
	'class' => 'elgg-input-text',
));
echo '</div>';

echo '<div style="margin-top:15px; margin-bottom:15px">';

echo '<label for="fr_link">' . elgg_echo('talent_cloud_invite_api:registration_link_fr') . '</label>';
echo elgg_view('input/text', array(
    'name' => 'params[fr_link]',
    'id' => 'fr_link',
	'value' => $vars['entity']->fr_link,
	'class' => 'elgg-input-text',
));
echo '</div>';

// Settings for personalized message

echo '<div style="margin-top:15px; margin-bottom:15px">';

echo '<label for="en_message">' . elgg_echo('talent_cloud_invite_api:personal_message_en') . '</label>';

echo elgg_view('input/textarea', array(
    'name' => 'params[en_message]',
    'id' => 'en_message',
	'value' => $vars['entity']->en_message,
	'class' => 'elgg-input-longtext',
));

echo '</div>';

echo '<div style="margin-top:15px; margin-bottom:15px">';

echo '<label for="fr_message">' . elgg_echo('talent_cloud_invite_api:personal_message_fr') . '</label>';

echo elgg_view('input/textarea', array(
	'name' => 'params[fr_message]',
	'value' => $vars['entity']->fr_message,
	'class' => 'elgg-input-longtext',
));

echo '</div>';
?>
