define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$('#tidypics-im-test').click(function() {
		var loc = $('input[name=im_location]').val();
		$("#tidypics-im-results").html("");

		elgg.get('mod/tidypics/actions/photos/admin/imtest.php', {
			data: {location: loc},
			cache: false,
			success: function(html) {
					if (html == '') {
						$("#tidypics-im-results").html(elgg.echo('tidypics:lib_tools:error'));
					} else {
						$("#tidypics-im-results").html(html);
					}
			}
		});
	});
});
