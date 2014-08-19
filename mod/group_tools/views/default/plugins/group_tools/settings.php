<?php

	$plugin = $vars["entity"];
	
	$admin_transfer_options = array(
		"no" => elgg_echo("option:no"),
		"admin" => elgg_echo("group_tools:settings:admin_transfer:admin"),
		"owner" => elgg_echo("group_tools:settings:admin_transfer:owner")
	);

	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	$yesno_options = array_reverse($noyes_options);
	
	$noyes3_options = array(
		"no" => elgg_echo("option:no"),
		"yes_off" => elgg_echo("group_tools:settings:invite_members:default_off"),
		"yes_on" => elgg_echo("group_tools:settings:invite_members:default_on")
	);
	
	$listing_options = array(
		"discussion" => elgg_echo("groups:latestdiscussion"),
		"newest" => elgg_echo("groups:newest"),
		"popular" => elgg_echo("groups:popular"),
		"open" => elgg_echo("group_tools:groups:sorting:open"),
		"closed" => elgg_echo("group_tools:groups:sorting:closed"),
		"alpha" => elgg_echo("group_tools:groups:sorting:alphabetical"),
		"ordered" => elgg_echo("group_tools:groups:sorting:ordered"),
		"suggested" => elgg_echo("group_tools:groups:sorting:suggested"),
	);
		
	if ($auto_joins = $plugin->auto_join) {
		$auto_joins = string_to_tag_array($auto_joins);
	}
	
	if ($suggested_groups = $plugin->suggested_groups) {
		$suggested_groups = string_to_tag_array($suggested_groups);
	}
	
	// group management settings
	$title = elgg_echo("group_tools:settings:management:title");
	
	$body = "<div>";
	$body .= elgg_echo("group_tools:settings:admin_transfer");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[admin_transfer]", "options_values" => $admin_transfer_options, "value" => $plugin->admin_transfer));
	$body .= "</div>";
	
	$body .= "<br />";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:search_index");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[search_index]", "options_values" => $noyes_options, "value" => $plugin->search_index));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:auto_notification");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[auto_notification]", "options_values" => $noyes_options, "value" => $plugin->auto_notification));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:show_membership_mode");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[show_membership_mode]", "options_values" => $yesno_options, "value" => $plugin->show_membership_mode));
	$body .= "</div>";

	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:auto_suggest_groups");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[auto_suggest_groups]", "options_values" => $yesno_options, "value" => $plugin->auto_suggest_groups));
	$body .= "</div>";
	
	$body .= "<br />";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:multiple_admin");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[multiple_admin]", "options_values" => $noyes_options, "value" => $plugin->multiple_admin));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:mail");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[mail]", "options_values" => $noyes_options, "value" => $plugin->mail));
	$body .= "</div>";
	
	$body .= "<br />";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:listing:default");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[group_listing]", "options_values" => $listing_options, "value" => $plugin->group_listing));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:listing:available");
	$body .= "<ul class='mll'>";
	
	foreach ($listing_options as $tab => $tab_title) {
		$tab_setting_name = "group_listing_" . $tab . "_available";
		$checkbox_options = array(
				"name" => "params[" . $tab_setting_name . "]",
				"value" => 1
				);
		$tab_value = $plugin->$tab_setting_name;
		if (($tab_value !== "0")) {
			if ($tab == "ordered") {
				// ordered tab is default disabled
				if ($tab_value !== null) {
					$checkbox_options["checked"] = "checked";
				}
			} else {
				$checkbox_options["checked"] = "checked";
			}
		}
		$body .= "<li>" . elgg_view("input/checkbox", $checkbox_options) . " " . $tab_title . "</li>";
	}
	$body .= "</ul>";
	$body .= "</div>";
	
	echo elgg_view_module("inline", $title, $body);
	
	// group invite settings
	$title = elgg_echo("group_tools:settings:invite:title");
	
	$body = "<div>";
	$body .= elgg_echo("group_tools:settings:invite");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[invite]", "options_values" => $noyes_options, "value" => $plugin->invite));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:invite_email");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[invite_email]", "options_values" => $noyes_options, "value" => $plugin->invite_email));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:invite_csv");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[invite_csv]", "options_values" => $noyes_options, "value" => $plugin->invite_csv));
	$body .= "</div>";
	
	$body .= "<div>";
	$body .= elgg_echo("group_tools:settings:invite_members");
	$body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[invite_members]", "options_values" => $noyes3_options, "value" => $plugin->invite_members));
	$body .= "<div class='plm elgg-subtext'>" . elgg_echo("group_tools:settings:invite_members:description") . "</div>";
	$body .= "</div>";
	
	echo elgg_view_module("inline", $title, $body);

	// group default access settings
	$title = elgg_echo("group_tools:settings:default_access:title");
	
	$body = "<div>";
	$body .= elgg_echo("group_tools:settings:default_access");
	
	// set a context so we can do stuff
	elgg_push_context("group_tools_default_access");
	
	$body .= "&nbsp;" . elgg_view("input/access", array("name" => "params[group_default_access]", "value" => $plugin->group_default_access));
	
	// restore context
	elgg_pop_context();
	
	$body .= "</div>";
	
	// check if we need to set a disclaimer
	global $GROUP_TOOLS_GROUP_DEFAULT_ACCESS_ENABLED;
	if (empty($GROUP_TOOLS_GROUP_DEFAULT_ACCESS_ENABLED)) {
		$body .= "<pre>";
		$body .= elgg_echo("group_tools:settings:default_access:disclaimer");
		$body .= "</pre>";
	}
	
	echo elgg_view_module("inline", $title, $body);
	
	// list all special state groups (features/auto_join/suggested
	$tabs = array();
	$content = "";
	
	// featured
	$options = array(
		"type" => "group",
		"limit" => false,
		"metadata_name_value_pairs" => array(
			"name" => "featured_group",
			"value" => "yes"
		)
	);
	
	if ($featured_groups = elgg_get_entities_from_metadata($options)) {
		$tabs[] = array(
			"text" => elgg_echo("group_tools:settings:special_states:featured"),
			"href" => "#group-tools-special-states-featured",
			"selected" => true
		);
		
		$content .= "<div id='group-tools-special-states-featured'>";
		$content .= elgg_view("output/longtext", array("value" => elgg_echo("group_tools:settings:special_states:featured:description")));
		
		$content .= "<table class='elgg-table mtm'>";
		
		$content .= "<tr>";
		$content .= "<th colspan='2'>" . elgg_echo("groups:name") . "</th>";
		$content .= "</tr>";
		
		foreach ($featured_groups as $group) {
			$content .= "<tr>";
			$content .= "<td>" . elgg_view("output/url", array("href" => $group->getURL(), "text" => $group->name)) . "</td>";
			$content .= "<td style='width: 25px'>";
			$content .= elgg_view("output/confirmlink", array(
				"href" => "action/groups/featured?group_guid=" . $group->getGUID(),
				"title" => elgg_echo("group_tools:remove"),
				"text" => elgg_view_icon("delete"),
			));
			$content .= "</td>";
			$content .= "</tr>";
		}
		
		$content .= "</table>";
		$content .= "</div>";
	}
	
	// auto join
	if (!empty($auto_joins)) {
		$class = "";
		$selected = true;
		if (!empty($tabs)) {
			$class = "hidden";
			$selected = false;
		}
		$tabs[] = array(
			"text" => elgg_echo("group_tools:settings:special_states:auto_join"),
			"href" => "#group-tools-special-states-auto-join",
			"selected" => $selected
		);
		
		$content .= "<div id='group-tools-special-states-auto-join' class='" . $class . "'>";
		$content .= elgg_view("output/longtext", array("value" => elgg_echo("group_tools:settings:special_states:auto_join:description")));
		
		$content .= "<table class='elgg-table mtm'>";
		
		$content .= "<tr>";
		$content .= "<th colspan='2'>" . elgg_echo("groups:name") . "</th>";
		$content .= "</tr>";
		
		$options = array(
			"type" => "group",
			"limit" => false,
			"guids" => $auto_joins
		);
		
		$groups = elgg_get_entities($options);
		
		if (!empty($groups)) {
			foreach ($groups as $group) {
				$content .= "<tr>";
				$content .= "<td>" . elgg_view("output/url", array("href" => $group->getURL(), "text" => $group->name)) . "</td>";
				$content .= "<td style='width: 25px'>";
				$content .= elgg_view("output/confirmlink", array(
					"href" => "action/group_tools/toggle_special_state?group_guid=" . $group->getGUID() . "&state=auto_join",
					"title" => elgg_echo("group_tools:remove"),
					"text" => elgg_view_icon("delete"),
				));
				$content .= "</td>";
				$content .= "</tr>";
			}
		}
		
		$content .= "</table>";
		$content .= "</div>";
	}
	
	// suggested
	if (!empty($suggested_groups)) {
		$class = "";
		$selected = true;
		if (!empty($tabs)) {
			$class = "hidden";
			$selected = false;
		}
		$tabs[] = array(
			"text" => elgg_echo("group_tools:settings:special_states:suggested"),
			"href" => "#group-tools-special-states-suggested",
			"selected" => $selected
		);
		
		$content .= "<div id='group-tools-special-states-suggested' class='" . $class . "'>";
		$content .= elgg_view("output/longtext", array("value" => elgg_echo("group_tools:settings:special_states:suggested:description")));
		
		$content .= "<table class='elgg-table mtm'>";
		
		$content .= "<tr>";
		$content .= "<th colspan='2'>" . elgg_echo("groups:name") . "</th>";
		$content .= "</tr>";
		
		$options = array(
			"type" => "group",
			"limit" => false,
			"guids" => $suggested_groups
		);
		
		$groups = elgg_get_entities($options);
		
		if (!empty($groups)) {
			foreach ($groups as $group) {
				
				$content .= "<tr>";
				$content .= "<td>" . elgg_view("output/url", array("href" => $group->getURL(), "text" => $group->name)) . "</td>";
				$content .= "<td style='width: 25px'>";
				$content .= elgg_view("output/confirmlink", array(
					"href" => "action/group_tools/toggle_special_state?group_guid=" . $group->getGUID() . "&state=suggested",
					"title" => elgg_echo("group_tools:remove"),
					"text" => elgg_view_icon("delete"),
				));
				$content .= "</td>";
				$content .= "</tr>";
			}
		}
		
		$content .= "</table>";
		$content .= "</div>";
	}
	
	if (!empty($tabs)) {
		$navigation = "";
		if (count($tabs) > 1) {
			$navigation = elgg_view("navigation/tabs", array("tabs" => $tabs, "id" => "group-tools-special-states-tabs"));
		}
		
		echo elgg_view_module("inline", elgg_echo("group_tools:settings:special_states"), $navigation . $content);
	}
	
	// fix some problems with groups
	
	$rows = array();
	
	// check missing acl members
	if ($missing_acl_members = group_tools_get_missing_acl_users()) {
		$rows[] = array(
			elgg_echo("group_tools:settings:fix:missing", array(count($missing_acl_members))),
			elgg_view("output/confirmlink", array(
				"href" => "action/group_tools/fix_acl?fix=missing",
				"text" => elgg_echo("group_tools:settings:fix_it"),
				"class" => "elgg-button elgg-button-action",
				"is_action" => true,
				"style" => "white-space: nowrap;"
			))
		);
	}
	
	// check excess acl members
	if ($excess_acl_members = group_tools_get_excess_acl_users()) {
		$rows[] = array(
			elgg_echo("group_tools:settings:fix:excess", array(count($excess_acl_members))),
			elgg_view("output/confirmlink", array(
				"href" => "action/group_tools/fix_acl?fix=excess",
				"text" => elgg_echo("group_tools:settings:fix_it"),
				"class" => "elgg-button elgg-button-action",
				"is_action" => true,
				"style" => "white-space: nowrap;"
			))
		);
	}
	
	// check groups without acl
	if ($wrong_groups = group_tools_get_groups_without_acl()) {
		$rows[] = array(
			elgg_echo("group_tools:settings:fix:without", array(count($wrong_groups))),
			elgg_view("output/confirmlink", array(
				"href" => "action/group_tools/fix_acl?fix=without",
				"text" => elgg_echo("group_tools:settings:fix_it"),
				"class" => "elgg-button elgg-button-action",
				"is_action" => true,
				"style" => "white-space: nowrap;"
			))
		);
	}
	
	// fix everything at once
	if (count($rows) > 1) {
		$rows[] = array(
			elgg_echo("group_tools:settings:fix:all:description"),
			elgg_view("output/confirmlink", array(
				"href" => "action/group_tools/fix_acl?fix=all",
				"text" => elgg_echo("group_tools:settings:fix:all"),
				"class" => "elgg-button elgg-button-action",
				"is_action" => true,
				"style" => "white-space: nowrap;"
			))
		);
	}
	
	if (!empty($rows)) {
		$content = "<table class='elgg-table'>";
		
		foreach($rows as $row){
			$content .= "<tr><td>" . implode("</td><td>", $row) . "</td></tr>";
		}
		
		$content .= "</table>";
		
		echo elgg_view_module("inline", elgg_echo("group_tools:settings:fix:title"), $content);
	}
	
	