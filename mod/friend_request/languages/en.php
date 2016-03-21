<?php
$english = array(

'friend_request' => "Colleague Request",
'friend_request:menu' => "Colleague Requests",
'friend_request:title' => "Colleague Requests for: %s",	
'friend_request:new' => "New colleague request",	
'friend_request:friend:add:pending' => "Colleague request pending",
	
/************* FRIEND REQUEST *************/	
	
'friend_request:newfriend:subject' => "%s wants to be your colleague! / %s veut être votre collègue!",
'friend_request:newfriend:body' => "%s wants to be your colleague! But he or she is waiting for you to approve the request... So login now so you can approve the request! <br/>
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
'friend_request:add:successful' => "You have requested to be collegues with %s. They must approve your request before they will show on your colleagues list.",
'friend_request:add:exists' => "You've already requested to be colleagues with %s.",
	
// Approve request	// Approve request
	
'friend_request:approve' => "Approve",
'friend_request:approve:subject' => "%s has accepted your colleague request / %s a accepté votre demande d’ajout de collègue",
'friend_request:approve:message' => "Dear %s, %s has accepted your request to become a colleague.",
	
	
	
'friend_request:approve:successful' => "%s is now a colleague",
'friend_request:approve:fail' => "Error while creating friend relation with %s",
	
// Decline request	
	
'friend_request:decline' => "Decline",
'friend_request:decline:subject' => "%s has declined your colleague request",
'friend_request:decline:message' => "Dear %s, %s has declined your request to become a colleague.",
	
	
'friend_request:decline:success' => "colleague request successfully declined",
'friend_request:decline:fail' => "Error while declining colleague request, please try again",
	
// Revoke request	
	
'friend_request:revoke' => "Revoke",
'friend_request:revoke:success' => "colleague request successfully revoked",
'friend_request:revoke:fail' => "Error while revoking colleague request, please try again",
	
// Views	
// Received	
	
'friend_request:received:title' => "Received colleague requests",
'friend_request:received:none' => "No requests pending your approval",
	
// Sent	
	
'friend_request:sent:title' => "Sent colleague requests",
'friend_request:sent:none' => "No sent requests pending approval",

);
				
add_translation("en", $english);
