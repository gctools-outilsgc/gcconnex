<?php
/*
 * Author: Bryden Arndt
 * Date: 01/09/2015
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for work experience (designed to be entered for a user's profile).
 */

$work_experience = get_entity($vars['guid']); // get the guid of the work experience entry that is being requested for display

$guid = ($work_experience != NULL)? $vars['guid'] : "new"; // if the work experience guid isn't given, this must be a new entry

echo '<div class="gcconnex-work-experience-entry ' . $guid . ' well" data-guid="' . $guid . '">'; // work experience entry wrapper for css styling

// enter organization name
echo '<span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:experience:title') . '</span>';

echo elgg_view("input/text", array(
    'name' => 'title',
    'class' => 'gcconnex-work-experience-title',
    'value' => $work_experience->title));


// enter title
echo '<br>';
echo '<span class="gcconnex-profile-field-title">';

echo elgg_echo('gcconnex_profile:experience:organization') . '</span>';

echo '<span class="gcconnex-profile-field-input">';

echo elgg_view("input/text", array(
    'name' => 'work-experience',
    'class' => 'gcconnex-work-experience-organization',
    'value' => $work_experience->organization));
echo '</span>';

// enter start date
echo '<br><span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:experience:start_month') .  '</span>';

echo elgg_view("input/pulldown", array(
        'name' => 'startdate',
        'class' => 'gcconnex-work-experience-startdate',
        'options_values' => array(
            1 => elgg_echo('gcconnex_profile:month:january'),
            2 => elgg_echo('gcconnex_profile:month:february'),
            3 => elgg_echo('gcconnex_profile:month:march'),
            4 => elgg_echo('gcconnex_profile:month:april'),
            5 => elgg_echo('gcconnex_profile:month:may'),
            6 => elgg_echo('gcconnex_profile:month:june'),
            7 => elgg_echo('gcconnex_profile:month:july'),
            8 => elgg_echo('gcconnex_profile:month:august'),
            9 => elgg_echo('gcconnex_profile:month:september'),
            10 => elgg_echo('gcconnex_profile:month:october'),
            11 => elgg_echo('gcconnex_profile:month:november'),
            12 => elgg_echo('gcconnex_profile:month:december'),
        ),
        'value' => $work_experience->startdate)
);

echo elgg_echo('gcconnex_profile:experience:year');
echo elgg_view("input/text", array(
        'name' => 'start-year',
        'class' => 'gcconnex-work-experience-start-year',
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $work_experience->startyear));

// disable the end dates if the user is still currently working here

$params = array(
    'name' => 'enddate',
    'class' => 'gcconnex-work-experience-enddate gcconnex-work-experience-enddate-' . $work_experience->guid,
    'options_values' => array(
        1 => elgg_echo('gcconnex_profile:month:january'),
        2 => elgg_echo('gcconnex_profile:month:february'),
        3 => elgg_echo('gcconnex_profile:month:march'),
        4 => elgg_echo('gcconnex_profile:month:april'),
        5 => elgg_echo('gcconnex_profile:month:may'),
        6 => elgg_echo('gcconnex_profile:month:june'),
        7 => elgg_echo('gcconnex_profile:month:july'),
        8 => elgg_echo('gcconnex_profile:month:august'),
        9 => elgg_echo('gcconnex_profile:month:september'),
        10 => elgg_echo('gcconnex_profile:month:october'),
        11 => elgg_echo('gcconnex_profile:month:november'),
        12 => elgg_echo('gcconnex_profile:month:december'),
    ),
    'value' => $work_experience->enddate
);

if ($work_experience->ongoing == 'true') {
        $params['disabled'] = 'true';
}

echo '<br><span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:experience:end_month') . '</span>';

echo elgg_view("input/pulldown", $params);

unset($params);


$params = array('name' => 'end-year',
        'class' => 'gcconnex-work-experience-end-year gcconnex-work-experience-end-year-' . $work_experience->guid,
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $work_experience->endyear);
if ($work_experience->ongoing == 'true') {
        $params['disabled'] = 'true';
}

echo 'Year: ' . elgg_view("input/text", $params);

unset($params);

$target = $work_experience->guid ? $work_experience->guid : "new";

$params = array(
    'name' => 'ongoing',
    'class' => 'gcconnex-work-experience-ongoing',
    'onclick' => 'toggleEndDate("work-experience", this)',
);
if ($work_experience->ongoing == 'true') {
        $params['checked'] = $work_experience->ongoing;
}

echo  '<label>' . elgg_view('input/checkbox', $params);
echo elgg_echo('gcconnex_profile:experience:ongoing') . '</label>';

// enter responsibilities
echo '<br>' . elgg_echo('gcconnex_profile:experience:responsibilities') . elgg_view("input/textarea", array(
        'name' => 'responsibilities',
        'id' => 'textarea',
        'class' => 'gcconnex-work-experience-responsibilities',
        'value' => $work_experience->responsibilities));


echo '<div class="colleagues-label">' . elgg_echo('gcconnex_profile:experience:colleagues') . '</div>';
echo '<div class="colleagues-list">';

if ( $work_experience->colleagues == null ) {
    echo '<div class="list-avatars"></div>';
}
else {
    echo list_avatars(array(
        'guids' => $work_experience->colleagues,
        'size' => 'small',
        'limit' => 0,
        'use_hover' => false,
        'edit_mode' => true
    ));
}
echo '</div>'; // close div class="colleauges-list"


$tid = 'tid-' . rand();

echo '<div>';

echo '<span class="colleague-suggest-field">' . elgg_view("input/text", array(
        'name' => $tid,
        'class' => 'gcconnex-work-experience-colleagues userfind ' . $tid,
        'data-guid' => $guid,
        'data-tid' => $tid,
)) . '</span>';
echo '<span>' . elgg_echo('gcconnex_profile:experience:colleague_suggest') . '</span>';
echo '</div>';

// create a delete button for each work experience entry
echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteEntry(this)" data-type="work-experience">' . elgg_echo('gcconnex_profile:experience:delete') . '</div>';

echo '</div>'; // close div class="gcconnex-work-experience-entry"
?>