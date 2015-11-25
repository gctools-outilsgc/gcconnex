<?php
/**
 * File renderer.
 *
 * @package ElggFile
 */

$full = elgg_extract('full_view', $vars, false);
$message = elgg_extract('entity', $vars, false);
$bulk_actions = (bool) elgg_extract('bulk_actions', $vars, false);

if (!$message) {
	return true;
}

if ($message->toId == elgg_get_page_owner_guid()) {
	// received
	$user = get_user($message->fromId);
	if ($user) {
		$icon = elgg_view_entity_icon($user, 'small');
		$user_link = elgg_view('output/url', array(
			//'href' => "messages/compose?send_to=$user->guid",
			'text' => $user->name,
			'is_trusted' => true,
		));
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	if ($message->readYet) {
		$class = 'message read';
	} else {
		$class = 'message unread-custom';
	}

} else {
	// sent
	$user = get_user($message->toId);

	if ($user) {
		$icon = elgg_view_entity_icon($user, 'small');
		$user_link = elgg_view('output/url', array(
			'href' => "messages/compose?send_to=$user->guid",
			'text' => elgg_echo('messages:to_user', array($user->name)),
			'is_trusted' => true,
		));
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	$class = 'message read';
}

$timestamp = elgg_view_friendly_time($message->time_created);

$subject_info = elgg_view('output/url', array(
	'href' => $message->getURL(),
	'text' => $message->title,
	'is_trusted' => true,
));

$delete_link = elgg_view("output/url", array(
						'href' => "action/messages/delete?guid=" . $message->getGUID() . "&full=$full",
						'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">Delete This</span></i>',
						'confirm' => elgg_echo('deleteconfirm'),
						'encode_text' => false,
					));

$checkbox = elgg_view('input/checkbox', array(
			'name' => 'message_id[]',
			'value' => $message->guid,
			'default' => false,
		));
$messageLink = $message->getURL();

$body = <<<HTML

<div class="mrgn-bttm-md clearfix">

<div class="messages-chkbx">$checkbox</div>
<div class="messages-owner">$user_link</div>
<div class="messages-subject">$subject_info</div>
<div class="messages-timestamp">$timestamp</div>
<div class="messages-delete">$delete_link</div>

</div>

HTML;

if ($full) {
    //echo '<a href="'.$messageLink.'">';
  
	echo   elgg_view_image_block($icon, $body, array('class' => $class));
	echo elgg_view('output/longtext', array('value' => $message->description));
    //echo '</a>';

} else {
	
    //Making the body preview dissapear!
	//$body .= elgg_view("output/longtext", array("value" => elgg_get_excerpt($message->description), "class" => "elgg-subtext clearfloat "));
	
	if ($bulk_actions) {
		$checkbox = elgg_view('input/checkbox', array(
			'name' => 'message_id[]',
			'value' => $message->guid,
			'default' => false,
		));
	
		$entity_listing = elgg_view_image_block($icon, $body, array('class' => $class));
		
		echo  $entity_listing;
	} else {
        
        //echo elgg_view_image_block($checkbox, $entity_listing);
		echo elgg_view_image_block( $icon, $body, array('class' => $class));
      
	}
}