<?php
/**
 * ideas French language file
 */

$french = array(

	/**
	 * Menu items and titles
	 */
'ideas:filter:top' => 'Meilleures',
'ideas:filter:hot' => 'Populaires',
'ideas:filter:new' => 'Nouvelles',
'ideas:filter:accepted' => 'Acceptées',
'ideas:filter:completed' => 'Terminées',
'ideas:filter:all' => 'Toutes',		
'item:object:idea' => 'Idées',
'river:create:object:idea' => "%s a soumis l'idée %s",
'river:comment:object:idea' => "%s a commenté l'idée %s",
'river:update:object:idea' => "%s a modifié l'idée %s",		
'ideas' => "Idées",
'ideas:add' => "Ajouter une idée",
'ideas:edit' => "Modifier une idée",
'ideas:new' => "Une nouvelle idée",
'ideas:settings' => "Paramètres",		
'ideas:all' => "Toutes les idées",
'ideas:owner' => "Idées de %s",
'ideas:friends' => "Idées des contacts",
'ideas:idea:edit' => "Modifier cette idée",
'ideas:idea:add' => "Ajouter cette idée",		
'ideas:group:settings:title' => "Paramètres des idées du groupe %s",
'ideas:group_settings' => "Paramètres",
'ideas:enableideas' => "Activer la fonctionnalité des idées",
'ideas:group' => 'Idées du groupe',
'ideas:group:idea' => 'Idées du groupe',
'ideas:same_group' => "Dans le groupe correspondant :",
'ideas:view:all' => "Voir tout",		
		
 // Content		
		
'ideas:yourvotes' => "Vos votes :",
'ideas:vote' => "Votez :",		
'ideas:status' => "Statut :",
'ideas:state' => "État :",
'ideas:status_info' => "Information sur le statut :",
'ideas:open' => 'Ouverte',
'ideas:under_review' => "En cours d'évaluation",
'ideas:planned' => 'Planifiée',
'ideas:started' => 'Commencée',
'ideas:completed' => 'Terminée',
'ideas:declined' => 'Refusée',
'ideas:minorchange' => "Changement mineur. Votre modification ne sera pas affiché dans votre fil d'activité et celui du groupe, sauf si vous avez modifié le statut de l'idée.",				
'ideas:none' => "Il n'y a présentement pas d'idée.",
'ideas:novoteleft' => "aucun vote restant.",
'ideas:onevoteleft' => "un vote restant.",
'ideas:votesleft' => "%s votes restants.",	
'ideas:search' => "Cherchez ou soumettez une idée :",
'ideas:charleft' => "Caractères restants.",		
'ideas:search:noresult_nogroupmember' => "Aucune idée trouvée, cherchez à nouveau.",
'ideas:search:result_vote_submit' => "Idées trouvée. Votez ou ",
'ideas:search:result_novote_submit' => "Idées trouvées. Changez vos votes ou ",
'ideas:search:noresult_submit' => "Aucune idée trouvée. Cherchez à nouveau ou ",
'ideas:search:skip_words' => "une,sans,avec,des,dans,pour,car,que,qui,mais,est,donc,elle,elles,nous,vous,ils,son,ses,ici,oui,non,toi,ton", // write words you want to skip separate by coma. Automaticaly skip word less than 3 chars, don't write them.		
'ideas:add' => "soumettez une nouvelle idée",		
'ideas:settings:points' => "Nombre de points de vote",
'ideas:settings:question' => "Question",
'ideas:settings:ideas_submit_idea_without_point' => "Soumettez une idée sans utiliser les points",
'ideas:settings:ideas_submit_idea_without_point_string' => "Vérifiez si vous voulez offrir la possibilité aux membres du groupe de soumettre des idées sans attribuer des points.",
		
// Widget and bookmarklet		
		
'ideas:widget:title' => "Idées",
'ideas:widget:description' => "Afficher les idées les plus votées.",
'ideas:more' => "Plus d'idées",
'ideas:numbertodisplay' => "Nombre d'idées à afficher ",
'ideas:typetodisplay' => "Afficher par ",
'ideas:widget:points_left:title' => "Votes restants",
'ideas:widget:points_left:description' => "Afficher les votes restants dans les idées des groupes dont vous êtes membre.",
		
 // Status messages		
		
'ideas:idea:rate:submitted' => "Votre vote a bien été pris en compte.",
'ideas:idea:save:success' => "Votre idée a bien été enregistrée.",
'ideas:idea:delete:success' => "Votre idée a bien été supprimée.",
'ideas:idea:delete:failed' => "Une erreur s'est produite lorsque l'idée a été supprimée.",		
'ideas:idea:save:empty' => "Vous devez définir un titre et une description.",
'ideas:idea:save:failed' => "Une erreur s'est produite lors de la sauvegarde de l'idée.",		
'ideas:group:settings:failed' => "Le groupe n'est pas défini ou vous n'êtes pas autorisé à modifier ce groupe.",
'ideas:group:settings:save:success' => "Les paramètres ont été enregistrés.",
		
	
 // Error messages		
		
'ideas:idea:rate:error:ajax' => "Erreur de connexion avec le serveur.",
'ideas:unknown_idea' => "Idée inconnue.",
'ideas:idea:rate:error' =>  "Votre vote n'a pas pu être pris en compte à cause d'une erreur sur le serveur.",
'ideas:idea:rate:error:underzero' => "Le nombre de votes restant ne vous permet pas de voter pour cette idée.",
  
    // NEW MESSAGING TO BE TRANSLATED 		
		
'ideas:idea:rate:error:updateerror' => "Une erreur est survenue en changeant votre vote. Veuillez essayer à nouveau.",
'ideas:idea:rate:error:voteagain' => "Vous ne pouvez pas voter plus d'une fois sur la même idée. Voulez-vous changer votre vote?",
'ideas:idea:rate:changevote' => "Votre vote a été changé.",
'ideas:group:newideas' => "Récentes idées du groupe",
'ideas:filter:tagcloud' => "Tag cloud",
'ideas:group:nonmember' => "<div class='alert'>Vous devez être membre de ce groupe pour voter ou soumettre une idée</div>",
    		
    // CHANGED MESSAGING TO BE TRANSLATED 	
		
'ideas:idea:rate:error:value' => "Une erreur est survenue en enregistrant votre vote. Veuillez essayer à nouveau.",
		
 // Notify messages		
	 			
'ideas:notify:subject' => "Une idée à laquelle vous avez voté est %s.",
'ideas:notify:body' => "L'idée <a href=\"%s\">%s</a> est %s.<br><br>Vous avez récupéré les points que vous aviez mis pour cette idée.<br><br><a href=\"%s\">Aller dans les idées du groupe %s</a>",

);

add_translation('fr', $french);
