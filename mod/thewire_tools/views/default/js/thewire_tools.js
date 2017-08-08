elgg.provide('elgg.thewire_tools');

elgg.thewire_tools.split = function (val) {
	return val.split( / \s*/ );
};

elgg.thewire_tools.extract_last = function (term, el) {

	var pos = el.selectionStart;

	term = term.substring(0, pos);
		
	return elgg.thewire_tools.split(term).pop();
};

elgg.thewire_tools.show_thread = function (event) {
	var guid = $(this).attr("rel");
	var $placeholder = $("#thewire-thread-" + guid);

	if (!$placeholder.length) {
		return;
	}

	if ($placeholder.is(":visible")) {
		$placeholder.hide();
		return false;
	}

	if ($placeholder.html().length) {
		$placeholder.show();
		return false;
	}
	
	elgg.get("ajax/view/thewire_tools/thread", {
		data: $placeholder.data(),
		success: function(result) {
			$placeholder.html(result).show();
		}
	});
	
	return false;
};

elgg.thewire_tools.init = function() {
	$(document).on("click", ".elgg-menu-item-thread a", elgg.thewire_tools.show_thread);
};

elgg.register_hook_handler('init', 'system', elgg.thewire_tools.init);