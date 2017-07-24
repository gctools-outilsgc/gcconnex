<?php
/*
 * Ethan Wallace - Re-used Bryden's code to complete actions for onboarding.
 * Adds profile details, education, work experience.
 */

$user = elgg_get_logged_in_user_entity();
$user_guid = $user->guid;

$section = get_input('section');

switch ($section) {
    case "details": //////////PROFILE DETAILS


        $job = get_input('job');
        $location = get_input('location');
        $phone = get_input('phone');
        $mobile = get_input('mobile');
        $website = get_input('website');



        $fields = array('job', 'location', 'phone', 'mobile');

        foreach($fields as $field){
            $data = get_input($field);


            $user->$field = $data;

        }
        echo json_encode([
            'sum' => $job
        ]);

        system_message(elgg_echo('profile:saved'));

        break;

    case 'edu': /////////EDUCATION

        $eguid = get_input('eguid', '');
        $delete = get_input('delete', '');
        $school = get_input('school', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0002.');
        $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
        $startyear = get_input('startyear');
        $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
        $endyear = get_input('endyear');
        $ongoing = get_input('ongoing');
        //$program = get_input('program', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0005.');
        $degree = get_input('degree');
        $field = get_input('field', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0006.');
        $access = get_input('access', 'ERROR: Ask your admin to grep: 5321GDS1111661353BB.');

        // create education object
        $education_guids = array();

        $education_list = $user->education;

        if ($delete != null && !is_array($delete)) {
            $delete = array( $delete );
        }

        if ( is_array($delete) ) {
            foreach ($delete as $delete_guid) {
                if ($delete_guid != NULL) {

                    if ($delete = get_entity($delete_guid)) {
                        $delete->delete();
                    }
                    if (is_array($education_list)) {
                        if (($key = array_search($delete_guid, $education_list)) !== false) {
                            unset($education_list[$key]);
                        }
                    } elseif ($education_list == $delete_guid) {
                        $education_list = null;
                    }
                }
            }
        }
        $user->education = $education_list;

        if ($eguid != null && !is_array($eguid)) {
            $eguid = array( $eguid );
        }
        //create new education entries
        if (is_array($eguid)) {
            foreach ($eguid as $k => $v) {

                $validInput = true;
                $offDates = false;

                //we need to do some validation to make sure the user doesnt submit bad info

                if(trim($school == '' || trim($degree) == '' || trim($field) == '' || trim($startyear) == '')){
                    $validInput = false;
                }

                if($ongoing == 'false'){
                    if($endyear < $startyear){
                        $validInput = false;
                        $offDates = true;
                    }

                    if(trim($endyear) == ''){
                        $validInput = false;
                    }

                    if($endyear == $startyear){
                        //should check if month is not right but dont want to right now
                    }
                }

                if($validInput == true){


                    if ($v == "new") {
                        $education = new ElggObject();
                        $education->subtype = "education";
                        $education->owner_guid = $user_guid;
                    } else {
                        $education = get_entity($v);
                    }

                    $education->title = htmlentities($school);
                    $education->description = htmlentities($degree);

                    $education->school = htmlentities($school);
                    $education->startdate = $startdate;
                    $education->startyear = $startyear;
                    $education->enddate = $enddate;
                    $education->endyear = $endyear;
                    $education->ongoing = $ongoing;
                    //$education->program = htmlentities($program[$k]);
                    $education->degree = htmlentities($degree);
                    $education->field = htmlentities($field);
                    $education->access_id = $access;

                    if ($v == "new") {
                        $education_guids[] = $education->save();
                    } else {
                        $education->save();
                    }

                    system_message(elgg_echo('profile:saved'));
                } else {
                    register_error(elgg_echo('error:nope'));
                    echo json_encode([
                        'valid' => false,
                        'dates' => $offDates,
                    ]);
                }
            }
        }
        if ($user->education == NULL) {
            $user->education = $education_guids;
        }
        else {
            $stack = $user->education;
            if (!(is_array($stack))) { $stack = array($stack); }

            if ($education_guids != NULL) {
                $user->education = array_merge($stack, $education_guids);
            }

        }

        $user->education_access = $access;
        $user->save();


        break;

    case 'work': /////////WORK EXPERIENCE

        $work_experience = get_input('work');
        $edit = $work_experience['edit'];
        $delete = $work_experience['delete_guids'];
        $access = get_input('access');
        system_message($work_experience['title']);
        $experience_list = $user->work;

        if (!(is_array($delete))) { $delete = array($delete); }

        foreach ($delete as $delete_guid) {
            if ($delete_guid != NULL) {

                if ($delete = get_entity($delete_guid)) {
                    $delete->delete();
                }
                if (is_array($experience_list)) {
                    if (($key = array_search($delete_guid, $experience_list)) !== false) {
                        unset($experience_list[$key]);
                    }
                }
                elseif ($experience_list == $delete_guid) {
                    $experience_list = null;
                }
            }
        }

        $user->work = $experience_list;
        $work_experience_guids = array();

        if ($edit != null && !is_array($edit)) {
            $edit = array( $edit );
        }



        //create new work experience entries
        $title = get_input('title');
        $response = get_input('responsibilities');
        $org = get_input('organization');
        $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
        $startyear = get_input('startyear');
        $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
        $endyear = get_input('endyear');
        $ongoing = get_input('ongoing');
        $eguid = get_input('eguid', '');
        $access = get_input('access', 'ERROR: Ask your admin to grep: 5321GDS1111661353BB.');

                $validInput = true;
                $offDates = false;

                if(trim($title == '')){
                    $validInput = false;
                }

                if(trim($org == '')){
                    $validInput = false;
                }

                if(trim($startyear == '')){
                    $validInput = false;
                }

                if($ongoing == 'false'){
                    if($endyear < $startyear){
                        $validInput = false;
                        $offDates = true;
                    }

                    if(trim($endyear) == ''){
                        $validInput = false;
                    }

                    if($endyear == $startyear){
                        //should check if month is not right but dont want to right now
                    }
                }

                if($validInput == true) {


                    if ($eguid == "new") {
                        $experience = new ElggObject();
                        $experience->subtype = "experience";
                        $experience->owner_guid = $user_guid;
                    } else {
                        $experience = get_entity($eguid);
                    }

                    $experience->title = htmlentities($title);
                   // $experience->description = htmlentities($response);

                    $experience->organization = htmlentities($org);
                    $experience->startdate = $startdate;
                    $experience->startyear = $startyear;
                    $experience->enddate = $enddate;
                    $experience->endyear = $endyear;
                    $experience->ongoing = $ongoing;
                    $experience->responsibilities = trim($response);
                   // $experience->colleagues = $work['colleagues'];
                    $experience->access_id = $access;

                    if ($eguid == "new") {
                        $work_experience_guids[] = $experience->save();
                    } else {
                        $experience->save();
                    }

                    system_message(elgg_echo('profile:saved'));

                } else {
                    register_error(elgg_echo('error:nope'));
                    echo json_encode([
                        'valid' => false,
                        'dates' => $offDates,
                    ]);
                }



        if ($user->work == NULL) {
            $user->work = $work_experience_guids;
        }
        else {
            $stack = $user->work;
            if (!(is_array($stack))) { $stack = array($stack); }

            if ($work_experience_guids != NULL) {
                $user->work = array_merge($stack, $work_experience_guids);
            }
        }
        $user->work_access = $access;
        $user->save();


        break;

    case 'skills':

        $skillsToAdd = get_input('skillsadded', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0021.');
        $skillsToRemove = get_input('skillsremoved', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0022.');
        $access = ACCESS_LOGGED_IN;

        $skill_guids = array();

        foreach ($skillsToAdd as $new_skill) {
            $skill = new ElggObject();
            $skill->subtype = "MySkill";
            $skill->title = htmlentities($new_skill);
            $skill->owner_guid = $user_guid;
            $skill->access_id = $access;
            $skill->endorsements = NULL;
            $skill_guids[] = $skill->save();
        }

        $skill_list = $user->gc_skills;

        if (!(is_array($skill_list))) { $skill_list = array($skill_list); }
        if (!(is_array($skillsToRemove))) { $skillsToRemove = array($skillsToRemove); }

        foreach ($skillsToRemove as $remove_guid) {
            if ($remove_guid != NULL) {

                if ($remove = get_entity($remove_guid)) {
                    $remove->delete();
                }

                if (($key = array_search($remove_guid, $skill_list)) !== false) {
                    unset($skill_list[$key]);
                }
            }
        }

        $user->gc_skills = $skill_list;

        if ($user->gc_skills == NULL) {
            $user->gc_skills = $skill_guids;
        }
        else {
            $stack = $user->gc_skills;
            if (!(is_array($stack))) { $stack = array($stack); }

            if ($skill_guids != NULL) {
                $user->gc_skills = array_merge($stack, $skill_guids);
            }
        }

        //$user->gc_skills = null; // dev stuff... delete me
        //$user->skillsupgraded = NULL; // dev stuff.. delete me
        $user->save();

        break;

        case 'welcome':
/*Education for students*/
                $eguid = get_input('eguid', '');
                $delete = get_input('delete', '');

            if($user->user_type === 'student' || $user->user_type === 'academic'){

                $school = get_input('school', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0002.');
                $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
                $startyear = get_input('startyear');
                $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
                $endyear = get_input('endyear');
                $ongoing = get_input('ongoing');
                //$program = get_input('program', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0005.');
                $degree = get_input('degree');
                $field = get_input('field', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0006.');
                $access = get_input('access', 'ERROR: Ask your admin to grep: 5321GDS1111661353BB.');

                // create education object
                $education_guids = array();

                $education_list = $user->education;

                if ($delete != null && !is_array($delete)) {
                    $delete = array( $delete );
                }

                if ( is_array($delete) ) {
                    foreach ($delete as $delete_guid) {
                        if ($delete_guid != NULL) {

                            if ($delete = get_entity($delete_guid)) {
                                $delete->delete();
                            }
                            if (is_array($education_list)) {
                                if (($key = array_search($delete_guid, $education_list)) !== false) {
                                    unset($education_list[$key]);
                                }
                            } elseif ($education_list == $delete_guid) {
                                $education_list = null;
                            }
                        }
                    }
                }
                $user->education = $education_list;

                if ($eguid != null && !is_array($eguid)) {
                    $eguid = array( $eguid );
                }
                //create new education entries
                if (is_array($eguid)) {
                    foreach ($eguid as $k => $v) {

                        $validInput = true;
                        $offDates = false;
                        if(!isset($field)){
                          $validInput = false;
                        }
                        if($school =='no_school'){
                          $validInput = false;
                        }
                        //we need to do some validation to make sure the user doesnt submit bad info
/*
                        if(trim($school == '' || trim($degree) == '' || trim($field) == '' || trim($startyear) == '')){
                            $validInput = false;
                        }

                        if($ongoing == 'false'){
                            if($endyear < $startyear){
                                $validInput = false;
                                $offDates = true;
                            }

                            if(trim($endyear) == ''){
                                $validInput = false;
                            }

                            if($endyear == $startyear){
                                //should check if month is not right but dont want to right now
                            }
                        }*/

                        if($validInput == true){


                            if ($v == "new") {
                                $education = new ElggObject();
                                $education->subtype = "education";
                                $education->owner_guid = $user_guid;
                            } else {
                                $education = get_entity($v);
                            }

                            $education->title = htmlentities($school);
                            $education->description = htmlentities($degree);

                            $education->school = htmlentities($school);
                            $education->startdate = $startdate;
                            $education->startyear = $startyear;
                            $education->enddate = $enddate;
                            $education->endyear = $endyear;
                            $education->ongoing = $ongoing;
                            //$education->program = htmlentities($program[$k]);
                            $education->degree = htmlentities($degree);
                            $education->field = htmlentities($field);
                            $education->access_id = $access;

                            if ($v == "new") {
                                $education_guids[] = $education->save();
                            } else {
                                $education->save();
                            }

                            system_message(elgg_echo('profile:saved'));
                        } else {
                            //register_error(elgg_echo('error:nope'));
                            echo json_encode([
                                'valid' => false,
                                'dates' => $offDates,
                            ]);
                        }
                    }
                }
                if ($user->education == NULL) {
                    $user->education = $education_guids;
                }
                else {
                    $stack = $user->education;
                    if (!(is_array($stack))) { $stack = array($stack); }

                    if ($education_guids != NULL) {
                        $user->education = array_merge($stack, $education_guids);
                    }

                }

                $user->education_access = $access;
                $user->save();
            }

/*Skills*/

                        $skillsToAdd = get_input('skillsadded', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0021.');
                        $skillsToRemove = get_input('skillsremoved', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0022.');
                        $access = ACCESS_LOGGED_IN;

                        $skill_guids = array();

                        foreach ($skillsToAdd as $new_skill) {
                            $skill = new ElggObject();
                            $skill->subtype = "MySkill";
                            $skill->title = htmlentities($new_skill);
                            $skill->owner_guid = $user_guid;
                            $skill->access_id = $access;
                            $skill->endorsements = NULL;
                            $skill_guids[] = $skill->save();
                        }

                        $skill_list = $user->gc_skills;

                        if (!(is_array($skill_list))) { $skill_list = array($skill_list); }
                        if (!(is_array($skillsToRemove))) { $skillsToRemove = array($skillsToRemove); }

                        foreach ($skillsToRemove as $remove_guid) {
                            if ($remove_guid != NULL) {

                                if ($remove = get_entity($remove_guid)) {
                                    $remove->delete();
                                }

                                if (($key = array_search($remove_guid, $skill_list)) !== false) {
                                    unset($skill_list[$key]);
                                }
                            }
                        }

                        $user->gc_skills = $skill_list;

                        if ($user->gc_skills == NULL) {
                            $user->gc_skills = $skill_guids;
                        }
                        else {
                            $stack = $user->gc_skills;
                            if (!(is_array($stack))) { $stack = array($stack); }

                            if ($skill_guids != NULL) {
                                $user->gc_skills = array_merge($stack, $skill_guids);
                            }
                        }

                        //$user->gc_skills = null; // dev stuff... delete me
                        //$user->skillsupgraded = NULL; // dev stuff.. delete me

                        $title = htmlentities(get_input('title'));
                        if($title !== 'no_title' && !empty($title)){
                            $user->job = $title;
                        }

                        $user->save();
                        break; // Ignore rest of case statement, will not be adding work experience

/*Work exp*/

//create new work experience entries
$title = get_input('title');
$response = get_input('responsibilities');
$org = get_input('organization');
$startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
$startyear = get_input('startyear');
$enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
$endyear = get_input('endyear');
$ongoing = get_input('ongoing');
$eguid = get_input('eguid', '');
$access = get_input('access', 'ERROR: Ask your admin to grep: 5321GDS1111661353BB.');

        $validInput = true;
        $offDates = false;
//going through the inital welcome mod, when a student registers this should stop an empty work exp field from being created.
        if($title == 'no_title'){
          $validInput = false;
        }
/*
        if(trim($title == '')){
            $validInput = false;
        }

        if(trim($org == '')){
            $validInput = false;
        }

        if(trim($startyear == '')){
            $validInput = false;
        }

        if($ongoing == 'false'){
            if($endyear < $startyear){
                $validInput = false;
                $offDates = true;
            }

            if(trim($endyear) == ''){
                $validInput = false;
            }

            if($endyear == $startyear){
                //should check if month is not right but dont want to right now
            }
        }
*/
        if($validInput == true) {


            if ($eguid == "new") {
                $experience = new ElggObject();
                $experience->subtype = "experience";
                $experience->owner_guid = $user_guid;
            } else {
                $experience = get_entity($eguid);
            }

            $experience->title = htmlentities($title);
           // $experience->description = htmlentities($response);

            $experience->organization = htmlentities($org);
            $experience->startdate = $startdate;
            $experience->startyear = $startyear;
            $experience->enddate = $enddate;
            $experience->endyear = $endyear;
            $experience->ongoing = $ongoing;
            $experience->responsibilities = trim($response);
           // $experience->colleagues = $work['colleagues'];
            $experience->access_id = $access;

            if ($eguid == "new") {
                $work_experience_guids[] = $experience->save();
            } else {
                $experience->save();
            }

            system_message(elgg_echo('profile:saved'));

        } else {
            //register_error(elgg_echo('error:nope'));
            echo json_encode([
                'valid' => false,
                'dates' => $offDates,
            ]);
        }



if ($user->work == NULL) {
    $user->work = $work_experience_guids;
}
else {
    $stack = $user->work;
    if (!(is_array($stack))) { $stack = array($stack); }

    if ($work_experience_guids != NULL) {
        $user->work = array_merge($stack, $work_experience_guids);
    }
}
$user->work_access = $access;
$user->save();


        break;
}
?>
