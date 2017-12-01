<?php


$languagecode = get_current_language();
$singularvar = $languagecode . 'singular';
$pluralvar = $languagecode . 'plural';

$singular = elgg_get_plugin_setting($singularvar, 'rename_friends');
$plural = elgg_get_plugin_setting($pluralvar, 'rename_friends');

// set defaults if setting can't be found
if(empty($singular)){ $singular = elgg_echo('friend'); }
if(empty($plural)){ $plural = elgg_echo('friends'); }

// get first letter of each, and register variables for starting with uppercase and lowercase first letter
// $usingle = uppercase singluar eg. Friend
// $lsingle = lowercase singluar eg. friend
// $uplural = uppercase plural eg. Friends
// $lplural = lowercase plural eg. friends

$lsingle = strtolower($singular);
$lplural = strtolower($plural);

//create our uppercase singular
$first_letter = strtoupper($singular[0]);
$rest_of_word = substr($singular, 1);

$usingle = $first_letter . $rest_of_word;

//create our uppercase plural
$first_letter = strtoupper($plural[0]);
$rest_of_word = substr($plural, 1);

$uplural = $first_letter . $rest_of_word;



// get variables for groups 
$singular = '';
$plural = '';
if(elgg_is_active_plugin('rename_groups')){
  $singular = elgg_get_plugin_setting($singularvar, 'rename_groups');
  $plural = elgg_get_plugin_setting($pluralvar, 'rename_groups');
}

  // set defaults if setting can't be found
  if(empty($singular)){ $singular = elgg_echo('groups:group'); }
  if(empty($plural)){ $plural = elgg_echo('groups'); }

  // get first letter of each, and register variables for starting with uppercase and lowercase first letter
  // $usingle = uppercase singluar eg. Group
  // $lsingle = lowercase singluar eg. group
  // $uplural = uppercase plural eg. Groups
  // $lplural = lowercase plural eg. groups

  $glsingle = strtolower($singular);
  $glplural = strtolower($plural);

  //create our uppercase singular
  $first_letter = strtoupper($singular[0]);
  $rest_of_word = substr($singular, 1);

  $gusingle = $first_letter . $rest_of_word;

  //create our uppercase plural
  $first_letter = strtoupper($plural[0]);
  $rest_of_word = substr($plural, 1);

  $guplural = $first_letter . $rest_of_word;
 
