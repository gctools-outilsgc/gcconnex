<?php
/**
 * Blog sidebar
 *
 * @package Blog
 */

// fetch & display latest comments
if ($vars['page'] == 'all') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'blog',
	));
} elseif ($vars['page'] == 'owner') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'blog',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
}

// only users can have archives at present
if (in_array($vars['page'], array('owner', 'group', 'view'))) {
	echo elgg_view('blog/sidebar/archives', $vars);
}

if ($vars['page'] != 'friends') {
	$page_owner = elgg_get_page_owner_entity();
	
	$options = array(
		'subtypes' => 'blog'
	);
	if ($page_owner instanceof ElggUser) {
		$options['owner_guid'] = $page_owner->getGUID();
	} elseif ($page_owner instanceof ElggGroup) {
		$options['container_guid'] = $page_owner->getGUID();
	}
	
	echo elgg_view('page/elements/tagcloud_block', $options);
}
