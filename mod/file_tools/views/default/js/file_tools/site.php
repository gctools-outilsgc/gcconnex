<?php

?>
//<script>
elgg.provide("elgg.file_tools");
elgg.provide("elgg.file_tools.uploadify");
elgg.provide("elgg.file_tools.tree");

// extend jQuery with a function to serialize to JSON
(function( $ ) {
	$.fn.serializeJSON = function() {
		var json = {};
		jQuery.map($(this).serializeArray(), function(n, i) {
			if (json[n['name']]) {
				if (!json[n['name']].push) {
					json[n['name']] = [json[n['name']]];
				}
				json[n['name']].push(n['value'] || '');
			} else {
				json[n['name']] = n['value'] || '';
			}
		});
		return json;
	};
})( jQuery );

elgg.file_tools.uploadify.init = function() {
	$uploadifyButton = $('#uploadify-button-wrapper');

	if ($uploadifyButton.length) {
		$('#file-tools-uploadify-cancel').live("click", elgg.file_tools.uploadify.cancel);
		$('#file-tools-multi-form').submit(elgg.file_tools.uploadify.upload);
		
		$uploadifyButton.uploadify({
			swf: elgg.normalize_url("mod/file_tools/vendors/uploadify/uploadify.swf"),
			uploader: elgg.normalize_url("mod/file_tools/procedures/upload/multi.php"),
			formData: {"X-Requested-With": "XMLHttpRequest"},
			buttonText: elgg.echo("file_tools:forms:browse"),
			queueID: "uploadify-queue-wrapper",
			fileTypeExts: "<?php echo file_tools_allowed_extensions(true); ?>",
			fileSizeLimit: "<?php echo file_tools_get_readable_file_size_limit(); ?>",
			fileObjName: "upload",
			height: "23",
			width: "120",
			auto: false,
			onQueueComplete: function(queueData) {
				var folder = $('#file_tools_file_parent_guid').val();
				
				var forward_location = file_tools_uploadify_return_url + "#";
				if (folder > 0) {
					forward_location += folder;
				}
				
				document.location.href = forward_location;
			},
			onUploadStart: function(file) {
				
				$('#uploadify-button-wrapper').uploadify("settings", "formData", $('#file-tools-multi-form').serializeJSON());
			},
			onUploadSuccess: function(file, data, response) {
				data = $.parseJSON(data);
				
				if (data && data.system_messages) {
					elgg.register_error(data.system_messages.error);
					elgg.system_message(data.system_messages.success);
				}
			},
			onUploadError: function(file, data, response) {
				data = $.parseJSON(data);
				
				if (data && data.system_messages) {
					elgg.register_error(data.system_messages.error);
					elgg.system_message(data.system_messages.success);
				}
			},
			onSelect: function(instance) {
	           $("#file-tools-uploadify-cancel").removeClass("hidden");
	        },
	        onClearQueue: function(queueItemCount) {
	        	$("#file-tools-uploadify-cancel").addClass("hidden");
	        }
		});
	}
}

elgg.file_tools.uploadify.cancel = function() {
	$('#uploadify-button-wrapper').uploadify("cancel", "*");
}

elgg.file_tools.uploadify.upload = function(event) {
	$('#uploadify-button-wrapper').uploadify("upload", "*");
	
	return false;
}

