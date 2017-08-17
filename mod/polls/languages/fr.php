<?php

	$french = array(
	
		/**
		 * Menu items and titles
		 */
'poll' => 	"Sondage",
'polls:add' => "Nouveau sondage",
'polls' => "Sondages",
'polls:votes' => "Votes",
'polls:user' => "Sondage de %s",
'polls:group_polls' => "Sondages de groupe",
'polls:group_polls:listing:title' => "Sondage de %s",
'polls:user:friends' => "Sondage de votre collègues %s",
'polls:your' => "Vos sondages",
'polls:not_me' => "%s's sondages",
'polls:posttitle' => "%s's sondages: %s",
'polls:friends' => "Sondages de collègues",
'polls:not_me_friends' => "Sondages des amis de %s's",
'polls:yourfriends' => "Les derniers sondages de vos amis",
'polls:everyone' => "Tous les sondages du site",
'polls:read' => "Consulter le sondage",
'polls:addpost' => "Créer un sondage",
'polls:editpost' => "Modifier un sondage : %s",
'polls:edit' => "Modifier un sondage",
'polls:text' => "Texte du sondage",
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
'polls:settings:no' => "Non",
'polls:settings:group_profile_display:title' => "Si les sondages du groupe sont activés, où doit être affiché le contenu des sondages au groupe?",
'polls:settings:group_profile_display_option:left' => "gauche",
'polls:settings:group_profile_display_option:right' => "droit",
'polls:settings:group_profile_display_option:none' => "aucun",
'polls:settings:group_access:title' => "Si les sondages du groupes sont activés, qui a le droit de créer des sondages?",
'polls:settings:group_access:admins' => "Les propriétaires et les administrateurs du groupe seulement",
'polls:settings:group_access:members' => "Tout membre du groupe",
'polls:none' => "Aucun sondage trouvé.",
'polls:permission_error' => "Vous n'avez pas la permission de modifier ce sondage.",
'polls:vote' => "Vote",
'polls:login' => "Veuillez ouvrir une session si vous souhaitez participer à ce sondage.",
'group:polls:empty' => "Pas de sondages",
'polls:settings:site_access:title' => "Qui peut créer l'ensemble du site sondages?",
'polls:settings:site_access:admins'	 => "Administrateurs seulement",
'polls:settings:site_access:all' => "Tous les utilisateurs connectés",
'polls:can_not_create' => "Vous n'avez pas la permission de créer des sondages.",
		
     // poll widget		
		
'polls:latest_widget_title' => "Derniers sondages collectifs",
'polls:latest_widget_description' => "Affiche les plus récents sondages.",
'polls:my_widget_title' => "Mes sondages",
'polls:my_widget_description' => "Ce widget n'affiche pas vos sondages.",
'polls:widget:label:displaynum' => "Combien de sondage vous souhaitez afficher?",
'polls:individual' => "Dernier sondage",
'poll_individual_group:widget:description' => "Afficher le plus récent sondage pour ce groupe.",
'poll_individual:widget:description' => "Afficher votre plus récent sondage",
'polls:widget:no_polls' => "Il n'y a pas encore de sondage pour %s.",
'polls:widget:nonefound' => "Aucun sondage trouvé.",
'polls:widget:think' => "Dites à %s ce que vous pensez.",
'polls:enable_polls' => "Activer les sondages",
'polls:group_identifier' => "(dans %s)",
'polls:noun_response' => "réponse",
'polls:noun_responses' => "réponses",
'polls:settings:yes' => "oui",
'polls:settings:no' => "non",
		
		
     // poll river		
		
'polls:settings:create_in_river:title' => "Afficher le sondage dans le fil d'activité",
'polls:settings:vote_in_river:title' => "Afficher les votes du sondage dans le fil d'activité",
'river:create:object:poll' => '%s a créé un sondage %s',
'river:vote:object:poll' => '%s a participé au sondage %s',
'river:comment:object:poll' => '%s a fait un commentaire sur le sondage %s',
		
 // Status messages		
		
		
'polls:added' => "Votre sondage a été créé.",
'polls:edited' => "Votre sondage a été sauvegardé.",
'polls:responded' => "Merci d'avoir répondu, votre vote a été enregistré.",
'polls:deleted' => 	"Votre sondage a été supprimé avec succès.",
'polls:totalvotes' => "Nombre total de votes: ",
'polls:voted' => "Votre vote a été fait pour ce sondage. Merci d'avoir pris le temps de voter sur ce sondage.",
		
 // Error messages		
		
'polls:save:failure' => "Votre vote n'a pas été enregistré pour ce sondage. Veuillez essayer à nouveau.",
'polls:blank' => "Désolé, vous devez compléter les questions et les réponses avant de créer votre sondage.",
'polls:novote' => "Désolé, vous devez choisir un choix afin de voter à ce sondage.",
'polls:notfound' => "Désolé, il nous est impossible de trouver le sondage demandé.",
'polls:nonefound' => "Aucun sondage n'a été trouvé de %s",
'polls:notdeleted' => "Désolé, il nous est impossible de supprimer ce sondage."

	);
					
	add_translation("fr",$french);

?>