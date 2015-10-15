<?php

if ($vars['events']) {
	foreach ($vars['events'] as $entity) {
		echo elgg_view_entity($entity['event']);
	}
}
