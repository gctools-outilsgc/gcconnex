<?php

	$french = array(
	
		/**
		 * Menu items and titles
		 */
			'poll' => "Sondage",
		    'polls:add' => "Nouveau sondage",
			'polls' => "Sondages",
			'polls:votes' => "Votes",
			'polls:user' => "Sondage a %s",
			'polls:group_polls' => "Sondages de groupe",
			'polls:group_polls:listing:title' => "Sondage a %s",
			'polls:user:friends' => "Sondage collègues %s",
			'polls:your' => "Vos sondages",
			'polls:not_me' => "%s's polls",
			'polls:posttitle' => "%s's polls: %s",
			'polls:friends' => "sondages collègues",
			'polls:not_me_friends' => "%s's friend's polls",
			'polls:yourfriends' => "Your friends' latest polls",
			'polls:everyone' => "Tous les sondages du site",
			'polls:read' => "lire sondage",
			'polls:addpost' => "Créer un sondage",
			'polls:editpost' => "Éditer un sondage: %s",
			'polls:edit' => "Éditer un sondage",
			'polls:text' => "Sondage texte",
			'polls:strapline' => "%s",			
			'item:object:poll' => 'Sondages',
			'item:object:poll_choice' => "Choix du sondage",
			'polls:question' => "Question du sondage",
			'polls:responses' => "Les choix de réponse",
			'polls:results' => "[+] Voir les résultats",
			'polls:show_results' => "Afficher les résultats",
			'polls:show_poll' => "Montrer sondage",
			'polls:add_choice' => "Ajouter choix de réponse",
			'polls:delete_choice' => "Supprimer ce choix",
			'polls:settings:group:title' => "Sondages de groupe",
			'polls:settings:group_polls_default' => "Oui, par défaut",
			'polls:settings:group_polls_not_default' => "Oui, désactivé par défaut",
			'polls:settings:no' => "no",
			'polls:settings:group_profile_display:title' => "Si les sondages du groupe sont activés, où doit être affiché le contenu sondages au groupe?",
			'polls:settings:group_profile_display_option:left' => "gauche",
			'polls:settings:group_profile_display_option:right' => "droit",
			'polls:settings:group_profile_display_option:none' => "aucun",
			'polls:settings:group_access:title' => "Si les sondages sont activés groupe, qui a le droit de créer des sondages?",
			'polls:settings:group_access:admins' => "Les propriétaires et les administrateurs de groupe seulement",
			'polls:settings:group_access:members' => "Tout membre du groupe",
			'polls:none' => "Aucun sondage trouvé.",
			'polls:permission_error' => "Vous n'avez pas la permission d'éditer ce sondage.",
			'polls:vote' => "Vote",
			'polls:login' => "S'il vous plaît vous connecter si vous souhaitez participer à ce sondage.",
			'group:polls:empty' => "Pas de sondages",
			'polls:settings:site_access:title' => "Qui peut créer l'ensemble du site sondages?",
			'polls:settings:site_access:admins' => "Admins only",
			'polls:settings:site_access:all' => "Any logged-in user",
			'polls:can_not_create' => "You do not have permission to create polls.",
		/**
	     * poll widget
	     **/
			'polls:latest_widget_title' => "Derniers sondages collectifs",
			'polls:latest_widget_description' => "Affiche les plus récents sondages.",
			'polls:my_widget_title' => "My polls",
			'polls:my_widget_description' => "This widget will display your polls.",
			'polls:widget:label:displaynum' => "How many polls you want to display?",
			'polls:individual' => "Dernier sondage",
			'poll_individual_group:widget:description' => "Afficher le plus récent sondage pour ce groupe.",
			'poll_individual:widget:description' => "Display your latest poll",
			'polls:widget:no_polls' => "Il n'y a pas encore sondages pour %s.",
			'polls:widget:nonefound' => "No polls found.",
			'polls:widget:think' => "Indiquez à %s ce que vous pensez.",
			'polls:enable_polls' => "Activer les sondages",
			'polls:group_identifier' => "(in %s)",
			'polls:noun_response' => "response",
			'polls:noun_responses' => "responses",
	        'polls:settings:yes' => "yes",
			'polls:settings:no' => "no",
			
         /**
	     * poll river
	     **/
	        'polls:settings:create_in_river:title' => "Show poll creation in activity river",
			'polls:settings:vote_in_river:title' => "Show poll voting in activity river",
			'river:create:object:poll' => '%s a créé un sondage %s',
			'river:vote:object:poll' => '%s a participé au sondage %s',
			'river:comment:object:poll' => '%s commented on the poll %s',
		/**
		 * Status messages
		 */
	
			'polls:added' => "Your poll was created.",
			'polls:edited' => "Your poll was saved.",
			'polls:responded' => "Thank you for responding, your vote was recorded.",
			'polls:deleted' => "Your poll was successfully deleted.",
			'polls:totalvotes' => "Total number of votes: ",
			'polls:voted' => "Your vote has been cast for this poll. Thank you for voting on this poll.",
			
	
		/**
		 * Error messages
		 */
	
			'polls:save:failure' => "Your poll could not be saved. Please try again.",
			'polls:blank' => "Sorry: you need to fill in both the question and responses before you can make a poll.",
			'polls:novote' => "Sorry: you need to choose an option to vote in this poll.",
			'polls:notfound' => "Sorry: we could not find the specified poll.",
			'polls:nonefound' => "No polls were found from %s",
			'polls:notdeleted' => "Sorry: we could not delete this poll."
	);
					
	add_translation("fr",$french);

?>