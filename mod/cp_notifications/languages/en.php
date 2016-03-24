<?php

$english = array(
	
	// texts that will be displayed in the email notification
	'cp_notification:email_header_en' => 'This is a system-generated message from GCconnex. Please do not reply to this message',
	'cp_notification:email_header_fr' => "Ceci est un message généré par le système de GCconnex. Veuillez ne pas répondre à ce message",
		
	'cp_notification:email_header_msg_en' => "This is a system-generated message from GCconnex, you're receiving this notification because there has been an update or reply to the content that you have been subscribed to. If you have any questions or concerns please consult the contact us page here: %s 
		Should you have any questions or concerns, please contact our Helpdesk at gcconnex@tbs-sct.gc.ca or learn more about GCconnex and its features here: %s <br/>
		Thank you",
	'cp_notification:email_header_msg_fr' => "Ceci est un message généré par le système de GCconnex. Vous recevez cette notification parce qu'il y a une mise à jour ou une réponse en lien au contenu que vous êtes abonné. Si vous avez des questions, veuillez consulter la page Contactez-vous :%s
		Si vous avez des questions, veuillez communiquer avec le Soutien technique à : GCconnex@tbs-sct.gc.ca. Pour de plus amples renseignements sur GCconnex et ses fonctionnalités consultez : %s<br/> 
	    Merci",
	
	// email subject lines	
	'cp_notify:subject:group_add_user_en' => '%s has added you into their group %s',
	'cp_notify:subject:group_add_user_fr' => "%s vous a ajouté a leur groupe %s",

	'cp_notify:subject:group_invite_user_en' => '%s has invited you to join their group %s',
	'cp_notify:subject:group_invite_user_en' => "%s vous a invité a joindre leur groupe %s",
		
	'cp_notify:subject:group_invite_user_by_email_en' => '%s has invited you to join their group %s',
	'cp_notify:subject:group_invite_user_by_email_fr' => "%s vous a invité a joindre leur groupe %s",
		
	'cp_notify:subject:group_request_en' => '%s has requested to join the group %s',
	'cp_notify:subject:group_request_fr' => "% vous a fait une demande à joindre le groupe %s",

	'cp_notify:subject:group_mail_en' => "%s has sent out a group message '%s'",
	'cp_notify:subject:group_mail_fr' => "%s a envoyé un message au groupe '%s'",

	'cp_notify:subject:friend_request_en' => "%s has sent you a colleague request",
	'cp_notify:subject:friend_request_fr' => "%s vous a envoyé une demande d'être collègue",

	'cp_notify:subject:forgot_password_en' => "You have requested a password reset",
	'cp_notify:subject:forgot_password_fr' => "Vous avez demandé de réinitialiser votre mot de passe",

	'cp_notify:subject:validate_user_en' => "Please validate account for %s",
	'cp_notify:subject:validate_user_fr' => "Veuiller valider le compte de %s",

	'cp_notify:subject:group_join_request_en' => "%s has requested to join your group '%s'",
	'cp_notify:subject:group_join_request_fr' => "%s demande de joindre votre groupe '%s'",

	'cp_notify:subject:likes_en' => "%s has liked your post '%s'",
	'cp_notify:subject:likes_fr' => "%s aime votre publication '%s'",

	'cp_notify:subject:comments_en' => "%s has posted a comment or reply to '%s'",
	'cp_notify:subject:comments_fr' => "%s a publié un commentaire ou une répose à '%s'",

	'cp_notify:subject:site_message_en' => "%s has sent you a new message '%s'",
	'cp_notify:subject:site_message_fr' => "%s vous a envoyé un nouveau message '%s'",

	'cp_notify:subject:new_content_en' => "%s has posted something new entitled '%s'",
	'cp_notify:subject:new_content_fr' => "%s a publié un nouvel item intitulé '%s'",

	'cp_notify:subject:mention_en' => "%s has mentioned you in their new post or reply",
	'cp_notify:subject:mention_fr' => "%s vous a mentionné dans sa publication ou réponse",
	
	// email notification content (title & corresponding description) 
	'cp_notify:body_likes:title_en' => "%s has liked your post called '%s'",
	'cp_notify:body_likes:title_fr' => "%s a aimé votre publication '%s'",

	'cp_notify:body_likes:description_en' => "You can view your content by clicking on this link: %s",
	'cp_notify:body_likes:description_fr' => "Vous pouvez consulter votre contenu en cliquant sur ce lien: %s",
		

	'cp_notify:body_comments:title_en' => "%s posted a comment or reply to %s by %s",
	'cp_notify:body_comments:title_fr' => "%s a publié un commentaire ou une réponse à %s par %s",

	'cp_notify:body_comments:description_en' => "Their comment or reply as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	'cp_notify:body_comments:description_fr' => "Leur commentaire ou réponse ce lit comme suit : <br/>
		 %s <br/> 
		Vous pouvez consulter ou répondre en cliquant le lien suivant : %s",
		

	'cp_notify:body_new_content:title_en' => "%s has created something new entitled '%s'",
	'cp_notify:body_new_content:title_fr' => "%s a publié un nouvel item intitulé '%s'",
	
	'cp_notify:body_new_content:description_en' => "The description of their new posting as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	'cp_notify:body_new_content:description_fr' => "La description de leur nouvel publication ce lit comme suit : <br/> 
		%s <br/> 
		Vous pouvez consulter ou répondre en cliquant le lien suivant : %s",

		
	'cp_notify:body_mention:title_en' => "%s has mentioned your name in their post or reply entitled '%s'",
	'cp_notify:body_mention:title_fr' => "%s vous a mentionné dans sa publication ou réponse intitulée '%s'",

	'cp_notify:body_mention:description_en' => "The posting you were mentioned in as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	'cp_notify:body_mention:description_fr' => "La publication où on vous mentionne est la suivante : <br/>
		 %s <br/>
		Vous pouvez consulter ou répondre en cliquant le lien suivant : %s",


	// site message
	'cp_notify:body_site_msg:title_en' => "%s has sent you a site message entitled '%s'",
	'cp_notify:body_site_msg:title_fr' => "%s vous a envoyé un message intitulé '%s'",

	'cp_notify:body_site_msg:description_en' => "The content of the message as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	'cp_notify:body_site_msg:description_fr' => "Le contenu du message est le suivant : <br/> 
		%s <br/> 
		Vous pouvez le consulter ou répondre en cliquant le lien suivant: %s",


	// group requesting membership
	'cp_notify:body_group_request:title_en' => "%s has sent you a join request to your group '%s'",
	'cp_notify:body_group_request:title_fr' => "%s vous a envoyer une demande de joindre votre groupe '%s'",

	'cp_notify:body_group_request:description_en' => "Please see the request by clicking on this link: %s,
		%s",
	'cp_notify:body_group_request:description_fr' => "Consultez la demande en cliquant le lien suivant : %s
		%s",


	'cp_notify:body_group_add:title_en' => "%s has added you into their group '%s'",
	'cp_notify:body_group_add:title_fr' => "%s vous a ajouté à sont groupe '%s'",

	'cp_notify:body_group_add:description_en' => "You have been added to the group %s with the following message... <br/>",
	'cp_notify:body_group_add:description_fr' => "Vous avez été ajouté au groupe %s avec le message suivant : <br/>",		


	'cp_notify:body_group_invite:title_en' => "%s has invited you to join their group '%s'",
	'cp_notify:body_group_invite:title_fr' => "%s vous a invité à joindre leur groupe '%s'",

	'cp_notify:body_group_invite:description_en' => "You have been invited to join the group '%s' with the following message... <br/>
		%s <br/>
		You can view your invitation by clicking here: %s",
	'cp_notify:body_group_invite:description_fr' => "Vous avez invité à joindre le groupe %s avec le message suivant : <br/> 
		%s <br/>
		Vous pouvez voir votre invitation en cliquant ici :%s",
		

	'cp_notify:body_group_mail:title_en' => "%s has sent out a message to all its members '%s'",
	'cp_notify:body_group_mail:title_fr' => "%s a envoyé un message à tous les membres du groupe '%s'",

	'cp_notify:body_group_mail:description_en' => "The group owner or administrator has sent out a message to all its members with the following message... <br/>
		%s",
	'cp_notify:body_group_mail:description_fr' => "Le propriétaire du groupe ou administrateur a envoyé le message suivant à tous les membres : <br/> 
		%s",

	
	'cp_notify:body_friend_req:title_en' => '%s has sent you a colleague request',
	'cp_notify:body_friend_req:title_fr' => "%s vous a envoyé une demande d'être collègue",

	'cp_notify:body_friend_req:description_en' => "%s has sent you a colleague request and are waiting for you to accept them <br/>
		To view the colleague request invitation please click on this linke: %s",
	'cp_notify:body_friend_req:description_fr' => "%s vous a envoyé une demande d'être collègue et attend que vous l'accepté.<br/>
		 Consultez la demande en cliquant le lien suivant : %s",


	'cp_notify:body_forgot_password:title_en' => "There was a password reset request from this IP: <code %s </code>",
	'cp_notify:body_forgot_password:title_fr' => "Une demande de réinitialisation de mot de passe a été fait a partir de cette adresse IP : <code> %s </code>",

	'cp_notify:body_forgot_password:description_en' => "There was a request to have a password reset from this user's IP:<code %s </code> <br/>
		Please go to this link to have your password resetted for %s's account: %s",
	'cp_notify:body_forgot_password:description_fr' => "Une demande de réinitialisation de mot de passe a été fait pour l'adresse IP:<code> %s </code> <br/> 
		Cliquer le lien suivant afin de réinitier le mote de passe pour le compte de %s : %s",

		
	'cp_notify:body_validate_user:title_en' => "Please validate your new account for %s",
	'cp_notify:body_validate_user:title_fr' => "Veuiller valider votre compte pour %s",
	
	'cp_notify:body_validate_user:description_en' => "Welcome to GCconnex, to complete your registration, please validate the account registered under %s by going to this link: %s",
	'cp_notify:body_validate_user:description_fr' => "Bienvenue sur GCconnex. Afin de compléter votre inscription, veuillez valider votre compte enregistré sous le nom %s en cliquant le lien suivant : %s",


	// email notification footer text (1 and 2)
	'cp_notify:footer_en' => "<p>If you do not want to receive this notification, please manage your subscription settings here: %s</p>",
	'cp_notify:footer_fr' => "<p>Si vous ne voulez plus recevoir ce type de notification, veuillez modifier vos paramètres d'abonnement en cliquant le lien suivant : - http link -</p>",

	'cp_notify:footer2_en' =>  "<p>Ceci est un message automatisé, veuillez ne pas y répondre</>p",
	'cp_notify:footer2_fr' => "<p>This is an automated message, please do not reply</p>",



	// texts that will be displayed in the site pages
	'cp_notify:panel_title' => 'Subscription settings (click to edit email: %s)',
	'cp_notify:quicklinks' => 'Subscription Quick Links',
	'cp_notify:content_name' => 'Content Name',
	'cp_notify:email' => 'Notify by e-mail',
	'cp_notify:site_mail' => 'Notify by site mail',
	'cp_notify:subscribe' => 'Subscribe',
	'cp_notify:unsubscribe' => 'Unsubscribe',
	'cp_notify:not_subscribed' => 'Not Subscribed',

	'cp_notify:no_group_sub' => "You have not subscribed to any Group content",
	'cp_notify:no_sub' => "You have not subscribed to any content",

	"cp_notify:sidebar:no_subscriptions" => "<i>No Subscriptions Available</i>",
	"cp_notify:sidebar:group_title" => "Group + Content Subscriptions",
	"cp_notify:sidebar:subs_title" => "Personal Subscriptions",

);

add_translation("en", $english);