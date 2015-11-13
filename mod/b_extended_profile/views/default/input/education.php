<?php
/*
 * Author: Bryden Arndt
 * Date: 15/12/14
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for education (designed to be entered for a user's profile).
 */


$education = get_entity($vars['guid']); // get the guid of the education entry that is being requested for display

$guid = ($education != NULL)? $vars['guid'] : "new"; // if the education guid isn't given, this must be a new entry

echo '<div class="gcconnex-education-entry" data-guid="' . $guid . '">'; // education entry wrapper for css styling

    // enter school name
    echo '<label for="education" class="gcconnex-profile-field-title">';
    echo elgg_echo('gcconnex_profile:education:school') . '</label>';
    echo elgg_view("input/text", array(
            'name' => 'education',
            'class' => 'gcconnex-education-school',
            'id' => 'education', 
            'value' => $education->school));


    // enter degree
    echo '<br><label for="degree" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:degree') . '</label>';
    echo elgg_view("input/text", array(
        'name' => 'degree',
        'id' => 'degree',
        'class' => 'gcconnex-education-degree',
        'value' => $education->degree));

/*
    // enter program
    echo '<br><span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:program') . '</span>';
    echo elgg_view("input/text", array(
            'name' => 'program',
            'class' => 'gcconnex-education-program',
            'value' => $education->program));
*/

    // enter field  of study
    echo '<br><label for="fieldofstudy" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:field') . '</label>';
    echo elgg_view("input/text", array(
            'name' => 'fieldofstudy',
            'id' => 'fieldofstudy',
            'class' => 'gcconnex-education-field',
            'value' => $education->field));



    // enter start date
    echo '<div class="col-xs-6"><h4>' . elgg_echo('gcconnex_profile:education:start') . '</h4>';
    echo '<label for="startdate" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:start_month') . '</label>';

    echo elgg_view("input/pulldown", array(
            'name' => 'startdate',
            'class' => 'gcconnex-education-startdate',
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
            'id' => 'startdate',
            'value' => $education->startdate));

    echo '<label for="start-year">' . elgg_echo('gcconnex_profile:education:start_year') . '</label>' . elgg_view("input/text", array(
            'name' => 'start-year',
            'id' => 'start-year',
            'class' => 'gcconnex-education-start-year',
            'maxlength' => 4,
            'onkeypress' => "return isNumberKey(event)",
            'value' => $education->startyear));

    $params = array(
        'name' => 'enddate',
        'id' => 'enddate',
        'class' => 'gcconnex-education-enddate gcconnex-education-enddate-' . $education->guid,
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
        'value' => $education->enddate);
    if ($education->ongoing == 'true') {
        $params['disabled'] = 'true';
    }
    echo '</div>';


    echo '<div class="col-xs-6"><h4>' . elgg_echo('gcconnex_profile:education:end') . '</h4>';
    echo '<label for="enddate" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:end_month') . '</label>';
    echo elgg_view("input/pulldown", $params);

    unset($params);


    $params = array('name' => 'end-year','id' => 'end-year',
        'class' => 'gcconnex-education-end-year gcconnex-education-end-year-' . $education->guid,
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $education->endyear);
    if ($education->ongoing == 'true') {
        $params['disabled'] = 'true';
    }

    echo '<label for="end-year">' . elgg_echo('gcconnex_profile:education:end_year') . '</label>' .  elgg_view("input/text", $params);

    unset($params);

    $params = array(
        'name' => 'ongoing',
        'class' => 'gcconnex-education-ongoing',
        'onclick' => 'toggleEndDate("education", this)',
    );
    if ($education->ongoing == 'true') {
        $params['checked'] = $education->ongoing;
    }

    echo  '<label>' . elgg_view('input/checkbox', $params);
    echo elgg_echo('gcconnex_profile:education:ongoing') . '</label>';

    echo '</div>';




    // create a delete button for each education entry
    echo '<br><button class="eduDeleteButton btn btn-danger" onclick="deleteEntry(this)" data-type="education">' . elgg_echo('gcconnex_profile:education:delete') . '</button>';

echo '</div>'; // close div class="gcconnex-education-entry"