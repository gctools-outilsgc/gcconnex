<?php

$page = elgg_extract('page', $vars);
switch ($page) {
	case 'all':
	case 'open':
		echo elgg_view('page/elements/comments_block', array(
			'subtypes' => 'event_calendar',
		));
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'event_calendar',
		));
		break;
	case 'owner':
	case 'mine':
	case 'group':
		echo elgg_view('page/elements/comments_block', array(
			'subtypes' => 'event_calendar',
			'owner_guid' => elgg_get_page_owner_guid(),
		));
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'event_calendar',
			'owner_guid' => elgg_get_page_owner_guid(),
		));
		break;
	case 'full_view':
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'event_calendar',
		));
		break;
}
