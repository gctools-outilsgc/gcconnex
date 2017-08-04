<?php

namespace ColdTrick\FileTools;

class PageHandler {
	
	/**
	 * Handle /file_tools URLs
	 *
	 * @param array $page URL segments
	 *
	 * @return bool
	 */
	public static function fileTools($page) {
		
		switch (elgg_extract(0, $page)) {
			case 'list':
				elgg_ajax_gatekeeper();
				
				$params = [];
				elgg_set_page_owner_guid(elgg_extract(1, $page));
				
				$folder_guid = get_input('folder_guid', false);
				if ($folder_guid !== false) {
					$params['folder_guid'] = (int) $folder_guid;
					$params['draw_page'] = false;
				}
				
				if (isset($page[2])) {
					$params['folder_guid'] = (int) $page[2];
				}
				
				echo elgg_view_resource('file_tools/file/list', $params);
				return true;
				break;
			case 'folder':
				
				switch (elgg_extract(1, $page)) {
					case 'new':
						elgg_set_page_owner_guid(elgg_extract(2, $page));
						
						echo elgg_view_resource('file_tools/folder/new');
						return true;
						break;
					case 'edit':
						
						$params = [
							'folder_guid' => (int) elgg_extract(2, $page),
						];
						
						echo elgg_view_resource('file_tools/folder/edit', $params);
						return true;
						break;
				}
				break;
		}
		
		return false;
	}
}
