<?php
/**
 * Extend the global site JS
 */
?>
//<script>
elgg.provide("elgg.group_tools");

elgg.group_tools.order_groups = function() {
	var ordered_ids = new Array();
	$('.group-tools-list-ordered > li').each(function() {
		group_id = $(this).attr("id").replace("elgg-group-", "");
		ordered_ids.push(group_id);
	});
	elgg.action("group_tools/order_groups", {
		data: {
			guids: ordered_ids
		}
	});
}

elgg.group_tools.kill_request = function() {

	var reason = prompt(elgg.echo('group_tools:groups:membershipreq:kill_request:prompt'));
	if (reason === null) {
		// user clicked cancel
		return false;
	}
	var guid = $(this).attr('rel');
	
	elgg.action($(this).attr('href'), {
		data: {
			reason: reason,
		},
		success: function() {
			var $wrapper = $('li.elgg-item[data-guid="' + guid + '"]');
			if ($wrapper.length) {
				$wrapper.remove();
			}
		}
	});
	
	return false;
};

elgg.group_tools.accept_request = function() {

	var guid = $(this).attr('rel');
	
	elgg.action($(this).attr('href'), {
		success: function() {
			var $wrapper = $('li.elgg-item[data-guid="' + guid + '"]');
			if ($wrapper.length) {
				$wrapper.remove();
			}
		}
	});
	
	return false;
};

elgg.group_tools.init = function() {
	$('.group-tools-list-ordered').sortable({
		update: elgg.group_tools.order_groups
	});

	// discussion start widget
	if ($('#group-tools-start-discussion-widget-form').length) {
		$('#group-tools-start-discussion-widget-form').submit(function() {
			var selected_group = $('#group-tools-discussion-quick-start-group').val();
			if (selected_group !== "0") {
				$('#group-tools-discussion-quick-start-access_id option').removeAttr("selected");
				$('#group-tools-discussion-quick-start-access_id option').each(function(index, elem) {
					if ($(elem).html() == selected_group) {
						$(elem).attr("selected", "selected");
					}
				});
			} else {
				elgg.register_error(elgg.echo("group_tools:forms:discussion:quick_start:group:required"));
				return false;
			}
		});
	}

	// suggested groups join clicks
	$(".group-tools-suggested-groups .elgg-button-action").live("click", function() {

		elgg.action($(this).attr("href"));

		$(this).css("visibility", "hidden");
		
		return false;
	});

	// make group admin menu toggle
	elgg.ui.registerTogglableMenuItems("group-admin", "group-admin-remove");
	// make discussion open/close menu toggle
	elgg.ui.registerTogglableMenuItems("status-change-open", "status-change-close");

	// prompt on kill group join request
	$('a.group-tools-kill-request-prompt').on('click', elgg.group_tools.kill_request);
	$('a.group-tools-accept-request').on('click', elgg.group_tools.accept_request);
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.group_tools.init);
