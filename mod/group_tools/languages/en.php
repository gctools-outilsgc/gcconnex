<?php

	$english = array(

		// general
		'group_tools:decline' => "Decline",
		'group_tools:revoke' => "Revoke",
		'group_tools:add_users' => "Add users",
		'group_tools:in' => "in",
		'group_tools:remove' => "Remove",
		'group_tools:clear_selection' => "Clear selection",
		'group_tools:all_members' => "All members",
		'group_tools:explain' => "Explanation",

		'group_tools:default:access:group' => "Group members only",

		'group_tools:joinrequest:already' => "Revoke membership request",
		'group_tools:joinrequest:already:tooltip' => "You already requested to join this group, click here to revoke this request",

		// menu
		'group_tools:menu:mail' => "Email Members",
		'group_tools:menu:invitations' => "Manage invitations",

		// plugin settings
		'group_tools:settings:invite:title' => "Group invitation options",
		'group_tools:settings:management:title' => "General group options",
		'group_tools:settings:default_access:title' => "Default group access",

		'group_tools:settings:admin_transfer' => "Allow group owner transfer",
		'group_tools:settings:admin_transfer:admin' => "Site admin only",
		'group_tools:settings:admin_transfer:owner' => "Group owners and site admins",

		'group_tools:settings:multiple_admin' => "Allow multiple group admins",
		'group_tools:settings:auto_suggest_groups' => "Auto suggest groups on the 'Suggested' groups page based on profile information. Will be completed with the predefined suggested groups. Setting this to 'No' will only show the predefined suggested groups (if there are any).",

		'group_tools:settings:invite' => "Allow all users to be invited (not just colleagues)",
		'group_tools:settings:invite_email' => "Allow all users to be invited by e-mail address",
		'group_tools:settings:invite_csv' => "Allow all users to be invited by CSV-file",
		'group_tools:settings:invite_members' => "Allow group members to invite new users",
		'group_tools:settings:invite_members:default_off' => "Yes, default off",
		'group_tools:settings:invite_members:default_on' => "Yes, default on",
		'group_tools:settings:invite_members:description' => "Group owners/admins can enable/disable this for their group",

		'group_tools:settings:mail' => "Allow group mail (allows group admins to send a message to all members)",

		'group_tools:settings:listing:default' => "Default group listing tab",
		'group_tools:settings:listing:available' => "Available group listing tabs",

		'group_tools:settings:default_access' => "What should be the default access for content in the groups of this site",
		'group_tools:settings:default_access:disclaimer' => "<b>DISCLAIMER:</b> this will not work unless you have <a href='https://github.com/Elgg/Elgg/pull/253' target='_blank'>https://github.com/Elgg/Elgg/pull/253</a> applied to your Elgg installation.",

		'group_tools:settings:search_index' => "Allow closed groups to be indexed by search engines",
		'group_tools:settings:auto_notification' => "Automatically enable group notification on group join",
		'group_tools:settings:show_membership_mode' => "Show open/closed membership status on group profile and owner block",
		
		'group_tools:settings:special_states' => "Groups with a special state",
		'group_tools:settings:special_states:featured' => "Featured",
		'group_tools:settings:special_states:featured:description' => "The site administrators have chosen to feature the following groups.",
		'group_tools:settings:special_states:auto_join' => "Auto join",
		'group_tools:settings:special_states:auto_join:description' => "New users will automaticly join the following groups.",
		'group_tools:settings:special_states:suggested' => "Suggested",
		'group_tools:settings:special_states:suggested:description' => "The following groups are suggested to (new) users. It is possible to auto suggest groups, if no groups are automaticly detected or too few, the list will be appended by these groups.",

		'group_tools:settings:fix:title' => "Fix group access problems",
		'group_tools:settings:fix:missing' => "There are %d users who are a member of a group but don't have access to the content shared with the group.",
		'group_tools:settings:fix:excess' => "There are %d users who have access to group content of groups where they are no longer a member off.",
		'group_tools:settings:fix:without' => "There are %d groups without the possibility to share content with their members.",
		'group_tools:settings:fix:all:description' => "Fix all off the above problems at once.",
		'group_tools:settings:fix_it' => "Fix this",
		'group_tools:settings:fix:all' => "Fix all problems",
		'group_tools:settings:fix:nothing' => "Nothing is wrong with the groups on your site!",

		// group invite message
		'group_tools:groups:invite:body' => "Hi %s,

%s invited you to join the '%s' group.
%s

Click below to view your invitations:
%s",

		// group add message
		'group_tools:groups:invite:add:subject' => "You've been added to the group %s",
		'group_tools:groups:invite:add:body' => "Hi %s,

%s added you to the group %s.
%s

To view the group click on this link
%s",
		// group invite by email
		'group_tools:groups:invite:email:subject' => "You've been invited for the group %s",
		'group_tools:groups:invite:email:body' => "Hi,

%s invited you to join the group %s on %s.
%s

If you don't have an account on %s please register here
%s

If you already have an account or after you registered, please click on the following link to accept the invitation
%s

You can also go to All site groups -> Group invitations and enter the following code:
%s",
		// group transfer notification
		'group_tools:notify:transfer:subject' => "Administration of the group %s has been appointed to you",
		'group_tools:notify:transfer:message' => "Hi %s,

%s has appointed you as the new administrator of the group %s.

To visit the group please click on the following link:
%s",

		// group edit tabbed
		'group_tools:group:edit:profile' => "Group profile / tools",
		'group_tools:group:edit:other' => "Other options",

		// admin transfer - form
		'group_tools:admin_transfer:title' => "Transfer the ownership of this group",
		'group_tools:admin_transfer:transfer' => "Transfer group ownership to",
		'group_tools:admin_transfer:myself' => "Myself",
		'group_tools:admin_transfer:submit' => "Transfer",
		'group_tools:admin_transfer:no_users' => "No members or colleagues to transfer ownership to.",
		'group_tools:admin_transfer:confirm' => "Are you sure you wish to transfer ownership?",

		// special states form
		'group_tools:special_states:title' => "Group special states",
		'group_tools:special_states:description' => "A group can have several special states, here is an overview of the special states and their current value.",
		'group_tools:special_states:featured' => "Is this group featured",
		'group_tools:special_states:auto_join' => "Will users automaticly join this group",
		'group_tools:special_states:auto_join:fix' => "To make all site members a member of this group, please %sclick here%s.",
		'group_tools:special_states:suggested' => "Is this group suggested to (new) users",
		
		// group admins
		'group_tools:multiple_admin:group_admins' => "Group admins",
		'group_tools:multiple_admin:profile_actions:remove' => "Remove group admin",
		'group_tools:multiple_admin:profile_actions:add' => "Add group admin",

		'group_tools:multiple_admin:group_tool_option' => "Enable group admins to assign other group admins",

		// cleanup options
		'group_tools:cleanup:title' => "Group sidebar cleanup",
		'group_tools:cleanup:description' => "Cleanup the sidebar of the group. This will have no effect for the group admins.",
		'group_tools:cleanup:owner_block' => "Limit the owner block",
		'group_tools:cleanup:owner_block:explain' => "The owner block can be found at the top of the sidebar, some extra links can be posted in this area (example: RSS links).",
		'group_tools:cleanup:actions' => "Do you want to allow users to join this group",
		'group_tools:cleanup:actions:explain' => "Depending on your group setting, users can directly join the group or request membership.",
		'group_tools:cleanup:menu' => "Hide side menu items",
		'group_tools:cleanup:menu:explain' => "Hide the menu links to the different group tools. The users will only be able to get access to the group tools by using the group widgets.",
		'group_tools:cleanup:members' => "Hide the group members",
		'group_tools:cleanup:members:explain' => "On the group profile page a list of the group members can be found at the highlighted section. You can choose to hide this list.",
		'group_tools:cleanup:search' => "Hide the search in group",
		'group_tools:cleanup:search:explain' => "On the group profile page a search box is available. You can choose to hide this.",
		'group_tools:cleanup:featured' => "Show featured groups in the sidebar",
		'group_tools:cleanup:featured:explain' => "You can choose to show a list of featured groups at the highlighted section on the group profile page",
		'group_tools:cleanup:featured_sorting' => "How to sort featured groups",
		'group_tools:cleanup:featured_sorting:time_created' => "Newest first",
		'group_tools:cleanup:featured_sorting:alphabetical' => "Alphabetical",
		'group_tools:cleanup:my_status' => "Hide the My Status sidebar",
		'group_tools:cleanup:my_status:explain' => "In the sidebar on the group profile page there is an item which shows you your current membership status and some other status information. You can choose to hide this.",

		// group default access
		'group_tools:default_access:title' => "Group default access",
		'group_tools:default_access:description' => "Here you can control what the default access of new content in your group should be.",

		// group notification
		'group_tools:notifications:title' => "Group notifications",
		'group_tools:notifications:description' => "This group has %s members, of those %s have enabled notifications on activity in this group. Below you can change this for all users of the group.",
		'group_tools:notifications:disclaimer' => "With large groups this could take a while.",
		'group_tools:notifications:enable' => "Enable notifications for everyone",
		'group_tools:notifications:disable' => "Disable notifications for everyone",

		// group profile widgets
		'group_tools:profile_widgets:title' => "Show group profile widgets to non members",
		'group_tools:profile_widgets:description' => "This is a closed group. Default no widgets are shown to non members. Here you can configure if you whish to change that.",
		'group_tools:profile_widgets:option' => "Allow non members to view widgets on the group profile page:",

		// group mail
		'group_tools:mail:message:from' => "From group",

		'group_tools:mail:title' => "Send a mail to the group members",
		'group_tools:mail:form:recipients' => "Number of recipients",
		'group_tools:mail:form:members:selection' => "Select individual members",

		'group_tools:mail:form:title' => "Subject",
		'group_tools:mail:form:description' => "Body",

		'group_tools:mail:form:js:members' => "Please select at least one member to send the message to",
		'group_tools:mail:form:js:description' => "Please enter a message",

		// group invite
		'group_tools:groups:invite:title' => "Invite users to this group",
		'group_tools:groups:invite' => "Invite users",

		'group_tools:group:invite:friends:select_all' => "Select all colleagues",
		'group_tools:group:invite:friends:deselect_all' => "Deselect all colleagues",

		'group_tools:group:invite:users' => "Find user(s)",
		'group_tools:group:invite:users:description' => "Enter a name or username of a site member and select him/her from the list",
		'group_tools:group:invite:users:all' => "Invite all site members to this group",

		'group_tools:group:invite:email' => "Using e-mail address",
		'group_tools:group:invite:email:description' => "Enter a valid e-mail address and select it from the list",

		'group_tools:group:invite:csv' => "Using CSV upload",
		'group_tools:group:invite:csv:description' => "You can upload a CSV file with users to invite.<br />The format must be: displayname;e-mail address. There shouldn't be a header line.",

		'group_tools:group:invite:text' => "Personal note (optional)",
		'group_tools:group:invite:add:confirm' => "Are you sure you wish to add these users directly?",

		'group_tools:group:invite:resend' => "Resend invitations to users who already have been invited",

		'group_tools:groups:invitation:code:title' => "Group invitation by e-mail",
		'group_tools:groups:invitation:code:description' => "If you have received an invitation to join a group by e-mail, you can enter the invitation code here to accept the invitation. If you click on the link in the invitation e-mail the code will be entered for you.",

		// group membership requests
		'group_tools:groups:membershipreq:requests' => "Membership requests",
		'group_tools:groups:membershipreq:invitations' => "Outstanding invitations",
		'group_tools:groups:membershipreq:invitations:none' => "No outstanding invitations",
		'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Are you sure you wish to revoke this invitation",

		// group invitations
		'group_tools:group:invitations:request' => "Outstanding membership requests",
		'group_tools:group:invitations:request:revoke:confirm' => "Are you sure you wish to revoke your membership request?",
		'group_tools:group:invitations:request:non_found' => "There are no outstanding membership requests at this time",

		// group listing
		'group_tools:groups:sorting:alphabetical' => "Alphabetical",
		'group_tools:groups:sorting:open' => "Open",
		'group_tools:groups:sorting:closed' => "Closed",
		'group_tools:groups:sorting:ordered' => "Ordered",
		'group_tools:groups:sorting:suggested' => "Suggested",

		// discussion status
		'group_tools:discussion:confirm:open' => "Are you sure you wish to reopen this topic?",
		'group_tools:discussion:confirm:close' => "Are you sure you wish to close this topic?",
		
		// allow group members to invite
		'group_tools:invite_members:title' => "Group members can invite",
		'group_tools:invite_members:description' => "Allow the members of this group to invite new members",

		// actions
		'group_tools:action:error:input' => "Invalid input to perform this action",
		'group_tools:action:error:entities' => "The given GUIDs didn't result in the correct entities",
		'group_tools:action:error:entity' => "The given GUID didn't result in a correct entity",
		'group_tools:action:error:edit' => "You don't have access to the given entity",
		'group_tools:action:error:save' => "There was an error while saving the settings",
		'group_tools:action:success' => "The settings where saved successfully",

		// admin transfer - action
		'group_tools:action:admin_transfer:error:access' => "You're not allowed to transfer ownership of this group",
		'group_tools:action:admin_transfer:error:self' => "You can't transfer onwership to yourself, you're already the owner",
		'group_tools:action:admin_transfer:error:save' => "An unknown error occured while saving the group, please try again",
		'group_tools:action:admin_transfer:success' => "Group ownership was successfully transfered to %s",

		// group admins - action
		'group_tools:action:toggle_admin:error:group' => "The given input doesn't result in a group or you can't edit this group or the user is not a member",
		'group_tools:action:toggle_admin:error:remove' => "An unknown error occured while removing the user as a group admin",
		'group_tools:action:toggle_admin:error:add' => "An unknown error occured while adding the user as a group admin",
		'group_tools:action:toggle_admin:success:remove' => "The user was successfully removed as a group admin",
		'group_tools:action:toggle_admin:success:add' => "The user was successfully added as a group admin",

		// group mail - action
		'group_tools:action:mail:success' => "Message succesfully send",

		// group - invite - action
		'group_tools:action:invite:error:invite'=> "No users were invited (%s already invited, %s already a member)",
		'group_tools:action:invite:error:add'=> "No users were invited (%s already invited, %s already a member)",
		'group_tools:action:invite:success:invite'=> "Successfully invited %s users (%s already invited and %s already a member)",
		'group_tools:action:invite:success:add'=> "Successfully added %s users (%s already invited and %s already a member)",

		// group - invite - accept e-mail
		'group_tools:action:groups:email_invitation:error:input' => "Please enter an invitation code",
		'group_tools:action:groups:email_invitation:error:code' => "The entered invitation code is no longer valid",
		'group_tools:action:groups:email_invitation:error:join' => "An unknown error occured while joining the group %s, maybe you're already a member",
		'group_tools:action:groups:email_invitation:success' => "You've successfully joined the group",

		// group - invite - decline e-mail
		'group_tools:action:groups:decline_email_invitation:error:delete' => "An error occured while deleting the invitation",

		// suggested groups
		'group_tools:suggested_groups:info' => "The following groups might be interesting for you. Click the join buttons to join them immediately or click the title to view more information about the group.",
		'group_tools:suggested_groups:none' => "We can't suggest a group for you. This can happen if we have to little information about you, or that you are already a member of the groups we like you to join. Use the search to find more groups.",
			
		// group toggle auto join
		'group_tools:action:toggle_special_state:error:auto_join' => "An error occured while saving the new auto join settings",
		'group_tools:action:toggle_special_state:error:suggested' => "An error occured while saving the new suggested settings",
		'group_tools:action:toggle_special_state:error:state' => "Invalid state provided",
		'group_tools:action:toggle_special_state:auto_join' => "The new auto join settings were saved successfully",
		'group_tools:action:toggle_special_state:suggested' => "The new suggested settings were saved successfully",
		
		// group fix auto_join
		'group_tools:action:fix_auto_join:success' => "Group membership fixed: %s new members, %s were already a member and %s failures",

		// group cleanup
		'group_tools:actions:cleanup:success' => "The cleanup settings were saved successfully",

		// group default access
		'group_tools:actions:default_access:success' => "The default access for the group was saved successfully",

		// group notifications
		'group_tools:action:notifications:error:toggle' => "Invalid toggle option",
		'group_tools:action:notifications:success:disable' => "Successfully disabled notifications for every member",
		'group_tools:action:notifications:success:enable' => "Successfully enabled notifications for every member",

		// fix group problems
		'group_tools:action:fix_acl:error:input' => "Invalid option you can't fix: %s",
		'group_tools:action:fix_acl:error:missing:nothing' => "No missing users found in the group ACLs",
		'group_tools:action:fix_acl:error:excess:nothing' => "No excess users found in the groups ACLs",
		'group_tools:action:fix_acl:error:without:nothing' => "No groups found without an ACL",

		'group_tools:action:fix_acl:success:missing' => "Successfully added %d users to group ACLs",
		'group_tools:action:fix_acl:success:excess' => "Successfully removed %d users from group ACLs",
		'group_tools:action:fix_acl:success:without' => "Successfully created %d group ACLs",

		// discussion toggle status
		'group_tools:action:discussion:toggle_status:success:open' => "The topic was successfully reopened",
		'group_tools:action:discussion:toggle_status:success:close' => "The topic was successfully closed",
		
		// Widgets
		// Group River Widget
		'widgets:group_river_widget:title' => "Group activity",
	    'widgets:group_river_widget:description' => "Shows the activity of a group in a widget",

	    'widgets:group_river_widget:edit:num_display' => "Number of activities",
		'widgets:group_river_widget:edit:group' => "Select a group",
		'widgets:group_river_widget:edit:no_groups' => "You need to be a member of at least one group to use this widget",

		'widgets:group_river_widget:view:not_configured' => "This widget is not yet configured",

		'widgets:group_river_widget:view:more' => "Activity in the '%s' group",
		'widgets:group_river_widget:view:noactivity' => "We could not find any activity.",

		// Group Members
		'widgets:group_members:title' => "Group members",
  		'widgets:group_members:description' => "Shows the members of this group",

  		'widgets:group_members:edit:num_display' => "How many members to show",
  		'widgets:group_members:view:no_members' => "No group members found",

  		// Group Invitations
		'widgets:group_invitations:title' => "Group invitations",
	  	'widgets:group_invitations:description' => "Shows the outstanding group invitations for the current user",

	  	// Discussion
		"widgets:discussion:settings:group_only" => "Only show discussions from groups you are member of",
  		'widgets:discussion:more' => "View more discussions",
  		"widgets:discussion:description" => "Shows the latest discussions",

		// Forum topic widget
		'widgets:group_forum_topics:description' => "Show the latest discussions",

		// index_groups
		'widgets:index_groups:description' => "List groups from your community",
		'widgets:index_groups:show_members' => "Show members count",
		'widgets:index_groups:featured' => "Show only featured groups",
		'widgets:index_groups:sorting' => "How to sort the groups",

		'widgets:index_groups:filter:field' => "Filter groups based on group field",
		'widgets:index_groups:filter:value' => "with value",
		'widgets:index_groups:filter:no_filter' => "No filter",

		// Featured Groups
		'widgets:featured_groups:description' => "Shows a random list of featured groups",
	  	'widgets:featured_groups:edit:show_random_group' => "Show a random non-featured group",

		// group_news widget
		"widgets:group_news:title" => "Group News",
		"widgets:group_news:description" => "Shows latest 5 blogs from various groups",
		"widgets:group_news:no_projects" => "No groups configured",
		"widgets:group_news:no_news" => "No blogs for this group",
		"widgets:group_news:settings:project" => "Group",
		"widgets:group_news:settings:no_project" => "Select a group",
		"widgets:group_news:settings:blog_count" => "Max number of blogs",
		"widgets:group_news:settings:group_icon_size" => "Group icon size",
		"widgets:group_news:settings:group_icon_size:small" => "Small",
		"widgets:group_news:settings:group_icon_size:medium" => "Medium",

		// quick start discussion
		'group_tools:widgets:start_discussion:title' => "Start a discussion",
		'group_tools:widgets:start_discussion:description' => "Quickly start a discussion is a selected group",

		'group_tools:widgets:start_discussion:login_required' => "In order to use this widget you need to be logged in",
		'group_tools:widgets:start_discussion:membership_required' => "You must be a member of at least one group in order to use this widget. You can find interesting groups %shere%s.",

		'group_tools:forms:discussion:quick_start:group' => "Select a group for this discussion",
		'group_tools:forms:discussion:quick_start:group:required' => "Please select a group",
		'' => "",
		'' => "",
	);

	add_translation("en", $english);

