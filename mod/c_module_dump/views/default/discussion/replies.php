<?php
/**
 * List replies with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);

$sort = get_input( 'sort', 'desc' );		// GCEdit: get input from sort-by links

//echo '<div id="group-replies" class="mtl">';
echo '<div id="group-replies" class="elgg-comments">'; // cyu - modified for elgg 1.12


$display = $_GET['num'];
if (!isset($display))
	$display = 25;

// $options = array(
// 	'guid' => $vars['entity']->getGUID(),
// 	'annotation_name' => 'group_topic_post',
// 	'order_by' => 'time_created ' . $sort,
// 	'limit' => $display,
// );

$html = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'discussion_reply',
	'container_guid' => $vars['topic']->getGUID(),
	'reverse_order_by' => true,
	'distinct' => false,
	'url_fragment' => 'group-replies',
	'limit' => $display,
));


//$html = elgg_list_annotations($options);
if ($html) {
	echo '<h3>' . elgg_echo('group:replies') . '</h3><br/>' . '<span style="float:left;">Display <a href="?sort='.$sort.'&num=25">25</a> | <a href="?sort='.$sort.'&num=50">50</a> | <a href="?sort='.$sort.'&num=100">100</a> </span> <span style="float:right;"> '
	.'Sort by: <a href="?sort=desc&num='.$display.'">Newest</a> | <a href="?sort=asc&num='.$display.'">Oldest</a></span>';   // GCEdit: add sort-by links
	echo $html;
}

if ($show_add_form) {
	$form_vars = array('class' => 'mtm');
	echo elgg_view_form('discussion/reply/save', $form_vars, $vars);
}

echo '</div>';
