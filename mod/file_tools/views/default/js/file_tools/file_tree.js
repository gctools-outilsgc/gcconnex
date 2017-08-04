/**
 * JS file for the file_tree widget
 */
define(function(require){
	var $ = require('jquery');
	var elgg = require('elgg');
	var Ajax = require('elgg/Ajax');
	
	function toggle_content() {
		var $link = $(this);
		var $li = $link.closest('.elgg-item-object-folder');
		
		if ($li.find('> .elgg-list').length) {
			// content already loaded
			$li.find('> .elgg-list').toggle();
			$li.find('> .elgg-content > .elgg-output').toggle();
			$link.find('> span').toggleClass('hidden');
			
			return;
		}
		
		var ajax = new Ajax();
		ajax.view('object/folder/file_tree_content', {
			data: $link.data(),
			method: 'GET',
			success: function(data) {
				
				if (!data.length) {
					data = '<ul class="elgg-list"><li class="elgg-item">' + elgg.echo('file_tools:object:no_files') + '</li></ul>';
				}
				
				$li.append(data);
				
				$li.find('> .elgg-content > .elgg-output').hide();
				$link.find('> span').toggleClass('hidden');
			}
		});
	};
	
	function init() {
		$(document).on('click', '.elgg-widget-instance-file_tree a.file-tools-file-tree-toggle-content', toggle_content);
	};
	
	init();
});
