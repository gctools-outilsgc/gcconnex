define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$(document).ready(function() {
		// broken images check
		$(document).on('click', '#elgg-tidypics-broken-images', function(){
			$(this).hide();
			var time = $.now();
			$("#elgg-tidypics-broken-images-results").html('<div><div class="elgg-ajax-loader"></div><div id="broken-image-log"></div><div>');
			elgg.action('photos/admin/broken_images', {
				timeout: 30000000,
				dataType: 'json',
				data: {
					delete: 0,
					time: time
				},
				success: function(result) {
					console.log(result);
				},
				error: function(jqXHR, textStatus, String) {
					console.log(textStatus);
				}
			});

			window.setTimeout(function() {
				refresh_deleteimage_log(time);
			}, 5000);
		});

		// broken images delete
		$(document).on('click', '#elgg-tidypics-broken-images-delete', function(){
			if (!confirm(elgg.echo('question:areyousure'))) {
				return false;
			}

			var time = $("#elgg-tidypics-broken-images-delete").data('time');

			$("#elgg-tidypics-broken-images-results").html('<div><div class="elgg-ajax-loader"></div><div id="broken-image-log"></div><div>');

			elgg.action('photos/admin/broken_images', {
				timeout: 30000000,
				data: {
					delete: 1,
					time: time
				}
			});

			window.setTimeout(function() {
				refresh_deleteimage_log(time);
			}, 15000);
		});

		function refresh_deleteimage_log(time) {
			elgg.get('ajax/view/photos/broken_images_delete_log?time='+time, {
				success: function(result) {

					if ($('#elgg-tidypics-broken-images-results div.done').length) {
						return; // all done!
					}

					if (result) {
						$('#elgg-tidypics-broken-images-results').html(result);
					}

					window.setTimeout(function() {
						refresh_deleteimage_log(time);
					}, 5000);
				}
			});
		}
	});
});