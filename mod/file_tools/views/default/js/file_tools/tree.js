/**
 * Provides interactive tree structure for browsing the files
 */
define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');
	var file_tools = require('file_tools/site');
	var jquery_tree = require('jstree/jstree.min');
	var jquery_hashchange = require('jquery.hashchange');

	/**
	 *
	 */
	var init = function() {
		var folders = $('#file-tools-folder-tree');

		if (!folders.length) {
			return;
		}

		var file_tools_old_parent_guid;

		//console.log($.jstree.defaults);

		folders.jstree({
			'core': {
				'multiple': false,
				'check_callback': true
			},
			'plugins' : [
				'dnd'
			]
		})
		.on('ready.jstree', function() {
			var hash = window.location.hash;

			var instance = folders.jstree(true);

			if (hash) {
				instance.select_node(folders.find('a[href="' + hash + '"]'));
				instance.open_node(folders.find('a[href="' + hash + '"]'));

				var folder_guid = hash.substr(1);
			} else {
				instance.select_node(folders.find('a[href="#"]'));
				instance.open_node(folders.find('a[href="#"]'));

				var folder_guid = 0;
			}

			file_tools.load_folder(folder_guid);

			// The structure is kept hidden until jsTree has been loaded
			folders.show();

			make_tree_folder_droppable();
		})
		.on('move_node.jstree', function (e, data) {
			var refresh = false;
			var tree_obj = data.instance;
			
			var parent_id = tree_obj.get_parent(data.node);
			var $parent_node = $('#' + parent_id);
			
			var folder_guid = data.node.a_attr.href.substr(1);
			var parent_guid = $parent_node.find('a:first').attr('href').substr(1);

			var order = [];
			$parent_node.find('>ul > li > a').each(function(k, v) {
				var guid = $(v).attr('href').substr(1);
				order.push(guid);
			});

			if ((parent_guid == window.location.hash.substr(1)) || (file_tools_old_parent_guid == window.location.hash.substr(1))) {
				if (parent_guid == window.location.hash.substr(1)) {
					refresh = parent_guid;
				} else if (file_tools_old_parent_guid == window.location.hash.substr(1)) {
					refresh = file_tools_old_parent_guid;
				}

				$('#file_tools_list_files_container .elgg-ajax-loader').show();
			}

			elgg.action('file_tools/folder/reorder', {
				data: {
					folder_guid: folder_guid,
					parent_guid: parent_guid,
					order: order
				},
				success: function() {
					if (refresh !== false) {
						file_tools.load_folder(refresh);
					}
				}
			});
		})
		.on('select_node.jstree', function(node, selected) {
			// Update location hash to match the selected one
			window.location.hash = selected.node.a_attr.href.substr(1);
		})
		.on('open_node.jstree', make_tree_folder_droppable);
	};

	/**
	 * Makes all directories in the jsTree droppable
	 */
	var make_tree_folder_droppable = function() {
		$('#file-tools-folder-tree .elgg-menu-content').droppable({
			accept: '#file_tools_list_files .file-tools-file',
			hoverClass: 'file-tools-tree-droppable-hover',
			tolerance: 'pointer',
			drop: function(event, ui) {
				droppable = $(this);
				draggable = ui.draggable;

				drop_id = droppable.attr('href').substring(1);
				drag_id = draggable.parent().attr('id').split('-').pop();

				file_tools.move_file(drag_id, drop_id, draggable);
			}
		});
	};

	/**
	 *
	 */
	function get_selected_tree_folder_id(){
		var result = 0;

		tree = $.tree.reference($('#file_tools_list_tree'));
		result = file_tools_tree_folder_id(tree.selected);
		return result;
	}

	/**
	 *
	 * @param {Object} link
	 */
	function file_tools_remove_folder_files(link) {
		if (confirm(elgg.echo('file_tools:folder:delete:confirm_files'))) {
			var cur_href = $(link).attr('href');
			$(link).attr('href', cur_href + '&files=yes');
		}
		return true;
	}

	/**
	 *
	 * @param {Object} node
	 * @param {Object} parent
	 */
	function file_tools_tree_folder_id(node, parent) {
		if (parent == true) {
			var find = 'a:first';
		} else {
			var find = 'a';
		}

		var element_id = node.find(find).attr('id');
		return element_id.substring(24, element_id.length);
	}

	/**
	 *
	 *
	 * @param {Object} folder_guid
	 * @param {Object} tree
	 */
	function file_tools_select_node(folder_guid, tree) {
		tree = $.tree.reference($('#file_tools_list_tree'));

		tree.select_branch($('#file_tools_tree_element_' + folder_guid));
		tree.open_branch($('#file_tools_tree_element_' + folder_guid));
	}

	/**
	 *
	 */
	$(function() {
		$(window).hashchange(function(){
			file_tools.load_folder(window.location.hash.substring(1));
		});

		$(document).on('click', '.file_tools_load_folder', function() {
			folder_guid = $(this).attr('rel');
			file_tools_select_node(folder_guid);
		});

		$('select[name="file_sort"], select[name="file_sort_direction"]').change(function() {
			show_loader($('#file_tools_list_folder'));

			// TODO(juho) Add this to the URL below: <?php echo get_input('search_viewtype', 'list'); ?>
			var folder_url = elgg.get_site_url() + 'file_tools/list/' + elgg.page_owner.guid + '?folder_guid=' + get_selected_tree_folder_id() + '&search_viewtype&sort_by=' + $('select[name="file_sort"]').val() + '&direction=' + $('select[name="file_sort_direction"]').val();
			$('#file_tools_list_files_container').load(folder_url);
		});
	});

	/**
	 *
	 * @param {Object} elem
	 */
	function show_loader(elem) {
		var overlay_width = elem.outerWidth();
		var margin_left = elem.css('margin-left');

		$('#file_tools_list_files_overlay').css('width', overlay_width).css('left', margin_left).show();
	}

	init();

	return {
		'get_selected_tree_folder_id': get_selected_tree_folder_id
	};
});
