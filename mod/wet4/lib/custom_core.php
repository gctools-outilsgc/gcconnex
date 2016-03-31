<?php
/*
* customized, faster list_river function for main page news feed
*/

function newsfeed_list_river(array $options = array()) {
	global $autofeed;
	$autofeed = true;

	$defaults = array(
		'offset'     => (int) max(get_input('offset', 0), 0),
		'limit'      => (int) max(get_input('limit', max(20, elgg_get_config('default_limit'))), 0),
		'pagination' => true,
		'list_class' => 'elgg-list-river',
		'no_results' => '',
	);

	$options = array_merge($defaults, $options);

	if (!$options["limit"] && !$options["offset"]) {
		// no need for pagination if listing is unlimited
		$options["pagination"] = false;
	}

	//$options['count'] = true;
	//$count = elgg_get_river($options);

	//if ($count > 0) {
		$options['count'] = false;
		$items = elgg_get_river($options);
	/*} else {
		$items = array();
	}*/

	//$options['count'] = $count;
	$options['items'] = $items;

	return elgg_view('page/components/list', $options);
}

?>