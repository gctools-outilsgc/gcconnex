<?php
/**
 * Elgg add comment action
 *
 * @package Elgg.Core
 * @subpackage Comments
 */


$entity_guid = (int) get_input('entity_guid');
$comment_text = get_input('generic_comment');

if (empty($comment_text)) {
	register_error(elgg_echo("generic_comment:blank"));
	forward(REFERER);
}

// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("generic_comment:notfound"));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

$annotation = create_annotation($entity->guid,
								'generic_comment',
								$comment_text,
								"",
								$user->guid,
								$entity->access_id);

// tell user annotation posted
if (!$annotation) {
	register_error(elgg_echo("generic_comment:failure"));
	forward(REFERER);
}

// notify if poster wasn't owner
if ($entity->owner_guid != $user->guid) {
	$the_entity = $entity->getContainerEntity();
	//$the_group = $the_entity->getContainer();
	$curr_user = get_user($entity->owner_guid);
	
	// get the message, and check for bilingualism/truncate message if it's too long (25 chars)
	$subj_line = c_validate_string(utf8_encode(html_entity_decode($entity->title, ENT_QUOTES | ENT_HTML5 )));
	if (!is_array($subj_line))
	{
		$lang01 = $subj_line;
		$lang02 = $subj_line;
	} else {
		$lang01 = $subj_line[0];
		$lang02 = $subj_line[1];
	}
	
	notify_user($entity->owner_guid,
		$user->guid,
		elgg_echo('generic_comment:email:subject', array($lang01, $lang02)),
		elgg_echo('generic_comment:email:body', array(
			$curr_user->name,
			$entity->title,
			$user->name,
			$comment_text,
			$entity->getURL(),
			$user->name,
			$user->getURL(),
			elgg_get_site_url().'notifications/personal/'.$curr_user->name,
			elgg_get_site_url().'notifications/group/'.$curr_user->name,

			$curr_user->name,
			$user->name,
			$entity->title,
			$comment_text,
			$entity->getURL(),
			$user->name,
			$user->getURL(),
			elgg_get_site_url().'notifications/personal/'.$curr_user->name,
			elgg_get_site_url().'notifications/group/'.$curr_user->name,
		))
	);
}

system_message(elgg_echo("generic_comment:posted"));

//add to river
add_to_river('river/annotation/generic_comment/create', 'comment', $user->guid, $entity->guid, "", 0, $annotation);

// Forward to the page the action occurred on
forward(REFERER);
