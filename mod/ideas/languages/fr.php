<?php
/**
 * ideas French language file
 */

$french = array(

	/**
	 * Menu items and titles
	 */

	'ideas:filter:top' => "Meilleures",
	'ideas:filter:hot' => "Populaires",
	'ideas:filter:new' => "Nouvelles",
	'ideas:filter:accepted' => "Acceptées",
	'ideas:filter:finished' => "Terminées",
	'ideas:filter:all' => "Toutes",

	'item:object:idea' => 'Idées',
	'river:create:object:idea' => "%s a soumis l'idée %s",
	'river:comment:object:idea' => "%s a commenté l'idée %s",
	'river:update:object:idea' => "%s a modifié l'idée %s",

	'ideas' => "Idées",
	'ideas:add' => "Ajouter une idée",
	'ideas:edit' => "Éditer une idée",
	'ideas:new' => "Une nouvelle idée",

	'ideas:all' => "Toutes les idées",
	'ideas:owner' => "Idées de %s",
	'ideas:friends' => "Idées des contacts",
	'ideas:idea:edit' => "Éditer cette idée",
	'ideas:idea:add' => "Ajouter cette idée",

	'ideas:group:settings:title' => "Options des idées du groupe %s",
	'ideas:group_settings' => "Options des idées",
	'ideas:enableideas' => "Active les idées",
	'ideas:group' => 'Idées du groupe',
	'ideas:group:idea' => 'Idées du groupe',
	'ideas:same_group' => "Dans le même groupe :",
	'ideas:view:all' => "Voir tout",

	'ideas:group:image' => '<span class="bpideas">Idées du groupe</span><img src="/mod/ideas/graphics/BP-fr.gif" alt="Objectif 2020 Idées" />',

	/**
	 * Content
	 */
	'ideas:yourvotes' => "Vos votes :",
	'ideas:vote' => "Vote :",

	'ideas:status' => "Statut :",
	'ideas:state' => "État :",
	'ideas:status_info' => "Information sur le statut :",
	'ideas:open' => 'Ouverte',
	'ideas:under_review' => "En cours d'évaluation",
	'ideas:planned' => 'Planifiée',
	'ideas:started' => 'Commencée',
	'ideas:completed' => 'Terminée',
	'ideas:declined' => 'Déclinée',
	'ideas:minorchange' => "Changement mineur. Votre modification ne sera pas notifiée dans votre flux et celui du groupe, sauf si vous avez changé le statut de l'idée.",

	'ideas:settings:status' => "Changer l'intitulé des statuts",
	'ideas:settings:status:accepted' => "Avec ces statuts, les points sont dépensés.",
	'ideas:settings:status:finished' => "Avec ces statuts, les points sont rendus.",

	'ideas:none' => "Il n'y a présentement pas d'idée.",
	'ideas:novoteleft' => "vote restant.",
	'ideas:onevoteleft' => "vote restant.",
	'ideas:votesleft' => "votes restants.",

	'ideas:search' => "Cherchez ou soumettez une idée :",
	'ideas:charleft' => "caractères restants.",

	'ideas:search:noresult_nogroupmember' => "Aucune idée trouvée, cherchez autre chose.",
	'ideas:search:result_vote_submit' => "Votez pour ces idées ou ",
	'ideas:search:result_novote_submit' => "Idées trouvées. Changez vos votes ou ",
	'ideas:search:result_novote_nosubmit' => "Des idées ont été trouvées mais vous n'avez plus de point. Changez vos votes si vous voulez soumettre une nouvelle idée.",
	'ideas:search:noresult_nosubmit' => "Aucune idée trouvée, cherchez autre chose. Vous devez changer vos votes si vous voulez soumettre une nouvelle idée.",
	'ideas:search:noresult_submit' => "Aucune idée trouvée. Cherchez autre chose ou ",
	'ideas:search:skip_words' => "une,sans,avec,des,dans,pour,car,que,qui,mais,est,donc,elle,elles,nous,vous,ils,son,ses,ici,oui,non,toi,ton", // write words you want to skip separate by coma. Automaticaly skip word less than 3 chars, don't write them.

	'ideas:add' => "soumettez une nouvelle idée",

	'ideas:settings:points' => "Nombre de points",
	'ideas:settings:question' => "Question",

	/**
	 * Widget and bookmarklet
	 */
	'ideas:widget:title' => "Idées",
	'ideas:widget:description' => "Afficher les idées les plus votées.",
	'ideas:more' => "Plus d'idées",
	'ideas:numbertodisplay' => "Nombre d'idées à afficher ",
	'ideas:typetodisplay' => "Afficher par ",
	'ideas:widget:points_left:title' => "Votes restants",
	'ideas:widget:points_left:description' => "Affiche vos votes restants dans les idées des groupes dont vous êtes membre.",

	/**
	 * Status messages
	 */
	'ideas:idea:rate:submitted' => "Votre vote a bien été pris en compte.",
	'ideas:idea:save:success' => "Votre idée a bien été enregistrée.",
	'ideas:idea:delete:success' => "Votre idée a bien été supprimée.",
	'ideas:idea:delete:failed' => "Une erreur s'est produite lors de la suppression de l'idée.",

	'ideas:idea:save:empty' => "Vous devez définir un titre et une description.",
	'ideas:idea:save:failed' => "Une erreur s'est produite lors de la sauvegarde de l'idée.",

	'ideas:group:settings:failed' => "Le groupe n'est pas défini ou vous n'êtes pas autorisé à éditer ce groupe.",
	'ideas:group:settings:save:success' => "Les paramètres ont été enregistrés.",
	'ideas:settings:ideas_submit_idea_without_point' => "Soumettre une idée sans avoir de point",
	'ideas:settings:ideas_submit_idea_without_point_string' => "Cochez si vous souhaitez que les membres du groupe puissent soumettre une idée sans avoir de point. Attention, cela offre la possibilité aux utilisateurs de soumettre beaucoup d'idées sans gage de qualité.",
	'ideas:settings:separate_tabs' => "Séparer les onglets",
	'ideas:settings:separate_tabs:info' => "Laisser vide un champ permet de ne pas utiliser et afficher un status.",
	'ideas:settings:ideas_separate_accepted_tabs' => "Afficher les onglets des status \"En cours d'évaluation\", \"Planifiée\" et \"Commencée\" au lieu de les regrouper dans l'onglet \"Acceptées\".",
	'ideas:settings:ideas_separate_finished_tabs' => "Afficher les onglets des status \"Terminée\" et \"Déclinée\" au lieu de les regrouper dans l'onglet \"Terminées\".",

	/**
	 * Error messages
	 */
	'ideas:idea:rate:error:ajax' => "Erreur de connexion avec le serveur.",
	'ideas:unknown_idea' => "Idée inconnue.",
	'ideas:idea:rate:error' => "Votre vote n'a pas pu être pris en compte à cause d'une erreur sur le serveur.",
	'ideas:idea:rate:error:underzero' => "Le nombre de votes restant ne vous permet pas de voter pour cette idée.",

    /* NEW MESSAGING TO BE TRANSLATED */
    'ideas:idea:rate:error:updateerror' => "Une erreur est survenue en changeant votre vote. Veuillez ré-essayer à nouveau.",
    'ideas:idea:rate:error:voteagain' => "Vous ne pouvez voter plus d'une fois sur la même idée. Voulez-vous changer votre vote?",
    'ideas:idea:rate:changevote' => "Votre vote a été changé.",
    'ideas:group:newideas' => "Idées récentes du groupe",
    'ideas:group:nonmember' => "<div class='alert'>Vous devez être membre de ce groupe pour voter ou soumettre une idée</div>",

    /* CHANGED MESSAGING TO BE TRANSLATED */
    'ideas:idea:rate:error:value' => "Une erreur est survenue en enregistrant votre vote. Veuillez essayer à nouveau.",

	/*
	 * Notify messages
	 */
	'ideas:notify:subject' => "Une idée à laquelle vous avez voté est %s.",
	'ideas:notify:body' => "L'idée <a href=\"%s\">%s</a> est %s.<br><br>Vous avez récupéré les points que vous aviez mis pour cette idée.<br><br><a href=\"%s\">Aller dans les idées du groupe %s</a>",

);

add_translation('fr', $french);
