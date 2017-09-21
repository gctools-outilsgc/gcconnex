<?php

$options = array(
	'type' => 'object',
	'subtype' => LINKEDIN_PROJECT_SUBTYPE,
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => false,
	'full_view' => FALSE,
	'pagination' => FALSE
);
$content = elgg_list_entities($options);

echo $content;
