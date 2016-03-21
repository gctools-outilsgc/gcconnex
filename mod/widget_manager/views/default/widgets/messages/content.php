<?php
	
if (!elgg_is_logged_in()) {
	echo elgg_echo("widgets:messages:not_logged_in");
} else {
	$widget = $vars["entity"];
	
	$max_messages = sanitise_int($widget->max_messages, false);
	if (empty($max_messages)) {
		$max_messages = 5;
	}
	
	$options = array(
		'type' => 'object',
		'subtype' => 'messages',
		"metadata_name_value_pairs" => array(
			"toId" => elgg_get_logged_in_user_guid()
		),
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'full_view' => false,
		"limit" => $max_messages
	);
	
	if ($widget->only_unread != "no") {
		$options["metadata_name_value_pairs"]["readYet"] = 0;
	}
	
	$list = "";
	if ($messages = elgg_get_entities_from_metadata($options)) {
		$list .= "<ul class='elgg-list'>";
		foreach ($messages as $message) {
			$icon = "";
			if ($user = get_user(($message->fromId))) {
				$icon = elgg_view_entity_icon($user, 'tiny');
			}

			if ($message->readYet) {
				$class = 'message read';
			} else {
				$class = 'message unread';
			}
			
			$timestamp = elgg_view_friendly_time($message->time_created);
			$subject_info = elgg_view('output/url', array(
				'href' => $message->getURL(),
				'text' => $message->title,
				'is_trusted' => true,
			));
			
			$body = '<div>' . $subject_info . '</div><div class="elgg-subtext">' . $timestamp . '</div>';
			
			$list .= "<li>" . elgg_view_image_block($icon, $body, array('class' => $class)) . "</li>";
		}
		$list .= "</ul>";
	}
	
	if (!empty($list)) {
		echo $list;
	} else {
		echo elgg_echo("messages:nomessages");
	}

	echo "<div class='elgg-widget-more'><a href='" . elgg_get_site_url() . "messages/compose'>" . elgg_echo("messages:add") . "</a></div>";
}
