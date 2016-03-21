<?php

elgg_load_css('gcforums-css');	// we need the stylesheet for styling
$group = elgg_get_page_owner_entity();

// if entity guid is not present, it is first page of forum
if (!$entity_guid) {
	$nested_forum = $vars['forum_guid'];
	$entity_guid = $vars['forum_guid'];
}
if (!$entity_guid) $entity_guid = 0;

$entity = get_entity($entity_guid); // entity guid may not be present

// check if the current entity is a forum-topic subtype then display topic and comments
if ($entity_guid && $entity->getSubtype() === 'hjforumtopic') {
	echo gcforums_menu_buttons($nested_forum, $group->guid, true);
	echo gcforums_topic_content($entity_guid, $group->guid);
} else {

	echo gcforums_menu_buttons($nested_forum, $group->guid);
	$entity = get_entity($nested_forum);

	// check if there are sticky topics
	if ($nested_forum && !$entity->enable_posting) 	// this was unexpectedly inverted
		echo "<div class='gcforums-display-topics'>".gcforums_topics_list($nested_forum, $group->guid, 1)."</div>";	// display sticky topics

	if ($nested_forum && !$entity->enable_posting) 	// this was unexpectedly inverted
		echo "<div class='gcforums-display-topics'>".gcforums_topics_list($nested_forum, $group->guid, 0)."</div>";	// display unstickied topics

	// check if subcategories is enabled OR this is the first page of forums
	if ($entity->enable_subcategories || !$entity) {
		if (!$entity)
			echo gcforums_category_content($group->guid, $group->guid);
		else
			echo gcforums_category_content($entity->getGUID(), $group->guid);

	} else // the nested forum does not have categories enabled 
		echo gcforums_forum_list($entity->getGUID(),$group->guid);
}
