/**
 * JS for on the group edit page
 */

/** global: elgg */
elgg.provide("elgg.group_tools");

elgg.group_tools.toggle_featured = function(group_guid, element) {
	var action_type = "";

	if ($(element).val() == "yes") {
		action_type = "feature";
	}

	elgg.action("action/groups/featured", {
		data : {
			group_guid: group_guid,
			action_type: action_type
		}
	});
};

elgg.group_tools.toggle_special_state = function(state, group_guid) {
	elgg.action("action/group_tools/toggle_special_state", {
		data : {
			group_guid: group_guid,
			state: state
		}
	});
};

elgg.group_tools.show_join_motivation = function(elem) {
	
	if ($(elem).val() === '0') {
		$('#group-tools-join-motivation').show();
	} else {
		$('#group-tools-join-motivation').hide();
	}
};
