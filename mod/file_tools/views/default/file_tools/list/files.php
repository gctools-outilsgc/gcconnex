<?php

$files = elgg_extract('files', $vars, []);
$folder = elgg_extract('folder', $vars);
$show_more = (bool) elgg_extract('show_more', $vars, false);
$limit = (int) elgg_extract('limit', $vars, file_tools_get_list_length());
$offset = (int) elgg_extract('offset', $vars, 0);

// only show the header if offset == 0
$folder_content = '';
if (empty($offset)) {
	$folder_content = elgg_view('file_tools/breadcrumb', [
		'entity' => $folder,
	]);
	
	$sub_folders = file_tools_get_sub_folders($folder);
	if (empty($sub_folders)) {
		$sub_folders = [];
	}
	
	$entities = array_merge($sub_folders, $files);
} else {
	$entities = $files;
}

$files_content = '';
if (!empty($entities)) {
	$params = [
		'full_view' => false,
		'pagination' => false,
	];
	
	elgg_push_context('file_tools_selector');
	
	$files_content = elgg_view_entity_list($entities, $params);
	
	elgg_pop_context();
}

if (empty($files_content)) {
	$files_content = elgg_echo('file_tools:list:files:none');
} else {
	if ($show_more) {
		$more = elgg_view('input/button', [
			'value' => elgg_echo('file_tools:show_more'),
			'class' => 'elgg-button-action',
			'id' => 'file-tools-show-more-files',
		]);
		$more .= elgg_view('input/hidden', [
			'name' => 'offset',
			'value' => ($limit + $offset),
		]);
		if (!empty($folder)) {
			$more .= elgg_view('input/hidden', [
				'name' => 'folder_guid',
				'value' => $folder->getGUID(),
			]);
		} else {
			$more .= elgg_view('input/hidden', [
				'name' => 'folder_guid',
				'value' => '0',
			]);
		}
		
		$files_content .= elgg_format_element('div', [
			'id' => 'file-tools-show-more-wrapper',
			'class' => 'center',
		], $more);
	}

	// only show selectors on the first load
	if (empty($offset)) {
		$selector = '';
		
		if (elgg_get_page_owner_entity()->canEdit()) {
			$selector = elgg_view('output/url', [
				'id' => 'file_tools_action_bulk_delete',
				'text' => elgg_echo('file_tools:list:delete_selected'),
				'href' => 'javascript:void(0);',
			]);
			$selector .= ' | ';
		}
		
		$selector .= elgg_view('output/url', [
			'id' => 'file_tools_action_bulk_download',
			'text' => elgg_echo('file_tools:list:download_selected'),
			'href' => 'javascript:void(0);',
		]);
		
		$selector .= elgg_view('output/url', [
			'id' => 'file_tools_select_all',
			'text' => elgg_format_element('span', [], elgg_echo('file_tools:list:select_all')) .
				elgg_format_element('span', ['class' => 'hidden wb-invisible'], elgg_echo('file_tools:list:deselect_all')),
			'href' => 'javascript:void(0);',
			'class' => 'float-alt',
		]);
				
		$files_content .= elgg_format_element('div', ['class' => 'clearfix'], $selector);
	}
}

// show the listing
echo '<div id="file_tools_list_files">';
echo '<div id="file_tools_list_files_overlay"></div>';
echo $folder_content;
echo $files_content;
echo elgg_view('graphics/ajax_loader');
echo '</div>';

$page_owner = elgg_get_page_owner_entity();

if ($page_owner->canEdit() || (elgg_instanceof($page_owner, 'group') && $page_owner->isMember())) {
	elgg_require_js('file_tools/site');
}
