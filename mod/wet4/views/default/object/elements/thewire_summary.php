<?php
/**
 * Object summary
 *
 * Sample output
 * <ul class="elgg-menu elgg-menu-entity"><li>Public</li><li>Like this</li></ul>
 * <h3><a href="">Title</a></h3>
 * <p class="elgg-subtext">Posted 3 hours ago by George</p>
 * <p class="elgg-tags"><a href="">one</a>, <a href="">two</a></p>
 * <div class="elgg-content">Excerpt text</div>
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (default is tags on entity, pass false for no tags)
 * @uses $vars['content']   HTML for the entity content (optional)
 *
 * GC_MODIFICATION
 * Description: Changing the layout of the wire
 * Author: GCTools Team
 */

$entity = $vars['entity'];
if ($entity instanceof ElggEntity) {

	$title_link = elgg_extract('title', $vars, '');
	if ($title_link === '') {
		if (isset($entity->title)) {
			$text = $entity->title;
		} else {
			$text = $entity->name;
		}
		$params = array(
			'text' => elgg_get_excerpt($text, 100),
			'href' => $entity->getURL(),
			'is_trusted' => true,
		);
		$title_link = elgg_view('output/url', $params);
	}

	$metadata = elgg_extract('metadata', $vars, '');
	$subtitle = elgg_extract('subtitle', $vars, '');
	$content = elgg_extract('content', $vars, '');

	$tags = elgg_extract('tags', $vars, '');
	if ($tags === '') {
		$tags = elgg_view('output/tags', array('tags' => $entity->tags));
	}

	if ($title_link) {
		echo "<h3 class=\"mrgn-bttm-0 panel-title\">$title_link</h3>";
	}

	echo "<div class=\"elgg-subtext  mrgn-lft-sm clearfix\">$subtitle</div>";
	echo "<div class=\"tags\">$tags</div>";

	echo elgg_view('object/summary/extend', $vars);

	if ($content) {
		echo "<div class=\"elgg-content mrgn-tp-sm mrgn-lft-sm\">$content</div>";
	}

	if ( $metadata && !(elgg_in_context('widgets')) ) {
		echo $metadata;
	}

}