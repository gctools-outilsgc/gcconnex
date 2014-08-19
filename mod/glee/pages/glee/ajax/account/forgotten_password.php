<?php

require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . "/engine/start.php");

if (elgg_is_logged_in()) {
	return;
}

$title = elgg_echo("user:password:lost");
$content = elgg_view_title($title);

$content .= elgg_view_form('user/requestnewpassword', array(
	'class' => 'elgg-form-account',
));

echo $content;