define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$('#elgg-tidypics-im-test').click(function() {
		var image_id = $('input[name=image_id]').val();
		$("#elgg-tidypics-im-results").html('<div class="elgg-ajax-loader"></div>');
		elgg.action('photos/admin/create_thumbnails', {
			format: 'JSON',
			data: {guid: image_id},
			cache: false,
			success: function(result) {
				// error
				if (result.status < 0) {
					var html = '';
				} else {
					var html = '<img class="elgg-photo tidypics-photo" src="'
						+ result.output.thumbnail_src + '" alt="' + result.output.title
						+ '" />';
				}
				$("#elgg-tidypics-im-results").html(html);
			}
		});
	});
});
