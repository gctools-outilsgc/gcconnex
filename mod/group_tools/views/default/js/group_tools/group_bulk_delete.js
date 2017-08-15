define(function (require) {

	var $ = require('jquery');

	$(document).on('change', '[name="checkall"]', function () {
		var $form = $(this).closest('form');
		var checked = $(this).is(":checked");
		$('[name="group_guids[]"]', $form).prop('checked', checked);
	});
});


