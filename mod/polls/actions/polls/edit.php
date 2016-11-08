<?php
/*
 *
 * Elgg polls: add action
 *
 */

elgg_load_library('elgg:polls');
// start a new sticky form session in case of failure
elgg_make_sticky_form('polls');

// Get input data
$question = get_input('question');
$question2 = get_input('question2');
$number_of_choices = (int) get_input('number_of_choices',0);
$number_of_choices2 = (int) get_input('number_of_choices2',0);
$tags = get_input('tags');
$access_id = get_input('access_id');
$container_guid = get_input('container_guid');
$guid = get_input('guid');

// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($tags);

//get response choices
$count = 0;
$count2 = 0;
$count3 = 0;
$new_choices = array();
$new_choices2 = array();
$new_choices3 = array();
if ($number_of_choices) {
	for($i=0;$i<$number_of_choices;$i++) {
		$text = get_input('choice_text_'.$i,'');
		if ($text) {
			$new_choices[] = $text;
			$count ++;
		}
	}
}

if ($number_of_choices2) {
	for($i=0;$i<$number_of_choices2;$i++) {
		$text2 = get_input('choice_text_f'.$i,'');
		if ($text2) {
			$new_choices2[] = $text2;
			$count2 ++;
		}
	}
}

if ($number_of_choices2>=$number_of_choices ) {
	for($i=0;$i<$number_of_choices2;$i++) {
		$text = get_input('choice_text_'.$i,'');
		$text2 = get_input('choice_text_f'.$i,'');
			if (empty($text)){
			$text = $text2;
		}
		if (($text2) ||($text)) {
			$new_choices3[] = gc_implode_translation($text,$text2);
			$count3 ++;
		}
	}
	
}else{

for($i=0;$i<$number_of_choices;$i++) {
		$text = get_input('choice_text_'.$i,'');
		$text2 = get_input('choice_text_f'.$i,'');
			if (empty($text2)){
			$text2 = $text;
		}
		if (($text2) ||($text)){
				$new_choices3[] = gc_implode_translation($text,$text2);
			$count3 ++;
		}
	}
}

$user = elgg_get_logged_in_user_entity();

if ($guid) {
	// editing an existing poll
	$poll = get_entity($guid);
	if (elgg_instanceof($poll,'object','poll') && $poll->canEdit()) {
		$container_guid = $poll->container_guid;
		// Make sure the question / responses aren't blank
		if  ((($count2 == 0) && ($count == 0)) || ((empty($question)) && (empty($question2)))) {
			register_error(elgg_echo("polls:blank"));
			forward("polls/edit/".$guid);
			exit;
			// Otherwise, save the poll
		} else {
			$poll->access_id = $access_id;
			$poll->question = $question;
			$poll->question2 = $question2;
			$poll->title3 = gc_implode_translation($question,$question2);
				
			if (!$poll->save()) {
				register_error(elgg_echo("polls:error"));
				if ($container_guid) {
					forward("polls/add/".$container_guid);
				} else {
					forward("polls/add");
				}
				exit;
			}
			
			elgg_clear_sticky_form('polls');
			polls_delete_choices($poll);
			polls_delete_choices2($poll);
			polls_delete_choices3($poll);
			polls_add_choices3($poll,$new_choices3);
			polls_add_choices2($poll,$new_choices2);
			polls_add_choices($poll,$new_choices);
			if (is_array($tagarray)) {
				$poll->tags = $tagarray;
			}
			
			// Success message
			system_message(elgg_echo("polls:edited"));
		}
	}
} else {
	if (!$container_guid) {
		$polls_site_access = elgg_get_plugin_setting('site_access', 'polls');
		$allowed = (elgg_is_logged_in() && ($polls_site_access != 'admins')) || elgg_is_admin_logged_in();		
		if (!$allowed) {
			register_error(elgg_echo('polls:can_not_create'));
			elgg_clear_sticky_form('polls');
			forward('polls/all');
			exit;
		}
	}
	// Make sure the question / responses aren't blank
	if ((($count2 == 0) && ($count == 0)) || ((empty($question)) && (empty($question2)))) {
		register_error(elgg_echo("polls:blank"));
		if ($container_guid) {
			forward("polls/add/".$container_guid);
		} else {
			forward("polls/add");
		}		
	} else {
		
		// Otherwise, save the poll
		// Initialise a new ElggObject
		$poll = new ElggObject();
	
		// Tell the system it's a poll
		$poll->subtype = "poll";
	
		// Set its owner to the current user
		$poll->owner_guid = $user->guid;
		$poll->container_guid = $container_guid;
		$poll->access_id = $access_id;
		$poll->question = $question;
		$poll->question2 = $question2;
		$poll->title3 = gc_implode_translation($question,$question2);
		
		if(!$poll->question){
			$poll->title = $poll->question2;
		}else{
			$poll->title = $poll->question;
		}
		if (!$poll->save()) {
			register_error(elgg_echo("polls:error"));
			if ($container_guid) {
				forward("polls/add/".$container_guid);
			} else {
				forward("polls/add");
			}
			exit;
		}
		
		elgg_clear_sticky_form('polls');

		polls_add_choices($poll,$new_choices);
		polls_add_choices2($poll,$new_choices2);
		polls_add_choices3($poll,$new_choices3);
	
		if (is_array($tagarray)) {
			$poll->tags = $tagarray;
		}
		
		$polls_create_in_river = elgg_get_plugin_setting('create_in_river','polls');
		if ($polls_create_in_river != 'no') {	
			add_to_river('river/object/poll/create','create',elgg_get_logged_in_user_guid(),$poll->guid);
		}
	
		// Success message
		system_message(elgg_echo("polls:added"));
	}
}

// Forward to the poll page
forward($poll->getURL());
exit;