elgg.file_tools.tree.init = function() {
	$tree = $('#file-tools-folder-tree');

	if ($tree.length) {
		var file_tools_old_parent_guid;
		
		$tree.tree({
			rules: {
				multiple: false,
				drag_copy: false,
				valid_children : [ "root" ]
			},
			ui: {
				theme_name: "classic"
			},
			callback: {
				onload: function(tree) {
					var hash = window.location.hash;

					if (hash) {
						tree.select_branch($tree.find('a[href="' + hash + '"]'));
						tree.open_branch($tree.find('a[href="' + hash + '"]'));

						var folder_guid = hash.substr(1);
					} else {
						tree.select_branch($tree.find('a[href="#"]'));
						tree.open_branch($tree.find('a[href="#"]'));

						var folder_guid = 0;
					}

					elgg.file_tools.load_folder(folder_guid);
					
					$tree.show();
				},
				onselect: function(node, tree) {
					var hash = $(node).find('a:first').attr("href").substr(1);

					window.location.hash = hash;
				},
				beforemove: function(node, ref_node, type, tree_obj) {
					file_tools_old_parent_guid = tree_obj.parent(node).find('a:first').attr('href').substr(1);
					
					return true;
				},
				onmove: function(node, ref_node, type, tree_obj, rb) {
					var refresh = false;
					var parent_node = tree_obj.parent(node);

					var folder_guid = $(node).find('a:first').attr('href').substr(1);
					var parent_guid = $(parent_node).find('a:first').attr('href').substr(1);
										
					var order = [];
					$(parent_node).find('>ul > li > a').each(function(k, v) {
						var guid = $(v).attr('href').substr(1);
						order.push(guid);
					});

					if ((parent_guid == window.location.hash.substr(1)) || (file_tools_old_parent_guid == window.location.hash.substr(1))) {
						if (parent_guid == window.location.hash.substr(1)) {
							refresh = parent_guid;
						} else if (file_tools_old_parent_guid == window.location.hash.substr(1)) {
							refresh = file_tools_old_parent_guid;
						}
						
						$("#file_tools_list_files_container .elgg-ajax-loader").show();
					}
					
					elgg.action("file_tools/folder/reorder", {
						data: {
							folder_guid: folder_guid,
							parent_guid: parent_guid,
							order: order
						},
						success: function() {
							if (refresh !== false) {
								elgg.file_tools.load_folder(refresh);
							}
						}
					});
				}
			}
		}).find("a").droppable({
			accept: "#file_tools_list_files .file-tools-file",
			hoverClass: "file-tools-tree-droppable-hover",
			tolerance: "pointer",
			drop: function(event, ui) {
				droppable = $(this);
				draggable = ui.draggable;

				drop_id = droppable.attr("href").substring(1);
				drag_id = draggable.parent().attr("id").split("-").pop();

				elgg.file_tools.move_file(drag_id, drop_id, draggable);
			}
		});
	}
}

elgg.file_tools.breadcrumb_click = function(event) {
	var href = $(this).attr("href");
	var hash = elgg.parse_url(href, "fragment");

	if (hash) {
		window.location.hash = hash;
	} else {
		window.location.hash = "#";
	}

	event.preventDefault();
}

elgg.file_tools.load_folder = function(folder_guid) {
	var query_parts = elgg.parse_url(window.location.href, "query", true);
	var search_type = 'list';
	
	if (query_parts && query_parts.search_viewtype) {
		search_type = query_parts.search_viewtype;
	}
	
	var url = elgg.get_site_url() + "file_tools/list/" + elgg.get_page_owner_guid() + "?folder_guid=" + folder_guid + "&search_viewtype=" + search_type;

	$("#file_tools_list_files_container .elgg-ajax-loader").show();
	$("#file_tools_list_files_container").load(url, function() {
		var new_add_link = elgg.get_site_url() + "file/add/" + elgg.get_page_owner_guid() + "?folder_guid=" + folder_guid;
		$('ul.elgg-menu-title li.elgg-menu-item-add a').attr("href", new_add_link);

		var new_zip_link = elgg.get_site_url() + "file/zip/" + elgg.get_page_owner_guid() + "?folder_guid=" + folder_guid;
		$('ul.elgg-menu-title li.elgg-menu-item-zip-upload a').attr("href", new_zip_link);
	});
}

elgg.file_tools.move_file = function(file_guid, to_folder_guid, draggable) {
	elgg.action("file/move", {
		data: {
			file_guid: file_guid,
			folder_guid: to_folder_guid
		},
		error: function(result) {
			var hash = elgg.parse_url(window.location.href, "fragment");

			if (hash) {
				elgg.file_tools.load_folder(hash);
			} else {
				elgg.file_tools.load_folder(0);
			}
		},
		success: function(result) {
			draggable.parent().remove();
		}
	});
}

elgg.file_tools.select_all = function(e) {
	e.preventDefault();

	if ($(this).find("span:first").is(":visible")) {
		// select all
		$('#file_tools_list_files input[type="checkbox"]').attr("checked", "checked");
	} else {
		// deselect all
		$('#file_tools_list_files input[type="checkbox"]').removeAttr("checked");
	}

	$(this).find("span").toggle();
}

elgg.file_tools.bulk_delete = function(e) {
	e.preventDefault();

	$checkboxes = $('#file_tools_list_files input[type="checkbox"]:checked');

	if ($checkboxes.length) {
		if (confirm(elgg.echo("deleteconfirm"))) {
			var postData = $checkboxes.serializeJSON();

			if ($('#file_tools_list_files input[type="checkbox"][name="folder_guids[]"]:checked').length && confirm(elgg.echo("file_tools:folder:delete:confirm_files"))) {
				postData.files = "yes";
			}

			$("#file_tools_list_files_container .elgg-ajax-loader").show();
			
			elgg.action("file/bulk_delete", {
				data: postData,
				success: function(res){
					$.each($checkboxes, function(key, value) {
						$('#elgg-object-' + $(value).val()).remove();
					});

					$("#file_tools_list_files_container .elgg-ajax-loader").hide();
				}
			});
		}
	}
}

