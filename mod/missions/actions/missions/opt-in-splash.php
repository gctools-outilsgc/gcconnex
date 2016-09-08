<?php
//This action lets users opt in from the splash page
$user = elgg_get_logged_in_user_entity();
           	$opt_in_mission = get_input('mission_check');
            $opt_in_swap = get_input('swap_check');
            $opt_in_mentored = get_input('mentored_check');
            $opt_in_shadowed = get_input('shadowed_check');
            $opt_in_mentoring = get_input('mentoring_check');
            $opt_in_shadowing = get_input('shadowing_check');
            $access = get_input('access');
            
            $opt_in_inputs = array($opt_in_mission, $opt_in_swap, $opt_in_mentored, $opt_in_shadowed, $opt_in_mentoring, $opt_in_shadowing);
    //Nick - Loop through array of selected things and change their value to match the meta data        
foreach($opt_in_inputs as $k => $v){
    if($v == 'on'){
        $opt_in_inputs[$k]  = 'gcconnex_profile:opt:yes';
    }else{
        $opt_in_inputs[$k]  = 'gcconnex_profile:opt:no';   
    }
}

            $user->opt_in_missions = $opt_in_inputs[0];
            $user->opt_in_swap = $opt_in_inputs[1];
            $user->opt_in_mentored = $opt_in_inputs[2];
            $user->opt_in_mentoring = $opt_in_inputs[3];
            $user->opt_in_shadowed = $opt_in_inputs[4];
            $user->opt_in_shadowing = $opt_in_inputs[5];
            /*$user->opt_in_peer_coached = $opt_in_set[6];
            $user->opt_in_peer_coaching = $opt_in_set[7];
            $user->opt_in_skill_sharing = $opt_in_set[8];
            $user->opt_in_job_sharing = $opt_in_set[9];*/
            
            // Not saving this at the moment because it is not in use.
            //$user->optaccess = $access;
            
            //$user->save();
            //system_message($opt_in_inputs[0].' '. $opt_in_inputs[1] . ' '. $opt_in_mentored . ' '. $opt_in_shadowed .' '. $opt_in_mentoring . ' ' . $opt_in_shadowing );
?>