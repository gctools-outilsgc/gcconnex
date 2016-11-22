<?php
/*
 * education.php
 *
 * Ethan Wallace - Re-used Bryden's code to complete action for onboarding.
 */

$education = get_entity($vars['guid']); // get the guid of the education entry that is being requested for display

$guid = ($education != NULL)? $vars['guid'] : "new"; // if the education guid isn't given, this must be a new entry

echo '<div class="gcconnex-education-entry" data-guid="' . $guid . '">'; // education entry wrapper for css styling

    // enter school name
    echo '<label for="education-' . $guid . '" class="gcconnex-profile-field-title">';
    echo elgg_echo('gcconnex_profile:education:school') . '</label>';
    echo elgg_view("input/text", array(
            'name' => 'education',
            'class' => 'gcconnex-education-school',
            'id' => 'education-' . $guid,
            'value' => $education->school));


    // enter degree
    echo '<br><label for="degree-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:degree') . '</label>';
    echo elgg_view("input/text", array(
        'name' => 'degree',
        'id' => 'degree-' . $guid,
        'class' => 'gcconnex-education-degree',
        'value' => $education->degree));

    // enter field  of study
    echo '<br><label for="fieldofstudy-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:field') . '</label>';
    echo elgg_view("input/text", array(
            'name' => 'fieldofstudy',
            'id' => 'fieldofstudy-' . $guid,
            'class' => 'gcconnex-education-field',
            'value' => $education->field));



    // enter start date
    echo '<div class="col-xs-6"><h4>' . elgg_echo('gcconnex_profile:education:start') . '</h4>';
    echo '<label for="startdate-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:start_month') . '</label>';

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
            'id' => 'startdate-' . $guid,
            'value' => $education->startdate));

    echo '<label for="start-year-' . $guid . '">' . elgg_echo('gcconnex_profile:education:start_year') . '</label>' . elgg_view("input/text", array(
            'name' => 'start-year',
            'id' => 'start-year-' . $guid,
            'class' => 'gcconnex-education-start-year',
            'maxlength' => 4,
            'onkeypress' => "return isNumberKey(event)",
            'value' => $education->startyear));

    $params = array(
        'name' => 'enddate',
        'id' => 'enddate-' . $guid,
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
    echo '<label for="enddate-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:end_month') . '</label>';
    echo elgg_view("input/pulldown", $params);

    unset($params);


    $params = array('name' => 'end-year','id' => 'end-year-' . $guid,
        'class' => 'gcconnex-education-end-year gcconnex-education-end-year-' . $education->guid,
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $education->endyear);
    if ($education->ongoing == 'true') {
        $params['disabled'] = 'true';
    }

    echo '<label for="end-year-' . $guid . '">' . elgg_echo('gcconnex_profile:education:end_year') . '</label>' .  elgg_view("input/text", $params);

    unset($params);

    $params = array(
        'name' => 'ongoing',
        'id' => 'ongoing',
        'class' => 'gcconnex-education-ongoing',
        'onclick' => 'toggleEndDate("education", this)',
    );
    if ($education->ongoing == 'true') {
        $params['checked'] = $education->ongoing;
    }

    echo  '<label>' . elgg_view('input/checkbox', $params);
    echo elgg_echo('gcconnex_profile:education:ongoing') . '</label>';

    echo '</div>';

    echo elgg_view('input/hidden', array(
            'id' => 'access',
            'name' => 'access',
            'value' => 2
        ));


echo '</div>'; // close div class="gcconnex-education-entry"
