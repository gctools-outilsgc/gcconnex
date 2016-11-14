<?php
/*
* Ajax view that builds the list of people in an organization.
* Checks each person in list to see if they are member of the site already
* if GCconnex member adds profile picture, and link to profile page, and link to add as college (friend)
* if not a member of GCconnex, adds GEDS profile picture, and link to invite to GCconnex.
* invatiation email is handled in invite friends mod, and email text is overridden in c_notification_messages mod by Christine Yu
*
* Modified by Ethan Wallace (2016-04-26) - Changed layout of gcconnex users to be consistant with non-gcconnex users
*
*/

// check that this is xhr request (ajax call)
if (elgg_is_xhr()) {
	//get JSON string of org members passed from org-panel
	$peopleString = get_input('orgPeopleData');
	// convert JSON string to php object
	$people = json_decode($peopleString);
    shuffle($people);
	//loop through list of people
	$x = 0;
	foreach($people as $person){
		//create div for each person

		//check for user with matching email address
		$user_entity = get_user_by_email($person->mail);
        if($person->guid == elgg_get_logged_in_user_guid() || check_entity_relationship(elgg_get_logged_in_user_guid(), 'friend', $user_entity[0]->guid)){

        } else if ($user_entity && $x < 6){ //is member
            echo "<div class='org-person' id='person".$x++."'>";
			if (is_array($user_entity)){ //array should be returned by get_user_by_email()
				// more than one user with same email. shouldnt happen but just in case
				if (count($user_entity)>1)
					echo $person->gn." ".$person->sn."</br>"; //basic view
				else{
					$user_entity = $user_entity[0]; //only one user.
					$icon = elgg_view_entity_icon($user_entity, "medium"); //get connex profile icon

					//build link to users connex profile
					$info = elgg_view("output/url", array(
						"href" => $user_entity->getURL(), //profile url
						"text" => $user_entity->name //profile dispaly name
					));
					$info .= "</br>";
					//if not the user or already a friend of user, build link to add as college
					if ($user_entity->guid!=elgg_get_logged_in_user_guid() && !$user_entity->isFriend() &&elgg_get_logged_in_user_guid()){
						$info .= elgg_view("output/url", array(
							"href" => 'action/friends/add?friend='.$user_entity->guid,
							"text" => elgg_echo('geds:add:friend'),
							"is_action" => true
						));
					}

                    if($user_entity->guid!=elgg_get_logged_in_user_guid()){
                        $htmloutput = '';
                        $site_url = elgg_get_site_url();
                        $userGUID=$user_entity->guid;
                        $job=$user_entity->job;
                        //$user_department=$l->department;
                        $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt onboard-coll">'; // suggested friend link to profile
                        //$htmloutput .= '<a href="'.  $site_url. 'profile/'. $l->username.'" class="">';

                        //EW - change to render icon so new ambassador badges can be shown
                        $htmloutput.= elgg_view_entity_icon($user_entity, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

                        $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$user_entity->getDisplayName().'</span></h4>';
                        if($job){ // Nick - Adding department if no job, if none add a space
                            $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$job.'</p>';
                        }else{
                            $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 min-height-cs"></p>';
                        }

                        //changed connect button to send a friend request we should change the wording

                        $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
                        $htmloutput=$htmloutput.'</div>';


                        echo $htmloutput . '';
                    }
                }
            }

		}else{//not a member of GCconnex

            //echo $person->mail;
			echo "</div>"; //close <div class='org-person-links'>

		}
		echo "</div>"; //close <div class='org-person' id='person".$x++."'>

        echo '</div>';
	}
}
