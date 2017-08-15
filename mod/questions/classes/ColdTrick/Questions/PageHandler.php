<?php

namespace ColdTrick\Questions;

class PageHandler {
	
	/**
	 * Handle /questions urls
	 *
	 * @param array $page URL segments
	 *
	 * @return bool
	 */
	public static function questions($page) {
		
		elgg_push_breadcrumb(elgg_echo('questions'), 'questions/all');
		
		$params = [];
		
		switch (elgg_extract(0, $page)) {
			case 'all':
				echo elgg_view_resource('questions/all');
				break;
			case 'todo':
				$group_guid = (int) elgg_extract(1, $page);
				if (!empty($group_guid)) {
					$params['group_guid'] = $group_guid;
				}
				echo elgg_view_resource('questions/todo', $params);
				break;
			case 'owner':
			case 'group':
				echo elgg_view_resource('questions/owner');
				break;
			case 'view':
				$params['guid'] = (int) elgg_extract(1, $page);
				
				echo elgg_view_resource('questions/view', $params);
				break;
			case 'add':
				echo elgg_view_resource('questions/add');
				break;
			case 'edit':
				$params['guid'] = (int) elgg_extract(1, $page);
				
				echo elgg_view_resource('questions/edit', $params);
				break;
			case 'experts':
				$group_guid = (int) elgg_extract(1, $page);
				if (!empty($group_guid)) {
					$params['group_guid'] = $group_guid;
				}
				echo elgg_view_resource('questions/experts', $params);
				break;
			default:
				forward('questions/all');
				return false;
		}
		
		return true;
	}
	
	/**
	 * Handle all /answers URLs
	 *
	 * @param array $page URL segments
	 *
	 * @return bool
	 */
	public static function answers($page) {
		
		elgg_push_breadcrumb(elgg_echo('questions'), 'questions/all');
		
		$params = [];
		
		switch (elgg_extract(0, $page)) {
			case 'edit':
				
				$params['guid'] = (int) elgg_extract(1, $page);
				
				echo elgg_view_resource('answers/edit', $params);
				break;
			default:
				forward('questions/all');
				return false;
		}
	
		return true;
	}
}
