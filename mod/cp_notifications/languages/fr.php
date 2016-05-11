<?php

$french = array(

	// e-mail header text
	'cp_notification:email_header' => "Ceci est un message généré par le système de GCconnex. Veuillez ne pas répondre à ce message",
	'cp_notification:email_header_msg' => "",
	

	// add user to group section
	'cp_notify:subject:group_add_user' => "Vous avez été ajouté au groupe '%s'",
	'cp_notify:body_group_add:title' => "Vous avez été ajouté au groupe '%s'",
	'cp_notify:body_group_add:description' => "Vous avez été ajouté au groupe %s : <br/>",		


	// group invite user
	'cp_notify:subject:group_invite_user' => "%s vous a invité à joindre le groupe %s",
	'cp_notify:body_group_invite:title' => "%s vous a invité à joindre le groupe '%s'",
	'cp_notify:body_group_invite:description' => "Vous avez été invité à joindre le groupe %s : <br/> 
		%s <br/>
		Cliquez ici pour consulter votre invitation :%s",


	// group invite user by email
	'cp_notify:subject:group_invite_email' => "%s vous a invité à joindre le groupe '%s'",
	'cp_notify:subject:group_invite_user_by_email' => "%s vous a invité à joindre le groupe %s",
	'cp_notify:body_group_invite_email:title' => "Vous êtes invité à joindre un groupe sur GCconnex",
	'cp_notify:body_group_invite_email:description' => "Vous êtes invité à joindre le groupe '%s' sur GCconnex, please register and use this link: %s or use this code: '%s' <br/> %s", // translate
	

	// group mail section
	'cp_notify:subject:group_mail' => "Vous avez reçu un message intitulé '%s' du groupe '%s'",
	'cp_notify:body_group_mail:title' => "Vous avez reçu un message intitulé '%s' du groupe '%s'",
	'cp_notify:body_group_mail:description' => "Le propriétaire ou l'administrateur du groupe a envoyé le message suivant : <br/> 
		%s",


	// group request section
	'cp_notify:subject:group_request' => "% a fait une demande pour joindre le groupe %s",
	'cp_notify:subject:group_join_request' => "%s a fait une demande pour se joindre au groupe '%s'",
	'cp_notify:body_group_request:title' => "%s vous a envoyé une demande d'adhésion au groupe '%s'",
	'cp_notify:body_group_request:description' => "Consultez la demande en cliquant sur le lien suivant : %s
		%s",


	// likes section
	'cp_notify:subject:likes' => "%s aime votre contenu '%s'",
	'cp_notify:body_likes:title' => "%s a aimé votre publication '%s'",

	'cp_notify:subject:likes_wire' => "%s aime votre message sur le fil",
	'cp_notify:body_likes_wire:title' => "%s aime votre message sur le fil '%s'", // Added % for wire post text
	
	'cp_notify:subject:likes_comment' => "%s a aimé votre commentaire '%s'",
	'cp_notify:body_likes_comment:title' => "%s a aimé votre commentaire sur '%s'",
	'cp_notify:body_likes_comment:description' => "Votre commentaire sur '%s' a eu une mention j'aime par %s",
	
	'cp_notify:subject:likes_discussion' => "%s a aimé votre réponse '%s'",
	'cp_notify:body_likes_discussion_reply:title' => "%s a aimé votre réponse à '%s'",
	'cp_notify:body_likes_discussion_reply:description' => "Votre réponse à '%s' a eu une mention j'aime par %s",
	
	'cp_notify:subject:likes_user_update' => "%s a aimé votre récente mise à jour",
	'cp_notify:body_likes_user_update:title' => "%s a aimé votre récente mise a jour",
	'cp_notify:body_likes_user_update:description' => "Votre récente mise à jour a eu une mention j'aime par %s",

	'cp_notify:body_likes:description' => "Vous pouvez consulter votre contenu en cliquant sur le lien suivant : %s",


	// friend request
	'cp_notify:subject:friend_request' => "%s veut être votre collègue!",	
	'cp_notify:body_friend_req:title' => "%s veut être votre collègue",
	'cp_notify:body_friend_req:description' => "%s souhaite être votre collègue et attend que vous approuviez sa demande.<br/>
		 Affichez les demandes qui sont en attente en cliquant ici : %s",
	
	'cp_notify:body_friend_req:title' => '%s veut être votre collègue!', 
	'cp_notify:body_friend_req:description' => "%s veux être votre collègue et attend que vous approuviez sa demande... Connectez-vous pour approuver cette demande<br/>
		Vous pouvez afficher les demandes de collègue qui sont attente : %s", 



	// forgot password section
	'cp_notify:subject:forgot_password' => "Vous avez fait une demande pour réinitialiser votre mot de passe",
	'cp_notify:body_forgot_password:title' => "Une demande de réinitialisation du mot de passe a été fait a partir de cette adresse IP : <code> %s </code>",
	'cp_notify:body_forgot_password:description' => "Une demande de réinitialisation du mot de passe a été fait pour l'adresse IP:<code> %s </code> <br/> 
		Cliquez sur le lien suivant afin de réinitialiser le mot de passe pour le compte de %s : %s",


	// validate user section
	'cp_notify:subject:validate_user' => "Veuillez valider le compte de %s",
	'cp_notify:body_validate_user:title' => "Veuillez valider votre compte pour %s",
	'cp_notify:body_validate_user:description' => "Bienvenue sur GCconnex. Afin de compléter votre inscription, veuillez valider votre compte enregistré sous le nom %s en cliquant sur le lien suivant : %s",


	// post comment
	'cp_notify:subject:comments' => "%s a publié un commentaire sur '%s'",
	'cp_notify:body_comments:title' => "%s a publié un commentaire sur '%s' par %s",
	'cp_notify:body_comments:description' => "Le commentaire se lit comme suit : <br/>
		 %s <br/> 
		Vous pouvez consulter ou répondre en cliquant sur le lien suivant : %s",


	// site message
	'cp_notify:subject:site_message' => "%s vous a envoyé un nouveau message '%s'",
	'cp_notify:body_site_msg:title' => "%s vous a envoyé un message intitulé '%s'",
	'cp_notify:body_site_msg:description' => "Le contenu du message est le suivant : <br/> 
		%s <br/> 
		Vous pouvez le consulter ou y répondre en cliquant sur le lien suivant: %s",


	// new content posted section
	'cp_notify:subject:new_content_mas' => "%s a publié un nouveau %s intitulé '%s'",
	'cp_notify:subject:new_content_fem' => "%s a publié une nouvelle %s intitulée '%s'",
	'cp_notify:body_new_content:title' => "%s a publié un nouvel item intitulé '%s'",
	'cp_notify:body_new_content:description' => "La description de leur nouvelle publication se lit comme suit : <br/> 
		%s <br/> 
		Vous pouvez consulter ou y répondre en cliquant sur le lien suivant : %s",


	// mention section
	'cp_notify:subject:mention' => "%s vous a mentioné sur GCconnex",
	'cp_notify:body_mention:title' => "%s vous a cité dans sa publication ou réponse intitulée '%s'",
	'cp_notify:body_mention:description' => "Voici la publication où  l'on vous cite : <br/>
		 %s <br/>
		Vous pouvez consulter la publication ou y répondre en cliquant sur le lien suivant : %s",


	// mention on the wire section
	'cp_notify:subject:wire_mention' => "%s vous a mentioné sur le fil",
	'cp_notify:body_wire_mention:title' => "Vous avez été mentioné sur le Fil",
	'cp_notify:body_wire_mention:description' => "%s vous a mentioné dans son message sur le fil. <br/>
		Pour voir tout les message ou vous avez été menioné, cliquez sur le lien suivant : %s", 


	// forum topic
	'cp_notify:subject:hjtopic' => "%s a publié un nouveau forum de discussion intitulé '%s'.",
	'cp_notify:body_hjtopic:title' => "Un nouveau forum de discussion a été publié avec le titre '%s'",
	'cp_notify:body_hjtopic:description' => "La description de leur nouvelle publication se lit comme suit : <br/> 
		%s <br/> 
		Vous pouvez consulter ou y répondre en cliquant sur le lien suivant : %s",


	// forum post (reply/comment)
	'cp_notify:subject:hjpost' => "%s a publié une nouvelle réponse au forum de discussion '%s'",
	'cp_notify:body_hjpost:title' => "Un nouveau message a été publié dans le forum de discussion.",
	'cp_notify:body_hjpost:description' => "Leur commentaire ou réponse se lit comme suit : <br/>
		 %s <br/> 
		Vous pouvez consulter ou répondre en cliquant sur le lien suivant : %s",


	// friend approve
	'cp_notify:subject:approve_friend' => "%s a approuvé votre demande pour devenir votre collègue.",
	'cp_notify:body_friend_approve:title' => "%s a approuvé votre demande à devenir collègue",
	'cp_notify:body_friend_approve:description' => "%s a approuvé votre demande à devenir collègue",


	// add new user
	'cp_notify:subject:add_new_user' => "Vous avez été ajouté en tant que nouvel utilisateur sur GCconnex",
	'cp_notify:body_add_new_user:title' => "Vous avez été ajouté en tant que nouvel utilisateur sur GCconnex",
	'cp_notify:body_add_new_user:description' => "Vous pouvez maintenant vous connecter en utilisant les informations de comptes suivants<br/>
		Nom d'utilisateur : %s  et mot de passe : %s",


	// invite new user to GCconnex
	'cp_notify:subject:invite_new_user' => "Vous avez été invité à joindre GCconnex",
	'cp_notify:body_invite_new_user:title' => "Vous avez été invité à joindre GCconnex",
	'cp_notify:body_invite_new_user:description' => "Joignez-vous à l'espace de travail collaboratif pour le réseautage professionnel pour l'ensemble de la fonction publique. Vous pouvez vous inscrire à GCconnex en cliquant sur le lien suivant %s",


	// transfer group admin
	'cp_notify:subject:group_admin_transfer' => "Les droits d'administration du groups %s vous ont été délégués", 							// translate
	'cp_notify:body_group_admin_transfer:title' => "Les droits d'administration du groups '%s' vous ont été délégués", 						// translate
	'cp_notify:body_group_admin_transfer:description' => "%s vous a délégué les droits d'administrateur du groups '%s'.<br/><br/>
		Pour visiter le groupe, veuillez cliquer sur le lien suivant : <br/> 
		%s", 																																// translate


	// add group operator
	'cp_notify:subject:add_grp_operator' => "french french french The administrator of the group '%s' delegated moderator rights to you", 	// translate
	'cp_notify:body_add_grp_operator:title' => "fr fr fr The administrator of the group '%s' delegated moderator rights to you",			// translate
	'cp_notify:body_add_grp_operator:description' => "fr fr fr fr %s has delegated you as the moderator of the group '%s'.<br/><br/>
		To visit the group, please click on the following link: <br/> %s", 																	// translate


	// message board post section
	'cp_notify:messageboard:subject' => "fr fr fr fr Someone wrote on your message board", 													// translate
	'cp_notify:body_messageboard:title' => "fr fr fr fr Someone wrote on your message board", 												// translate
	'cp_notify:body_messageboard:description' => "%s wrote on your messageboard with the following message: <br/><br/>	
		%s <br/>
		To view your messageboard, please click on the following link: %s",																	// translate


	// wire share section
	'cp_notify:wireshare:subject' => "french french %s shared your %s with title '%s'",														// translate
	'cp_notify:body_wireshare:title' => "french frehnch %s shared your %s with title '%s'",													// translate
	'cp_notify:body_wireshare:description' => "french fr fr fr %s has shared your %s on the wire, 
		to view or reply to this please click on the following link: %s",																	// translate


	// event calendar section
	'cp_notify:event:subject' => "Calendrier d'événement", //NEW
	'cp_notify:body_event:title' => "Calendrier d'événement",
	'cp_notify:body_event:description' => '%s%s', 

	// event calendar(request) section
	'cp_notify:event_request:subject' => "%s veut ajouter %s à son calendrier ",//NEW
	'cp_notify:body_event_request:title' => "Demande d'ajout d'un événement",//NEW
	'cp_notify:body_event_request:description' => '%s a fait une demande pour ajouter %s à son calendrier<br><br>Pour voir la demande, cliquez ici: <a href="%s">Demande d\'ajout</a>', //NEW



	// email notification footer text (1 and 2)	
	'cp_notify:footer' => "<p>Si vous ne voulez plus recevoir ce type de notification, veuillez modifier vos param?tres d'abonnement en cliquant le lien suivant : - http link -</p>",
	'cp_notify:footer2' =>  "",//"Ceci est un message automatis?, veuillez ne pas y r?pondre",





	// texts that will be displayed in the site pages
	'cp_notifications:usersettings:title' => 'Paramètres des notifications',
	'label:email' => "Courriel",
	'cp_notify:panel_title' => "Paramètres d'abonnement (cliquer pour modifier votre %s)",
	'cp_notify:panel_title' => "Paramètres d'abonnement <br> (Modifiez votre %s)", // % should be the user's email, hyperlinked to the user's settings page
	'cp_notify:quicklinks' => 'Liens rapides aux abonnements',
	'cp_notify:content_name' => 'Nom du contenu',
	'cp_notify:email' => 'Informer par courriel',
	'cp_notify:site_mail' => 'Informer par courrier du système',
	'cp_notify:subscribe' => 'Abonner',
	'cp_notify:unsubscribe' => 'Désabonner',
	'cp_notify:not_subscribed' => 'Pas abonné',

	'cp_notify:no_group_sub' => "Vous n'êtes pas abonné a aucun contenu de groupe",
	'cp_notify:no_sub' => "Vous n'êtes pas abonné a aucun contenu",

	"cp_notify:sidebar:no_subscriptions" => "<i>Aucun abonnement disponible</i>",
	"cp_notify:sidebar:group_title" => "Abonnement aux groupes et contenu",
	"cp_notify:sidebar:subs_title" => "Abonnement personnel",
	'cp_notify:pickColleagues' => 'fr fr frPick colleagues to subscribe', // translate
	'cp_notify:contactHelpDesk'=>'Si vous avez des questions, veuillez soumettre votre demande via le <a href="https://gcconnex.gc.ca/mod/contactform/">formlaire Contactez-nous</a>.',
    'cp_notify:visitTutorials'=>"Pour de plus amples renseignements sur GCconnex et ses fonctionnalités, consultez l'<a href='http://www.gcpedia.gc.ca/wiki/Aide_%C3%A0_l%27utilisateur/Voir_Tout'>aide à l'utilisateur de GCconnex</a>.<br/>
	                             Merci",
    'cp_notify:email'=>'fr fr frCouriel', 						// translate
    'cp_notify:personal_likes'=>'Envoyez-moi une notification lorsque quelqu\'un aime mon contenu',
    'cp_notify:personal_mentions'=>'Envoyez-moi une notification lorsque quelqu\'un me mentionne',
    'cp_notify:personal_content'=>'Envoyez-moi une notification lorsqu\'un changement est fait au contenu que j\'ai crée',
    'cp_notify:colleagueContent'=>'Envoyez-moi une notification lorsqu\'un(e) collègue crée du nouveau contenu',
    'cp_notify:emailsForGroup'=>'Sélectionnez tout',
    'cp_notify:groupContent'=>'Contenu de group',
    'cp_notify:notifNewContent'=>'Envoyez-moi une notification lorsque du nouveau contenu est crée (discussion, fichier, etc.)',
    'cp_notify:notifComments'=>'Envoyez-moi une notification lorsqu\'un commentaire est publié',
    'cp_notify:siteForGroup'=>'Selectionnez tout',
    'cp_notify:unsubBell'=>'Vous êtes abonné a ce contenu. Cliquez pour vous désabonner',
    'cp_notify:subBell'=>'Vous n\'êtes pas abonné a ce contenu. Cliquez pour vous abonnez et recevoir des notifications au sujet de ce contenu.',
    'cp_notify:comingSoon'=>'À venir bientôt!',
    'cp_notify:personalNotif'=>'Notifications personnel',
    'cp_notify:collNotif'=>'Notifications de collègues',
    'cp_notify:groupNotif'=>'Notifications de groupe',

);

add_translation("fr", $french);