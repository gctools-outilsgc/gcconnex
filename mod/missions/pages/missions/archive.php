<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
gatekeeper();

$title = elgg_echo('missions:mission_archive');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['metadata_name_value_pairs'] = array(array(
		'name' => 'state',
		'value' => 'completed'
), array(
		'name' => 'state',
		'value' => 'cancelled'
));
$options['metadata_name_value_pairs_operator'] = 'OR';
$options['limit'] = 0;
$entity_list = elgg_get_entities_from_metadata($options);

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

$content .= '<div style="display:block;">' . elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
		'mission_full_view' => false
), $offset, $max) . '</div>';

echo elgg_view_page($title, $content);