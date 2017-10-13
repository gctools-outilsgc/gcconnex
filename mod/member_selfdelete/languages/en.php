<?php

return array(
	'member_selfdelete' => "Member Self-Delete",
	'member_selfdelete:account:delete' => "Delete Account",
	'member_selfdelete:invalid:confirmation' => "Invalid confirmation - you must type your password in the confirmation box to delete your account",
	'member_selfdelete:DELETE' => "DELETE",
	'member_selfdelete:error:delete:admin' => "Admins cannot delete themselves",
	'member_selfdelete:delete:account' => "Delete My Account",
	'member_selfdelete:deleted' => "Your account has been deleted",
	'member_selfdelete:action:anonymized' => "Your account has been anonymized.",
	'member_selfdelete:action:banned' => "Your account has been disabled",
	'member_selfdelete:feedback:no_results' => 'No users have deleted their acccounts',
	'member_selfdelete:error:invalid:annotation' => "Invalid Feedback ID",
	'member_selfdelete:feedback:deleted' => "Feedback has been deleted",
	'member_selfdelete:explain:anonymize' => "Permanently disable your account, remove all profile information, profile pictures, and relationships but will leave your public content/comments accessible.  This cannot be undone.",
	'member_selfdelete:explain:ban' => "Disable your account, you will no longer be able to log in or post new content.  Existing public content/comments will remain visible, though your profile and profile image will not.  An admin can re-enable your account if you so choose.",
	'member_selfdelete:explain:choose' => "Select what happens to your account",
	'member_selfdelete:explain:delete' => "Permanently delete your account and all content/comments belonging to you.",
	'member_selfdelete:feedback:thanks' => "We're sad to see you go, but thank you for leaving us feedback.",
	'member_selfdelete:inactive:user' => "Inactive User",
	'member_selfdelete:label:reason' => "Optional: Please tell us the reason you are deleting your account",
	'member_selfdelete:label:confirmation' => "To confirm your intent to delete your account please enter your password",
	'member_selfdelete:option:anonymize' => "Anonymize",
	'member_selfdelete:option:ban' => "Ban",
	'member_selfdelete:option:choose' => "Choose",
	'member_selfdelete:option:delete' => "Delete",
	'member_selfdelete:options:explanation:ban' => "All of the users content will remain accessible with existing permissions.  The display
  name remains the same, the profile picture is reset to default.  The profile is visible, but will
  display the fact that the account is banned.  They will not be able to log back in, though an administrator
  can unban the account.",
	'member_selfdelete:options:explanation:delete' => "All of the users content/comments/information/etc will be permanently deleted.  Their account,
  will be deleted.  This cannot be undone.",
	'member_selfdelete:options:explanation:anonymize' => "All of the users content/comments will remain accessible with existing permissions.  All of their
  relationships will be deleted (eg. no more friends).  All of their collections will be deleted.  All of their profile information and any other
  identifiable information will be deleted.  The profile picture will be reset to default, display name will be reset to 'Inactive User',
  email and password will be reset - they will be unable to log in, and won't receive site notifications.  The only information remaining
  on the system will be the username - preserved only for correct links to content.  These changes are permanent and cannot be undone.",
	'member_selfdelete:options:explanation:choose' => "Allow the user to choose from the above options at the time they cancel their account.",
	'member_selfdelete:options:explanation:prefix' => "These are the options for how the user can delete their account.",
	'member_selfdelete:profile_view' => "Inactive users do not have profiles",
	'member_selfdelete:reasons:list' => "Self-Deleted User Feedback",
	'member_selfdelete:select:feedback' => "Select whether user feedback should be collected",
	'member_selfdelete:select:method' => "Select the method of deletion",
	'member_selfdelete:self:banned' => "Self-deleted user",
	'member_selfdelete:submit' => "Submit",
	'admin:users:member_selfdelete/reasons' => "Deleted User Feedback",
	'admin:users:member_selfdelete:reasons' => "Deleted User Feedback",

	//GC langs

	//Form
	'member_selfdelete:explain:deactivate' => "This is what it means to deactivate...",
	'member_selfdelete:gc:group:owner:change' => "You need to change ownership of these groups pls",
	'member_selfdelete:gc:change:owner' => "Owner changed",
	'member_selfdelete:gc:change:not:member' => "This user is not a member of this group, please choose another user",
	'member_selfdelete:gc:change:error' => "Please change select a new owner",

	//Reasons
	'member_selfdelete:gc:reasonforleave' => "WHY ARE YOU DEACTIVATING YOUR ACCOUNT?",
	'member_selfdelete:gc:reason:temp' => "This is temporary, I will be back. (mat leave, sick leave)",
	'member_selfdelete:gc:reason:retire' => "I am retiring.",
	'member_selfdelete:gc:reason:understand' => "I don’t understand how to use GCconnex/collab.",
	'member_selfdelete:gc:reason:notifs' => "I get too many notifications.",
	'member_selfdelete:gc:reason:useful' => "I don’t find GCconnex/collab useful.",
	'member_selfdelete:gc:reason:time' => "I spend too much time using GCconnex/collab.",
	'member_selfdelete:gc:reason:hacked' => "My account was hacked.",
	'member_selfdelete:gc:reason:other' => "Other, please explain further:",

	'member_selfdelete:gc:deactivate:success' => "Smell ya later",
	'member_selfdelete:gc:youaredeactivated' =>"Welcome Back! Your account is currently inactive. Contact the help desk to re-activate your account and start collaborating.",

	//Admin
	'admin:users:member_selfdelete:deactivated_users' => 'GC Deactivated Users',
	'admin:users:member_selfdelete/deactivated_users' => 'GC Deactivated Users',
	'member_selfdelete:gc:admin:state:1' => 'Deactivated',
	'member_selfdelete:gc:admin:state:0' => 'Reactivated',

	//User and Profile
	'member_selfdelete:gc:deactivate:profile' => "This user has deactivated their account",
	'member_selfdelete:gc:deactivate:avatar' => "Deactivated User",
);
