<?php

$french = array(

	// e-mail header text
	'cp_notification:email_header' => "Ceci est un message généré par le système de GCconnex. Veuillez ne pas répondre à ce message",
	'cp_notification:email_header_msg' => "",

	// add user to group section
	'cp_notify:subject:group_add_user' => "Vous avez été ajouté au groupe '%s'",
	'cp_notify:body_group_add:title' => "Vous avez été ajouté au groupe '%s'",
	'cp_notify:body_group_add:description' => "Vous avez été ajouté au groupe %s : <br/>",
	
	// content edit section
	'cp_notify:subject:edit_content' => "%s a été mis à jour par %s", // new
	'cp_notify:body_edit:title' => "Ce contenu a été modifié. Cliquez ici pour voir le contenu : %s",	// new
	'cp_notify:body_edit:description' => "Pour vous désabonner à cette notification : %s", // new


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
	'cp_notify:body_group_invite_email:description' => "Vous êtes invité à joindre le groupe '%s' sur GCconnex, veuillez vous inscrire ou vous connecter à GCconnex, ensuite cliquez sur ce lien : %s ou utiliser ce code dans la page d'invitation de groupe : '%s' <br/> %s", // translate
	

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
	'cp_notify:subject:likes' => "%s a aimé votre publication '%s'",
	'cp_notify:body_likes:title' => "%s a aimé votre publication '%s'",

	'cp_notify:subject:likes_wire' => "%s a aimé votre message sur le fil",
	'cp_notify:body_likes_wire:title' => "%s a aimé votre message sur le fil '%s'",
	
	'cp_notify:subject:likes_comment' => "%s a aimé votre commentaire sur '%s'",
	'cp_notify:body_likes_comment:title' => "%s a aimé votre commentaire sur '%s'",
	'cp_notify:body_likes_comment:description' => "Votre commentaire sur '%s' a eu une mention j'aime par %s",
	
	'cp_notify:subject:likes_discussion' => "%s a aimé votre réponse à '%s'",
	'cp_notify:body_likes_discussion_reply:title' => "%s a aimé votre réponse à '%s'",
	'cp_notify:body_likes_discussion_reply:description' => "Votre réponse à '%s' a eu une mention j'aime par %s",

	'cp_notify:subject:likes_user_update' => "%s aime votre nouvel avatar ou votre nouvelle connection de collègue", 
	'cp_notify:body_likes_user_update:title' => "%s aime votre nouvel avatar ou votre nouvelle connection de collègue",
	'cp_notify:body_likes_user_update:description' => "La mise à jour de votre avatar ou votre nouvelle connection de collègue a eu une mention j'aime par %s", 

	/*
	'cp_notify:subject:likes_user_update' => "%s aime votre nouvel avatar", // Please update
	'cp_notify:body_likes_user_update:title' => "%s aime votre nouvel avatar", // Please update
	'cp_notify:body_likes_user_update:description' => "La mise à jour de votre avatar a eu une mention j'aime par %s", // Please update
	
	'cp_notify:subject:likes_user_update' => "%s aime votre nouvelle connection de collègue", // Please update
	'cp_notify:body_likes_user_update:title' => "%s aime votre nouvelle connection de collègue", // Please update
	'cp_notify:body_likes_user_update:description' => "Votre récente connection de collègue a eu une mention j'aime par %s", // Please update
	*/

	'cp_notify:body_likes:description' => "Vous pouvez consulter votre contenu en cliquant sur le lien suivant : %s",


	// friend request
	'cp_notify:subject:friend_request' => "%s veut être votre collègue!",	
	'cp_notify:body_friend_req:title' => "%s veut être votre collègue",
	'cp_notify:body_friend_req:description' => "%s souhaite être votre collègue et attend que vous approuviez sa demande.<br/>
		 Affichez les demandes qui sont en attentes en cliquant ici : %s",
	
	

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
	'cp_notify:subject:mention' => "%s vous a cité sur GCconnex",
	'cp_notify:body_mention:title' => "%s vous a cité dans sa publication ou réponse intitulée '%s'",
	'cp_notify:body_mention:description' => "Voici la publication où l'on vous cite : <br/>
		 %s <br/>
		Vous pouvez consulter la publication ou y répondre en cliquant sur le lien suivant : %s",


	// mention on the wire section
	'cp_notify:subject:wire_mention' => "%s vous a mentioné sur le fil",
	'cp_notify:body_wire_mention:title' => "Vous avez été mentioné sur le Fil",
	'cp_notify:body_wire_mention:description' => "%s vous a mentioné dans son message sur le fil. <br/>
		Pour consulter tous les messages ou vous avez été mentioné, cliquez sur le lien suivant : %s", 


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
	'cp_notify:body_friend_approve:title' => "%s a approuvé votre demande pour devenir collègue",
	'cp_notify:body_friend_approve:description' => "%s a approuvé votre demande pour devenir collègue",


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
	'cp_notify:subject:group_admin_transfer' => "Vous êtes maintenant le propriétaire du groupe '%s'", // translate
	'cp_notify:body_group_admin_transfer:title' => "Vous êtes maintenant le propriétaire du group '%s'", // translate
	'cp_notify:body_group_admin_transfer:description' => "%s vous a délégué les droits d'administrateur du groups '%s'.<br/><br/>
		Pour accéder le groupe, veuillez cliquer sur le lien suivant : <br/> 
		%s", // translate


	// add group operator
	'cp_notify:subject:add_grp_operator' => "Le propriétaire du groupe '%s' vous à délégué les droits d'administrateur", // new
	'cp_notify:body_add_grp_operator:title' => "Le propriétaire du groupe '%s' vous a délégué les droits d'administrateur'", // new
	'cp_notify:body_add_grp_operator:description' => "%s vous a fait propriétaire du groupe '%s'. <br/>
		Pour accéder le groupe , s'il vous plaît cliquer sur le lien suivant : <br/>
		%s", // new


	// message board post section
	'cp_notify:messageboard:subject' => "Quelqu'un a écrit sur ​​votre babillard", // translate
	'cp_notify:body_messageboard:title' => "Quelqu'un a écrit sur ​​votre babillard", // translate
	'cp_notify:body_messageboard:description' => "%s a écrit sur ​​votre babillard le message suivant : <br/><br/>	
		%s <br/>
		Pour consulter votre babillard, cliquez sur le lien suivant : %s", // translate


	// wire share section
	'cp_notify:wireshare:subject' => "%s a partagé votre %s avec le titre '%s'", // translate
	'cp_notify:body_wireshare:title' => "%s a partagé votre %s avec le titre '%s'", // translate
	'cp_notify:body_wireshare:description' => "%s a partagé votre %s sur le fil, 
		pour consulter ou répondre, veuillez cliquer sur le lien suivant : %s", // translate
	'cp_notify:wireshare_thewire:subject' => "%s a partager votre publication sur le fil",

	// event calendar section
	'cp_notify:event:subject' => "Calendrier d'événement",
	'cp_notify:body_event:title' => "Calendrier d'événement",
	'cp_notify:body_event:description' => 'Information: <br/> %s',

	'cp_notify:body_event:event_title' => '<b>Titre :</b> %s',
	'cp_notify:body_event:event_time_duration' => '<b>Quand :</b>%s',
	'cp_notify:body_event:event_location' => '<b>Lieu :</b> %s',
	'cp_notify:body_event:event_room' => '<b>Salle :</b> %s',
	'cp_notify:body_event:event_teleconference' => '<b>Réunion en ligne et téléconférence :</b> %s',
	'cp_notify:body_event:event_additional' => '<b>Information additionelle :</b> %s',
	'cp_notify:body_event:event_fees' => '<b>Prix :</b> %s',
	'cp_notify:body_event:event_organizer' => '<b>Organisateur :</b> %s',
	'cp_notify:body_event:event_contact' => '<b>Personne ressource :</b> %s',
	'cp_notify:body_event:event_long_description' => '<b>Longue description :</b> %s',
	'cp_notify:body_event:event_language' => '<b>Langue de l\'événement :</b> %s',
	'cp_notify:body_event:event_link' => '<b>Ajouter à mon calendrier Outlook :</b> %s',
	'cp_notify:body_event:event_add_to_outlook' => 'Ajouter à mon calendrier Outlook',


	// event calendar(request) section
	'cp_notify:event_request:subject' => "%s veut ajouter %s à son calendrier ",// NEW
	'cp_notify:body_event_request:title' => "Demande d'ajout d'un événement",// NEW
	'cp_notify:body_event_request:description' => '%s a fait une demande pour ajouter %s à son calendrier<br><br>Pour voir la requête, veuillez cliquer ici: <a href="%s">Demande d\'ajout</a>', //  Check URL or link

	// event calendar (update)
	'cp_notify:event_update:subject' => " L'événement' %s a été mis à jour", // NEW

	// email notification footer text (1 and 2)	
	'cp_notify:footer' => "<p>Si vous ne voulez plus recevoir ce type de notification, veuillez modifier vos param?tres d'abonnement en cliquant le lien suivant : - http link -</p>",// Check URL or link
	'cp_notify:footer2' =>  "",





	// texts that will be displayed in the site pages
	'cp_notifications:usersettings:title' => 'Paramètres des notifications',
	'label:email' => "Courriel",
	'label:site' => "Site", // new
	'cp_notify:panel_title' => "Paramètres d'abonnement (cliquer pour modifier votre %s)",
	'cp_notify:panel_title' => "Paramètres d'abonnement <br> (Modifiez votre %s)",
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
	'cp_notify:pickColleagues' => 'Abonnez-vous à vos collègues', // new
	'cp_notify:contactHelpDesk'=>'Si vous avez des questions, veuillez soumettre votre demande via le <a href="https://gcconnex.gc.ca/mod/contactform/">formlaire Contactez-nous</a>.',
    'cp_notify:visitTutorials'=>"Pour de plus amples renseignements sur GCconnex et ses fonctionnalités, consultez l'<a href='http://www.gcpedia.gc.ca/wiki/Aide_%C3%A0_l%27utilisateur/Voir_Tout'>aide à l'utilisateur de GCconnex</a>.<br/>
	                             Merci",
    'cp_notify:email'=>'Courriel', // new
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

	'cp_notify:personal_bulk_notifications' => 'Activer la notification des Actualités', // new
	'ec_minor_edit' => 'Changements mineurs', // new
	'cp_notify:sidebar:forum_title' => 'Les sujets de discussion et les forums',
	'cp_notify:wirepost_generic_title' => 'Publications sur le fil', // new
	'cp_notify:personal_setting' => 'Vos abonnements', // new
	'cp_notify:subscribe_all_label' => 'Cliquez ici pour vous abonner à toutes les mises à jour des groupes', // new
	'cp_notify:unsubscribe_all_label' => 'Cliquez ici pour vous désabonner à toutes les mises à jour des groupes',
	'cp_notify:no_subscription' => "Il n'y a pas d'abonnement", // new
);

add_translation("fr", $french);