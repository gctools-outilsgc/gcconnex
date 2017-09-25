<?php
/**
 * Remove a pad
 *
 * Subpages are not deleted but are moved up a level in the tree
 *
 * @package ElggPad
 */

$guid = get_input('guid');
$page = new ElggPad($guid);
if ($page) {
	if ($page->canEdit()) {
		$container = get_entity($page->container_guid);

		// Bring all child elements forward
		$parent = $page->parent_guid;
		$children = elgg_get_entities_from_metadata(array(
			'metadata_name' => 'parent_guid',
			'metadata_value' => $page->getGUID()
		));
		if ($children) {
			foreach ($children as $child) {
				$child->parent_guid = $parent;
			}
		}
		
		if ($page->delete()) {
			system_message(elgg_echo('etherpad:delete:success'));
			if ($parent) {
				if ($parent = get_entity($parent)) {
					forward($parent->getURL());
				}
			}
			//Forward to pages only if pages integration enabled. Otherwise forward to docs. 
			$handler = elgg_get_plugin_setting('integrate_in_pages', 'etherpad') == 'yes' ? 'pages' : 'docs';
			
			if (elgg_instanceof($container, 'group')) {
				forward("$handler/group/$container->guid/all");
			} else {
				forward("$handler/owner/$container->username");
			}
			
		}
	}
}

register_error(elgg_echo('etherpad:delete:failure'));
forward(REFERER);
