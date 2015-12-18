<?php
/**
 * Blog sidebar
 *
 * @package Blog
 */

$week_ago = time() - (60 * 60 * 24 * 7);

// Get entities that have been liked within a week
$liked_entities = elgg_get_entities_from_annotation_calculation(array(
	'annotation_names' => 'likes',
	'calculation' => 'count',
	'wheres' => array("n_table.time_created > $week_ago"),
));

if ($liked_entities) {
	// Order the entities by like count
	$guids_to_entities = array();
	$guids_to_like_count = array();
	foreach ($liked_entities as $entity) {
		$guids_to_entities[$entity->guid] = $entity;
		$guids_to_like_count[$entity->guid] = $entity->countAnnotations('likes');
	}
	arsort($guids_to_like_count);

	$entities = array();
	foreach ($guids_to_like_count as $guid => $like_count) {
		$entities[] = $guids_to_entities[$guid];
	}

	// We must use a customized list view since there is no standard for list items in widget context
	$items = '';
	foreach ($entities as $entity) {
		$id = "elgg-{$entity->getType()}-{$entity->getGUID()}";
		$item = elgg_view('activity/entity', array('entity' => $entity));
		$items .= "<li id=\"$id\" class=\"elgg-item\">$item</li>";
	}
	$html = "<ul class=\"elgg-list\">$items</ul>";
} else {
	$text = elgg_echo('activity:module:weekly_likes:none');
	$html = "<p>$text</p>";
}

echo elgg_view_module('aside', elgg_echo('activity:module:weekly_likes'), $html);
// fetch & display latest comments
if ($vars['page'] != 'friends') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'blog',
		'container_guid' => elgg_get_page_owner_guid(),
         'limit' => 2,//$num,
        
	));
}
/*
// only users can have archives at present
if ($vars['page'] == 'owner' || $vars['page'] == 'group') {
	echo elgg_view('blog/sidebar/archives', $vars);
}
*/
if ($vars['page'] != 'friends') {
	echo elgg_view('page/elements/tagcloud_block', array(
		'subtypes' => 'blog',
		'container_guid' => elgg_get_page_owner_guid(),
	));
}

if (elgg_is_active_plugin('blog')) {
elgg_push_context('widgets');
$options = array(
    'type' => 'object',
    'subtype' => 'blog',
    'limit' => 2,//$num,
    'full_view' => FALSE,'list_type' => 'list',
    'pagination' => FALSE,
    );
$content = elgg_list_entities($options);
echo elgg_view_module('featured',  elgg_echo("Recent Blogs"), $content);
elgg_pop_context();
}

