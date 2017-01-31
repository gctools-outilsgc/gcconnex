define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$('#slideshow').click(function() {
		var slideshowurl = $(this).data('slideshowurl');
		var lite_url = elgg.get_site_url() + "mod/tidypics/vendors/PicLensLite/";
		PicLensLite.setLiteURLs({lite: lite_url});
		PicLensLite.start({maxScale: 0, feedUrl: slideshowurl});
	});
});
