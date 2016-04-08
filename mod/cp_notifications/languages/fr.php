<?php

	$french = array(
    'cp_notify:footer2' =>  "",
	// texts that will be displayed in the email notification
	
	'cp_notification:email_header' => "Ceci est un message généré par le système de GCconnex. Veuillez ne pas répondre à ce message",
	
	'cp_notification:email_header_msg' => "",
	
	
	// email subject lines	
	
	'cp_notify:subject:group_add_user' => "Vous avez été ajouté au groupe '%s'",

	'cp_notify:subject:group_invite_user' => "%s vous a invité à joindre le groupe %s",
		
	'cp_notify:subject:group_invite_user_by_email' => "%s vous a invité à joindre le groupe %s",
		
	'cp_notify:subject:group_request' => "% a fait une demande à joindre le groupe %s",

	'cp_notify:subject:group_mail' => "%s a envoyé un message au groupe '%s'",

	'cp_notify:subject:friend_request' => "%s veut être votre collègue!",

	'cp_notify:subject:forgot_password' => "Vous avez fait une demande pour réinitialiser votre mot de passe",

	'cp_notify:subject:validate_user' => "Veuillez valider le compte de %s",

	'cp_notify:subject:group_join_request' => "%s a fait une demande de joindre votre groupe '%s'",

	'cp_notify:subject:likes' => "%s aime votre publication '%s'",

	'cp_notify:subject:comments' => "%s a publié un commentaire ou une réponse à '%s'",

	'cp_notify:subject:site_message' => "%s vous a envoyé un nouveau message '%s'",

	//'cp_notify:subject:new_content' => "%s a publié un nouvel %s intitulé '%s'",
	'cp_notify:subject:new_content_mas' => "%s a publié un nouveau %s intitulé '%s'",
	
	'cp_notify:subject:new_content_fem' => "%s a publié une nouvelle %s intitulée '%s'",


	'cp_notify:subject:mention' => "%s vous a cité dans sa publication ou réponse",

	'cp_notify:subject:hjtopic' => "Un nouveau forum de discussion à été publié.",
	
	'cp_notify:subject:hjpost' => "Une nouvelle réponse au forum de discussion a été publiée.",

	'cp_notify:subject:approve_friend' => "%s a approuvé votre demande à devenir collègue.", 

	'cp_notify:subject:group_invite_email' => "%s vous a invité à joindre le groupe '%s'",


	'cp_notify:subject:likes_comment' => "%s a aimé votre commentaire sur '%s'",
	'cp_notify:subject:likes_discussion' => "%s a aimé votre réponse à '%s'",
	'cp_notify:subject:likes_user_update' => "%s a aimé votre récente mise à jour",
	'cp_notify:subject:add_new_user' => "Vous avez été ajouté en tant que nouvel utilisateur sur GCconnex",
	'cp_notify:subject:invite_new_user' => "Vous avez été invité à joindre GCconnex",


	// email notification content (title & corresponding description) 

	'cp_notify:body_friend_approve:title' => "%s a approuvé votre demande à devenir collègue",
 
	'cp_notify:body_friend_approve:description' => "%s a approuvé votre demande à devenir collègue",


	'cp_notify:body_likes:title' => "%s a aimé votre publication '%s'",

	'cp_notify:body_likes:description' => "Vous pouvez consulter votre contenu en cliquant sur le lien suivant : %s",
		
	'cp_notify:body_comments:title' => "%s a publié un commentaire ou une réponse à %s par %s",

	'cp_notify:body_comments:description' => "Leur commentaire ou réponse ce lit comme suit : <br/>
		 %s <br/> 
		Vous pouvez consulter ou répondre en cliquant sur le lien suivant : %s",
		

	
	'cp_notify:body_new_content:title' => "%s a publié un nouvel item intitulé '%s'",
	
	'cp_notify:body_new_content:description' => "La description de leur nouvelle publication ce lit comme suit : <br/> 
		%s <br/> 
		Vous pouvez consulter ou y répondre en cliquant sur le lien suivant : %s",

		
	'cp_notify:body_mention:title' => "%s vous a cité dans sa publication ou réponse intitulée '%s'",

	'cp_notify:body_mention:description' => "Voici la publication où  l'on vous cite : <br/>
		 %s <br/>
		Vous pouvez consulter la publication ou y répondre en cliquant sur le lien suivant : %s",


	// site message
	'cp_notify:body_site_msg:title' => "%s vous a envoyé un message intitulé '%s'",

	'cp_notify:body_site_msg:description' => "Le contenu du message est le suivant : <br/> 
		%s <br/> 
		Vous pouvez le consulter ou y répondre en cliquant sur le lien suivant: %s",


	// group requesting membership
	
	'cp_notify:body_group_request:title' => "%s vous a envoyé une demande d'adhésion au groupe '%s'",

	'cp_notify:body_group_request:description' => "Consultez la demande en cliquant sur le lien suivant : %s
		%s",

	'cp_notify:body_group_invite_email:title' => "Vous êtes invité à joindre un groupe sur GCconnex",
	'cp_notify:body_group_invite_email:description' => "Vous être invité à joindre le groupe '%s' sur GCconnex",


	'cp_notify:body_group_add:title' => "Vous avez été ajouté au groupe '%s'",

	'cp_notify:body_group_add:description' => "Vous avez été ajouté au groupe %s : <br/>",		


	'cp_notify:body_group_invite:title' => "%s vous a invité à joindre le groupe '%s'",

	'cp_notify:body_group_invite:description' => "Vous avez invité à joindre le groupe %s : <br/> 
		%s <br/>
		Cliquez ici pour consulter votre invitation :%s",
		

	'cp_notify:body_group_mail:title' => "%s a envoyé un message à tous les membres du groupe '%s'",

	'cp_notify:body_group_mail:description' => "Le propriétaire du groupe ou administrateur a envoyé le message suivant à tous les membres : <br/> 
		%s",

	
	'cp_notify:bodyiend_req:title' => "%s veut être votre collègue",

	'cp_notify:bodyiend_req:description' => "%s souhaite être votre collègue et attend que vous approuviez sa demande.<br/>
		 Affichez les demandes qui sont en attente en cliquant ici : %s",


	'cp_notify:body_forgot_password:title' => "Une demande de réinitialisation du mot de passe a été fait a partir de cette adresse IP : <code> %s </code>",

	'cp_notify:body_forgot_password:description' => "Une demande de réinitialisation du mot de passe a été fait pour l'adresse IP:<code> %s </code> <br/> 
		Cliquez sur le lien suivant afin de réinitialiser le mot de passe pour le compte de %s : %s",

		
	'cp_notify:body_validate_user:title' => "Veuillez valider votre compte pour %s",

	'cp_notify:body_validate_user:description' => "Bienvenue sur GCconnex. Afin de compléter votre inscription, veuillez valider votre compte enregistré sous le nom %s en cliquant sur le lien suivant : %s",


	'cp_notify:body_hjtopic:title' => "Un nouveau forum de discussion a été publié",

	'cp_notify:body_hjtopic:description' => "La description de leur nouvelle publication ce lit comme suit : <br/> 
		%s <br/> 
		Vous pouvez consulter ou y répondre en cliquant sur le lien suivant : %s",


	'cp_notify:body_hjforum:title' => "Un nouveau message a été publié dans le forum de discussion.",

	'cp_notify:body_hjforum:description' => "Leur commentaire ou réponse ce lit comme suit : <br/>
		 %s <br/> 
		Vous pouvez consulter ou répondre en cliquant sur le lien suivant : %s",




	'cp_notify:body_likes_comment:title' => "%s a aimé votre commentaire sur '%s'",
	'cp_notify:body_likes_comment:description' => "Votre commentaire sur '%s' a eu une mention j'aime par %s",

	'cp_notify:body_likes_discussion_reply:title' => "%s a aimé votre réponse à '%s'",
	'cp_notify:body_likes_discussion_reply:description' => "Votre réponse à '%s' a eu une mention j'aime par %s",

	'cp_notify:body_likes_user_update:title' => "%s a aimé votre récente mise a jour",
	'cp_notify:body_likes_user_update:description' => "Votre récente mise à jour a eu une mention j'aime par %s",

	'cp_notify:body_add_new_user:title' => "Vous avez été ajouté en tant que nouvel utilisateur sur GCconnex",
	'cp_notify:body_add_new_user:description' => "Vous pouvez maintenant vous connecter en utilisant les informations de comptes suivants<br/>
		Nom d'utilisateur : %s  et mot de passe : %s",

	'cp_notify:body_invite_new_user:title' => "Vous avez été invité à joindre GCconnex",
	'cp_notify:body_invite_new_user:description' => "Joignez-vous à l'espace de travail collaboratif pour le réseautage professionnel pour l'ensemble de la fonction publique. Vous pouvez vous inscrire à GCconnex en cliquant sur le lien suivant %s",

	'cp_notify:body_event:title' => "Évènement ajouté à votre calendrier",
	'cp_notify:body_event:description' => '%s<br>%s - %s', 

	// email notification footer text (1 and 2)
	
	'cp_notify:footer' => "<p>Si vous ne voulez plus recevoir ce type de notification, veuillez modifier vos param?tres d'abonnement en cliquant le lien suivant : - http link -</p>",

	'cp_notify:footer2' =>  "",//"Ceci est un message automatis?, veuillez ne pas y r?pondre",



	// texts that will be displayed in the site pages
	'cp_notify:panel_title' => "Paramètres d'abonnement (cliquer pour modifier votre courriel : %s)",
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

	'cp_notify:contactHelpDesk'=>'Si vous avez des questions, veuillez soumettre votre demande via le <a href="https://gcconnex.gc.ca/mod/contactform/">formlaire Contactez-nous</a>.',
    'cp_notify:visitTutorials'=>"Pour de plus amples renseignements sur GCconnex et ses fonctionnalités, consultez l'<a href='http://www.gcpedia.gc.ca/wiki/Aide_%C3%A0_l%27utilisateur/Voir_Tout'>aide à l'utilisateur de GCconnex</a>.
	                             Merci",
    'cp_notify:personalLikes'=>'Notify me when someone likes my content (translate me)',
    'cp_notify:personalMention'=>'Notify me when someone @mentions me (translate me)',
    'cp_notify:personalContent'=>'Notify me when something happens on content I create (translate me)',
    'cp_notify:colleagueContent'=>'Notify me when my colleagues create content (translate me)',
    'cp_notify:emailsForGroup'=>'Recieve emails about group notifications (translate me)',
    'cp_notify:groupContent'=>'Group Content (translate me)',
    'cp_notify:notifNewContent'=>'Notify me when new content is created (Discussion, Files, etc.) (translate me)',
    'cp_notify:notifComments'=>'Notify me when comments are created (translate me)',

	);

add_translation("fr", $french);