<?php
/*
 * education.php
 *
 * Ethan Wallace - Re-used Bryden's code to complete action for onboarding.
 */


//Test if the user is a public servant or other to know what institution or department to use
$user_type = elgg_get_logged_in_user_entity()->user_type;
 if($user_type == 'federal') {
   $user_institution = elgg_get_logged_in_user_entity()->federal;
 } else if($user_type == 'public_servant') {
   $user_institution = elgg_get_logged_in_user_entity()->department;
 } else {
   $institution = elgg_get_logged_in_user_entity()->institution;
   $user_institution = ($institution == 'university') ? elgg_get_logged_in_user_entity()->university : elgg_get_logged_in_user_entity()->college;
 }

$education = get_entity($vars['guid']); // get the guid of the education entry that is being requested for display

$guid = ($education != NULL)? $vars['guid'] : "new"; // if the education guid isn't given, this must be a new entry
$degree_types = array(elgg_echo('degree:highSchool'), elgg_echo('degree:associate'), elgg_echo('degree:university'), elgg_echo('degree:bachelor'), elgg_echo('degree:master'), elgg_echo('degree:mba'), elgg_echo('degree:js'),elgg_echo('degree:md'),elgg_echo('degree:phd'),elgg_echo('degree:engineer'),elgg_echo('degree:other'));

echo '<div class="gcconnex-education-entry" data-guid="' . $guid . '">'; // education entry wrapper for css styling

if($user_type == 'student' || $user_type == 'academic'){//Do a test for the user type
  //We show different forms based on the user type (student/ academic/ ps)
  // enter school name
  echo elgg_view("input/hidden", array(
          'name' => 'education',
          'class' => 'gcconnex-education-school',
          'id' => 'education-' . $guid,
          'value' => $user_institution,
        ));


          // enter field  of study
          echo '<br><label for="fieldofstudy-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:field') . '</label>';
          echo elgg_view("input/text", array(
                  'name' => 'fieldofstudy',
                  'id' => 'fieldofstudy-' . $guid,
                  'class' => 'gcconnex-education-field',
                  'value' => $education->field));


  // enter degree
  echo '<br><label for="degree-' . $guid . '" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:education:degree') . '</label>';
  echo elgg_view("input/select", array(
      'name' => 'degree',
      'id' => 'degree-' . $guid,
      'class' => 'gcconnex-education-degree',
      'options' => $degree_types,
    ));

    echo elgg_view('input/hidden', array(
      'name'=>'title',
      'class'=> 'gcconnex-job-title',
      'value'=>'no_title',
    ));
}else{ //academic form
  
//Job title
  echo '<label for="jobTitle-'.$guid.'">'.elgg_echo('gcconnex_profile:basic:job').'</label>';
echo elgg_view('input/text', array(
  'name'=>'title',
  'id'=>'jobTitle-' .$guid,
  'class'=>'gcconnex-job-title',
  'value'=>elgg_get_logged_in_user_entity()->job
));

}

    echo elgg_view('input/hidden', array(
            'id' => 'access',
            'name' => 'access',
            'class'=>'gcconnex-access',
            'value' => ACCESS_LOGGED_IN
            // 'value' => 2
        ));


echo '</div>'; // close div class="gcconnex-education-entry"
