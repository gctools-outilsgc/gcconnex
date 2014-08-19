<?php
/**
 * AJAX uploading
 */

$maxfilesize = (int) elgg_get_plugin_setting('maxfilesize', 'tidypics');
$maxfilesize *= 1024;
?>

//<script>
elgg.provide('elgg.tidypics.uploading');

elgg.tidypics.uploading.init = function() {

	var fields = ['Elgg', 'user_guid', 'album_guid', 'batch', 'tidypics_token'];
	var data = elgg.security.token;

	$(fields).each(function(i, name) {
		var value = $('input[name=' + name + ']').val();
		if (value) {
			data[name] = value;
		}
	});

	$("#uploadify").uploadify({
		'swf'           : elgg.config.wwwroot + 'mod/tidypics/vendors/uploadify/uploadify.swf',
		'uploader'      : elgg.config.wwwroot + 'action/photos/image/ajax_upload',
		'fileObjName'   : 'Image',
		'fileSizeLimit' : <?php echo $maxfilesize; ?>,
		'fileTypeDesc'  : 'Image Files',
                'fileTypeExts'  : '*.gif; *.jpg; *.png', 
		'multi'         : true,
		'auto'          : false,
		'buttonText'    : '1. <?php echo elgg_echo('tidypics:uploader:choose'); ?>',
		'height'        : $('#tidypics-choose-button').height(),
		'width'         : $('#tidypics-choose-button').width(),
		'formData'      : data,
		'onFallback'    : function() {
                        alert('<?php echo elgg_echo('tidypics:uploader:no_flash'); ?>');
                },
                'onDialogClose' : function(queueData) {
                        if (queueData.queueLength > 0) {
                                 $("#tidypics-upload-button").removeClass('tidypics-disable');
                        }
                },
		'onUploadStart' : function(file) {
			// @todo do something
		},
		'onQueueComplete' : function(queueData) {
			elgg.action('photos/image/ajax_upload_complete', {
				data: {
					album_guid: data.album_guid,
					batch: data.batch
				},
				success: function(json) {
					var url = elgg.normalize_url('photos/edit/' + json.batch_guid)
					window.location.href = url;
				}
			});
		},
		'onUploadSuccess' : function(file, data, response) {
                        // check for errors here
                        if (response != 'success') {
                                $("#uploadify" + file.name + " .percentage").text(" - " + response);
                                $("#uploadify" + file.name).addClass('uploadifyError');
                        }
                        $("#uploadify" + file.name + " > .cancel").remove();
                        return false;
		},
		'onUploadComplete' : function(file) {
                        // @todo do something
		},
		'onCancel' : function(file) {
                        // @todo do something
                },
		'onClearQueue' : function(queueItemCount) {
		        // @todo do something
		},
		'onUploadError' : function (file, errorCode, errorMsg, errorString) {
			// @todo do something
		}

	});

	// bind to choose button
	$('#tidypics-choose-button').live('click', function(e) {
		var $uploadify = $('#uploadify');
		$uploadify.uploadify('disable', false);
		e.preventDefault();
	});
	
	// bind to upload button
        $('#tidypics-upload-button').live('click', function(e) {
                var $uploadify = $('#uploadify');
                $uploadify.uploadify('upload','*');
                e.preventDefault();
        });
}

elgg.register_hook_handler('init', 'system', elgg.tidypics.uploading.init);