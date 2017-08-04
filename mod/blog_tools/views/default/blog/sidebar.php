<?php
/**
 * Blog sidebar
 *
 * @package Blog
 */

$page = elgg_extract('page', $vars);

// fetch & display latest comments
if ($page === 'all') {
	echo elgg_view('page/elements/comments_block', [
		'subtypes' => 'blog',
	]);
} elseif ($page === 'owner') {
	echo elgg_view('page/elements/comments_block', [
		'subtypes' => 'blog',
		'owner_guid' => elgg_get_page_owner_guid(),
	]);
}

// only users can have archives at present
if (in_array($page, ['owner', 'group', 'view'])) {
	echo elgg_view('blog/sidebar/archives', $vars);
}

if ($page !== 'friends') {
	$page_owner = elgg_get_page_owner_entity();
	
	$options = [
		'subtypes' => 'blog',
	];
	if ($page_owner instanceof ElggUser) {
		$options['owner_guid'] = $page_owner->getGUID();
	} elseif ($page_owner instanceof ElggGroup) {
		$options['container_guid'] = $page_owner->getGUID();
	}
	
	echo elgg_view('page/elements/tagcloud_block', $options);
}
