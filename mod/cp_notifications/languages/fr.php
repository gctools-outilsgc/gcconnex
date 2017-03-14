<?php

$site = elgg_get_site_entity();
$site_name = $site->name;
$contact_us = "{$site->getURL()}mod/contactform/";

$french = array( 

	/// SETTINGS PAGE: Newsletter translation texts
	'cp_newsletter:notice' => "Choisissez le moyen par lequel vous souhaitez recevoir des avis sur les activités de GCconnex qui vous intéressent. Le résumé des notifications vous permet de recevoir un courriel quotidien ou hebdomadaire contenant un sommaire des activités auxquelles vous êtes abonné. Vous préférez recevoir un avis instantané? Oubliez le résumé et sélectionnez le contenu pour lequel vous souhaitez recevoir des avis en temps réel. Veuillez noter que les avis par courriel sont envoyés à l’adresse électronique utilisée dans vos paramètres d’utilisateur.",
	'cp_newsletter:notice:disable_digest' => "Le résumé des avis est maintenant activé; veuillez choisir ci après vos préférences applicables au résumé (fréquence et langue). Le résumé comprendra tout le contenu sélectionné dans la colonne « Courriel », de même que les abonnements dans la section « Autres abonnements de contenu ».",
	'cp_newsletter:subject:daily' => "Votre bulletin quotidien",
	'cp_newsletter:subject:weekly' => "Votre bulletin hebdomadaire",
	'cp_newsletter:enable_digest_option' => "Activer la fonctionnalité de bulletin",
	'cp_newsletter:label:english' => "anglais",
	'cp_newsletter:label:french' => "français",
	'cp_newsletter:label:daily' => "Chaque jour",
	'cp_newsletter:label:weekly' => "Chaque semaine",


	'cp_newsletter:information:digest_option' => "Cette option activera ou désactivera la fonction de résumé.",
	'cp_newsletter:information:digest_option:url' => "#",
	'cp_newsletter:information:frequency' => "Cette option déterminera la fréquence à laquelle vous souhaitez recevoir le résumé.",
	'cp_newsletter:information:frequency:url' => "#",
	'cp_newsletter:information:language' => "Cette option déterminera la langue dans laquelle vous recevrez le résumé.",
	'cp_newsletter:information:language:url' => "#",
	'cp_newsletter:information:select_all' => "Cette option permet de sélectionner le groupe uniquement, et non le contenu du groupe",
	'cp_newsletter:information:select_all:url' => "#",
	'cp_newsletter:set_frequency' => "À quelle fréquence souhaitez-vous recevoir le résumé?",
	'cp_newsletter:set_language' => "Dans quelle langue souhaitez-vous recevoir le résumé?",


	'cp_notifications:subtype:groupforumtopic' => "Discussions",
	'cp_notifications:subtype:hjforumtopic' => "Sujet du forum",
	'cp_notifications:subtype:hjforumpost' => "Sujet réponse",
	'cp_notifications:subtype:page' => "Page",
	'cp_notifications:subtype:page_top' => "Page",
	'cp_notifications:subtype:blog' => "Blogue",
	'cp_notifications:subtype:bookmarks' => "Signet",
	'cp_notifications:subtype:file' => "Fichier",
	'cp_notifications:subtype:album' => "Album",
	'cp_notifications:subtype:thewire' => "Fil",
	'cp_notifications:subtype:poll' => "Vote",
	'cp_notifications:subtype:event_calendar' => "Événement",
	'cp_notifications:subtype:photo' => "Images",
	'cp_notifications:subtype:task' => "Tâche",

	'cp_notifications:mail_body:subtype:groupforumtopic' => "% a publié une discussion %s",
	'cp_notifications:mail_body:subtype:hjforumtopic' => "%s a posté un sujet sur le forum %s",
	'cp_notifications:mail_body:subtype:hjforumpost' => "%s a publié une réponse à un sujet de forum %s",
	'cp_notifications:mail_body:subtype:page' => "%s a publié une page %s",
	'cp_notifications:mail_body:subtype:blog' => "%s a publié un blogue %s",
	'cp_notifications:mail_body:subtype:bookmarks' => "%s a publié un signet %s",
	'cp_notifications:mail_body:subtype:file' => "%s a publié un fichier %s",
	'cp_notifications:mail_body:subtype:album' => "%s a publié un album %s",
	'cp_notifications:mail_body:subtype:thewire' => "%s publié sur le %s",
	'cp_notifications:mail_body:subtype:poll' => "%s a créé un sondage",
	'cp_notifications:mail_body:subtype:event_calendar' => "%s a publié un événement %s",
	'cp_notifications:mail_body:subtype:photo' => "%s a publié une image %s",
	'cp_notifications:mail_body:subtype:task' => "%s a publié une tâche %s",
	'cp_notifications:mail_body:subtype:likes' => "%s a aimé votre publication: %s",
	'cp_notifications:mail_body:subtype:response' => "%s a répondu ou commenté votre publication: %s",
	'cp_notifications:mail_body:subtype:any' => "%s posted a%s %s %s", // john doe post un blogue vs john doe posted un blog

	'cp_newsletter:other_content:notice' => "Ces abonnements s'appliquent uniquement au contenu qui ne fait pas partie d'un groupe",
	
	'cp_notifications:no_colleagues' => "Vous n'avez aucun collègue",
	'cp_notifications:chkbox:email' => "Courriel",
	'cp_notifications:chkbox:site' => "Site",
	'cp_notifications:unsubscribe' => 'Désabonner',
	'cp_notify:not_subscribed' => 'Pas abonné',
	'cp_notifications:pick_colleagues' => 'Abonnez-vous à vos collègues',
	'cp_notifications:group_content'=>'Contenu du groupe',
	'cp_notifications:no_group_subscription' => 'Rien à charger',
	'cp_notifications:loading' => 'Chargement...',
	'cp_notifications:subscribe_all_label' => "<a href='%s'>S’abonner</a> ou <a href='%s'>Se désabonner</a> à tous les groupes et leur contenu",
	'cp_notifications:chkbox:select_all_group_for_notification' => "Sélectionner tous les groupes (cette option ne sélectionnera pas le contenu des groupes).",

	'cp_notify:personal_bulk_notifications' => 'Activer le résumé des notifications', 

	'cp_notifications:personal_likes'=>'Envoyez-moi une notification lorsque quelqu\'un aime mon contenu',
	'cp_notifications:personal_mentions'=>'Envoyez-moi une notification lorsque quelqu\'un me mentionne',
	'cp_notifications:personal_content'=>'Envoyez-moi une notification lorsqu\'un changement est fait au contenu que j\'ai crée',
	'cp_notifications:colleagueContent'=>'Envoyez-moi une notification lorsqu\'un(e) collègue crée du nouveau contenu',
	'cp_notifications:personal_opportunities' => "Avertissez-moi dès qu'une nouvelle opportunité que j'ai choisie est créée dans la plate-forme Opportunités Carrières ConneXions",

	'cp_notifications:no_group_content' => "(Aucun contenu de groupe abonné)", //

	'cp_notifications:heading:page_title' => "Paramètres d'abonnement (cliquer pour modifier votre %s)",
	'cp_notifications:your_email' => "courriel",
	'cp_notifications:heading:newsletter_section' => "Bulletin d'information",
	'cp_notifications:heading:personal_section' => 'Vos abonnements',
	'cp_notifications:heading:colleague_section'=>'Avis de collègues',
	'cp_notifications:heading:group_section' => 'Notifications de groupe',
	'cp_notifications:heading:nonGroup_section' => 'Autres abonnements de contenu',


	'cp_newsletter:title:nothing' => "Votre résumé {$site_name} : Rien à signaler aujourd’hui.",
	'cp_newsletter:body:nothing' => "Il semble que c'était calme dans votre réseau sur GCconnex, nous n'avons rien à signaler.",
	'cp_newsletter:title' => "Votre résumé {$site_name} : Il y a du nouveau contenu et des mises à jour.",
	'cp_newsletter:greeting' => "Bonjour %s. Voici vos notifications pour le <strong>%s</strong>",


	'cp_newsletter:heading:notify:content_revision' => "Contenu qui a été révisé",
	'cp_newsletter:heading:notify:mission' => "Avis d’occasion (micro-mission)",
	'cp_newsletter:heading:notify:group' => "Avis de groupes",
	'cp_newsletter:heading:notify:new_post' => "Nouveau contenu publié par vos collègues",
	'cp_newsletter:heading:notify:cp_wire_share' => "Contenu qui a été partagé",
	'cp_newsletter:heading:notify:likes' => "Utilisateurs ayant apprécié votre contenu",
	'cp_newsletter:heading:notify:friend_request' => "Demandes de collègues",
	'cp_newsletter:heading:notify:friend_approved' => "%s a approuvé vos demandes de collègue",
	'cp_newsletter:heading:notify:personal' => "Avis personnels",
	'cp_newsletter:heading:notify:forum_topic' => "Sujets de forum",
	'cp_newsletter:heading:notify:forum_reply' => "Réponses au sujet de forum",
	'cp_newsletter:heading:notify:response' => "Réponse à un contenu auquel vous êtes abonné",

	'cp_newsletter:footer:notification_settings' => "Pour vous désabonner ou gérer ces messages, veuillez vous connecter et visiter votre <a href='{$site->getURL()}settings/plugin/%s/cp_notifications'> Paramètres de notification</a>.",
	'cp_newsletter:ending' => "<p>Cordialement,</p> <p>L'équipe GCTools</p>",
	'cp_notifications:contact_help_desk'=> "Si vous avez des questions, veuillez soumettre votre demande via le <a href='{$site->getURL()}mod/contactform/'>formulaire Contactez-nous</a>.",





	// e-mail header text
	'cp_notification:email_header' => "Ceci est un message généré par le système de GCconnex. Veuillez ne pas répondre à ce message",
	'cp_notification:email_header_msg' => "",

	// add user to group section
	'cp_notify:subject:group_add_user' => "Vous avez été ajouté au groupe '%s'",
	'cp_notify:body_group_add:title' => "Vous avez été ajouté au groupe '%s'",
	'cp_notify:body_group_add:description' => "Vous avez été ajouté au groupe %s : <br/>",

	// content edit section
	//'cp_notify:subject:edit_content' => "%s a été mis à jour par %s", // new
	//'cp_notify:body_edit:title' => "Ce contenu a été modifié.",	// new
	//'cp_notify:body_edit:description' => "Cliquez ici pour voir le contenu : <a href='%s'>%s</a>", // new
	'cp_notify:subject:edit_content' => "%s '%s' a été mis à jour par %s",
	'cp_notify:body_edit:title' => "%s a été modifié.",
	'cp_notify:body_edit:description' => "<a href='%s'>Visualiser ou afficher un commentaire</a> <br/>
		Vous pouvez aimer, partager et vous abonner à ce contenu dans GCconnex.",

	// group invite user
	'cp_notify:subject:group_invite_user' => "%s vous a invité à joindre le groupe %s",
	'cp_notify:body_group_invite:title' => "%s vous a invité à joindre le groupe '%s'",
	'cp_notify:body_group_invite:description' => "Vous avez été invité à joindre le groupe %s : <br/> 
		%s <br/>
		Cliquez ici pour consulter votre invitation :%s",


	// group invite user by email
	'cp_notify:subject:group_invite_email' => "%s vous a invité à joindre le groupe '%s'",
	'cp_notify:subject:group_invite_user_by_email' => "%s vous a invité à joindre le groupe %s",
	'cp_notify:body_group_invite_email:title' => "<a href='%s'>%s</a> vous a invité à joindre le groupe <a href='%s'>%s</a>  sur GCconnex. <br>",
	'cp_notify:body_group_invite_email:description' => "<a href='%s'>Inscrivez-vous maintenant</a> et vous serez automatiquement ajouté au groupe.<br/><br/>

	Si vous désirez vous inscrire à une date ultérieure en utilisant le <a href='https://gcconnex.gc.ca/register'>formulaire d’inscription</a> sur GCconnex, vous pouvez vous joindre au groupe en utilisant le code suivant sur votre page d'<a href='%s'>invitation de groupe</a> : %s .<br/><br/>

	Vous-êtes déjà sur GCconnex? Votre adresse est peut-être désuète. <a href='https://gcconnex.gc.ca/login'>Connectez-vous</a> et mettez à jour vos paramètres de comptes.<br/> ",

	'cp_notify:footer:no_user' => 'Apprenez davantage au sujet de <a href=http://www.gcpedia.gc.ca/wiki/OutilsGC/GCconnex">GCconnex</a>, l’espace de travail collaboratif pour le réseautage professionnel à l\'ensemble de la fonction publique.<br/>
	Besoin d\'aide? <a href="https://gcconnex.gc.ca/mod/contactform/">Contactez-nous</a>.',
	'cp_personalized_message' => "<div style='border: 1px solid #047177; padding:5px; margin-bottom:10px;'>%s vous a envoyé un message personnalisé:<br/><i>%s</i></div>",


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
	'cp_notify:body_forgot_password:title' => "Une demande de réinitialisation du mot de passe a été faite à partir de cette adresse IP : <code> %s </code>",
	'cp_notify:body_forgot_password:description' => "Une demande de réinitialisation du mot de passe a été faite pour l'adresse IP:<code> %s </code> <br/> 
		Cliquez sur le lien suivant afin de réinitialiser le mot de passe pour le compte de %s : %s",


	// validate user section
	'cp_notify:subject:validate_user' => "Veuillez valider le compte de %s",
	'cp_notify:body_validate_user:title' => "Veuillez valider votre compte pour %s",
	'cp_notify:body_validate_user:description' => "Bienvenue sur GCconnex. Afin de compléter votre inscription, veuillez valider votre compte enregistré sous le nom %s en cliquant sur le lien suivant : %s",


	// post comment
	// +------ cyu updated
	'cp_notify:subject:comments_user' => "Un commentaire a été affiché dans le groupe %s",

	'cp_notify:subject:comments' => "Un commentaire a été affiché dans le groupe %s",
	'cp_notify:subject:comments_discussion' => "Une réponse à une discussion a été affichée dans le groupe %s",

	'cp_notify:subject:comments_user' => "Un commentaire a été publié dans le sujet de %s",

	'cp_notify:body_comments:title_m' => "<a href='%s'>%s</a> a affiché un commentaire sur le %s intitulé <a href='%s'>%s</a>",
	'cp_notify:body_comments:title_f' => "<a href='%s'>%s</a> a affiché un commentaire sur la %s intitulée <a href='%s'>%s</a>",


	// +------ cyu discussion
	'cp_notify:body_comments:title_discussion' => "<a href='%s'>%s</a> a affiché une réponse dans la %s intitulée <a href='%s'>%s</a>",

	'cp_notify:body_comments:title_user' => "<a href='%s'>%s</a> a affiché une réponse dans la %s intitulée <a href='%s'>%s</a>",

	'cp_notify:body_comments:description' => "<a href='%s'>Visualiser ou afficher un commentaire</a>",
	'cp_notify:body_comments:description_discussion' => "<a href='%s'>Visualiser ou répondre</a>",


	// site message
	'cp_notify:subject:site_message' => "%s vous a envoyé un nouveau message '%s'",
	'cp_notify:body_site_msg:title' => "%s vous a envoyé un message intitulé '%s'",
	'cp_notify:body_site_msg:description' => "Le contenu du message est le suivant : <br/> 
		%s <br/> 
		Vous pouvez le consulter ou y répondre en cliquant sur le lien suivant: %s",


	// new content posted section
	'cp_notify_usr:subject:new_content' => "%s a publié un nouveau %s avec le titre '%s'",
	'cp_notify_usr:subject:new_content2' => "%s a publié un nouveau %s",
	'cp_notify:subject:new_content_mas' => "Un nouveau %s a été affiché dans le groupe %s",
	'cp_notify:subject:new_content_mas2' => "Un nouvel %s a été affiché dans le groupe %s",
	'cp_notify:subject:new_content_fem' => "Une nouvelle %s a été affichée dans le groupe %s",

	// +------ cyu <User name> posted a new <item type> entitled <item name>
	'cp_notify:body_new_content:title_m' => "<a href='%s'>%s</a> a affiché un nouveau %s intitulé <a href='%s'>%s</a>",
	'cp_notify:body_new_content:title_f' => "<a href='%s'>%s</a> a affiché une nouvelle %s intitulée <a href='%s'>%s</a>",

	'cp_notify:body_new_content:title_m2' => "<a href='%s'>%s</a> a ajouté un nouveau %s intitulé <a href='%s'>%s</a>",
	'cp_notify:body_new_content:title_m3' => "<a href='%s'>%s</a> a ajouté un nouvel %s intitulé <a href='%s'>%s</a>",
	'cp_notify:body_new_content:title_f2' => "<a href='%s'>%s</a> a ajouté une nouvelle %s intitulée <a href='%s'>%s</a>",

	'cp_notify:body_new_content:description' => "La description de leur nouvelle publication se lit comme suit : <br/> 
		%s <br/>
		<a href='%s'>Visualiser ou afficher un commentaire</a> <br/>
		Vous pouvez aimer, partager et vous abonner à ce contenu dans GCconnex.",

	'cp_notify:body_new_content:description_discussion' => "La description de leur nouvelle publication se lit comme suit : <br/>
		%s <br/>
		<a href='%s'>Visualiser ou répondre</a> <br/>
		Vous pouvez aimer, partager et vous abonner à ce contenu dans GCconnex.",

			'cp_notify:body_new_content:no_description_discussion' => "<a href='%s'>Visualiser ou répondre</a> <br/>
		Vous pouvez aimer, partager et vous abonner à ce contenu dans GCconnex.",

	// mention section
	'cp_notify:subject:mention' => "%s vous a cité sur GCconnex",
	'cp_notify:body_mention:title' => "%s vous a cité dans sa publication ou réponse intitulée '%s'",
	'cp_notify:body_mention:description' => "Voici la publication où l'on vous cite : <br/>
		 %s <br/>
		Vous pouvez consulter la publication ou y répondre en cliquant sur le lien suivant : %s",


	// mention on the wire section
	'cp_notify:subject:wire_mention' => "%s vous a mentionné sur le fil",
	'cp_notify:body_wire_mention:title' => "Vous avez été mentionné sur le Fil",
	'cp_notify:body_wire_mention:description' => "%s vous a mentionné dans son message sur le fil. <br/>
		Pour consulter tous les messages ou vous avez été mentionné, cliquez sur le lien suivant : %s", 


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
	'cp_notify:body_invite_new_user:title' => "Vous avez été invité à joindre GCconnex par %s",
	'cp_notify:body_invite_new_user:description' => "Joignez-vous à l'espace de travail collaboratif pour le réseautage professionnel pour l'ensemble de la fonction publique. Vous pouvez vous inscrire à GCconnex en cliquant sur le lien suivant %s",


	// transfer group admin
	'cp_notify:subject:group_admin_transfer' => "Vous êtes maintenant le propriétaire du groupe '%s'",
	'cp_notify:body_group_admin_transfer:title' => "Vous êtes maintenant le propriétaire du group '%s'",
	'cp_notify:body_group_admin_transfer:description' => "%s vous a délégué les droits d'administrateur du groups '%s'.<br/><br/>
		Pour accéder le groupe, veuillez cliquer sur le lien suivant : <br/> 
		%s", // translate


	// add group operator
	'cp_notify:subject:add_grp_operator' => "Le propriétaire du groupe '%s' vous a délégué les droits d'administrateur",
	'cp_notify:body_add_grp_operator:title' => "Le propriétaire du groupe '%s' vous a délégué les droits d'administrateur'",
	'cp_notify:body_add_grp_operator:description' => "%s vous a fait propriétaire du groupe '%s'. <br/>
		Pour accéder le groupe , s'il vous plaît cliquer sur le lien suivant : <br/>
		%s", // new


	// message board post section
	'cp_notify:messageboard:subject' => "Quelqu'un a écrit sur ​​votre babillard",
	'cp_notify:body_messageboard:title' => "Quelqu'un a écrit sur ​​votre babillard",
	'cp_notify:body_messageboard:description' => "%s a écrit sur ​​votre babillard le message suivant : <br/><br/>	
		%s <br/>
		Pour consulter votre babillard, cliquez sur le lien suivant : %s", // translate


	// wire share section
	'cp_notify:wireshare:subject' => "%s a partagé votre %s avec le titre '%s'",
	'cp_notify:body_wireshare:title' => "%s a partagé votre %s avec le titre '%s'",
	'cp_notify:body_wireshare:title2' => "%s a partagé votre %s",

	'cp_notify:body_wireshare:description' => "%s a partagé votre %s sur le fil, pour consulter ou répondre, veuillez cliquer sur le lien suivant : %s",
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
	'cp_notify:event_request:subject' => "%s veut ajouter %s à son calendrier ",
	'cp_notify:body_event_request:title' => "Demande d'ajout d'un événement",
	'cp_notify:body_event_request:description' => '%s a fait une demande pour ajouter %s à son calendrier<br><br>Pour voir la requête, veuillez cliquer ici: <a href="%s">Demande d\'ajout</a>', //  Check URL or link

	// event calendar (update)
	'cp_notify:event_update:subject' => " L'événement' %s a été mis à jour",

	// email notification footer text (1 and 2)	


	'cp_notify:footer' => "Apprenez davantage au sujet des <a href='http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/Manage_Account_Settings/How_Do_I_Change_My_Notifications_Settings%3F'>notifications de GCconnex</a>.",// Check URL or link
	'cp_notify:footer2' =>  " Besoin d’aide? <a href='".elgg_get_site_url()."mod/contactform/'>Contactez-nous</a>.<br/>Pour vous désabonner de ces notifications, connectez-vous à GCconnex et modifiez vos <a href='%s'>paramètres de notifications</a>.",



	// texts that will be displayed in the site pages
	'cp_notifications:usersettings:title' => 'Paramètres des notifications',
	'label:email' => "Courriel",
	'label:site' => "Site", // new

	'cp_notify:panel_title' => "Paramètres d'abonnement <br> (Modifiez votre %s)",
	'cp_notify:quicklinks' => 'Liens rapides aux abonnements',
	'cp_notify:content_name' => 'Nom du contenu',
	'cp_notify:email' => 'Informer par courriel',
	'cp_notify:site_mail' => 'Informer par courrier du système',
	'cp_notify:subscribe' => 'Abonner',


	'cp_notify:no_group_sub' => "Vous n'êtes pas abonné a aucun contenu de groupe",
	'cp_notify:no_sub' => "Vous n'êtes pas abonné a aucun contenu",

	"cp_notify:sidebar:no_subscriptions" => "<i>Aucun abonnement disponible</i>",
	"cp_notify:sidebar:group_title" => "Abonnement aux groupes et contenu",
	"cp_notify:sidebar:subs_title" => "Abonnement personnel",


	'cp_notify:visitTutorials'=>"Pour de plus amples renseignements sur GCconnex et ses fonctionnalités, consultez l'<a href='http://www.gcpedia.gc.ca/wiki/GCconnex_-_Aide_%C3%A0_l%27utilisateur/Modifier_mes_param%C3%A8tres_de_compte/Comment_puis-je_modifier_mes_param%C3%A8tres_de_notification%3F'>aide à l'utilisateur de GCconnex</a>.<br/>
	                             Merci",

	// cyu - new message in place for email content revamp
	'cp_notify:french_follows' => "<i><sup>(Le fran&ccedil;ais suit)</sup></i>",
	'cp_notify:readmore' => "<a href='%s'>Lire la suite</a>",


	'cp_notify:email'=>'Courriel',


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


	'cp_notify:minor_edit' => 'Changements mineurs',
	'cp_notify:sidebar:forum_title' => 'Les sujets de discussion et les forums',
	'cp_notify:wirepost_generic_title' => 'Publications sur le fil',


	'cp_notify:unsubscribe_all_label' => 'Cliquez ici pour vous désabonner à toutes les mises à jour des groupes',
	'cp_notify:no_subscription' => "Il n'y a pas d'abonnement",

	'not_contact_person' => "Vous n'êtes pas la personne contact?",
);

add_translation("fr", $french);