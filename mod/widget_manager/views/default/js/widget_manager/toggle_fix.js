define(['elgg', 'jquery'], function (elgg, $) {

	$(document).on('click', '.widget-manager-fix', function (event) {
		$(this).find(' > .elgg-icon').toggleClass('elgg-icon-hover');
		var guid = $(this).attr('href').replace('#', '');

		elgg.action('widget_manager/widgets/toggle_fix', {
			data: {
				guid: guid
			}
		});
		event.stopPropagation();
	});
});