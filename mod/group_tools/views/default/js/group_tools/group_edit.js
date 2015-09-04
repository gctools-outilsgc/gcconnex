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
}

elgg.group_tools.toggle_special_state = function(state, group_guid) {
	elgg.action("action/group_tools/toggle_special_state", {
		data : {
			group_guid: group_guid,
			state: state
		}
	});
}

elgg.group_tools.cleanup_highlight = function(section) {
	switch (section) {
		case "owner_block":
			$('div.elgg-sidebar ul.elgg-menu-extras').addClass('group-tools-highlight');
			break;
		case "menu":
			$('div.elgg-sidebar ul.elgg-menu-owner-block').addClass('group-tools-highlight');
			break;
		case "search":
			$('div.elgg-sidebar').append('<div id="group_tools_search_example" class="group-tools-highlight">' + elgg.echo('groups:search_in_group') + '</div>');
			break;
		case "members":
			$('div.elgg-sidebar').append('<div id="group_tools_members_example" class="group-tools-highlight">' + elgg.echo('groups:members') + '</div>');
			break;
		case "featured":
			$('div.elgg-sidebar').append('<div id="group_tools_featured_example" class="group-tools-highlight">' + elgg.echo('groups:featured') + '</div>');
			break;
		case "my_status":
			$('div.elgg-sidebar').append('<div id="group_tools_my_status_example" class="group-tools-highlight">' + elgg.echo('groups:my_status') + '</div>');
			break;
	}
}

elgg.group_tools.cleanup_unhighlight = function(section) {
	switch (section) {
		case "owner_block":
			$('div.elgg-sidebar ul.elgg-menu-extras').removeClass('group-tools-highlight');
			break;
		case "menu":
			$('div.elgg-sidebar ul.elgg-menu-owner-block').removeClass('group-tools-highlight');
			break;
		case "search":
			$('#group_tools_search_example').remove();
			break;
		case "members":
			$('#group_tools_members_example').remove();
			break;
		case "featured":
			$('#group_tools_featured_example').remove();
			break;
		case "my_status":
			$('#group_tools_my_status_example').remove();
			break;
	}
}