elgg.file_tools.bulk_download = function(e) {
	e.preventDefault();

	$checkboxes = $('#file_tools_list_files input[type="checkbox"]:checked');

	if ($checkboxes.length) {
		elgg.forward("file/bulk_download?" + $checkboxes.serialize());
	}
}

elgg.file_tools.new_folder = function(event) {
	event.preventDefault();

	var hash = window.location.hash.substr(1);
	var link = elgg.get_site_url() + "file_tools/folder/new/" + elgg.get_page_owner_guid() + "?folder_guid=" + hash;
	
	$.colorbox({
		href: link,
		titleShow: false
	});
}

elgg.file_tools.upload_tab_click = function(event) {
	event.preventDefault();

	$('#file-tools-upload-tabs .elgg-state-selected').removeClass("elgg-state-selected");
	$(this).parent().addClass("elgg-state-selected");

	var id = $(this).attr("id").replace("-link", "");
	$('#file-tools-upload-wrapper form').hide();
	$('#' + id).show();
}

elgg.file_tools.show_more_files = function() {
	$(this).hide();
	$('#file_tools_list_files div.elgg-ajax-loader').show();

	var offset = $(this).siblings('input[name="offset"]').val();
	var folder = $(this).siblings('input[name="folder_guid"]').val();
	var query_parts = elgg.parse_url(window.location.href, "query", true);
	var search_type = 'list';
	
	if (query_parts && query_parts.search_viewtype) {
		search_type = query_parts.search_viewtype;
	}

	
	elgg.post("file_tools/list/" + elgg.get_page_owner_guid(), {
		data: {
			folder_guid: folder,
			search_viewtype: search_type,
			offset: offset
		},
		success: function(data) {
			// append the files to the list
			var li = $(data).find("ul.elgg-list-entity > li");
			$('#file_tools_list_files ul.elgg-list').append(li);
			elgg.file_tools.initialize_file_draggable();

			// replace the show more button with new data
			var show_more = $(data).find("#file-tools-show-more-wrapper");
			$("#file-tools-show-more-wrapper").replaceWith(show_more);

			// hide ajax loader
			$('#file_tools_list_files div.elgg-ajax-loader').hide();
		}
	});
	 
}

elgg.file_tools.initialize_file_draggable = function() {
	
	$("#file_tools_list_files .file-tools-file").draggable({
		revert: "invalid",
		opacity: 0.8,
		appendTo: "body",
		helper: "clone",
		start: function(event, ui) {
			$(this).css("visibility", "hidden");
			$(ui.helper).width($(this).width());
		},
		stop: function(event, ui) {
			$(this).css("visibility", "visible");
		}
	});
}

elgg.file_tools.initialize_folder_droppable = function() {
	$("#file_tools_list_files .file-tools-folder").droppable({
		accept: "#file_tools_list_files .file-tools-file",
		drop: function(event, ui){
			droppable = $(this);
			draggable = ui.draggable;

			drop_id = droppable.parent().attr("id").split("-").pop();
			drag_id = draggable.parent().attr("id").split("-").pop();

			elgg.file_tools.move_file(drag_id, drop_id, draggable);
		}
	});
}

elgg.file_tools.init = function() {
	// uploadify functions
	elgg.file_tools.uploadify.init();

	// upload functions
	$('#file-tools-upload-tabs a').live("click", elgg.file_tools.upload_tab_click);
	
	// tree functions
	elgg.file_tools.tree.init();
	
	$('#file_tools_breadcrumbs a').live("click", elgg.file_tools.breadcrumb_click);
	$('#file_tools_select_all').live("click", elgg.file_tools.select_all);
	$('#file_tools_action_bulk_delete').live("click", elgg.file_tools.bulk_delete);
	$('#file_tools_action_bulk_download').live("click", elgg.file_tools.bulk_download);
	$('#file-tools-show-more-files').live("click", elgg.file_tools.show_more_files);

	$('#file_tools_list_new_folder_toggle').live('click', elgg.file_tools.new_folder);
}

// register init hook
elgg.register_hook_handler("init", "system", elgg.file_tools.init);