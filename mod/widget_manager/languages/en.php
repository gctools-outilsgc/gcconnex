<?php

return [

	// admin menu items
	'admin:widgets' => "Widgets",
	'admin:widgets:manage' => "Manage",
	'admin:widgets:manage:index' => "Manage Index",
	'admin:statistics:widgets' => "Widget Usage",

	// widget edit wrapper
	'widget_manager:widgets:edit:custom_title' => "Custom title",
	'widget_manager:widgets:edit:custom_url' => "Custom title link",
	'widget_manager:widgets:edit:custom_more_title' => "Custom more text",
	'widget_manager:widgets:edit:custom_more_url' => "Custom more link",
	'widget_manager:widgets:edit:hide_header' => "Hide header",
	'widget_manager:widgets:edit:custom_class' => "Custom CSS class",
	'widget_manager:widgets:edit:disable_widget_content_style' => "No widget style",
	'widget_manager:widgets:edit:fixed_height' => "Fixed widget height (in pixels)",
	'widget_manager:widgets:edit:collapse_disable' => "Disable collapse ability",
	'widget_manager:widgets:edit:collapse_state' => "Default collapsed state",

	// group
	'widget_manager:groups:enable_widget_manager' => "Enable management of widgets",

	// admin settings
	'widget_manager:settings:index' => "Index",
	'widget_manager:settings:group' => "Group",

	'widget_manager:settings:custom_index' => "Use Widget Manager custom index?",
	'widget_manager:settings:custom_index:non_loggedin' => "For non-loggedin users only",
	'widget_manager:settings:custom_index:loggedin' => "For loggedin users only",
	'widget_manager:settings:custom_index:all' => "For all users",

	'widget_manager:settings:widget_layout' => "Choose a widget layout",
	'widget_manager:settings:widget_layout:33|33|33' => "Default layout (33% per column)",
	'widget_manager:settings:widget_layout:50|25|25' => "Wide left column (50%, 25%, 25%)",
	'widget_manager:settings:widget_layout:25|50|25' => "Wide middle column (25%, 50%, 25%)",
	'widget_manager:settings:widget_layout:25|25|50' => "Wide right column (25%, 25%, 50%)",
	'widget_manager:settings:widget_layout:75|25' => "Two column (75%, 25%)",
	'widget_manager:settings:widget_layout:60|40' => "Two column (60%, 40%)",
	'widget_manager:settings:widget_layout:50|50' => "Two column (50%, 50%)",
	'widget_manager:settings:widget_layout:40|60' => "Two column (40%, 60%)",
	'widget_manager:settings:widget_layout:25|75' => "Two column (25%, 75%)",
	'widget_manager:settings:widget_layout:100' => "Single column (100%)",

	'widget_manager:settings:index_top_row' => "Show a top row on the index page",
	'widget_manager:settings:index_top_row:none' => "No top row",
	'widget_manager:settings:index_top_row:full_row' => "Full width row",
	'widget_manager:settings:index_top_row:two_column_left' => "Two column aligned left",

	'widget_manager:settings:group:enable' => "Enable Widget Manager for groups",
	'widget_manager:settings:group:enable:yes' => "Yes, managable by group tool option",
	'widget_manager:settings:group:enable:forced' => "Yes, always on",
	'widget_manager:settings:group:option_default_enabled' => "Widget management for groups default enabled",
	'widget_manager:settings:group:option_admin_only' => "Only administrator can enable group widgets",
	'widget_manager:settings:group:force_tool_widgets' => "Enforce group tool widgets",
	'widget_manager:settings:group:force_tool_widgets:confirm' => "Are you sure? This will add/remove all widgets specific to a tool option for all groups (where widget management is enabled).",

	'widget_manager:settings:extra_contexts' => "Extra widget contexts",
	'widget_manager:settings:extra_contexts:add' => "Add a page",
	'widget_manager:settings:extra_contexts:description' => "Enter the page handler name of the new page which will get a layout similar to the index page. You can add as much pages as you need. Be sure not to add a page handler that is already in use. You can also configure the column layout for that page and optionally assign non-admin users as manager of the page by entering their username. You can have multiple managers by seperating their username by a comma.",
	'widget_manager:settings:extra_contexts:page' => "Page",
	'widget_manager:settings:extra_contexts:layout' => "Layout",
	'widget_manager:settings:extra_contexts:top_row' => "Extra Top Row",
	'widget_manager:settings:extra_contexts:manager' => "Manager",

	// views
	// settings
	'widget_manager:forms:manage_widgets:no_widgets' => "No widgets to manage",
	'widget_manager:forms:manage_widgets:context' => 'Available in the context',
	'widget_manager:forms:manage_widgets:can_add' => "Can be added",
	'widget_manager:forms:manage_widgets:multiple' => "Multiple widgets allowed",
	'widget_manager:forms:manage_widgets:non_default' => "This setting is different from the default setting",
	'widget_manager:forms:manage_widgets:unsupported_context:confirm' => "Are you sure you wish to enable this widget for this context? If the widget does not support the context this could cause issues.",

	// groups widget access
	'widget_manager:forms:groups_widget_access:title' => "Widget Access",
	'widget_manager:forms:groups_widget_access:description' => "This action allows you to update the access level of all widgets in this group to the given access level.",
	
	// lightbox
	'widget_manager:button:add' => "Add widget",
	'widget_manager:widgets:lightbox:title:dashboard' => "Add widgets to your personal dashboard",
	'widget_manager:widgets:lightbox:title:profile' => "Add widgets to your public profile",
	'widget_manager:widgets:lightbox:title:index' => "Add widgets to the index",
	'widget_manager:widgets:lightbox:title:groups' => "Add widgets to the group profile",
	'widget_manager:widgets:lightbox:title:admin' => "Add widgets to your admin dashboard",

	// actions
	// manage
	'widget_manager:action:manage:success' => "Widget configuration saved successfully",

	// force tool widgets
	'widget_manager:action:force_tool_widgets:error:not_enabled' => "Widget managent for groups is not enabled",
	'widget_manager:action:force_tool_widgets:succes' => "Enforced tool specific widgets for %s groups",
	
	// groups update widget access
	'widget_manager:action:groups:update_widget_access:success' => "Access to all widgets in this group is updated",
	
	// widgets
	'widget_manager:widgets:edit:advanced' => "Advanced",
	'widget_manager:widgets:fix' => "Fix this widget on the dashboard/profile",
];
