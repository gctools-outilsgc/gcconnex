<?php

return array(

	/**
	 * Menu items and titles
	 */
	'poll' => "Sondages",
	'poll:add' => "Nouveau sondage",
	'poll:group_poll' => "<i class=\"fa fa-pie-chart\"></i> Sondages",
	'poll:group_poll:listing:title' => "Sondages de %s",
	'poll:your' => "Vos sondages",
	'poll:not_me' => "Sondages de %s",
	'poll:friends' => "Sondages des contacts",
	'poll:addpost' => "Créer un sondage",
	'poll:editpost' => "Modifier un sondage : %s",
	'poll:edit' => "Modifier un sondage",
	'item:object:poll' => 'Sondages',
	'item:object:poll_choice' => "Options du sondage",
	'poll:question' => "Question du sondage",
	'poll:description' => "Description (facultatif)",
	'poll:responses' => "Options du vote",
	'poll:note_responses' => "Note : la modification des choix d'un sondage existant (ajout/suppression de choix ou modification du texte d'un choix existant) va réinitliser les votes du sondage pour permettre aux membres de re-voter sur la base des nouveaux choix.",
	'poll:result:label' => "%s (%s)",
	'poll:show_results' => "Montrer les résultats",
	'poll:show_poll' => "Afficher le sondage",
	'poll:add_choice' => "Ajouter une option",
	'poll:delete_choice' => "Supprimer cette option",
	'poll:close_date' => "Date de clôture du sondage (facultatif)",
	'poll:voting_ended' => "Les votes pour ce sondage se terminent le %s.",
	'poll:poll_closing_date' => "(Date de clôture du sondage : %s)",
	'poll:poll_reset' => "Réinitialiser le sondage",
	'poll:poll_reset_description' => "Avec cette option vous pouvez réinitialiser le sondage et supprimer tous les votes.",
	'poll:poll_reset_confirmation' => "Confirmez-vous vouloir réinitialiser ce sondage et supprimer tous les votes ?",

	'poll:convert:description' => "ATTENTION : %s sondages existant utilisent encore l'ancienne structure de données pour les choix des votes. Ces sondages ne vont plus fonctionner avec cette version du plugin \"poll\".",
	'poll:convert' => 'Mettre à jour les sondages maintenant',
	'poll:convert:confirm' => "La mise à jour est irréversible. Confirmez-vous vouloir convertir la structure de données des choix des votes ?",

	'poll:settings:notification_on_vote:title' => "Notifier l'auteur lorsque quelqu'un a voté sur un sondage ?",
	'poll:settings:notification_on_vote:desc' => "(L'auteur recevra des notifications en fonction de ses réglages personnels et de la configuration globale des notifications, par ex. notifications par email et/ou notifications du site ou aucune)",
	'poll:settings:group:title' => "Activer les sondages du groupe ?",
	'poll:settings:group_poll_default' => "Oui, activé par défaut",
	'poll:settings:group_poll_not_default' => "Oui, désactivé par défaut",
	'poll:settings:no' => "Non",
	'poll:settings:group_access:title' => "Si les sondages de groupe sont activés, qui peut créer des sondages ?",
	'poll:settings:group_access:admins' => "responsables du groupe et administrateurs seulement",
	'poll:settings:group_access:members' => "tout les membres du groupe",
	'poll:settings:front_page:title' => "Les administrateurs peuvent-ils définir un sondage à la fois comme \"Sondage à la Une\" ?",
	'poll:settings:front_page:desc' => "(le plugin Widget Manager est requis pour ajouter le widget correspondant sur la page d'accueil)",
	'poll:settings:allow_close_date:title' => "Permettre de définir une date de fin pour les sondages ?",
	'poll:settings:allow_close_date:desc' => "(après cette date les résultats seront toujours visibles, mais les votes ne seront plus permis)",
	'poll:settings:allow_open_poll:title' => "Activer les sondages ouverts ?",
	'poll:settings:allow_open_poll:desc' => "(les sondages ouverts affichent les noms des membres qui ont voté pour chacun des choix du sondage ; si cette option est activée, les administrateurs peuvent voir qui a voté pour quel choix sur tous les sondages)",
	'poll:settings:allow_poll_reset:title' => "Autoriser les auteurs des sondages à réinitiliser les votes sur leurs sondages ?",
	'poll:settings:allow_poll_reset:desc' => "(l'activation de cette option va ajouter un bouton de titre visible des auteurs de sondages et des administrateurs qui leur permet de réinitialiser tous les votes sur un sondage ; les administateurs auront touours la possibilité de réinitialiser les votes même si cette option est désactivée)",
	'poll:settings:multiple_answer_polls:title' => "Permettre des sondages à réponses multiples ?",
	'poll:settings:multiple_answer_polls:desc' => "(Dans ces sondages, les membres peuvent sélectionner plusieurs réponses lorsqu'ils votent. Le nombre maximum de choix possibles est défini par l'auteur du sondage. Si vous désactivez les réponses multiples après que de tels sondages aient été créés, le nombre de choix autorisés dans  es sondages ne va pas changer à moins que vous ne modifiez les choix du sondage. Dans le cas où les choix du sondage sont modifiés, le nombre maximum de choix autorisés sera réinitialisé à 1, à moins que plusieurs réponses ne soient autorisées au moment de la modification)",
	'poll:none' => "Aucun sondage.",
	'poll:not_found' => "Le sondage n'a pas été trouvé.",
	'poll:permission_error' => "Vous n'avez pas la permission de modifier ce sondage.",
	'poll:vote' => "Voter",
	'poll:login' => "Veuillez vous connecter pour voter sur ce sondage.",
	'group:poll:empty' => "Aucun sondage",
	'poll:settings:site_access:title' => "Qui peut créer des sondages pour l'ensemble du site ?",
	'poll:settings:site_access:admins' => "administrateurs seulement",
	'poll:settings:site_access:all' => "tous les membres du site",
	'poll:can_not_create' => "Vous n'avez pas la permission de créer des sondages.",
	'poll:front_page_label' => "Faire de ce sondage le nouveau \"Sondage à la Une\"",
	'poll:open_poll_label' => "Afficher dans les résultats quels membres ont voté pour quel choix (sondage ouvert)",
	'poll:show_voters' => "Afficher les votants",
	'poll:max_votes:label' => "Permettre une sélection multiple de choix par participant jusqu'à un maximum de",
	'poll:max_votes:desc' => "Si vous saisissez un nombre supérieur à 1, le sondage va devenir un sondage à choix multiple qui permet aux participants de sélectionner plusieurs choix jusqu'à un maximum de choix défini ici. Vous ne pouvez pas saisir un nombre plus grand que le nombre total de choix du sondage.",
	'poll:max_votes:exceeded' => "Le nombre maximum de choix sélectionnable ne peut pas dépasser le nombre total de choix du sondage.",
	'poll:max_votes:info' => "Vous pouvez sélectionner plusieurs choix jusqu'à un maximum de %s pour votre vote.",
	'poll:max_votes:not_allowed_hint' => "ATTENTION: quand ce sondage a été créé la configuration du site autorisait des sondages à choix multiples, mais cette fonctionnalité n'est plus activée. Actuellement ce sondage permet aux votants de sélectionner jusqu'à %s choix lorsqu'ils votent, et ce nombre ne sera pas modifié à moins que vous ne modifiiez les choix du sondage. Mais si vous modifiez les choix du sondage, le nombre maximum de choix pour les votants sera réinitialisé à 1.",

	/**
	 * Poll widget
	 **/
	'poll:latest_widget_title' => "Sondages récents",
	'poll:latest_widget_description' => "Affiche les sondages les plus récents.",
	'poll:latestgroup_widget_title' => "Derniers sondages du groupe",
	'poll:latestgroup_widget_description' => "Affiche les derniers sondages du groupe.",
	'poll:my_widget_title' => "<i class=\"fa fa-pie-chart\"></i> Mes sondages",
	'poll:my_widget_description' => "Ce widget affiche vos propres sondages.",
	'poll:widget:label:displaynum' => "Combien de sondages afficher ?",
	'poll:individual' => "Sondage à la Une",
	'poll_individual:widget:description' => "Affiche le \"Sondage à la Une\" du site.",
	'poll:widget:no_poll' => "Il n'y a aucun sondage pour %s pour le moment.",
	'poll:widget:nonefound' => "Aucun sondage.",
	'poll:widget:think' => "Dites à %s ce que vous en pensez !",
	'poll:enable_poll' => "Activer les sondages",
	'poll:noun_response' => "vote",
	'poll:noun_responses' => "votes",
	'poll:settings:yes' => "oui",
	'poll:settings:no' => "non",

	'poll:month:01' => 'Janvier',
	'poll:month:02' => 'Février',
	'poll:month:03' => 'Mars',
	'poll:month:04' => 'Avril',
	'poll:month:05' => 'Mai',
	'poll:month:06' => 'Juin',
	'poll:month:07' => 'Juillet',
	'poll:month:08' => 'Août',
	'poll:month:09' => 'Septembre',
	'poll:month:10' => 'Octobre',
	'poll:month:11' => 'Novembre',
	'poll:month:12' => 'Décembre',

	/**
	 * Notifications
	 **/
	'poll:new' => 'Un nouveau sondage',
	'poll:notify:summary' => "Nouveau sondage intitulé %s",
	'poll:notify:subject' => 'Nouveau sondage : %s',
	'poll:notify:body' =>'
%s a créé un nouveau sondage :

%s

Afficher le sondage et voter :
%s
',
	'poll:notification_on_vote:subject' => "Nouveau vote sur le sondage",
	'poll:notification_on_vote:body' => "%s,\n\nun nouveau vote a été ajouté pour votre sondage \"%s\".\n\nVous pouvez afficher les résultats actuel via ce lien : \n\n%s\n",

	/**
	 * Poll river
	 **/
	'poll:settings:create_in_river:title' => "Afficher les sondages dans le fil d'activité ?",
	'poll:settings:vote_in_river:title' => "Afficher les votes sur les sondages dans le fil d'activité ?",
	'poll:settings:send_notification:title' => "Envoyer une notification lorsqu'un nouveau sondage est créé ?",
	'poll:settings:send_notification:desc' => "(les membres ne recevront de notification que s'ils sont en contact avec l'auteur du sondage, ou membre du groupe où le sondage a été publié. De plus, les notifications ne seront envoyées qu'aux membres dont les paramètres de notification permettent l'envoi de notifications)",
	'river:create:object:poll' => '%s a créé le sondage %s',
	'river:update:object:poll' => '%s a mis à jour le sondage %s',
	'river:vote:object:poll' => '%s a voté sur le sondage %s',
	'river:comment:object:poll' => '%s a commenté le sondage %s',

	/**
	 * Status messages
	 */
	'poll:added' => "Votre sondage a bien été créé.",
	'poll:edited' => "Votre sondage a bien été enregistré.",
	'poll:responded' => "Merci d'avoir répondu, votre vote a bien été enregistré.",
	'poll:deleted' => "Votre sondage a bien été supprimé.",
	'poll:totalvotes' => "Nombre total de votes : ",
	'poll:voted' => "Votre vote a bien été enregistré. Merci d'avoir voté sur ce sondage.",
	'poll:poll_reset_success' => "Le sondage a bien été réinitialisé.",
	'poll:upgrade' => 'Mise à niveau',
	'poll:upgrade:success' => 'Mise à niveau du plugin Poll réussie.',

	/**
	 * Error messages
	 */
	'poll:blank' => "Désolé : vous devez indiquer au moins une question, et ajouter au moins un choix pour le vote avant de pouvoir enregistrer votre sondage.",
	'poll:alreadyvoted' => "Désolé : vous ne pouvez répondre qu'une seule fois.",
	'poll:novote' => "Désolé : vous devez choisir une option pour voter dans ce sondage.",
	'poll:notfound' => "Désolé : impossible de trouver le sondage correspondant.",
	'poll:notdeleted' => "Désolé : impossible de supprimer ce sondage.",
	'poll:poll_reset_denied' => "Désolé : vous n'avez pas l'autorisation de réinitialiser ce sondage.",
	
);