define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function init() {
	    /*
        Production would toss up error 
        Removed - Now lightbox is done through Elgg's lightbox
        */
        if ($(".tidypics-lightbox").length) {
			$(".tidypics-lightbox").colorbox({photo:true, maxWidth:'95%', maxHeight:'95%'});
		}

		$("#tidypics-sort").sortable({
			opacity: 0.7,
			revert: true,
			scroll: true
		});

		$('.elgg-form-photos-album-sort').submit(function() {
			var tidypics_guids = [];
			$("#tidypics-sort li").each(function(index) {
				tidypics_guids.push($(this).attr('id'));
			});
			$('input[name="guids"]').val(tidypics_guids.toString());
		});
	}

	init();
});
