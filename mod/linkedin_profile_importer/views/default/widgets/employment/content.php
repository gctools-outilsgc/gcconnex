<?php

$options = array(
	'type' => 'object',
	'subtype' => LINKEDIN_POSITION_SUBTYPE,
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => false,
	'full_view' => FALSE,
	'pagination' => FALSE,
	'order_by_metadata' => array(
		array('name' => 'calendar_start_year', 'direction' => 'DESC', 'as' => 'integer'),
		array('name' => 'calendar_start_month', 'direction' => 'DESC', 'as' => 'integer'),
	)
);
$content = elgg_list_entities_from_metadata($options);

echo $content;
