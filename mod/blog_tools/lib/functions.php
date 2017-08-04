<?php
/**
 * All helper functions can be found here
 *
 */

/**
 * Remove the icon of a blog
 *
 * @param ElggBlog $blog The blog to remove the icon from
 *
 * @return bool
 */
function blog_tools_remove_blog_icon(ElggBlog $blog) {
	
	if (!($blog instanceof ElggBlog)) {
		return false;
	}
	
	if (empty($blog->icontime)) {
		// no icon
		return true;
	}
	
	$icon_sizes = elgg_get_icon_sizes('object', 'blog');
	if (!empty($icon_sizes)) {
		$fh = new ElggFile();
		$fh->owner_guid = $blog->getOwnerGUID();
		
		$prefix = "blogs/{$blog->getGUID()}";
		
		foreach ($icon_sizes as $name => $info) {
			$fh->setFilename("{$prefix}{$name}.jpg");
			
			if ($fh->exists()) {
				$fh->delete();
			}
		}
	}
	
	unset($blog->icontime);
	
	return true;
}

/**
 * Check a plugin setting for the allowed use of advanced publication options
 *
 * @return bool
 */
function blog_tools_use_advanced_publication_options() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = false;
	
	$setting = elgg_get_plugin_setting('advanced_publication', 'blog_tools');
	if ($setting === 'yes') {
		$result = true;
	}
	
	return $result;
}

/**
 * Get related blogs to this blog
 *
 * @param ElggBlog $entity the blog to relate to
 * @param int      $limit  number of blogs to return
 *
 * @return false|ElggBlog[]
 */
function blog_tools_get_related_blogs(ElggBlog $entity, $limit = 4) {
	
	$limit = sanitise_int($limit, false);
	
	if (!($entity instanceof ElggBlog)) {
		return false;
	}
	
	// transform to values
	$tag_values = $entity->tags;
	if (empty($tag_values)) {
		return false;
	}
	
	if (!is_array($tag_values)) {
		$tag_values = [$tag_values];
	}
	
	// find blogs with these metadatavalues
	$options = [
		'type' => 'object',
		'subtype' => 'blog',
		'metadata_name' => 'tags',
		'metadata_values' => $tag_values,
		'wheres' => [
			"(e.guid <> {$entity->getGUID()})",
		],
		'group_by' => 'e.guid',
		'order_by' => 'count(msn.id) DESC',
		'limit' => $limit,
	];
	
	return elgg_get_entities_from_metadata($options);
}
