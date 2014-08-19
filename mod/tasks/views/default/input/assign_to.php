<?php

	$result ='';
	$user  = elgg_get_logged_in_user_entity();
	//$owner = get_entity($vars["entity"]->getOwner());
	
	//$result  = elgg_echo("groups:owner") . ": <a href='" . $owner->getUrl() . "'>" . $owner->name."</a>&nbsp;";
	//$result .= elgg_echo("tasks:transfer") . ": ";
	$result .= "<select name='assigned_to' id='assigned_to' class='elgg-input-dropdown elgg-input-access'>\n";
	
	
	$result .= "<option value='" . $user->getGUID() . "'>" . elgg_echo("tasks:transfer:myself") . "(" . $user->name .")" . "</option>\n";
	
	
	//$result .= "<optgroup label='" .elgg_echo("groups:owner"). "'>\n";
	//$result .= "<option value='" . $owner->guid . "'>" . $owner->name . "</option>\n";
	//$result .= "</optgroup>\n";
	
	
	$friends_options = array(
		"type" => "user",
		"relationship" => "friend",
		"relationship_guid" => $user->getGUID(),
		"limit" => false,
	);
	$friends = elgg_get_entities_from_relationship($friends_options); 
	
	if(!empty($friends)){
		$add_friends = false;
		$friends_block .= "<optgroup label='" . elgg_echo("friends") . "'>\n";
		
		foreach($friends as $friend){
			if($user->getGUID() != $friend->getGUID()){
				$add_friends = true;
				if ($vars['value'] == $friend->getGUID())
					$friends_block .= "<option selected value='" . $friend->getGUID() . "'>" . $friend->name . "</option>\n";
				else
					$friends_block .= "<option value='" . $friend->getGUID() . "'>" . $friend->name . "</option>\n";
			}
		}
		
		$friends_block .= "</optgroup>\n";
		
		if($add_friends){
			$result .= $friends_block;
		}
	}
	
	
	if($vars["entity"] instanceof ElggGroup){ 
		
		$member_options = array(
			"type" => "user",
			"relationship" => "member",
			"relationship_guid" => $group->getGUID(),
			"inverse_relationship" => true,
			"limit" => false,
		);
		$members = elgg_get_entities_from_relationship($member_options);
		
		if(!empty($members)){
			$add_members = false;
			
			$members_block .= "<optgroup label='" . elgg_echo("groups:members") . "'>\n";
			
			foreach($members as $member){
				if(($group->getOwner() != $member->getGUID()) && ($user->getGUID() != $member->getGUID())){
					$add_members = true;
					
					$members_block .= "<option value='" . $member->getGUID() . "'>" . $member->name . "</option>\n";
				}
			}
			
			$members_block .= "</optgroup>\n";
			if($add_members){
				$result .= $members_block;
			}
		}
		
	}

	$result .= "</select>";
	echo $result;
		

?>