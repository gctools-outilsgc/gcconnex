<?php
/*
* Ajax view that builds the list of people in an organization.
* Checks each person in list to see if they are member of the site already
* if GCconnex member adds profile picture, and link to profile page, and link to add as college (friend)
* if not a member of GCconnex, adds GEDS profile picture, and link to invite to GCconnex.
* invatiation email is handled in invite friends mod, and email text is overridden in c_notification_messages mod by Christine Yu
*/

// check that this is xhr request (ajax call)
if (elgg_is_xhr()) {
	//get JSON string of org members passed from org-panel
	$peopleString = get_input('orgPeopleData');
	// convert JSON string to php object
	$people = json_decode($peopleString);

	//loop through list of people
	$x = 0;
	foreach($people as $person){
		//create div for each person
		echo "<div class='org-person' id='person".$x++."'>";
		//check for user with matching email address
		$user_entity = get_user_by_email($person->mail);

		if ($user_entity){ //is member

			if (is_array($user_entity)){ //array should be returned by get_user_by_email()
				// more than one user with same email. shouldnt happen but just in case
				if (count($user_entity)>1) 
					echo $person->gn." ".$person->sn."</br>"; //basic view
				else{
					$user_entity = $user_entity[0]; //only one user.
					$icon = elgg_view_entity_icon($user_entity, "small"); //get connex profile icon
		
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
					
					echo elgg_view_image_block($icon, $info); //show built person view
				}
			}
			
		}else{//not a member of GCconnex

			echo "<div class='org-avatar-container'>"; //div for image
			echo "<img class='org-avatar' src='$person->imageURL'/>"; //display geds image
			echo "</div>";
			echo "<div class='org-person-links'>";
			//GEDS name stored as surname given name initial etc. build into connex style name
			echo $person->gn." ".$person->sn."</br>"; 
			//build link to invite user to site. if user is logged in
			if (elgg_get_logged_in_user_guid()){
				echo elgg_view(
				"output/url", array(
					"href" => 'action/invitefriends/invite?emails='.$person->mail,
					"text" => elgg_echo('geds:invite:friend'),
					"is_action" => true
				));
			}
			
			echo "</div>"; //close <div class='org-person-links'>
		}
		echo "</div>"; //close <div class='org-person' id='person".$x++."'>
		
	}
}