<?php

/**
 * Wet 4 theme custom activity widget
 * (Display colleague and group activity)
 *
 * content description.
 *
 * @version 1.0
 * @author Owner
 
    
        /*
 

        */


        //YOLO CODE V2



if(elgg_is_logged_in()){
        $_SESSION['Suggested_friends']=0;
        $title = elgg_echo('river:all');
        $user = elgg_get_logged_in_user_entity();
        $db_prefix = elgg_get_config('dbprefix');
        $page_filter = 'all';

        if ($user) {
            //check if user exists and has friends or groups
            $hasfriends = $user->getFriends();
            $hasgroups = $user->getGroups();
            if($hasgroups){
                //loop through group guids
                $groups = $user->getGroups(array(), false);
                $group_guids = array();
                foreach ($groups as $group) {
                    $group_guids[] = $group->getGUID();
                }
            }
           
        }
        if(!$hasgroups && !$hasfriends){
            //no friends and no groups :(
            $activity = '';
        }else if(!$hasgroups && $hasfriends){
            //has friends but no groups 
            $optionsf['relationship_guid'] = elgg_get_logged_in_user_guid();
            $optionsf['relationship'] = 'friend';
            $optionsf['pagination'] = true;
            $activity = elgg_list_river($optionsf);
        }else if(!$hasfriends && $hasgroups){
            //if no friends but groups
            $guids_in = implode(',', array_unique(array_filter($group_guids)));
            $optionsg['joins'] = array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid");
            $optionsg['wheres'] = array("(e1.container_guid IN ($guids_in))");
            $optionsg['pagination'] = true;
            $activity = elgg_list_river($optionsg);
        }else{
            //if friends and groups :3
            $guids_in = implode(',', array_unique(array_filter($group_guids)));

            $optionsfg['joins'] = array("JOIN {$db_prefix}entities e ON e.guid = rv.object_guid");
            //Groups + Friends activity query
            $optionsfg['wheres'] = array("
        e.container_guid IN({$guids_in})
        OR rv.subject_guid IN (SELECT guid_two FROM {$db_prefix}entity_relationships WHERE guid_one=$user->guid AND relationship='friend')
        ");
            $optionsfg['pagination'] = true;
            $activity = elgg_list_river($optionsfg);
        }
        /*
        if($hasfriends){
        //friends activity only (if they only have friends no groups)
        }else if($hasgroups){
        //only groups but no friends
        }else if($hasgroups && $hasfriends){
        //groups and friends

        }else{
        //nothing :(
        }
        */


        if (!$activity) {
            //if the user doesn't have any friends or activity display this message
            $site_url = elgg_get_site_url();
            $featuredGroupButton = elgg_view('output/url', array(
		        'href' => $site_url .'groups/all?filter=feature',
		        'text' => elgg_echo('wetActivity:browsegroups'),
		        'class' => 'btn btn-primary',
		        'is_trusted' => true,
	        ));
            //$activity = elgg_echo('river:none');
            //placeholder panel 
            $activity .= '<div class="panel panel-custom"><div class="panel-body">';
            $activity .= '<h3 class="panel-title mrgn-tp-md">'.elgg_echo('wetActivity:welcome').'</h3>';
            $activity .= '<div class="mrgn-bttm-md mrgn-tp-sm">'.elgg_echo('wetActivity:nocollorgroup').'</div>';
            $activity .= '<div>'.$featuredGroupButton.'</div>';
            $activity .= '</div></div>';
            //$activity .= 'You should join some groups or something dawg.';
            //we can put a link here (or suggested groups and stuff) as well to invite users to join groups or have colleagues and stuff
        }

    }else{
        //if the user is not logged in then display a login thing to invite users to login and register :3
        $title = elgg_echo('login');
        $body = elgg_view_form('login');
        $login_ = elgg_view_module('index',$title, $body);
        
        //display the notice message on the home page only when not logged in, and in the language user wants
        $notice_title = elgg_echo('wet4:noticetitle');
        $notice_body = elgg_echo('wet4:homenotice');
        $notice_ = elgg_view_module('index', $notice_title, $notice_body);
        echo $notice_;
        echo $login_;
}


//echo out the yolo code
echo $activity;

