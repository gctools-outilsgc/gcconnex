<?php
/*
 * stepTwo.php - Welcome
 *
 * Second step of welcome module. Matches colleagues based on department from ambassador group and popular members.
 */

 elgg_load_library('elgg:onboarding');
?>

<div class="panel-heading clearfix">
    <h2 class="pull-left">
        <?php echo elgg_echo('onboard:welcome:two:title'); ?>
    </h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>4, 'total_steps'=>7));?>

    </div>
</div>
<div class="panel-body">
    <p>
        <?php echo elgg_echo('onboard:welcome:two:description'); ?>
    </p>
    <div class="clearfix wb-eqht" style="">
      <?php

        //get user entity
        $user = elgg_get_logged_in_user_entity();

        //get user type to decide method of recommending people
        $userType = $user->user_type;

        /////STUDENTS
        if($userType == 'student'){

          if($user->institution == "university" || $user->institution == "college" || $user->institution == "highschool"){
            $institution = $user->institution;
            $institution_value = ($institution == 'university') ? $user->university : ($institution == 'college' ? $user->college : $user->highschool);

            ///OPTION 1///

            //random offset so we do not recommend the same people all the time
            $student_count = elgg_get_entities_from_metadata(array(
              'type' => 'user',
              'count' => true,
              'metadata_name_value_pairs' => array(
                array('name' => 'user_type', 'value' => $userType),
                array('name' => $institution, 'value' => $institution_value)
              ),
            ));

            if($student_count > 10){
              $offset = rand(0, $student_count - 10);
            } else {
              $offset = 0;
            }

            //get students from the same university/college
            $students = elgg_get_entities_from_metadata(array(
              'type' => 'user',
              'offset' => $offset,
              'metadata_name_value_pairs' => array(
                array('name' => 'user_type', 'value' => $userType),
                array('name' => $institution, 'value' => $institution_value)
              ),
            ));

            //set keys for array as the user's guid, removes friends and the current user
            foreach($students as $f => $l){
              $students['"'.$l->guid.'"'] = $l;
              unset($students[$f]);
              //remove friend or logged in user
              if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                unset($students['"'.$l->guid.'"']);
              }
            }

            ///OPTION 2///

            //If we dont have six users to recommend, expand search to academics from same university/college
            if(count($students) < 6){
              $academics = elgg_get_entities_from_metadata(array(
                'type' => 'user',
                'metadata_name_value_pairs' => array(
                  array('name' => 'user_type', 'value' => 'academic'),
                  array('name' => $institution, 'value' => $institution_value)
                ),
              ));

              //set keys for array as the user's guid, removes friends and the current user
              foreach($academics as $f => $l){
                $academics['"'.$l->guid.'"'] = $l;
                unset($academics[$f]);
                if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                  unset($academics['"'.$l->guid.'"']);
                }
              }
              //combine students with academics
              $students = array_merge($students, $academics);
            }

            ///OPTION 3///

            //If we still dont have 6 users, use user's skills to recommend people from the site
            if(count($students) < 6){
              //retrieve users based on similiar skills
              $match = user_skill_match();

              if($match){
                foreach($match as $k => $l){
                  $match['"'.$l->guid.'"'] = $l;
                  unset($match[$k]);

                  //remove self or friends from retrieved list
                  if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                    unset($match['"'.$l->guid.'"']);
                  }
                }

                //get feed back string which shows how they were matched
                $status = $_SESSION['candidate_search_feedback'];

                //combine students with skill matched users
                $students = array_merge($students, $match);
              }
            }

            ///OPTION 4///

            //If we still dont have 6 users, get users from the same institution
            if(count($students) < 6){
              $same_institution = elgg_get_entities_from_metadata(array(
                'type' => 'user',
                'metadata_name_value_pairs' => array(
                  array('name' => 'user_type', 'value' => $userType),
                  array('name' => 'institution', 'value' => $institution)
                ),
              ));

              //set keys for array as the user's guid, removes friends and the current user
              foreach($same_institution as $f => $l){
                $same_institution['"'.$l->guid.'"'] = $l;
                unset($same_institution[$f]);
                if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                  unset($same_institution[$l->guid]);
                }
              }
              //combine with students from same institution
              $students = array_merge($students, $same_institution);
            }

            //we only need six different people to display so lets split the array of users to have only 6
            $students = array_slice($students, 0, 6);

            //make display order random
            shuffle($students);

            if(count($students) == 0){
              echo elgg_echo('onboard:welcome:two:noresults');
            }

            //output the student
            foreach($students as $f => $l){
              $htmloutput = '';
              $site_url = elgg_get_site_url();
              $userGUID=$l->guid;
              $job=$l->job;
              $institution = $l->institution;
              $school = ($institution == "university") ? $l->university : $l->college;

              $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">';
              $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

              $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
              if(($l->user_type == 'student' || $l->user_type == 'academic') && $institution == $user->institution){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.elgg_echo('gcRegister:occupation:'.$l->user_type).'</p>';
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$school.'</p>';
              } else {
                if($l->department){
                  $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->department.'</p>';
                } else if($institution){
                  $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$school.'</p>';
                }
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$status[$l->guid].'</p>';
              }
              //changed connect button to send a friend request we should change the wording
              $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
              $htmloutput=$htmloutput.'</div>';

              echo $htmloutput . '';
            }
          }
        /////ACADEMICS
        } else if($userType == 'academic') {

          if($user->institution == "university" || $user->institution == "college"){
            $institution = $user->institution;
            $institution_value = ($institution == 'university') ? $user->university : ($institution == 'college' ? $user->college : $user->highschool);

            ///OPTION 1///

            //random offset so we do not recommend the same people all the time
            $academic_count = elgg_get_entities_from_metadata(array(
              'type' => 'user',
              'count' => true,
              'metadata_name_value_pairs' => array(
                array('name' => 'user_type', 'value' => $userType),
                array('name' => $institution, 'value' => $institution_value)
              ),
            ));

            if($academic_count > 10){
              $offset = rand(0, $academic_count - 10);
            } else {
              $offset = 0;
            }

            //get academics from the same institution
            $academics = elgg_get_entities_from_metadata(array(
              'type' => 'user',
              'offset' => $offset,
              'metadata_name_value_pairs' => array(
                array('name' => 'user_type', 'value' => $userType),
                array('name' => $institution, 'value' => $institution_value)
              ),
            ));

            //set keys for array as the user's guid, removes friends and the current user
            foreach($academics as $f => $l){
              $academics['"'.$l->guid.'"'] = $l;
              unset($academics[$f]);
              //remove friend or logged in user
              if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                unset($academics['"'.$l->guid.'"']);
              }
            }

            ///OPTION 2///

            //If we dont have six users to recommend, expand search to academics from same institution
            if(count($academics) < 6){
              $students = elgg_get_entities_from_metadata(array(
                'type' => 'user',
                'metadata_name_value_pairs' => array(
                  array('name' => 'user_type', 'value' => 'student'),
                  array('name' => $institution, 'value' => $institution_value)
                ),
              ));

              //set keys for array as the user's guid, removes friends and the current user
              foreach($students as $f => $l){
                $students['"'.$l->guid.'"'] = $l;
                unset($students[$f]);
                if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                  unset($students['"'.$l->guid.'"']);
                }
              }
              //combine students with academics
              $academics = array_merge($academics, $students);
            }

            ///OPTION 3///

            //If we still dont have 6 users, use user's skills to recommend people from the site
            if(count($academics) < 6){
              //retrieve users based on similiar skills
              $match = user_skill_match();

              if($match){
                foreach($match as $k => $v){
                  $match['"'.$v->guid.'"'] = $v;
                  unset($match[$k]);

                  //remove self or friends from retrieved list
                  if($user->guid == $v->guid || check_entity_relationship($user->guid, 'friend', $v->guid)){
                    unset($match['"'.$v->guid.'"']);
                  }
                }

                //get feed back string which shows how they were matched
                $status = $_SESSION['candidate_search_feedback'];

                //combine students with skill matched users
                $academics = array_merge($academics, $match);
              }
            }

            ///OPTION 4///

            //If we still dont have 6 users, get users from the same institution
            if(count($academics) < 6){
              $same_institution = elgg_get_entities_from_metadata(array(
                'type' => 'user',
                'metadata_name_value_pairs' => array(
                  array('name' => 'user_type', 'value' => $userType),
                  array('name' => 'institution', 'value' => $institution)
                ),
              ));

              //set keys for array as the user's guid, removes friends and the current user
              foreach($same_institution as $f => $l){
                $same_institution['"'.$l->guid.'"'] = $l;
                unset($same_institution[$f]);
                if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                  unset($same_institution[$l->guid]);
                }
              }
              //combine with academics from same institution
              $academics = array_merge($academics, $same_institution);
            }

            //we only need six different people to display so lets split the array of users to have only 6
            $academics = array_slice($academics, 0, 6);

            //make display order random
            shuffle($academics);

            if(count($academics) == 0){
              echo elgg_echo('onboard:welcome:two:noresults');
            }

            //output the student
            foreach($academics as $f => $l){
              $htmloutput = '';
              $site_url = elgg_get_site_url();
              $userGUID=$l->guid;
              $job=$l->job;
              $institution = $l->institution;
              $school = ($institution == "university") ? $l->university : $l->college;

              $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">';

              //EW - change to render icon so new ambassador badges can be shown
              $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

              $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
              if(($l->user_type == 'student' || $l->user_type == 'academic') && $institution == $user->institution){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.elgg_echo('gcRegister:occupation:'.$l->user_type).'</p>';
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$school.'</p>';
              } else {
                if($l->department){
                  $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->department.'</p>';
                } else if($institution){
                  $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$school.'</p>';
                }
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$status[$l->guid].'</p>';
              }
              //changed connect button to send a friend request we should change the wording
              $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
              $htmloutput=$htmloutput.'</div>';

              echo $htmloutput . '';
            }
          }
        /////PUBLIC SERVANTS
        } else if($userType == 'federal') {

          //get user's federal department
          $federal = elgg_get_logged_in_user_entity()->federal;

          $obj = elgg_get_entities(array(
              'type' => 'object',
              'subtype' => 'federal_departments',
          ));
          $departments = get_entity($obj[0]->guid);

          $federal_departments_en = json_decode($departments->federal_departments_en, true);
          $federal_departments_fr = json_decode($departments->federal_departments_fr, true);
          $federal_departments = array();
          if (get_current_language() == 'en'){
            $federal_departments = $federal_departments_en;
          } else {
            $federal_departments = $federal_departments_fr;
          }

          ///OPTION 1///

          //popular members in federal department
          $federal_count = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'limit' => 50,
            'count' => true,
            'metadata_name'  => 'federal',
            'metadata_values'  => $federal,
          ));

          if($federal_count > 10){
            $offset = rand(0, $federal_count - 6);
          } else {
            $offset = 0;
          }

          //popular members in federal department
          $federal_employees = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'limit' => 50,
            'offset' => $offset,
            'metadata_name'  => 'federal',
            'metadata_values'  => $federal,
          ));

          //set guids as key for each array items
          foreach($federal_employees as $f => $l){
            $federal_employees['"'.$l->guid.'"'] = $l;
            unset($federal_employees[$f]);
            if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
              unset($federal_employees['"'.$l->guid.'"']);
            }
          }

          ///OPTION 2///
          
          //If we dont have six users to recommend, use user's skills to recommend people from the site
          if(count($federal_employees) < 6){
            //retrieve users based on similiar skills
            $match = user_skill_match();

            if($match){
              foreach($match as $k => $v){
                $match['"'.$v->guid.'"'] = $v;
                unset($match[$k]);

                if($user->guid == $v->guid || check_entity_relationship($user->guid, 'friend', $v->guid)){
                  unset($match['"'.$v->guid.'"']);
                }
              }

              $status = $_SESSION['candidate_search_feedback'];

              //combine students with academics
              $federal_employees = array_merge($federal_employees, $match);
            }
          }

          $federal_employees = array_splice($federal_employees, 0, 6);

          shuffle($federal_employees);

          //if the search does not find anyone, grb 6 random ambassadors for the user
          if(count($federal_employees) == 0){
            echo elgg_echo('onboard:welcome:two:noresults');
          }

          //output the employee
          foreach($federal_employees as $f => $l){
            $htmloutput = '';
            $site_url = elgg_get_site_url();
            $userGUID=$l->guid;
            $job=$l->job;

            $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">'; // suggested friend link to profile

            //EW - change to render icon so new ambassador badges can be shown
            $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

            $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
            if($l->federal == $user->federal){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->federal.'</p>';
            }else if($l->federal == $depart1 || $l->federal == $depart2){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->federal.'</p>';
            }else{
              $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$status[$l->guid].'</p>';
            }

            //changed connect button to send a friend request we should change the wording
            $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
            $htmloutput=$htmloutput.'</div>';

            echo $htmloutput . '';
          }
        } else if($userType == 'provincial') {
          //get user's province
          $province = elgg_get_logged_in_user_entity()->provincial;

          //popular members in federal department
          $province_count = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'limit' => 50,
            'count' => true,
            'metadata_name'  => 'provincial',
            'metadata_values'  => $province,
          ));

          if($province_count > 10){
            $offset = rand(0, $province_count - 6);
          } else {
            $offset = 0;
          }

          //popular members in provincial department
          $provincial_employees = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'limit' => 50,
            'offset' => $offset,
            'metadata_name'  => 'provincial',
            'metadata_values'  => $province,
          ));

          //set guids as key for each array items
          foreach($provincial_employees as $f => $l){
            $provincial_employees['"'.$l->guid.'"'] = $l;
            unset($provincial_employees[$f]);
             if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
               unset($provincial_employees['"'.$l->guid.'"']);
             }
           }

          if(count($provincial_employees) < 6){
            //retrieve users based on similiar skills
            $match = user_skill_match();

            if($match){
              foreach($match as $k => $v){
                $match['"'.$v->guid.'"'] = $v;
                unset($match[$k]);

                if($user->guid == $v->guid || check_entity_relationship($user->guid, 'friend', $v->guid)){
                  unset($match['"'.$v->guid.'"']);
                }
              }

              $status = $_SESSION['candidate_search_feedback'];

              //combine students with academics
              $provincial_employees = array_merge($provincial_employees, $match);
            }
          }

          $provincial_employees = array_splice($provincial_employees, 0, 6);

          shuffle($provincial_employees);

          //if the search does not find anyone, grb 6 random ambassadors for the user
          if(count($provincial_employees) == 0){
            echo elgg_echo('onboard:welcome:two:noresults');
          }

          foreach($provincial_employees as $f => $l){
            $htmloutput = '';
            $userGUID=$l->guid;

            $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">'; // suggested friend link to profile

            //EW - change to render icon so new ambassador badges can be shown
            $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

            $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
            if($l->province == $user->province){ // Nick - Adding department if no job, if none add a space
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->province.'</p>';
            }else{
              $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$status[$l->guid].'</p>';
            }

            //changed connect button to send a friend request we should change the wording
            $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
            $htmloutput=$htmloutput.'</div>';

            echo $htmloutput . '';
          }
        } else if($userType == 'other') {

          //get user's other department
          $other = elgg_get_logged_in_user_entity()->other;

          ///OPTION 1///

          //popular members in other
          $other_count = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'limit' => 50,
            'count' => true,
            'metadata_name'  => 'other',
            'metadata_values'  => $other,
          ));

          if($other_count > 10){
            $offset = rand(0, $other_count - 6);
          } else {
            $offset = 0;
          }

          //popular members in other
          $other_members = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'limit' => 50,
            'offset' => $offset,
            'metadata_name'  => 'other',
            'metadata_values'  => $other,
          ));

          //set guids as key for each array items
          foreach($other_members as $f => $l){
            $other_members['"'.$l->guid.'"'] = $l;
            unset($other_members[$f]);
            if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
              unset($other_members['"'.$l->guid.'"']);
            }
          }

          ///OPTION 2///
          
          //If we dont have six users to recommend, use user's skills to recommend people from the site
          if(count($other_members) < 6){
            //retrieve users based on similiar skills
            $match = user_skill_match();

            if($match){
              foreach($match as $k => $v){
                $match['"'.$v->guid.'"'] = $v;
                unset($match[$k]);

                if($user->guid == $v->guid || check_entity_relationship($user->guid, 'friend', $v->guid)){
                  unset($match['"'.$v->guid.'"']);
                }
              }

              $status = $_SESSION['candidate_search_feedback'];

              //combine students with academics
              $other_members = array_merge($other_members, $match);
            }
          }

          ///OPTION 3///
          
          //If we dont have six users to recommend, expand search to all 'others'
          if(count($other_members) < 6){
            $more_others = elgg_get_entities_from_metadata(array(
              'type' => 'user',
              'metadata_name_value_pairs' => array(
                array('name' => 'user_type', 'value' => 'other'),
              ),
            ));

            //set keys for array as the user's guid, removes friends and the current user
            foreach($more_others as $f => $l){
              $more_others['"'.$l->guid.'"'] = $l;
              unset($more_others[$f]);
              if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                unset($more_others['"'.$l->guid.'"']);
              }
            }

            //combine both sets of 'others'
            $other_members = array_merge($other_members, $more_others);
          }

          $other_members = array_splice($other_members, 0, 6);

          shuffle($other_members);

          //if the search does not find anyone, grb 6 random ambassadors for the user
          if(count($other_members) == 0){
            echo elgg_echo('onboard:welcome:two:noresults');
          }

          //output the employee
          foreach($other_members as $f => $l){
            $htmloutput = '';
            $site_url = elgg_get_site_url();
            $userGUID=$l->guid;
            $job=$l->job;

            $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">'; // suggested friend link to profile

            //EW - change to render icon so new ambassador badges can be shown
            $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

            $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
            if($l->federal == $user->federal){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->federal.'</p>';
            }else if($l->federal == $depart1 || $l->federal == $depart2){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->federal.'</p>';
            }else{
              $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$status[$l->guid].'</p>';
/*=======
    //skip to next step
    $('#next').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepThree', {
            success: function (output) {
               // var oldHeight = $('#welcome-step').css('height');
                $('#welcome-step').html(output);
                $('#welcome-step').focus();
               // var newHeight = $('#welcome-step').children().css('height');
                //console.log('new:' + newHeight + ' old:' + oldHeight);
                //animateStep(oldHeight, newHeight);
>>>>>>> connex/gcconnex*/
            }

            //changed connect button to send a friend request we should change the wording
            $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
            $htmloutput=$htmloutput.'</div>';

            echo $htmloutput . '';
          }
        } else if($userType == 'retired') {

          ///OPTION 1///
          
          $retired_members = elgg_get_entities_from_metadata(array(
            'type' => 'user',
            'metadata_name_value_pairs' => array(
              array('name' => 'user_type', 'value' => 'retired'),
            ),
          ));

          //set keys for array as the user's guid, removes friends and the current user
          foreach($retired_members as $f => $l){
            $retired_members['"'.$l->guid.'"'] = $l;
            unset($retired_members[$f]);
            if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
              unset($retired_members['"'.$l->guid.'"']);
            }
          }

          ///OPTION 2///

          //If we still dont have 6 users, use user's skills to recommend people from the site
          if(count($retired_members) < 6){
            //retrieve users based on similiar skills
            $match = user_skill_match();

            if($match){
              foreach($match as $k => $l){
                $match['"'.$l->guid.'"'] = $l;
                unset($match[$k]);

                //remove self or friends from retrieved list
                if($user->guid == $l->guid || check_entity_relationship($user->guid, 'friend', $l->guid)){
                  unset($match['"'.$l->guid.'"']);
                }
              }

              //get feed back string which shows how they were matched
              $status = $_SESSION['candidate_search_feedback'];

              //combine 'others' with skill matched users
              $retired_members = array_merge($retired_members, $match);
            }
          }

          $retired_members = array_splice($retired_members, 0, 6);

          shuffle($retired_members);

          //if the search does not find anyone, grb 6 random ambassadors for the user
          if(count($retired_members) == 0){
            echo elgg_echo('onboard:welcome:two:noresults');
          }

          //output the employee
          foreach($retired_members as $f => $l){
            $htmloutput = '';
            $site_url = elgg_get_site_url();
            $userGUID=$l->guid;
            $job=$l->job;

            $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">'; // suggested friend link to profile

            //EW - change to render icon so new ambassador badges can be shown
            $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

            $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
            if($l->federal == $user->federal){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->federal.'</p>';
            }else if($l->federal == $depart1 || $l->federal == $depart2){
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$l->federal.'</p>';
            }else{
              $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$status[$l->guid].'</p>';
            }

            //changed connect button to send a friend request we should change the wording
            $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
            $htmloutput=$htmloutput.'</div>';

            echo $htmloutput . '';
          }
        }
      ?>
    </div>

    <div class="mrgn-bttm-md mrgn-tp-lg pull-right">
      <a id="next" class="btn btn-primary" href="#"><?php echo elgg_echo('onboard:welcome:next'); ?></a>
    </div>

    <script>
      function addFriendOnboard(guid) {
        var button = $('#' + guid);
        //check if button has id
        if (button.attr('id') != '') {

          //change to loading spinner
          button.html('<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i><span class="sr-only">Loading...</span>').removeClass('btn-primary add-friend').addClass('btn-default');
          var id = $(this).attr('id');

          //do the elgg friend request action
          elgg.action('friends/add', {
            data: {
                friend: guid,
            },
            success: function (wrapper) {
              if (wrapper.output) {
                  //alert(wrapper.output.sum);
              } else {
                  // the system prevented the action from running
              }

              //show that the request was sent
              button.html("<?php echo elgg_echo('friend_request:friend:add:pending'); ?>");
              //remove id to disabe sending request again
              button.attr('id', '');
            }
          });
        }
      }

      //skip to next step
      $('#next').on('click', function () {
        $(this).html('<i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><span class="sr-only">Loading...</span>');
          elgg.get('ajax/view/welcome-steps/stepFour', {
              success: function (output) {

                  $('#welcome-step').html(output);

              }
          });
      });
    </script>
    <style>
      .min-height-cs {
        min-height: 20px;
      }

      .job-length {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .onboard-coll {
        max-width:285px;
      }
    </style>
</div>
