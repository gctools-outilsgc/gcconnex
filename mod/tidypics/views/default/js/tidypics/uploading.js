define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function init() {
		var fields = ['Elgg', 'user_guid', 'album_guid', 'batch', 'tidypics_token'];
		var data = elgg.security.token;

		$(fields).each(function(i, name) {
			var value = $('input[name=' + name + ']').val();
			if (value) {
				data[name] = value;
			}
		});
		
		var maxfilesize = $("#uploader").data('maxfilesize');
		var maxfiles = $("#uploader").data('maxnumber');

		$("#uploader").plupload({
			// General settings
			runtimes : 'html5,html4',
			url : elgg.get_site_url() + 'action/photos/image/ajax_upload',
			file_data_name : 'Image',

			dragdrop: true,
			sortable: true,
			multipart_params : data,
			max_file_size : maxfilesize + 'mb',

			filters : [
				{title : elgg.echo('tidypics:uploader:filetype'), extensions : "jpg,jpeg,gif,png"}
			],

			// Views to activate
			views: {
				list: true,
				thumbs: true,
				active: 'thumbs'
			},

			init : {
				UploadComplete: function(up, files) {
					// Called when all files are either uploaded or failed
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

				FilesAdded: function(up, files) {
					if(up.files.length > maxfiles ) {
						alert(elgg.echo('tidypics:exceedmax_number', [maxfiles]));
					}
					if(up.files.length > maxfiles ) {
						up.splice(maxfiles);
					}
					if (up.files.length >= maxfiles) {
						up.disableBrowse(true);
					}
				},

				FilesRemoved: function(up, files) {
					if (up.files.length < maxfiles) {
						up.disableBrowse(false);
					}
				}
			}
		});
	}

	init();
});
