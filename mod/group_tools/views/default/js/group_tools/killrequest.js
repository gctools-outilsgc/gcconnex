define('group_tools/killrequest', ['jquery', 'elgg'], function ($, elgg) {

	$(document).on('submit', '.elgg-form-groups-killrequest', function () {

		if (typeof $.colorbox !== 'undefined') {
			$.colorbox.close();
		}
		
		var guid = $(this).data('guid');
		
		elgg.action($(this).attr('action'), {
			data: $(this).serialize(),
			success: function () {
				var $wrapper = $('#elgg-user-' + guid);
				
				if ($wrapper.length) {
					$wrapper.remove();
				}
			}
		});

		return false;
	});
});
