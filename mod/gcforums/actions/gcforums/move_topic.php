<?php

$topics = str_replace(' ', '', get_input('txtTopic'));
$forum = (int)get_input('txtForum');

$error = "";

// validate that the inputs are correct
if (!preg_match("/[\d*,\s?]+/", $topics)) {
	$error .= "<p>invalid input for topics</p>";
}

if (!is_bool($forum)) {
	$error .= "<p>invalid input for forums</p>";
}

if ($error) {
	register_error($error);
	return;
}

$topic_guids = explode(',', $topics);

foreach ($topic_guids as $topic_guid) {
	$topic_entity = get_entity($topic_guid);
	$topic_entity->container_guid = $forum;
	$topic_entity->save();
}

system_message("topic(s) were successfully moved!");
