<?php
/**
 * Blog sidebar
 *
 * @package Blog
 *
 * GC_MODIFICATION
 * Description: GSA crawler fixes / Added most liked blogs / 
 * Author: GCTools Team
 */

// cyu - 01/04/2016: as per eric cantin's advice
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {
	
} else {
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
            if($entity->getSubtype() == 'blog'){
                $guids_to_entities[$entity->guid] = $entity;
                $guids_to_like_count[$entity->guid] = $entity->countAnnotations('likes');
            }
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


    $pageOwner = elgg_get_page_owner_entity();
    if(!$pageOwner){
        echo elgg_view_module('aside', elgg_echo('activity:module:weekly_likes'), $html);
    }

	// fetch & display latest comments
	if ($vars['page'] != 'friends') {
		echo elgg_view('page/elements/comments_block', array(
			'subtypes' => 'blog',
			'container_guid' => elgg_get_page_owner_guid(),
	         'limit' => 3,//$num,
	        
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
	
}
