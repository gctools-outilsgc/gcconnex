/**
 *
 */
define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');
	var serializer = require('jquery.serializejson');
	var lightbox = require('elgg/lightbox');

	/**
	 *
	 */
	var breadcrumb_click = function(event) {
		var href = $(this).attr('href');
		var hash = elgg.parse_url(href, 'fragment');

		if (hash) {
			window.location.hash = hash;
		} else {
			window.location.hash = '#';
		}

		event.preventDefault();
	};

	/**
	 *
	 */
	var load_folder = function(folder_guid) {
		var query_parts = elgg.parse_url(window.location.href, 'query', true);
		var search_type = 'list';

		if (query_parts && query_parts.search_viewtype) {
			search_type = query_parts.search_viewtype;
		}

		var url = elgg.get_site_url() + 'file_tools/list/' + elgg.get_page_owner_guid() + '?folder_guid=' + folder_guid + '&search_viewtype=' + search_type;

		$('#file_tools_list_files_container .elgg-ajax-loader').show();
		$('#file_tools_list_files_container').load(url, function() {
			var new_add_link = elgg.get_site_url() + 'file/add/' + elgg.get_page_owner_guid() + '?folder_guid=' + folder_guid;
			$('ul.elgg-menu-title li.elgg-menu-item-add a').attr('href', new_add_link);

			var new_zip_link = elgg.get_site_url() + 'file/zip/' + elgg.get_page_owner_guid() + '?folder_guid=' + folder_guid;
			$('ul.elgg-menu-title li.elgg-menu-item-zip-upload a').attr('href', new_zip_link);

			initialize_file_draggable();
		});
	};

	/**
	 *
	 */
	var move_file = function(file_guid, to_folder_guid, draggable) {
		elgg.action('file/move', {
			data: {
				file_guid: file_guid,
				folder_guid: to_folder_guid
			},
			error: function(result) {
				var hash = elgg.parse_url(window.location.href, 'fragment');

				if (hash) {
					load_folder(hash);
				} else {
					load_folder(0);
				}
			},
			success: function(result) {
				draggable.parent().remove();
			}
		});
	};

	/**
	 *
	 */
	var select_all = function(e) {
		e.preventDefault();
		
		var select_all_visible = $(this).find('span:first').is(':visible');
		$('#file_tools_list_files input[type="checkbox"]').prop('checked', select_all_visible);
		
		$(this).find('span').toggle();
	};

	/**
	 *
	 */
	var bulk_delete = function(e) {
		e.preventDefault();

		$checkboxes = $('#file_tools_list_files input[type="checkbox"]:checked');

		if (!$checkboxes.length) {
			return;
		}

		if (confirm(elgg.echo('deleteconfirm'))) {
			var postData = $checkboxes.serializeJSON();

			if ($('#file_tools_list_files input[type="checkbox"][name="folder_guids[]"]:checked').length && confirm(elgg.echo('file_tools:folder:delete:confirm_files'))) {
				postData.files = 'yes';
			}

			$('#file_tools_list_files_container .elgg-ajax-loader').show();

			elgg.action('file/bulk_delete', {
				data: postData,
				success: function(res){
					$.each($checkboxes, function(key, value) {
						$('#elgg-object-' + $(value).val()).remove();
					});

					$('#file_tools_list_files_container .elgg-ajax-loader').hide();
				}
			});
		}
	};

	/**
	 *
	 */
	var bulk_download = function(e) {
		e.preventDefault();

		$checkboxes = $('#file_tools_list_files input[type="checkbox"]:checked');

		if ($checkboxes.length) {
			elgg.forward('file/bulk_download?' + $checkboxes.serialize());
		}
	};

	/**
	 *
	 */
	var new_folder = function(event) {
		event.preventDefault();
		
		var hash = window.location.hash.substr(1);
		var link = elgg.get_site_url() + 'file_tools/folder/new/' + elgg.get_page_owner_guid() + '?folder_guid=' + hash;
		
		lightbox.open({
			href: link,
			titleShow: false
		});
	};

	/**
	 *
	 */
	var upload_tab_click = function(event) {
		event.preventDefault();

		$('#file-tools-upload-tabs .elgg-state-selected').removeClass('elgg-state-selected');
		$(this).parent().addClass('elgg-state-selected');

		var id = $(this).attr('id').replace('-link', '');
		$('#file-tools-upload-wrapper form').hide();
		$('#' + id).show();
	};

	/**
	 *
	 */
	var show_more_files = function() {
		$(this).hide();
		$('#file_tools_list_files div.elgg-ajax-loader').show();

		var offset = $(this).siblings('input[name="offset"]').val();
		var folder = $(this).siblings('input[name="folder_guid"]').val();
		var query_parts = elgg.parse_url(window.location.href, 'query', true);
		var search_type = 'list';

		if (query_parts && query_parts.search_viewtype) {
			search_type = query_parts.search_viewtype;
		}

		elgg.post('file_tools/list/' + elgg.get_page_owner_guid(), {
			data: {
				folder_guid: folder,
				search_viewtype: search_type,
				offset: offset
			},
			success: function(data) {
				// append the files to the list
				var li = $(data).find('ul.elgg-list-entity > li');
				$('#file_tools_list_files ul.elgg-list').append(li);
				initialize_file_draggable();

				// replace the show more button with new data
				var show_more = $(data).find('#file-tools-show-more-wrapper');
				$('#file-tools-show-more-wrapper').replaceWith(show_more);

				// hide ajax loader
				$('#file_tools_list_files div.elgg-ajax-loader').hide();
			}
		});

	};

	/**
	 *
	 */
	var initialize_file_draggable = function() {
		$('#file_tools_list_files .file-tools-file').draggable({
			revert: 'invalid',
			opacity: 0.8,
			appendTo: 'body',
			helper: 'clone',
			start: function(event, ui) {
				$(this).css('visibility', 'hidden');
				$(ui.helper).width($(this).width());
			},
			stop: function(event, ui) {
				$(this).css('visibility', 'visible');
			}
		});
	};

	/**
	 *
	 */
	var initialize_folder_droppable = function() {
		$('#file_tools_list_files .file-tools-folder').droppable({
			accept: '#file_tools_list_files .file-tools-file',
			drop: function(event, ui){
				droppable = $(this);
				draggable = ui.draggable;

				drop_id = droppable.parent().attr('id').split('-').pop();
				drag_id = draggable.parent().attr('id').split('-').pop();

				move_file(drag_id, drop_id, draggable);
			}
		});
	};

	$(document).on('click', '#file-tools-upload-tabs a', upload_tab_click);
	$(document).on('click', '#file_tools_breadcrumbs a', breadcrumb_click);
	$(document).on('click', '#file_tools_select_all', select_all);
	$(document).on('click', '#file_tools_action_bulk_delete', bulk_delete);
	$(document).on('click', '#file_tools_action_bulk_download', bulk_download);
	$(document).on('click', '#file-tools-show-more-files', show_more_files);
	$(document).on('click', '#file_tools_list_new_folder_toggle', new_folder);

	return {
		'load_folder': load_folder,
		'move_file': move_file
	};
});