$english = array(
	//
	//	rename_friends language mappings
	//
	'rename_friends:language' => "Language",
	'rename_friends:missing:language:file' => "Language file appears to be missing.  Check that it exists and that the languages directory has read access.",
	'rename_friends:plural' => "Plural",
	'rename_friends:settings' => "Rename Friends for each language",
	'rename_friends:singular' => "Singular",


    /*
     * 	Default Notification Settings
     */
	'notifications_tools:friends_notifications' => "Choose the default notification method for {$lplural} notifications (This will be applied when a new user acount is created)",
    'notifications_tools:friends_batch_method' => "Choose a notification method for {$lplural} notifications (This will affect all site users)",

    /*
     * Elgg Core
     */

	//'access:friends:label' => $uplural,
	'friends' => $uplural,
	'friends:yours' => "Your {$lplural}",
	'friends:owned' => "%s's {$lplural}",
	'friend:add' => "Add {$lsingle}",
	'friend:remove' => "Remove {$lsingle}",
	'friends:add:successful' => "You have successfully added %s as a {$lsingle}.",
	'friends:add:failure' => "We couldn't add %s as a {$lsingle}. Please try again.",
	'friends:remove:successful' => "You have successfully removed %s from your {$lplural}.",
	'friends:remove:failure' => "We couldn't remove %s from your {$lplural}. Please try again.",
	'friends:none' => "This user hasn't added anyone as a {$lsingle} yet.",
	'friends:none:you' => "You don't have any {$lplural} yet.",
	'friends:none:found' => "No {$lplural} were found.",
	'friends:of:none' => "Nobody has added this user as a {$lsingle} yet.",
	'friends:of:none:you' => "Nobody has added you as a {$lsingle} yet. Start adding content and fill in your profile to let people find you!",
	'friends:of:owned' => "People who have made %s a {$lsingle}",
	'friends:of' => "{$uplural} of",
	'friends:collections' => "{$usingle} circles",
	'collections:add' => "New {$lplural} circle",
	'friends:collections:add' => "New {$lplural} circle",
	'friends:addfriends' => "Select {$lplural}",
	'friends:collectionfriends' => "{$uplural} in circle",
	'friends:collections:members' => "Circle {$lplural}",
	'river:friend:user:default' => "%s is now a {$lsingle} with %s",
	'river:widgets:friends' => "{$uplural} activity",
	'userpicker:only_friends' => "Only {$lplural}",
	'river:friends' => "{$uplural} Activity",
	'friends:widget:description' => "Displays some of your {$lplural}.",
	'friends:num_display' => "Number of {$lplural} to display",
	'friend:newfriend:subject' => "%s has made you a {$lsingle}!",
	'friend:newfriend:body' => "%s has made you a {$lsingle}!

To view their profile, click here:

%s

You cannot reply to this email.",

    /*
     * 	Extendafriend
     */

	'extendafriend:edit:friend' => "Edit {$usingle}",
	'extendafriend:updated' => "{$usingle} access circles have been updated",


    /*
     * 	Friend Request
     */

	'friend_request' => "{$usingle} Request",
	'friend_request:menu' => "{$usingle} Requests",
	'friend_request:title' => "{$usingle} Requests for: %s",
	'friend_request:new' => "New {$lsingle} request",
	'friend_request:friend:add:pending' => "{$usingle} request pending",
	'friend_request:newfriend:subject' => "%s wants to be your {$lsingle}!",
	'friend_request:newfriend:body' => "
%s wants to be your colleague! But he or she is waiting for you to approve the request... So login now so you can approve the request! <br/>
You can view your pending colleague requests at:

%s <br/>
<i>Make sure you are logged into the website before clicking on the following link, otherwise you will be redirected to the login page.</i>

To view their profile, click here: %s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s souhaite être votre collègue! Il ou elle attend que vous approuviez sa demande... Connectez-vous pour approuver cette demande! <br/>
Vous pouvez afficher les demandes de collègue qui sont en attente :
%s <br/>
<i>Assurez-vous d'être connecté(e) au site avant de cliquer sur le lien suivant. Si vous n'êtes pas connecté(e), vous serez redirigé(e) vers la page d'ouverture de session.</i>

Pour consulter son profil, cliquez ici : %s
",
		
	// Actions
	// Add request
	'friend_request:add:successful' => "You have requested to be {$lplural} with %s. They must approve your request before they will show on your {$lplural} list.",
	'friend_request:add:exists' => "You've already requested to be {$lplural} with %s.",
		
	// Approve request
	'friend_request:approve:successful' => "%s is now a {$lsingle}",
	'friend_request:approve:fail' => "Error while creating {$lsingle} relation with %s",
	
	// Decline request
	'friend_request:decline:subject' => "%s has declined your {$lsingle} request",
	'friend_request:decline:message' => "Dear %s,

%s has declined your request to become a {$lsingle}.",
	'friend_request:decline:success' => "{$usingle} request successfully declined",
	'friend_request:decline:fail' => "Error while declining {$usingle} request, please try again",
		
	// Revoke request
	'friend_request:revoke:success' => "{$usingle} request successfully revoked",
	'friend_request:revoke:fail' => "Error while revoking {$usingle} request, please try again",
	
	// Views
	// Received
	'friend_request:received:title' => "Received {$usingle} requests",
	
	// Sent
	'friend_request:sent:title' => "Sent {$usingle} requests",



    /*
     * 	HypeEvents
     */

    'hj:events:friendevents' => "{$uplural} Events",

    /*
     * 	Invite Friends
     */
	
	'friends:invite' => "Invite colleagues",
	'invitefriends:introduction' => "To invite colleagues to join you on this network, enter their email addresses below (one per line):",
	'invitefriends:success' => "Your colleagues were invited.",
	'invitefriends:email' => "
You have been invited to join %s by %s. They included the following message:

%s

To join, click the following link:

%s

You will automatically add them as a {$lsingle} when you create your account.",


/*
 * 	Rename Groups
 */

'groups:invite' => "Invite users to the group",
'groups:invite:title' => "Invite {$lplural} to this {$glsingle}",
'groups:inviteto' => "Invite {$lplural} to '%s'",
'groups:nofriends' => "You have no {$lplural} left who have not been invited to this {$glsingle}.",
'groups:nofriendsatall' => "You have no {$lplural} to invite!",


/*
 * 	River Addon
 */
'river_addon:label:friends' => "Do you want to display {$lplural} in sidebar?",
'river_addon:label:num' => "Number of {$lplural} to display",
'river_addon:option:default' => "All, Mine, {$uplural}",
'river_addon:option:friend'	=> "{$uplural}, Mine, All",
'river_addon:option:mine' => "Mine, {$uplural}, All",

/*
* General / multi-mod
*/
'friends:filterby' => "My {$lplural}'",

);

add_translation("en", $english);
