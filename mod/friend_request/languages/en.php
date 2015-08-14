<?php
$english = array(
	'friend_request' => "Friend Request",
	'friend_request:menu' => "Friend Requests",
	'friend_request:title' => "Friend Requests for: %s",

	'friend_request:new' => "New friend request",
	
	'friend_request:friend:add:pending' => "Friend request pending",
	
// 	'friend_request:newfriend:subject' => "%s wants to be your friend!",
// 	'friend_request:newfriend:body' => "%s wants to be your friend! But they are waiting for you to approve the request...so login now so you can approve the request!

// You can view your pending friend requests at:
// %s

// Make sure you are logged into the website before clicking on the following link otherwise you will be redirected to the login page.

// (You cannot reply to this email.)",
		


/************* FRIEND REQUEST *************/
"friend_request:newfriend:subject" => "%s wants to be your colleague! / %s veut être votre collègue!",
"friend_request:newfriend:body" => "
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
	'friend_request:add:failure' => "Sorry, because of a system error we were unable to complete your request. Please try again.",
	'friend_request:add:successful' => "You have requested to be friends with %s. They must approve your request before they will show on your friends list.",
	'friend_request:add:exists' => "You've already requested to be friends with %s.",
	
	// Approve request
	'friend_request:approve' => "Approve",
	'friend_request:approve:subject' => "%s has accepted your friend request / %s a accepté votre demande d’ajout de collègue",
	'friend_request:approve:message' => "Dear %s,

%s has accepted your request to become a friend.",

	'friend_request:approve:successful' => "%s is now a friend",
	'friend_request:approve:fail' => "Error while creating friend relation with %s",

	// Decline request
	'friend_request:decline' => "Decline",
	'friend_request:decline:subject' => "%s has declined your friend request",
	'friend_request:decline:message' => "Dear %s,

%s has declined your request to become a friend.",
	'friend_request:decline:success' => "Friend request successfully declined",
	'friend_request:decline:fail' => "Error while declining Friend request, please try again",
	
	// Revoke request
	'friend_request:revoke' => "Revoke",
	'friend_request:revoke:success' => "Friend request successfully revoked",
	'friend_request:revoke:fail' => "Error while revoking Friend request, please try again",

	// Views
	// Received
	'friend_request:received:title' => "Received Friend requests",
	'friend_request:received:none' => "No requests pending your approval",

	// Sent
	'friend_request:sent:title' => "Sent Friend requests",
	'friend_request:sent:none' => "No sent requests pending approval",
);
				
add_translation("en", $english);
