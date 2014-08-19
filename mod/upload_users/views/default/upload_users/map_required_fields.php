<?php

$title = elgg_echo('upload_users:attributes');

$body = elgg_view_form('upload_users/map_required_fields', array(
	'id' => 'upload-users-attributes-form',
	'class' => 'mam'
		));

echo elgg_view_module('aside', $title, $body, array(
	'class' => 'mam'
));
