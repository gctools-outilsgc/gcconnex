<?php
/**
 * View a list of items
 *
 * @package Elgg
 *
 * @uses $vars['items']       Array of ElggEntity or ElggAnnotation objects
 * @uses $vars['offset']      Index of the first list item in complete list
 * @uses $vars['limit']       Number of items per page
 * @uses $vars['count']       Number of items in the complete list
 * @uses $vars['base_url']    Base URL of list (optional)
 * @uses $vars['pagination']  Show pagination? (default: true)
 * @uses $vars['position']    Position of the pagination: before, after, or both
 * @uses $vars['full_view']   Show the full view of the items (default: false)
 * @uses $vars['list_class']  Additional CSS class for the <ul> element
 * @uses $vars['item_class']  Additional CSS class for the <li> elements
 */

$items = $vars['items'];
$offset = elgg_extract('offset', $vars);
$limit = elgg_extract('limit', $vars);
$count = elgg_extract('count', $vars);
$base_url = elgg_extract('base_url', $vars, '');
$pagination = elgg_extract('pagination', $vars, true);
$offset_key = elgg_extract('offset_key', $vars, 'offset');
$position = elgg_extract('position', $vars, 'after');

$list_class = 'nav elgg-list';
if (isset($vars['list_class'])) {
	$list_class = "$list_class {$vars['list_class']}";
}

$item_class = 'elgg-item';
if (isset($vars['item_class'])) {
	$item_class = "$item_class {$vars['item_class']}";
}

$html = "";
$nav = "";

if ($pagination && $count) {
	$nav .= elgg_view('navigation/pagination', array(
		'baseurl' => $base_url,
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
		'offset_key' => $offset_key,
	));
}

if (is_array($items) && count($items) > 0) {
	$html .= "<ul class=\"$list_class\">";
	foreach ($items as $item) {
		if (elgg_instanceof($item)) {
			$id = "elgg-{$item->getType()}-{$item->getGUID()}";
		} else {
			$id = "item-{$item->getType()}-{$item->id}";
		}
		$html .= "<li id=\"$id\" class=\"$item_class\">";
		// GCchange - Troy T. Lawson
		// adds a link to remove user from group.
		// More obvious than drop down list.

		//Get Group and check that page is instance of Group
		$group = elgg_get_page_owner_entity();
		if (!elgg_instanceof($group, 'group')) {
			$html .= elgg_view_list_item($item, $vars);
			
		}else{
			//Check if item id is a user and is a member of the group
			if (!elgg_instanceof($item, 'user') || !$group->isMember($item)) {
				$html .= elgg_view_list_item($item, $vars);
				
			}else{
				//Make sure logged in user is able to edit group (Site admin, owner, group admin, etc), and make sure not able to remove group owner.
				if ($group->canEdit() && $group->getOwnerGUID() != $item->getGUID()) {
					//get link to remove user
					$remove = elgg_view('output/confirmlink', array(
						'href' => "action/groups/remove?user_guid={$item->getGUID()}&group_guid={$group->guid}",
						'text' => elgg_echo('groups:removeuser'),
					));
					//wrap link in div for styling
					$html .= "<div id=\"removelink\">";
					$html .= $remove;
					$html .= "</div>";
					//show list item.
					$html .= elgg_view_list_item($item, $vars);
					
				} else{
					$html .= elgg_view_list_item($item, $vars);
				
				}
			}
			
		}
		
		$html .= '</li>';
	}
	$html .= '</ul>';
}

if ($position == 'before' || $position == 'both') {
	$html = $nav . $html;
}

if ($position == 'after' || $position == 'both') {
	$html .= $nav;
}

echo $html;
