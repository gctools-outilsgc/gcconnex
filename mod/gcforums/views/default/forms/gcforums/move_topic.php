<?php

$notice = "<p><form action='{$base_url}gcforums/move_topic'><div class='administrative-topic-tool'>
			<section class='alert alert-danger'>
				<strong>This only shows up for administrators</strong>.
				<p>Administrative tool that will enable to move topics to a different forum. <strong><u>PLEASE USE ON YOUR OWN RISK</u></strong>.</p>
				<p>the source guid can be separated with commas.</p>
			</section>";

$txtTopic = elgg_view('input/text', array(
	'name' => 'txtTopic',
	'value' => '',
));

$txtForum = elgg_view('input/text', array(
	'name' => 'txtForum',
	'value' => '',
));

$btnMove = elgg_view('input/submit', array(
	'value' => elgg_echo('gcforums:save_button'),
	'name' => 'save'
));

$content .= "{$notice} <label>Source (Forum Topic GUIDs) </label> {$txtTopic} <label>Target (Forum GUID) </label> {$txtForum} <br/> {$btnMove}</div></form></p>";

echo $content;
