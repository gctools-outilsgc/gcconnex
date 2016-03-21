<?php
/*
 * Author: Bryden Arndt
 * Date: 01/09/2015
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for work experience (designed to be entered for a user's profile).
 */

$work_experience = get_entity($vars['guid']); // get the guid of the work experience entry that is being requested for display

$guid = ($work_experience != NULL)? $vars['guid'] : "new"; // if the work experience guid isn't given, this must be a new entry

echo '<div class="gcconnex-work-experience-entry ' . $guid . '" data-guid="' . $guid . '">'; // work experience entry wrapper for css styling

// enter organization name
echo '<label for="title-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:experience:title') . '</label>';

echo elgg_view("input/text", array(
    'name' => 'title',
    'id' => 'title-' . $guid,
    'class' => 'gcconnex-work-experience-title',
    'value' => $work_experience->title));


// enter title
echo '<br>';
echo '<label for="work-experience-' . $guid . '" class="gcconnex-profile-field-title">';

echo elgg_echo('gcconnex_profile:experience:organization') . '</label>';

echo '<span class="gcconnex-profile-field-input">';

echo elgg_view("input/text", array(
    'name' => 'work-experience',
    'id' => 'work-experience-' . $guid,
    'class' => 'gcconnex-work-experience-organization',
    'value' => $work_experience->organization));
echo '</span>';

// enter start date
echo '<div class="col-xs-6"><h4>' . elgg_echo('gcconnex_profile:education:start') . '</h4>';
echo '<label for="startdate-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:experience:start_month') .  '</label>';

echo elgg_view("input/pulldown", array(
        'name' => 'startdate',
        'id' => 'startdate-' . $guid,
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

echo '<label for="start-year-' . $guid . '">' . elgg_echo('gcconnex_profile:education:start_year') . '</label>';
echo elgg_view("input/text", array(
        'name' => 'start-year',
        'id' => 'start-year-' . $guid,
        'class' => 'gcconnex-work-experience-start-year',
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $work_experience->startyear));

// disable the end dates if the user is still currently working here

$params = array(
    'name' => 'enddate',
    'id' => 'enddate-' . $guid,
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
echo '</div>';

//end date
echo '<div class="col-xs-6"><h4>' . elgg_echo('gcconnex_profile:education:end') . '</h4>';
echo '<label for="enddate-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:experience:end_month') . '</label>';

echo elgg_view("input/pulldown", $params);

unset($params);


$params = array('name' => 'end-year','id' => 'end-year-' . $guid,
        'class' => 'gcconnex-work-experience-end-year gcconnex-work-experience-end-year-' . $work_experience->guid,
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $work_experience->endyear);
if ($work_experience->ongoing == 'true') {
        $params['disabled'] = 'true';
}


echo '<label for="end-year-' . $guid . '">' . elgg_echo('gcconnex_profile:education:end_year') . '</label>' . elgg_view("input/text", $params);

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
echo '</div>';



// enter responsibilities
echo '<br><label for="textarea-' . $guid . '">' . elgg_echo('gcconnex_profile:experience:responsibilities') . '</label>' . elgg_view("input/textarea", array(
        'name' => 'responsibilities',
        'id' => 'textarea-' . $guid,
        'class' => 'gcconnex-work-experience-responsibilities',
        'value' => $work_experience->responsibilities));

echo '<label for="colleagues-' . $guid . '">' . elgg_echo('gcconnex_profile:experience:colleagues') . '</label>';
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
        'id' => 'colleagues-' . $guid,
        'class' => 'gcconnex-work-experience-colleagues userfind ' . $tid,
        'data-guid' => $guid,
        'data-tid' => $tid,
)) . '</span>';
echo '<span>' . elgg_echo('gcconnex_profile:experience:colleague_suggest') . '</span>';
echo '</div>';

// create a delete button for each work experience entry
echo '<br><button class="workDeleteButton btn btn-danger" onclick="deleteEntry(this)" data-type="work-experience">' . elgg_echo('gcconnex_profile:experience:delete') . '</button>';

echo '</div>'; // close div class="gcconnex-work-experience-entry"
?>