<?php
if (elgg_is_xhr()) {  //This is an Ajax call!
    $user_guid = get_input('guid');
    $user = get_user($user_guid);
    $section = get_input('section');
    $error = false;
    switch ($section) {
        case "profile":
            $profile_fields = get_input('profile');
            $social_media = get_input('social_media');
            $error_message = '';
            foreach ( $profile_fields as $f => $v ) {
                // cyu - check if email field is empty
                if ($f === "email") {
                    trim($v);   // remove white spaces from both sides of string
                    if (!$v) {
                        register_error(elgg_echo('gcc_profile:error').elgg_echo('gcc_profile:missingemail'));
                        return true;
                    }
                    
                    elgg_load_library('c_ext_lib');
                    $isValid = false;
                    
                    if ($v) {
                        // cyu - check if the email is in the list of exceptions
                        $user_email = explode('@',$v);
                        $list_of_domains = getExtension();
                        if (count($list_of_domains) > 0) {
                            while ($row = mysqli_fetch_array($list_of_domains)) {
                                if (strtolower($row['ext']) === strtolower($user_email[1])) {
                                    $isValid = true;
                                    break;
                                }
                            }
                            $error_message = elgg_echo('gcc_profile:error').elgg_echo('gcc_profile:notaccepted');
                        }
                        // cyu - check if domain is gc.ca
                        if (!$isValid) {
                            $govt_domain = explode('.',$user_email[1]);
                            $govt_domain_len = count($govt_domain) - 1;                           
                            if ($govt_domain[$govt_domain_len - 1].'.'.$govt_domain[$govt_domain_len] === 'gc.ca') {
                                $isValid = true;
                            } else {
                                $isValid = false;
                                $error_message = elgg_echo('gcc_profile:error').elgg_echo('gcc_profile:notaccepted');
                            }
                        }
                    }
                    if (!$isValid) {
                        register_error($error_message);
                        return true;
                    }
                    $user->set($f, $v);
                }
                else {
                	if($f=='department'){
                		$obj = elgg_get_entities(array(
   							'type' => 'object',
   							'subtype' => 'dept_list',
   							'owner_guid' => 0
						));
						$departmentsEn = json_decode($obj[0]->deptsEn, true);
						$provinces['pov-alb'] = 'Government of Alberta';
						$provinces['pov-bc'] = 'Government of British Columbia';
						$provinces['pov-man'] = 'Government of Manitoba';
						$provinces['pov-nb'] = 'Government of New Brunswick';
						$provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
						$provinces['pov-ns'] = 'Government of Nova Scotia';
						$provinces['pov-nwt'] = 'Government of Northwest Territories';
						$provinces['pov-nun'] = 'Government of Nunavut';
						$provinces['pov-ont'] = 'Government of Ontario';
						$provinces['pov-pei'] = 'Government of Prince Edward Island';
						$provinces['pov-que'] = 'Government of Quebec';
						$provinces['pov-sask'] = 'Government of Saskatchewan';
						$provinces['pov-yuk'] = 'Government of Yukon';
						$departmentsEn = array_merge($departmentsEn,$provinces);
						
						$departmentsFr = json_decode($obj[0]->deptsFr, true);
						$provincesFr['pov-alb'] = "Gouvernement de l'Alberta";
						$provincesFr['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
						$provincesFr['pov-man'] = 'Gouvernement du Manitoba';
						$provincesFr['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
						$provincesFr['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
						$provincesFr['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
						$provincesFr['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
						$provincesFr['pov-nun'] = 'Gouvernement du Nunavut';
						$provincesFr['pov-ont'] = "Gouvernement de l'Ontario";
						$provincesFr['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
						$provincesFr['pov-que'] = 'Gouvernement du Québec';
						$provincesFr['pov-sask'] = 'Gouvernement de Saskatchewan';
						$provincesFr['pov-yuk'] = 'Gouvernement du Yukon';
						$departmentsFr = array_merge($departmentsFr,$provincesFr);
						
						if (get_current_language()=='en'){
							$deptString = $departmentsEn[$v]." / ".$departmentsFr[$v];
						}else{
							$deptString = $departmentsFr[$v]." / ".$departmentsEn[$v];
						}
			
						$user->set('department',$deptString);
                	}else{
                		$user->set($f, $v);
                	}
                	//register_error($f);
                    
                }
            }
            foreach ( $social_media as $f => $v ) {
                $link = $v;
                if (filter_var($link, FILTER_VALIDATE_URL) == false) {
                    $user->set($f, $link);
                }
            }
            //$user->micro = get_input('micro');
            $user->save();
            //forward($user->getURL());
            break;
        case 'about-me':
            //$user->description = get_input('description', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0001.');
            //error_log(print_r("access: " . get_input('access')));
            create_metadata($user_guid, 'description', get_input('description', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0001.'), 'text', 0, get_input('access'));
            $user->save();
            break;
        case 'education':
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
                    /*
                    if($ongoing[$k] == true){
                        $endyear[$k] = $startyear[$k];
                    }*/
                    if(trim( htmlentities($school[$k])) == '' || trim( htmlentities($degree[$k])) == '' || trim( htmlentities($field[$k])) == ''){
                        $validInput = false;
                        $error == true;
                    }
                    /*
                    if(trim( $endyear[$k]) < trim($startyear[$k])){
                        $validInput = false;
                        $error == true;
                    }
                    */
                    if($validInput == true){
                        if ($v == "new") {
                            $education = new ElggObject();
                            $education->subtype = "education";
                            $education->owner_guid = $user_guid;
                        } else {
                            $education = get_entity($v);
                        }
                        $education->title = htmlentities($school[$k]);
                        $education->description = htmlentities($degree[$k]);
                        $education->school = htmlentities($school[$k]);
                        $education->startdate = $startdate[$k];
                        $education->startyear = $startyear[$k];
                        $education->enddate = $enddate[$k];
                        $education->endyear = $endyear[$k];
                        $education->ongoing = $ongoing[$k];
                        //$education->program = htmlentities($program[$k]);
                        $education->degree = htmlentities($degree[$k]);
                        $education->field = htmlentities($field[$k]);
                        $education->access_id = $access;
                        if ($v == "new") {
                            $education_guids[] = $education->save();
                        } else {
                            $education->save();
                        }
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
        case 'work-experience':
            $work_experience = get_input('work');
            $edit = $work_experience['edit'];
            $delete = $work_experience['delete_guids'];
            $access = get_input('access');
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
            if ( is_array($edit) ) {
                foreach ($edit as $work) {
                    $validInput = true;
                    /*
                    if($work['ongoing'] == true){
                        $work['endyear'] = $work['startyear'];
                    }
                    */
                    //validation of work experience entry
                    if(trim($work['title']) == '' || trim($work['organization']) == ''){
                        $validInput = false;
                        $error = true;
                    }
                    /*
                    if(trim($work['endyear']) < trim($work['startyear'])){
                        $validInput = false;
                        $error = true;
                    }
                    */
                    if($validInput == true) {
                        if ($work['eguid'] == "new") {
                            $experience = new ElggObject();
                            $experience->subtype = "experience";
                            $experience->owner_guid = $user_guid;
                        } else {
                            $experience = get_entity($work['eguid']);
                        }
                        $experience->title = htmlentities($work['title']);
                        $experience->description = htmlentities($work['responsibilities']);
                        $experience->organization = htmlentities($work['organization']);
                        $experience->startdate = $work['startdate'];
                        $experience->startyear = $work['startyear'];
                        $experience->enddate = $work['enddate'];
                        $experience->endyear = $work['endyear'];
                        $experience->ongoing = $work['ongoing'];
                        $experience->responsibilities = trim($work['responsibilities']);
                        $experience->colleagues = $work['colleagues'];
                        $experience->access_id = $access;
                        if ($work['eguid'] == "new") {
                            $work_experience_guids[] = $experience->save();
                        } else {
                            $experience->save();
                        }
                    }
                }
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
            //$access = ACCESS_LOGGED_IN;
            $access = get_input('access');
            //error_log('test - '.$access);
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
            $user->skill_access = $access;
            $user->save();
            
            break;
        case 'old-skills':
            $user->skillsupgraded = TRUE;
            break;
        case 'languages':
            $firstlang = get_input('firstlang', '');
            $french = get_input('french', 'ERROR: Ask your admin to grep: ASFDJKGJKG333616.');
            $english = get_input('english', 'ERROR: Ask your admin to grep: SDFANLVNVNVNVNVNAA31566.');
            $languagesToAdd = get_input('langadded', 'ERROR: Ask your admin to grep: 5FH13FFSSGAHHHS0021.');
            $languagesToRemove = get_input('langremoved', 'ERROR: Ask your admin to grep: 5AAAAGGFH13GAH0022.');
            //$access = get_input('access');    // not used
			$access = get_input('access_id');
            $user->english = $english;
            $user->french = $french;
            $user->officialLanguage = $firstlang;
            $user->save();
			
			$metadata = elgg_get_metadata(array(
                'metadata_names' => array('english'),
                'metadata_owner_guids' => array(elgg_get_logged_in_user_guid()),
            ));
            if ($metadata){
                foreach ($metadata as $data){
					
                    update_metadata($data->id, $data->name, $data->value, $data->value_type, $data->owner_guid, $access);
                    //error_log('id '.$data->id .' name '. $data->name.' value '. $data->value.' value type '. $data->value_type.' owner_guid '.$data->owner_guid.' $access '. $access);
                }
                //$metadata[0]->save();
            }
            $metadata = elgg_get_metadata(array(
                'metadata_names' => array('french'),
                'metadata_owner_guids' => array(elgg_get_logged_in_user_guid()),
            ));
            if ($metadata){
                foreach ($metadata as $data){
                    
                    update_metadata($data->id, $data->name, $data->value, $data->value_type, $data->owner_guid, $access);
                }
                //$metadata[0]->save();
            }
			$metadata = elgg_get_metadata(array(
                'metadata_names' => array('officialLanguage'),
                'metadata_owner_guids' => array(elgg_get_logged_in_user_guid()),
            ));
            if ($metadata){
                foreach ($metadata as $data){
                    
                    update_metadata($data->id, $data->name, $data->value, $data->value_type, $data->owner_guid, $access);
                }
                //$metadata[0]->save();
            }
			
            break;
        case 'portfolio':
            $portfolio = get_input('portfolio');
            $edit = $portfolio['edit'];
            $delete = $portfolio['delete_guids'];
            $access = get_input('access');
            $portfolio_list = $user->portfolio;
            if (!(is_array($delete))) { $delete = array($delete); }
            foreach ($delete as $delete_guid) {
                if ($delete_guid != NULL) {
                    if ($delete = get_entity($delete_guid)) {
                        $delete->delete();
                    }
                    if (is_array($portfolio_list)) {
                        if (($key = array_search($delete_guid, $portfolio_list)) !== false) {
                            unset($portfolio_list[$key]);
                        }
                    }
                    elseif ($portfolio_list == $delete_guid) {
                        $portfolio_list = null;
                    }
                }
            }
            $user->portfolio = $portfolio_list;
            $portfolio_list_guids = array();
            //create new work experience entries
            foreach ($edit as $portfolio_edit) {
                $validInput = true;
                if(trim($portfolio_edit['title']) == '' || trim($portfolio_edit['description']) == '' || trim($portfolio_edit['link']) == ''){
                    $validInput = false;
                    $error = true;
                }
                if($portfolio_edit['datestamped'] == false && trim( $portfolio_edit['pubdate']) == ''){
                    $validInput = false;
                    $error = true;
                }
                if($validInput == true){
                    if ($portfolio_edit['eguid'] == "new") {
                        $entry = new ElggObject();
                        $entry->subtype = "portfolio";
                        $entry->owner_guid = $user_guid;
                    }
                    else {
                        $entry = get_entity($portfolio_edit['eguid']);
                    }
                    $entry->title = htmlentities($portfolio_edit['title']);
                    $entry->description = htmlentities($portfolio_edit['description']);
                    $entry->link = $portfolio_edit['link'];
                    $entry->pubdate = $portfolio_edit['pubdate'];
                    $entry->datestamped = $portfolio_edit['datestamped'];
                    $entry->access_id = $access;
                    if($portfolio_edit['eguid'] == "new") {
                        $portfolio_list_guids[] = $entry->save();
                    }
                    else {
                        $entry->save();
                    }
                }
            }
            if ($user->portfolio == NULL) {
                $user->portfolio = $portfolio_list_guids;
            }
            else {
                $stack = $user->portfolio;
                if (!(is_array($stack))) { $stack = array($stack); }
                if ($portfolio_list_guids != NULL) {
                    $user->portfolio = array_merge($stack, $portfolio_list_guids);
                }
            }
            //$user->portfolio = null;
            $user->portfolio_access = $access;
            $user->save();
            break;
        
        /*
         * MODIFIED CODE!
         * optset is the array of opt-in choices and gets directly saved as a metadata array (cannot be associative).
         * access is not currently being used for anything.
         */
        case 'opt-in':
            $opt_in_set = get_input('opt_in_set');
            $access = get_input('access');
            
            $user->opt_in_missions = $opt_in_set[0];
            $user->opt_in_swap = $opt_in_set[1];
            $user->opt_in_mentored = $opt_in_set[2];
            $user->opt_in_mentoring = $opt_in_set[3];
            $user->opt_in_shadowed = $opt_in_set[4];
            $user->opt_in_shadowing = $opt_in_set[5];
            $user->opt_in_jobshare = $opt_in_set[6];
            $user->opt_in_pcSeek = $opt_in_set[7];
            $user->opt_in_pcCreate = $opt_in_set[8];
            $user->opt_in_ssSeek = $opt_in_set[9];
            $user->opt_in_ssCreate = $opt_in_set[10];
            $user->opt_in_rotation = $opt_in_set[11];
            $user->opt_in_assignSeek = $opt_in_set[12];
            $user->opt_in_assignCreate = $opt_in_set[13];
            $user->opt_in_deploySeek = $opt_in_set[14];
            $user->opt_in_deployCreate = $opt_in_set[15];
            $user->opt_in_missionCreate = $opt_in_set[16];
            /*$user->opt_in_peer_coached = $opt_in_set[6];
              $user->opt_in_peer_coaching = $opt_in_set[7];
              $user->opt_in_skill_sharing = $opt_in_set[8];
              $user->opt_in_job_sharing = $opt_in_set[9];*/
            
            // Not saving this at the moment because it is not in use.
            //$user->optaccess = $access;
            
            $user->save();
            
            break;
        /*
         * END MODIFIED CODE
         */
            
        default:
            system_message(elgg_echo("profile:saved"));
    }
    //system_message(elgg_echo("profile:saved"));
    if($error == true){
       register_error(elgg_echo('Not all information could be saved, empty fields are not allowed'));
    } else {
        system_message(elgg_echo("profile:saved"));
    }
}
else {  // In case this view will be called via the elgg_view_form() action, then we know it's the basic profile only
}