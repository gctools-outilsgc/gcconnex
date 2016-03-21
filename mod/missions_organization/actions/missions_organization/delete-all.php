<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to uproot and delete the entire organization tree.
 */
$options['type'] = 'object';
$options['subtype'] = 'orgnode';
$options['limit'] = 0;
$entities = elgg_get_entities($options);

$count = 0;

foreach($entities as $entity) {
	remove_entity_relationships($entity->guid);
	$entity->delete();
	$count++;
}

//system_message($count . '#');

forward(REFERER);