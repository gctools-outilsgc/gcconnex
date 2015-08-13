<?php
/*
 * Author: Bryden Arndt
 * Date: 03/26/2015
 * Time: 11:18 AM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for languages (designed to be entered for a user's profile).
 */


$languages = get_entity($vars['guid']); // get the guid of the language entry that is being requested for display

$guid = ($languages != NULL)? $vars['guid'] : "new"; // if the languages guid isn't given, this must be a new entry

echo '<div class="gcconnex-languages-entry" data-guid="' . $guid . '">'; // languages entry wrapper for css styling

// enter language
echo elgg_echo('gcconnex_profile:languages:language') . elgg_view("input/text", array(
        'name' => 'language',
        'class' => 'gcconnex-languages-language',
        'value' => $languages->title));


$params = array(
    'name' => 'enddate',
    'class' => 'gcconnex-education-enddate gcconnex-education-enddate-' . $education->guid,
    'options' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
    'value' => $education->enddate);
if ($education->ongoing == 'true') {
    $params['disabled'] = 'true';
}

echo '<br>' . elgg_echo('gcconnex_profile:education:end_month') . elgg_view("input/pulldown", $params);

unset($params);



$params = array(
    'name' => 'ongoing',
    'class' => 'gcconnex-education-ongoing',
    'onclick' => 'toggleEndDate(' . $education->guid . ', "education")',
);
if ($education->ongoing == 'true') {
    $params['checked'] = $education->ongoing;
}

echo  '<label>' . elgg_view('input/checkbox', $params);
echo elgg_echo('gcconnex_profile:education:ongoing') . '</label>';







// create a delete button for each languages entry
echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteEntry(this)" data-type="languages">' . elgg_echo('gcconnex_profile:languages:delete') . '</div>';

echo '</div>'; // close div class="gcconnex-languages-entry"