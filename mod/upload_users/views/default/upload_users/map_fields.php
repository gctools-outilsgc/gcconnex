<?php

$title = elgg_echo('upload_users:mapping');

$body = elgg_view_form('upload_users/map_fields', array(
	'id' => 'upload-users-map-form',
	'class' => 'mam'
		));

echo elgg_view_module('aside', $title, $body, array(
	'class' => 'mam'
));
