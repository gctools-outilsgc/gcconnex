<?php

return [
	'answers' => 'Réponses',
	'answers:addyours' => 'Ajoutez votre réponse',

	/**
	 * General stuff
	 */
	'item:object:answer' => "Réponses",
	'item:object:question' => "Questions",

	// admin
	'admin:upgrades:set_question_status' => "Préciser l'état de toutes les questions",
	'admin:upgrades:set_question_status:description' => "Assurez-vous que toutes les questions ont un champ de métadonnées d'état. Les questions plus anciennes ne les auront pas par défaut.",

	/**
	 * Menu items
	 */
	'questions:menu:user_hover:make_expert' => "Créer un expert en questions",
	'questions:menu:user_hover:make_expert:confirm' => "Êtes-vous sûr que vous voulez créer cet utilisateur un expert en questions de %s",
	'questions:menu:user_hover:remove_expert' => "Enlever un expert en questions",
	'questions:menu:user_hover:remove_expert:confirm' => "Êtes-vous sûr que vous voulez enlever cet utilisateur un expert en questions de %s ?",

	'questions:menu:entity:answer:mark' => "Ceci est correcte",
	'questions:menu:entity:answer:unmark' => "Ceci n’est plus correcte",

	'questions:menu:filter:todo' => "à Faire",
	'questions:menu:filter:todo_group' => "Créer Groupe à Faire",
	'questions:menu:filter:experts' => "Experts",

	'river:create:object:question' => '%s demandés questions %s',
	'river:create:object:answer' => '%s a fourni une réponse pour question %s',

	'questions' => 'Questions',
	'questions:asked' => 'Demandées par %s',
	'questions:answered' => 'Répondue dernièrement par %s %s',
	'questions:answered:correct' => 'Réponse correcte fournie par %s %s',

	'questions:everyone' => 'Tous Questions',
	'questions:add' => 'Ajoutez une question',
	'questions:todo' => 'à Faire',
	'questions:todo:none' => 'Il n’y a rien à faire. Continuer le bon travail!',
	'questions:owner' => "Questions de %s",
	'questions:none' => "Aucune question n'a encore été soumise.",
	'questions:group' => 'Questions de groupe',
	'questions:enable' => 'Activer questions de groupe',

	'questions:edit:question:title' => 'Question',
	'questions:edit:question:description' => "Détails",
	'questions:edit:question:container' => "Où devrait-on classé cette question",
	'questions:edit:question:container:select' => "Veuillez choisir un groupe",
	'questions:edit:question:move_to_discussions' => "Déplacer aux discussions",
	'questions:edit:question:move_to_discussions:confirm' => "Êtes-vous sûr que vous vouliez déplacer ces questions aux discussions? Cette étape ne peut pas être annulée!",

	'questions:object:answer:title' => "Réponse à question %s",

	/**
	 * experts page
	 */
	'questions:experts:title' => "Experts",
	'questions:experts:none' => "Aucun expert n'a encore été assigné pour %s.",
	'questions:experts:description:group' => "Veuillez trouver ci-dessus un liste des experts pour% s. Ces personnes ressources aideront à répondre aux questions",
	'questions:experts:description:site' => "Vous trouverez ci-dessous une liste des experts du site. Ces personnes aideront à répondre aux questions, tant sur le site que dans les groupes.",

	/**
	 * notifications
	 */
	'questions:notifications:create:subject' => "Une nouvelle question a été posée",
	'questions:notifications:create:summary' => "Une nouvelle question a été posée",
	'questions:notifications:create:message' => "Bonjour %s

La question: %s a été possée.

Pour répondre, visitez:
%s",
	'questions:notifications:move:subject' => "Une question a été déplacée",
	'questions:notifications:move:summary' => "Une question a été déplacée",
	'questions:notifications:move:message' => "Bonjour %s

La question: %s a été déplacee et vous devriez répondre.

Pour répondre, visitez:
%s",

	'questions:notifications:answer:create:subject' => "Une réponse a été fournie sur %s",
	'questions:notifications:answer:create:summary' => "Une réponse a été fournie sur %s",
	'questions:notifications:answer:create:message' => "Bonjour %s

%s a fourni une réponse pour la question '%s'.

%s

Pour répondre, visitez:
%s",
	'questions:notifications:answer:correct:subject' => "Une réponse a été marquée comme la réponse correcte pour la question %s",
	'questions:notifications:answer:correct:summary' => "Une réponse a été marquée comme la réponse correcte pour la question %s",
	'questions:notifications:answer:correct:message' => "Bonjour %s

%s a marqué une réponse comme la réponse correcte pour la question '%s'.

%s

Pour répondre, visitez:
%s",
	'questions:notifications:answer:comment:subject' => "Nouveau commentaire sur une réponse",
	'questions:notifications:answer:comment:summary' => "Nouveau commentaire sur une réponse",
	'questions:notifications:answer:comment:message' => "Bonjour %s

%s a fourni une commentaire pour la réponse '%s'.

%s

Pour répondre, visitez:
%s",

	'questions:daily:notification:subject' => "Vue d'ensemble de la charge de travail des questions quotidiennes",
	'questions:daily:notification:message:more' => "Voir plus",
	'questions:daily:notification:message:overdue' => "Les questions suivantes sont en retard",
	'questions:daily:notification:message:due' => "Les questions suivantes doivent être résolues aujourd'hui",
	'questions:daily:notification:message:new' => "Nouvelles questions posées",

	'questions:notification:auto_close:subject' => "La question '%s' est fermée en raison de l'inactivité",
	'questions:notification:auto_close:summary' => "La question '%s' est fermée en raison de l'inactivité",
	'questions:notification:auto_close:message' => "Bonjour %s,

Votre question '%s' est inactive depuis plus que %s jours. Pour cette raison, la question est fermée.

Pour répondre, visitez:
%s",

	/**
	 * answers
	 */
	'questions:answer:edit' => "Actualiser la réponse",
	'questions:answer:checkmark:title' => "%s a marqué ceci comme la réponse correcte sur %s",

	'questions:search:answer:title' => "Réponse",

	/**
	 * plugin settings
	 */
	'questions:settings:general:title' => "Réglages généraux",
	'questions:settings:general:close' => "Fermez une question quand elle obtient une réponse marquée correcte",
	'questions:settings:general:close:description' => "Lorsque la réponse à une question est marquée comme correcte, fermez la question. Cela signifie que plus de réponses peuvent être données.",
	'questions:settings:general:solution_time' => "Définir un temps de solution par défaut en jours",
	'questions:settings:general:solution_time:description' => "Les questions doivent être répondues avant l'expiration de ce délai, les groupes peuvent remplacer ce paramètre par leur propre limite de temps. 0 pour aucune limite.",
	'questions:settings:general:auto_close_time' => "Fermez les questions automatiquement après un certain nombre de jours",
	'questions:settings:general:auto_close_time:description' => "Les questions qui ne sont pas encore fermées après un certain nombre de jours seront automatiquement fermées. 0 ou vide pour aucune fermeture automatique",
	'questions:settings:general:solution_time_group' => "Les propriétaires de groupes peuvent modifier la période de temps de la solution par défaut",
	'questions:settings:general:solution_time_group:description' => " Si elle n'est pas autorisée, les groupes utiliseront la période de temps défaut de la solution tel que défini ci-dessus.",
	'questions:settings:general:limit_to_groups' => "Limiter les questions uniquement au contexte du groupe",
	'questions:settings:general:limit_to_groups:description' => "Si défini comme 'oui', les questions ne peuvent plus être faites dans le contexte personnel.",

	'questions:settings:experts:title' => "Paramètres d'expert en Q&R",
	'questions:settings:experts:enable' => "Activer des rôles d'experts",
	'questions:settings:experts:enable:description' => "Les experts ont des privilèges spéciaux et peuvent être nommés par les administrateurs du site et les propriétaires des groupes.",
	'questions:settings:experts:answer' => "Seuls les experts peuvent répondre à une question",
	'questions:settings:experts:mark' => "Seuls les experts peuvent marquées une question comme correcte",

	'questions:settings:access:title' => "Paramètres d'accès",
	'questions:settings:access:personal' => "Quel sera le niveau d'accès pour les questions personnelles",
	'questions:settings:access:group' => "Quel sera le niveau d'accès pour les questions de groupe",
	'questions:settings:access:options:user' => "Défini par l’utilisateur",
	'questions:settings:access:options:group' => "Membres du groupe",

	/**
	 * group settings
	 */
	'questions:group_settings:title' => "Paramètres des questions",

	'questions:group_settings:solution_time:description' => "Les questions doivent être répondues avant l'expiration de ce délai. 0 pour aucune limite.",

	'questions:group_settings:who_can_ask' => "Qui peut poser une question dans ce groupe",
	'questions:group_settings:who_can_ask:members' => "Tous membres",
	'questions:group_settings:who_can_ask:experts' => "Experts seulement",

	'questions:group_settings:who_can_answer' => "Qui peut répondre aux questions dans ce groupe",
	'questions:group_settings:who_can_answer:experts_only' => " L'administrateur du site a configuré que seulement les experts peuvent répondre aux questions.",

	'questions:group_settings:auto_mark_correct' => "Lorsqu'un expert crée une réponse, marquez-la automatiquement comme la correcte réponse",

	/**
	 * Widgets
	 */

	'widget:questions:title' => "Questions",
	'widget:questions:description' => "Vous pouvez regarder l'état de vos questions.",
	'widget:questions:content_type' => "Quelles questions à montrer",
	'widget:questions:more' => "Voir plus de questions",

	/**
	 * Actions
	 */

	'questions:action:answer:save:error:container' => "Vous n'avez pas la permission de répondre à cette question!",
	'questions:action:answer:save:error:body' => "Un contenu est requis: %s, %s",
	'questions:action:answer:save:error:save' => "Il y a eu un problème sauvegarder votre réponse!",
	'questions:action:answer:save:error:question_closed' => "La question que vous essayez de répondre est déjà fermée!",

	'questions:action:answer:toggle_mark:error:not_allowed' => "Vous n'êtes pas autorisé à marquer les réponses comme correcte",
	'questions:action:answer:toggle_mark:error:duplicate' => "Il y a déjà une réponse correcte à cette question",
	'questions:action:answer:toggle_mark:success:mark' => "La réponse est marquée comme la réponse correcte ",
	'questions:action:answer:toggle_mark:success:unmark' => "La réponse n'est plus marquée comme la réponse correcte ",

	'questions:action:question:save:error:container' => "Vous n'avez pas la permission de poser une question ici",
	'questions:action:question:save:error:body' => "Un titre et une description sont obligatoires: %s, %s",
	'questions:action:question:save:error:save' => "Il y a eu un problème sauvegarder votre question!",
	'questions:action:question:save:error:limited_to_groups' => "Les questions sont limitées au groupe, sélectionnez un groupe",

	'questions:action:question:move_to_discussions:error:move' => "Vous n'êtes pas autorisé à déplacer les questions aux discussions",
	'questions:action:question:move_to_discussions:error:topic' => "Une erreur s'est produite lors de la création du sujet de la discussion, veuillez essayer à nouveau",
	'questions:action:question:move_to_discussions:success' => "Les questions ont été déplacées à un sujet de discussion",

	'questions:action:toggle_expert:success:make' => "%s est maintenant un expert en questions pour %s",
	'questions:action:toggle_expert:success:remove' => "%s n’est plus un expert en questions pour  %s",

	'questions:action:group_settings:success' => "Les paramètres du groupe ont été sauvegardés",
];
