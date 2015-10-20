<?php
/**
 * List replies with optional add form
 *
 * @uses $vars['entity']        ElggEntity the group discission
 * @uses $vars['show_add_form'] Display add form or not
 *
 * Modified by Christine Yu
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);

// cyu - 09/08/2015: fixed ordering of replies by date created for elgg 1.12
$sort = get_input('sort');
if (!$sort || $sort === '') {
	$sort = true;
} else {
	if ($sort === 'true') $sort = true;
	if ($sort === 'false') $sort = false;
}

// newest:false / oldest:true
echo '<span style="float:right;"> Sort replies by <a href="?sort=false">Newest</a> | <a href="?sort=true">Oldest</a></span>';


echo '<div id="group-replies" class="elgg-comments">';

$replies = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'discussion_reply',
	'container_guid' => $vars['topic']->getGUID(),
	'reverse_order_by' => $sort,
	'distinct' => false,
	'url_fragment' => 'group-replies',
	'limit' => 25,	// cyu - 09/09/2015: fixed the increase limit
));

echo $replies;

if ($show_add_form) {
	$form_vars = array('class' => 'mtm');
	echo elgg_view_form('discussion/reply/save', $form_vars, $vars);
}

echo '</div>';