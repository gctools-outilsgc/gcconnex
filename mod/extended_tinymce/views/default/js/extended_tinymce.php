elgg.provide('elgg.extended_tinymce');

/**
 * Toggles the extended tinymce editor
 *
 * @param {Object} event
 * @return void
 */
elgg.extended_tinymce.toggleEditor = function(event) {
	event.preventDefault();

	var target = $(this).attr('href');
	var id = $(target).attr('id');
	if (!tinyMCE.get(id)) {
		tinyMCE.execCommand('mceAddControl', false, id);
		$(this).html(elgg.echo('extended_tinymce:remove'));
	} else {
		tinyMCE.execCommand('mceRemoveControl', false, id);
		$(this).html(elgg.echo('extended_tinymce:add'));
	}
}

/**
 * TinyMCE initialization script
 *
 * You can find configuration information here:
 * http://tinymce.moxiecode.com/wiki.php/Configuration
 */
elgg.extended_tinymce.init = function() {

	$('.extended_tinymce-toggle-editor').live('click', elgg.extended_tinymce.toggleEditor);

	$('.elgg-input-longtext').parents('form').submit(function() {
		tinyMCE.triggerSave();
	});

	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "elgg-input-longtext",
		theme : "advanced",
		skin : "cirkuit",
                language : "<?php echo extended_tinymce_get_site_language(); ?>",
		plugins : "lists,autosave,fullscreen,style,table,advhr,advimage,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras",
		relative_urls : false,
		remove_script_host : false,
		document_base_url : elgg.config.wwwroot,
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,table,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink",
		theme_advanced_buttons3 : "print,|,insertdate,inserttime,|,forecolor,backcolor,|,image,emotions,|,fullscreen,|,code",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_path : true,
		width : "100%",
		extended_valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height],object[classid|clsid|codebase|width|height],font[face|size|color|style],span[class|align|style],style[lang|media|title|type]",
		setup : function(ed) {
			//show the number of words
			ed.onLoadContent.add(function(ed, o) {
				var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
				var text = elgg.echo('extended_tinymce:word_count') + strip.split(' ').length + ' ';
				tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
			});

			ed.onKeyUp.add(function(ed, e) {
				var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
				var text = elgg.echo('extended_tinymce:word_count') + strip.split(' ').length + ' ';
				tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
			});
		},
		content_css: elgg.config.wwwroot + 'mod/extended_tinymce/css/elgg_extended_tinymce.css'
	});

	// work around for IE/TinyMCE bug where TinyMCE loses insert carot
        if ($.browser.msie) {
                $(".embed-control").live('hover', function() {
                        var classes = $(this).attr('class');
                        var embedClass = classes.split(/[, ]+/).pop();
                        var textAreaId = embedClass.substr(embedClass.indexOf('embed-control-') + "embed-control-".length);

                        if (window.tinyMCE) {
                                var editor = window.tinyMCE.get(textAreaId);
                                if (elgg.extended_tinymce.bookmark == null) {
                                        elgg.extended_tinymce.bookmark = editor.selection.getBookmark(2);
                                }
                        }
                });
        }
}

elgg.register_hook_handler('init', 'system', elgg.extended_tinymce.init);
