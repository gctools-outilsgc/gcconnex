<?php

$title = elgg_echo('upload_users:upload');

$body = elgg_view_form('upload_users/upload', array(
	'enctype' => 'multipart/form-data',
	'method' => 'POST',
	'id' => 'upload-users-upload-form',
	'class' => 'mam'
		), array());

echo elgg_view_module('aside', $title, $body, array(
	'class' => 'mam'
));