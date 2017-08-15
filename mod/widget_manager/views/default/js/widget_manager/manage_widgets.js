define(['elgg', 'jquery'], function (elgg, $) {

	$(document).on('click', '.widget-manager-unsupported-context .elgg-input-checkbox', function (e, elem) {
		if(!$(this).is(':checked')) {
			return;
		}
		if (!confirm(elgg.echo('widget_manager:forms:manage_widgets:unsupported_context:confirm'))) {
			return false;
		}
	});
});