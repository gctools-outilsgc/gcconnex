<?php

// Load Elgg engine
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");

$keyword = get_input('keyword', 'false');
$point = (int)get_input('point', 1);

if ( $keyword != 'false' ) {
	$group_guid = (int)get_input('group', 'false');

	if ( $group_guid ) {

		$db_prefix = elgg_get_config('dbprefix');

		$params = array(
			'type' => 'object',
			'subtype' => 'idea',
			'container_guid' => $group_guid,
			'limit' => 0,
			'pagination' => false,
			'full_view' => false,
			'item_class' => 'elgg-item-idea'
		);

		$likes = $keys = array();
		$keywords = explode(' ', sanitise_string($keyword));
		$skip_words = explode(',', elgg_echo('ideas:search:skip_words'));

		foreach ($keywords as $key) {
			if ( strlen($key) > 2 && !in_array($key, $skip_words) ) {
				$keys[] = $key;
				$likes[] = "oe.title LIKE '%$key%' OR oe.description LIKE '%$key%'";
			}
		}
		if ( !empty($keys) ) {
			$params['wheres'] = array('(' . implode(' OR ', $likes) . ')');
			$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");

			$ideas = elgg_get_entities($params);

			// hightlight result. Protected against searching «elgg» or «ideas» or anything else can be found on class with elgg_list_entities
			foreach ( $ideas as $item => $idea ) {
				$excerpt_description = elgg_get_excerpt($idea->description, '300');
				foreach ($keys as $key) {
					$idea->title = preg_replace("/($key)/i", "<span class='ideas-highlight'>$1</span>", $idea->title);
					$excerpt_description = preg_replace("/($key)/i", "<span class='ideas-highlight'>$1</span>", $excerpt_description);
				}
				$idea->description = $excerpt_description;
			}

			if ($ideas) {
				$content = elgg_view_entity_list($ideas, array(
					'full_view' => 'searched',
					'item_class' => 'elgg-item-idea',
					'pagination' => false,
					'limit' => 0
				));
			}
		}

		$group = get_entity($group_guid);
		if ($group->canWritetoContainer()) {
			$html_keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
			$button = "<a class='elgg-button elgg-button-action' href='" . elgg_get_site_url() . "ideas/add/{$group_guid}/?search={$html_keyword}'>" . elgg_echo('ideas:add') . '</a>';

			if ($content) {
				$html = '<span>' . elgg_echo('ideas:search:result_vote_submit') . '</span>' . $button;
				$html .= $content;
			} else {
				$html = '<span>' . elgg_echo('ideas:search:noresult_submit') . '</span>' . $button;
			}
			echo $html;
		} else {
			if ($content) {
				echo $content;
			} else {
				echo '<span>' . elgg_echo('ideas:search:noresult_nogroupmember') . '</span>';
			}
		}
	}
}