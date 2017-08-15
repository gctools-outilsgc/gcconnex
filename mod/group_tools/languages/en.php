<?php

return array(

	// general
	'group_tools:add_users' => "Add users",
	'group_tools:delete_selected' => "Delete selected",
	'group_tools:clear_selection' => "Clear selection",
	'group_tools:all_members' => "All members",
	
	'group_tools:default:access:group' => "Group members only",

	'group_tools:joinrequest:already' => "Revoke membership request",
	'group_tools:joinrequest:already:tooltip' => "You already requested to join this group, click here to revoke this request",
	'group_tools:join:already:tooltip' => "You were invited to this group so you can join right now.",
	
	'item:object:group_tools_group_mail' => "Group mail",
	
	// menu
	'group_tools:menu:mail' => "Mail Members",
	'group_tools:menu:invitations' => "Manage invitations",
	
	'admin:groups:bulk_delete' => "Group bulk delete",
	'admin:groups:admin_approval' => "Approval needed",
	'admin:groups:tool_presets' => "Group tool presets",
	'admin:groups:auto_join' => "Auto join",
	
	// plugin settings
	'group_tools:settings:default_off' => "Yes, default off",
	'group_tools:settings:default_on' => "Yes, default on",
	'group_tools:settings:required' => "Yes, required",
	'group_tools:settings:admin_only' => "Admin only",
	
	'group_tools:settings:edit:title' => "Group edit settings",
	'group_tools:settings:simple_access_tab' => "Simplified group access selection",
	'group_tools:settings:simple_access_tab:help' => "Replaces group access options when creating groups with a simplified choice between 'Open' and 'Closed'",

	'group_tools:settings:simple_create_form' => "Simple group create form",
	'group_tools:settings:simple_create_form:help' => "Enabling this will change the way how the 'New Group' form is displayed",
	
	'group_tools:settings:allow_hidden_groups:help' => "Who can create hidden groups. This setting will overrule the groups plugin setting.",
	
	'group_tools:settings:invite:title' => "Group invitation options",
	'group_tools:settings:management:title' => "General group options",
	'group_tools:settings:default_access:title' => "Default group access",

	'group_tools:settings:admin_transfer' => "Allow group owner transfer",
	'group_tools:settings:admin_transfer:admin' => "Site admin only",
	'group_tools:settings:admin_transfer:owner' => "Group owners and site admins",

	'group_tools:settings:multiple_admin' => "Allow multiple group admins",
	'group_tools:settings:auto_suggest_groups' => "Auto suggest groups on the 'Suggested' groups page based on profile information. Will be completed with the predefined suggested groups. Setting this to 'No' will only show the predefined suggested groups (if there are any).",
	
	'group_tools:settings:notifications:title' => "Group notification settings",
	'group_tools:settings:notifications:notification_toggle' => "Show notification settings on group join",
	'group_tools:settings:notifications:notification_toggle:description' => "This will show a system message where to user can toggle the notification settings, and add a link in the e-mail notification to the group notification settings.",
	
	'group_tools:settings:invite' => "Allow all users to be invited (not just friends)",
	'group_tools:settings:invite_friends' => "Allow friends to be invited",
	'group_tools:settings:invite_email' => "Allow all users to be invited by e-mail address",
	'group_tools:settings:invite_email:match' => "Try to match e-mail addresses to existing users",
	'group_tools:settings:invite_csv' => "Allow all users to be invited by CSV-file",
	'group_tools:settings:invite_members' => "Allow group members to invite new users",
	'group_tools:settings:invite_members:description' => "Group owners/admins can enable/disable this for their group",
	'group_tools:settings:domain_based' => "Enable domain based groups",
	'group_tools:settings:domain_based:description' => "Users can join a group based on their e-mail domain. During registration they will auto join groups based on their e-mail domain.",
	'group_tools:settings:join_motivation' => "Joining closed groups requires a motivation",
	'group_tools:settings:join_motivation:description' => "When a user wants to join a closed group, a motivation is required. Group owners can change this setting, if not set to 'no' or 'required'.",

	'group_tools:settings:mail' => "Allow group mail (allows group admins to send a message to all members)",
	
	'group_tools:settings:mail:members' => "Allow group admins to enable group mail for their members",
	'group_tools:settings:mail:members:description' => "This requires group mail to be enabled",

	'group_tools:settings:listing:title' => "Group listing settings",
	'group_tools:settings:listing:description' => "Here you can configure which tabs will be visible on the group listing page, which tab will be the default landing page and what the default sorting will be per tab.",
	'group_tools:settings:listing:enabled' => "Enabled",
	'group_tools:settings:listing:default_short' => "Default tab",
	'group_tools:settings:listing:default' => "Default group listing tab",
	'group_tools:settings:listing:available' => "Available group listing tabs",

	'group_tools:settings:content:title' => "Group content settings",
	'group_tools:settings:default_access' => "What should be the default access for content in the groups of this site",
	'group_tools:settings:stale_timeout' => "Groups become stale if no content is created within a number of days",
	'group_tools:settings:stale_timeout:help' => "If no new content is created in a group within the given number of days, the group is shown as stale. The group owner will receive a notification on the day the group becomes stale. A group owner/admin can tell the group is still relevant. 0 or empty to not enable this feature.",
	
	'group_tools:settings:search_index' => "Allow closed groups to be indexed by search engines",
	'group_tools:settings:auto_notification' => "Automatically enable group notification on group join",
	'group_tools:settings:show_membership_mode' => "Show open/closed membership status on group profile and owner block",
	'group_tools:settings:show_hidden_group_indicator' => "Show an indicator if a group is hidden",
	'group_tools:settings:show_hidden_group_indicator:group_acl' => "Yes, if group is members only",
	'group_tools:settings:show_hidden_group_indicator:logged_in' => "Yes, for all non public groups",
	
	'group_tools:settings:special_states' => "Groups with a special state",
	'group_tools:settings:special_states:featured:description' => "The site administrators have chosen to feature the following groups.",
	'group_tools:settings:special_states:suggested' => "Suggested",
	'group_tools:settings:special_states:suggested:description' => "The following groups are suggested to (new) users. It is possible to auto suggest groups, if no groups are automaticly detected or too few, the list will be appended by these groups.",

	'group_tools:settings:fix:title' => "Fix group access problems",
	'group_tools:settings:fix:missing' => "There are %d users who are a member of a group but don't have access to the content shared with the group.",
	'group_tools:settings:fix:excess' => "There are %d users who have access to group content of groups where they are no longer a member off.",
	'group_tools:settings:fix:without' => "There are %d groups without the possibility to share content with their members.",
	'group_tools:settings:fix:all:description' => "Fix all off the above problems at once.",
	'group_tools:settings:fix_it' => "Fix this",
	'group_tools:settings:fix:all' => "Fix all problems",
	
	'group_tools:settings:member_export' => "Allow group admins to export member information",
	'group_tools:settings:member_export:description' => "This includes the name, username and email address of the user.",
	
	'group_tools:settings:admin_approve' => "Site administrators need to approve new groups",
	'group_tools:settings:admin_approve:description' => "Any user can create a group, but a site administrator has to approve the new group",
	
	// auto join
	'group_tools:admin:auto_join:default' => "Auto join",
	'group_tools:admin:auto_join:default:description' => "New users will automaticly join the following groups.",
	'group_tools:admin:auto_join:default:none' => "No auto join groups configured yet.",
	
	'group_tools:form:admin:auto_join:group' => "Add a group to the auto join groups",
	'group_tools:form:admin:auto_join:group:help' => "Search for a group by name and select it from the list.",
	
	'group_tools:form:admin:auto_join:additional:group' => "Select the group(s) to join",
	'group_tools:form:admin:auto_join:additional:group:help' => "Search for a group by name and select it from the list.",
	
	'group_tools:admin:auto_join:additional' => "Additional auto join groups",
	'group_tools:admin:auto_join:additional:description' => "Here you can configure additional groups a user should join, based on properties of the user.",
	'group_tools:admin:auto_join:additional:none' => "No additional groups configured yet",
	
	'group_tools:admin:auto_join:exclusive' => "Exclusive auto join groups",
	'group_tools:admin:auto_join:exclusive:description' => "Here you can configure exclusive groups a user should join, based on properties of the user. If a match is found for a user they will NOT be added to any of the groups defined above.",
	'group_tools:admin:auto_join:exclusive:none' => "No exclusive groups configured yet",
	
	'group_tools:form:admin:auto_join:additional:pattern' => "User property matching",
	'group_tools:form:admin:auto_join:additional:pattern:add' => "Add property",
	'group_tools:form:admin:auto_join:additional:pattern:help' => "Users will be matched on all configured properties. To remove a property leave the value empty.",
	'group_tools:auto_join:pattern:operand:equals' => "Equals",
	'group_tools:auto_join:pattern:operand:not_equals' => "Not equals",
	'group_tools:auto_join:pattern:operand:contains' => "Contains",
	'group_tools:auto_join:pattern:operand:not_contains' => "Doesn't contain",
	'group_tools:auto_join:pattern:operand:pregmatch' => "Preg match",
	'group_tools:auto_join:pattern:value:placeholder' => "Enter a matching value",
	
	'group_tools:action:admin:auto_join:additional:error:pregmatch' => "The provided preg match pattern was invalid",
	
	// simplified access
	'group_tools:edit:access_simplified:open' => 'Open Group',
	'group_tools:edit:access_simplified:open:description' => '<ul><li>Any user may join</li><li>Content can be shared with anyone</li></ul>',
	'group_tools:edit:access_simplified:closed' => 'Closed Group',
	'group_tools:edit:access_simplified:closed:description' => '<ul><li>Membership needs to be approved</li><li>Content can only be shared with group members</li></ul>',
	
	// group tool presets
	'group_tools:admin:group_tool_presets:description' => "Here you can configure group tool presets.
When a user creates a group he/she gets to choose one of the presets in order to quickly get the correct tools. A blank option is also offered to the user to allow his/her own choices.",
	'group_tools:admin:group_tool_presets:header' => "Existing presets",
	'group_tools:create_group:tool_presets:description' => "You can select a group tool preset here. If you do so, you will get a set of tools which are configured for the selected preset. You can always chose to add additional tools to a preset, or remove the ones you do not like.",
	'group_tools:create_group:tool_presets:active_header' => "Tools for this preset",
	'group_tools:create_group:tool_presets:more_header' => "Extra tools",
	'group_tools:create_group:tool_presets:select' => "Select a group type",
	'group_tools:create_group:tool_presets:show_more' => "More tools",
	'group_tools:create_group:tool_presets:blank:title' => "Blank group",
	'group_tools:create_group:tool_presets:blank:description' => "Choose this group to select your own tools.",
	
	
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
	
	// deline membeship request notification
	'group_tools:notify:membership:declined:subject' => "Your membership request for '%s' was declined",
	'group_tools:notify:membership:declined:message' => "Hi %s,

Your membership request for the group '%s' was declined.

You can find the group here:
%s",
	'group_tools:notify:membership:declined:message:reason' => "Hi %s,

Your membership request for the group '%s' was declined, because of:

%s

You can find the group here:
%s",

	// group edit tabbed
	'group_tools:group:edit:profile' => "Profile",
	'group_tools:group:edit:access' => "Access",
	'group_tools:group:edit:tools' => "Tools",
	'group_tools:group:edit:other' => "Other options",

	// admin transfer - form
	'group_tools:admin_transfer:current' => "Keep current owner: %s",
	'group_tools:admin_transfer:myself' => "Myself",
	
	// special states form
	'group_tools:special_states:title' => "Group special states",
	'group_tools:special_states:description' => "A group can have several special states, here is an overview of the special states and their current value.",
	'group_tools:special_states:featured' => "Is this group featured",
	'group_tools:special_states:suggested' => "Is this group suggested to (new) users",
	
	// group admins
	'group_tools:multiple_admin:group_admins' => "Group admins",
	'group_tools:multiple_admin:profile_actions:remove' => "Remove group admin",
	'group_tools:multiple_admin:profile_actions:add' => "Add group admin",

	'group_tools:multiple_admin:group_tool_option' => "Enable group admins to assign other group admins",

	// cleanup options
	'group_tools:cleanup:title' => "Group sidebar cleanup",
	'group_tools:cleanup:description' => "Cleanup the sidebar of the group. This will have no effect for the group admins.",
	'group_tools:cleanup:extras_menu' => "Hide the Extras menu",
	'group_tools:cleanup:extras_menu:explain' => "The extras menu can be found at the top of the sidebar, some links can be posted in this area (example: RSS links).",
	'group_tools:cleanup:actions' => "Hide the Join group/Request membership button",
	'group_tools:cleanup:actions:explain' => "Depending on your group setting, users can directly join the group or request membership.",
	'group_tools:cleanup:menu' => "Hide side menu items",
	'group_tools:cleanup:menu:explain' => "Hide the menu links to the different group tools. The users will only be able to get access to the group tools by using the group widgets.",
	'group_tools:cleanup:members' => "Hide the group members",
	'group_tools:cleanup:members:explain' => "On the group profile page a list of the group members can be found in the sidebar. You can choose to hide this list.",
	'group_tools:cleanup:search' => "Hide the search in group",
	'group_tools:cleanup:search:explain' => "On the group profile page a search box is available. You can choose to hide this.",
	'group_tools:cleanup:featured' => "Show featured groups in the sidebar",
	'group_tools:cleanup:featured:explain' => "You can choose to show a list of featured groups in the sidebar on the group profile page",
	'group_tools:cleanup:featured_sorting' => "How to sort featured groups",
	'group_tools:cleanup:featured_sorting:time_created' => "Newest first",
	'group_tools:cleanup:my_status' => "Hide the My Status sidebar",
	'group_tools:cleanup:my_status:explain' => "In the sidebar on the group profile page there is an item which shows you your current membership status and some other status information. You can choose to hide this.",

	// group default access
	'group_tools:default_access:title' => "Group default access",
	'group_tools:default_access:description' => "Here you can control what the default access of new content in your group should be.",
	
	// group admin approve
	'group_tools:group:admin_approve:notice' => "New groups need to be approved by a site administrator. You can make/edit the group, but it won't be visible to other users until approved by a site administrator.",
	'group_tools:group:admin_approve:decline:confirm' => "Are you sure you wish to decline this group? This will delete the group.",
	'group_tools:group:admin_approve:admin:description' => "Here is a list of groups which need to be approved by the site administrators before they can be used.

When you approve a group the owner will receive a notification that his/her group is now ready for use.
If you decline a group, the owner will receive a notification that his/her group was removed and the group will be removed.",
	
	'group_tools:group:admin_approve:approve:success' => "The group can now be used on the site",
	'group_tools:group:admin_approve:decline:success' => "The group was removed",
	
	'group_tools:group:admin_approve:approve:subject' => "Your group '%s' was approved",
	'group_tools:group:admin_approve:approve:summary' => "Your group '%s' was approved",
	'group_tools:group:admin_approve:approve:message' => "Hi %s,

your group '%s' was approved by a site administrator. You can now use it.

To visit the group click here:
%s",
	'group_tools:group:admin_approve:admin:subject' => "A new group '%s' was created which requires approval",
	'group_tools:group:admin_approve:admin:summary' => "A new group '%s' was created which requires approval",
	'group_tools:group:admin_approve:admin:message' => "Hi %s,

%s created a group '%s' which need to be approved by a site administrator.

To visit the group click here:
%s

To view all groups which need action click here:
%s",
	
	'group_tools:group:admin_approve:decline:subject' => "Your group '%s' was declined",
	'group_tools:group:admin_approve:decline:summary' => "Your group '%s' was declined",
	'group_tools:group:admin_approve:decline:message' => "Hi %s,

your group '%s' was declined and removed by a site administrator.",
	
	// group notification
	'group_tools:notifications:title' => "Group notifications",
	'group_tools:notifications:description' => "This group has %s members, of those %s have enabled notifications on activity in this group. Below you can change this for all users of the group.",
	'group_tools:notifications:disclaimer' => "With large groups this could take a while.",
	'group_tools:notifications:enable' => "Enable notifications for everyone",
	'group_tools:notifications:disable' => "Disable notifications for everyone",

	'group_tools:notifications:toggle:email:enabled' => "Currently you are receiving notifications about activity in this group. If you don't want to receive notifications, change the settings here %s",
	'group_tools:notifications:toggle:email:disabled' => "Currently you are not receiving notifications about activity in this group. If you want to receive notifications, change the settings here %s",
	
	'group_tools:notifications:toggle:site:enabled' => "Currently you are receiving notifications about activity in this group. If you don't want to receive notifications, click here %s",
	'group_tools:notifications:toggle:site:enabled:link' => "disable notifications",
	'group_tools:notifications:toggle:site:disabled' => "Currently you are not receiving notifications about activity in this group. If you want to receive notifications, click here %s",
	'group_tools:notifications:toggle:site:disabled:link' => "enable notifications",
	
	// group mail
	'group_tools:tools:mail_members' => "Allow group members to mail other group members",
	'mail_members:group_tool_option:description' => "This will allow normal group members to send an e-mail to other group members. By default this is limited to group admins.",
	
	'group_tools:mail:message:from' => "From group",

	'group_tools:mail:title' => "Send a mail to the group members",
	'group_tools:mail:form:recipients' => "Number of recipients",
	'group_tools:mail:form:members:selection' => "Select individual members",

	'group_tools:mail:form:title' => "Subject",
	'group_tools:mail:form:description' => "Body",

	'group_tools:mail:form:js:members' => "Please select at least one member to send the message to",
	'group_tools:mail:form:js:description' => "Please enter a message",

	// group invite
	'group_tools:groups:invite:error' => "No invitation options are available",
	'group_tools:groups:invite:title' => "Invite users to this group",
	'group_tools:groups:invite' => "Invite users",
	'group_tools:groups:invite:user_already_member' => "User is already a member of the group",

	'group_tools:group:invite:friends:select_all' => "Select all friends",
	'group_tools:group:invite:friends:deselect_all' => "Deselect all friends",

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
	'group_tools:groups:membershipreq:invitations' => "Invited users",
	'group_tools:groups:membershipreq:invitations:none' => "No pending user invitations",
	'group_tools:groups:membershipreq:email_invitations' => "Invited e-mail addresses",
	'group_tools:groups:membershipreq:email_invitations:none' => "No pending e-mail invitations",
	'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Are you sure you wish to revoke this invitation",
	'group_tools:groups:membershipreq:kill_request:prompt' => "Optionaly you can tell the user why you declined the request.",

	// group invitations
	'group_tools:group:invitations:request' => "Outstanding membership requests",
	'group_tools:group:invitations:request:revoke:confirm' => "Are you sure you wish to revoke your membership request?",
	'group_tools:group:invitations:request:non_found' => "There are no outstanding membership requests at this time",

	// group listing
	'group_tools:groups:sorting:open' => "Open",
	'group_tools:groups:sorting:closed' => "Closed",
	'group_tools:groups:sorting:ordered' => "Ordered",
	'group_tools:groups:sorting:suggested' => "Suggested",
	
	// allow group members to invite
	'group_tools:invite_members:title' => "Group members can invite",
	'group_tools:invite_members:description' => "Allow the members of this group to invite new members",
	'group_tools:invite_members:disclaimer' => "Please note that for closed groups allowing your users to invite new members means they don't require approval by the group owner/admin(s).",

	// group tool option descriptions
	'activity:group_tool_option:description' => "Show an activity feed about group related content.",
	
	// actions
	// group edit
	'group_tools:action:group:edit:error:default_access' => "The chosen default access level was more public than the group content access, therefore default access has been lowered to group members.",
	
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
	'group_tools:action:groups:email_invitation:error:code' => "The entered invitation code is no longer valid",
	'group_tools:action:groups:email_invitation:error:join' => "An unknown error occured while joining the group %s, maybe you're already a member",
	'group_tools:action:groups:email_invitation:success' => "You've successfully joined the group",

	// group - invite - decline e-mail
	'group_tools:action:groups:decline_email_invitation:error:delete' => "An error occured while deleting the invitation",

	// suggested groups
	'group_tools:suggested_groups:info' => "The following groups might be interesting for you. Click the join buttons to join them immediately or click the title to view more information about the group.",
	'group_tools:suggested_groups:none' => "We can't suggest a group for you. This can happen if we have to little information about you, or that you are already a member of the groups we like you to join. Use the search to find more groups.",
		
	// group toggle auto join
	'group_tools:action:toggle_special_state:error:suggested' => "An error occured while saving the new suggested settings",
	'group_tools:action:toggle_special_state:error:state' => "Invalid state provided",
	'group_tools:action:toggle_special_state:suggested' => "The new suggested settings were saved successfully",
	
	// group cleanup
	'group_tools:actions:cleanup:success' => "The cleanup settings were saved successfully",

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

	// Widgets
	// Group River Widget
	'widgets:group_river_widget:title' => "Group activity",
    'widgets:group_river_widget:description' => "Shows the activity of a group in a widget",

    'widgets:group_river_widget:edit:num_display' => "Number of activities",
	'widgets:group_river_widget:edit:group' => "Select a group",
	'widgets:group_river_widget:edit:no_groups' => "You need to be a member of at least one group to use this widget",

	'widgets:group_river_widget:view:not_configured' => "This widget is not yet configured",

	'widgets:group_river_widget:view:noactivity' => "We could not find any activity.",

	// Group Members
	'widgets:group_members:title' => "Group members",
  	'widgets:group_members:description' => "Shows the members of this group",

	'widgets:group_members:view:no_members' => "No group members found",

  	// Group Invitations
	'widgets:group_invitations:title' => "Group invitations",
  	'widgets:group_invitations:description' => "Shows the outstanding group invitations for the current user",

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
	
	'groups:search:title' => "Search for groups matching '%s'",
	
	// welcome message
	'group_tools:welcome_message:title' => "Group welcome message",
	'group_tools:welcome_message:description' => "You can configure a welcome message for new users who join this group. If you don't want to send a welcome message leave this field blank.",
	'group_tools:welcome_message:explain' => "In order to personalize the message you can use the following placeholders:
[name]: the name of the new user (eg. %s)
[group_name]: the name of this group (eg. %s)
[group_url]: the URL to this group (eg. %s)",
	
	'group_tools:action:welcome_message:success' => "The welcome message was saved",
	
	'group_tools:welcome_message:subject' => "Welcome to %s",
	
	// email invitations
	'group_tools:action:revoke_email_invitation:error' => "An error occured while revoking the invitation, please try again",
	'group_tools:action:revoke_email_invitation:success' => "The invitation was revoked",
	
	// domain based groups
	'group_tools:join:domain_based:tooltip' => "Because of a matching e-mail domain, you can join this group.",
	
	'group_tools:domain_based:title' => "Configure e-mail domains",
	'group_tools:domain_based:description' => "When you configure one (or more) e-mail domains, users with that e-mail domain will automaticly join your group upon registration. Also if you have a closed group user with a matching e-mail domain can join without requesting membership. You can configure multipe domains by using a comma. Don't include the @ sign",
	
	'group_tools:action:domain_based:success' => "The new e-mail domains were saved",
	
	// related groups
	'groups_tools:related_groups:tool_option' => "Show related groups",
	
	'groups_tools:related_groups:widget:title' => "Related groups",
	'groups_tools:related_groups:widget:description' => "Display a list of groups you added as related to this group.",
	
	'groups_tools:related_groups:none' => "No related groups found.",
	'group_tools:related_groups:title' => "Related groups",
	
	'group_tools:related_groups:form:placeholder' => "Search for a new related group",
	'group_tools:related_groups:form:description' => "You can search for a new related group, select it from the list and click Add.",
	
	'group_tools:action:related_groups:error:same' => "You can't related this group to itself",
	'group_tools:action:related_groups:error:already' => "The selected group is already related",
	'group_tools:action:related_groups:error:add' => "An unknown error occured while adding the relationship, please try again",
	'group_tools:action:related_groups:success' => "The group is now related",
	
	'group_tools:related_groups:notify:owner:subject' => "A new related group was added",
	'group_tools:related_groups:notify:owner:message' => "Hi %s,
	
%s added your group %s as a related group to %s.",
	
	'group_tools:related_groups:entity:remove' => "Remove related group",
	
	'group_tools:action:remove_related_groups:error:not_related' => "The group is not related",
	'group_tools:action:remove_related_groups:error:remove' => "An unknown error occured while removing the relationship, please try again",
	'group_tools:action:remove_related_groups:success' => "The group is no longer related",
	
	'group_tools:action:group_tool:presets:saved' => "New group tool presets saved",
	
	'group_tools:forms:members_search:members_search:placeholder' => "Enter the name or username of the user to search for",
	
	// group member export
	'group_tools:member_export:title_button' => "Export members",
	
	// csv exporter
	'group_tools:csv_exporter:group_admin:name' => "Group admin(s) name",
	'group_tools:csv_exporter:group_admin:email' => "Group admin(s) e-mail address",
	'group_tools:csv_exporter:group_admin:url' => "Group admin(s) profile url",
	
	'group_tools:csv_exporter:user:group_admin:name' => "Groups administrated name",
	'group_tools:csv_exporter:user:group_admin:url' => "Groups administrated url",
	
	// group bulk delete
	'group_tools:action:bulk_delete:success' => "The selected groups were deleted",
	'group_tools:action:bulk_delete:error' => "An error occured while deleting the groups, please try again",
	
	// group toggle notifications
	'group_tools:action:toggle_notifications:disabled' => "The notifications for the group '%s' have been disabled",
	'group_tools:action:toggle_notifications:enabled' => "The notfications for the group '%s' have been enabled",
	
	// group join motivation
	'group_tools:join_motivation:edit:option:label' => "Joining this closed group requires motivation",
	'group_tools:join_motivation:edit:option:description' => "Closed groups can require that new users supply a motivation why they want to join.",
	
	'group_tools:join_motivation:title' => "Why do you wish to join '%s'?",
	'group_tools:join_motivation:description' => "The owner of '%s' has indicated that a motivation is required to join this group. Please provide a motivation below so the owner can judge your membership request.",
	'group_tools:join_motivation:label' => "My motivation for joining this group",
	
	'group_tools:join_motivation:notification:subject' => "%s has requested to join %s",
	'group_tools:join_motivation:notification:summary' => "%s has requested to join %s",
	'group_tools:join_motivation:notification:body' => "Hi %s,

%s has requested to join the '%s' group.

Their motivation for joining is:
%s

Click below to view their profile:
%s

Click below to view the group's join requests:
%s",
	'group_tools:join_motivation:toggle' => "Show motivation",
	'group_tools:join_motivation:listing' => "Reason for joining:",
	
	// stale groups
	'group_tools:stale_info:description' => "This group has been inactive for a while. The content may no longer be relevant.",
	'group_tools:stale_info:link' => "This group is still relevant",
	
	'group_tools:csv_exporter:stale_info:is_stale' => "Stale group",
	'group_tools:csv_exporter:stale_info:timestamp' => "Stale timestamp",
	'group_tools:csv_exporter:stale_info:timestamp:readable' => "Stale timestamp (readable)",
	
	'groups_tools:state_info:notification:subject' => "Your group '%s' has been inactive for a while",
	'groups_tools:state_info:notification:summary' => "Your group '%s' has been inactive for a while",
	'groups_tools:state_info:notification:message' => "Hi %s,

Your group '%s' has been inactive for a while.

Please check on the group here:
%s",
);
