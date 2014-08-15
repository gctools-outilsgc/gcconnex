<?php
/**
 * Members search page
 *
 */
$offset = $_GET["offset"];
$limit = 10;

if ($vars['search_type'] == 'tag') {
	$tag = get_input('tag');

	$title = elgg_echo('members:title:searchtag', array($tag));

	$options = array();
	$options['query'] = $tag;
	//echo "<script>console.log( 'Tag: ".$tag."' );</script>";
	$options['search_type'] = "tags";
	$options['offset'] = $offset;
	$options['sort'] = "relevance";
	$options['order'] = "desc";
	//echo "<script>console.log( 'offset: ".$offset."' );</script>";
	$options['limit'] = $limit;
	//echo "<script>console.log( 'limit: ".$limit."' );</script>";
	$results = elgg_trigger_plugin_hook('search', 'tags', $options, array());
	//echo "<script>console.log( 'results: ".count($results)."' );</script>";
	$count = $results['count'];
	$users = $results['entities'];
	//echo "<script>console.log( 'count: ".$count."' );</script>";
	//echo "<script>console.log( 'users: ".count($users)."' );</script>";

	elgg_log('cyu - offset:'.$offset, 'NOTICE');
	elgg_log('cyu - limit:'.$limit, 'NOTICE');
	
	foreach ($users as $user)
	{
		elgg_log('cyu -'.$user->username, 'NOTICE');

	}

	

	$content = elgg_view_entity_list($users, array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $limit,
		'full_view' => false,
		'list_type_toggle' => false,
		'pagination' => true,
	));
} else {
	$name = sanitize_string(get_input('name'));

	$title = elgg_echo('members:title:searchname', array($name));

	$db_prefix = elgg_get_config('dbprefix');
	$params = array(
		'type' => 'user',
		'full_view' => false,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'wheres' => array("(u.name LIKE \"%{$name}%\" OR u.username LIKE \"%{$name}%\")"),
	);

	$content .= elgg_list_entities($params);
}

$params = array(
	'title' => $title,
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
