define(['elgg', 'jquery'], function (elgg, $) {

	$(document).on('click', '#widget-manager-settings-add-extra-context', function () {
		$('#widget-manager-settings-extra-contexts tr.hidden').clone().insertBefore($('#widget-manager-settings-extra-contexts tr.hidden')).removeClass('hidden');
	});

	$(document).on('click', '#widget-manager-settings-extra-contexts .elgg-icon-delete', function () {
		$(this).parent().parent().remove();
	});
});