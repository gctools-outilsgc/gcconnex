<?php

if (!HYPEFORUM_USER_SIGNATURE) {
	return true;
}

$entity = elgg_extract('entity', $vars);

$signature = elgg_get_plugin_user_setting('hypeforum_signature', $entity->guid, 'hypeForum');

if ($signature) {
	echo elgg_view('output/longtext', array(
		'value' => $signature,
		'class' => 'hj-forum-user-signature'
	));
}
