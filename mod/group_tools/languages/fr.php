<?php 

	$french = array(
	
		// general
		'group_tools:decline' => "Refuser",
		'group_tools:revoke' => "Révoquer",
		'group_tools:add_users' => "Ajouter des utilisateurs",
		'group_tools:in' => "dans",
		'group_tools:remove' => "Enlever",
		'group_tools:clear_selection' => "Effacer la sélection",
		'group_tools:all_members' => "Tous les membres",
		'group_tools:explain' => "Explication",
		'group_tools:default:access:group' => "Membres des groupes seulement",
		'group_tools:joinrequest:already' => "Révoquer la demande d’adhésion",
		'group_tools:joinrequest:already:tooltip' => "Vous avez déjà demandé à vous joindre à ce groupe; cliquez ici pour révoquer cette demande",

		// menu
		'group_tools:menu:mail' => "Courriel aux membres",
		'group_tools:menu:invitations' => "Gérer les invitations",

		// plugin settings
		'group_tools:settings:invite:title' => "Options liées aux invitations de groupe",
		'group_tools:settings:management:title' => "Options générales liées aux groupes",
		'group_tools:settings:default_access:title' => "Accès par défaut des groupes",
		'group_tools:settings:admin_create' => "Limiter la création de groupes aux administrateurs de sites",
		'group_tools:settings:admin_create:description' => "Si vous choisissez « Oui », il sera impossible pour un utilisateur normal de votre site de créer un nouveau groupe.",
		'group_tools:settings:admin_transfer' => "Permettre le transfert du propriétaire du groupe",
		'group_tools:settings:admin_transfer:admin' => "Administrateur du site seulement",
		'group_tools:settings:admin_transfer:owner' => "Propriétaires de groupes et administrateurs de sites",
		'group_tools:settings:multiple_admin' => "Permettre de multiples administrateurs de groupes",
		'group_tools:settings:invite' => "Permettre que tous les utilisateurs soient invités (non seulement les collègues)",
		'group_tools:settings:invite_email' => "Permettre que tous les utilisateurs soient invités par adresse de courriel",
		'group_tools:settings:invite_csv' => "Permettre que tous les utilisateurs soient invités par fichier CSV",
		'group_tools:settings:mail' => "Permettre des messages de groupe (permet aux administrateurs de groupes d’envoyer un message à tous les membres)",
		'group_tools:settings:listing' => "Onglet de liste de groupe par défaut",
		'group_tools:settings:default_access' => "Quel devrait être l’accès par défaut au contenu quant aux groupes de ce site",
		'group_tools:settings:default_access:disclaimer' => "<b>AVERTISSEMENT :</b> ceci ne fonctionnera pas à moins que vous ayez <a href='https://github.com/Elgg/Elgg/pull/253' target='_blank'>https://github.com/Elgg/Elgg/pull/253</a> présenté une demande à votre installation de Elgg.",
		'group_tools:settings:search_index' => "Permettre que les groupes fermés soient indexés par les engins de recherche",
		'group_tools:settings:auto_notification' => "Permettre automatiquement les notifications de groupes au moment de l’adhésion des groupes",
		'group_tools:settings:auto_join' => "Adhésion automatique des groupes",
		'group_tools:settings:auto_join:description' => "Les nouveaux utilisateurs se joindront automatiquement aux groupes suivants",

		// group invite message
		'group_tools:groups:invite:body' => "Bonjour %s,

%s vous a invité à joindre le groupe '%s'. 
%s

Cliquez ci-dessous pour voir vos invitations :
%s",
	
		// group add message
		'group_tools:groups:invite:add:subject' => "Vous avez été ajouté au groupe %s",
		'group_tools:groups:invite:add:body' => "Bonjour %s,
	
%s vous a ajouté au groupe %s.
%s

Pour voir le groupe, cliquez sur le lien suivant
%s",

		// group invite by email
		'group_tools:groups:invite:email:subject' => "Vous avez été ajouté au groupe %s",
		'group_tools:groups:invite:email:body' => "Bonjour,

%s vous a invité à joindre le groupe %s le %s.
%s

Si vous n’avez pas de compte sur %s, inscrivez-vous ici
%s

Si vous avez déjà un compte ou lorsque vous vous serez inscrit, cliquez sur le lien suivant pour accepter l’invitation
%s

You can also go to All site groups -> Group invitations et entrer le code suivant :
%s",

		// group transfer notification
		'group_tools:notify:transfer:subject' => "L’administration du groupe %s vous a été confiée",
		'group_tools:notify:transfer:message' => "Bonjour %s,

%s vous a nommé à titre de nouvel administrateur du groupe %s. 

Pour visiter le groupe, cliquez sur le lien suivant :
%s",

		// group edit tabbed
		'group_tools:group:edit:profile' => "Profil de groupe / tools",
		'group_tools:group:edit:other' => "Autres options",

		// admin transfer - form
		'group_tools:admin_transfer:title' => "Transférer la propriété de ce groupe",
		'group_tools:admin_transfer:transfer' => "Transférer la propriété du groupe à",
		'group_tools:admin_transfer:myself' => "Moi-même",
		'group_tools:admin_transfer:submit' => "Transfert",
		'group_tools:admin_transfer:no_users' => "Aucun membre ou collègues à qui transférer la propriété.",
		'group_tools:admin_transfer:confirm' => "Êtes-vous certain de vouloir transférer la propriété?",

		// auto join form
		'group_tools:auto_join:title' => "Options d’adhésion automatique",
		'group_tools:auto_join:add' => "%sAjouter ce groupe%s aux groupes qui adhèrent automatiquement. Cela signifiera que les nouveaux utilisateurs sont automatiquement ajoutés à ce groupe au moment de l’enregistrement.",
		'group_tools:auto_join:remove' => "%sEnlever ce groupe%s des groupes qui adhèrent automatiquement. Cela signifiera que les nouveaux utilisateurs ne seront plus automatiquement ajoutés à ce groupe au moment de l’enregistrement.",
		'group_tools:auto_join:fix' => "Pour faire de tous les membres du site des membres de ce groupe, veuillez %scliquer ici%s.",

		// group admins
		'group_tools:multiple_admin:group_admins' => "Administrateurs de groupe",
		'group_tools:multiple_admin:profile_actions:remove' => "Enlever l’administrateur de groupe",
		'group_tools:multiple_admin:profile_actions:add' => "Ajouter l’administrateur de groupe",
		'group_tools:multiple_admin:group_tool_option' => "Permettre aux administrateurs de groupe d’assigner d’autres administrateurs de groupe",

		// cleanup options
		'group_tools:cleanup:title' => "Nettoyage de l’encadré latéral du groupe",
		'group_tools:cleanup:description' => "Nettoyer l’encadré latéral du groupe. Ceci n’aura aucun effet pour les administrateurs de groupes.",
		'group_tools:cleanup:owner_block' => "Limiter le bloc du propriétaire",
		'group_tools:cleanup:owner_block:explain' => "Le bloc du propriétaire se trouve au haut de l’encadré latéral, certains liens supplémentaires peuvent être affichés à cet endroit (exemple : liens RSS).",
		'group_tools:cleanup:actions' => "Voulez-vous permettre à des utilisateurs de se joindre à ce groupe",
		'group_tools:cleanup:actions:explain' => "Selon les caractéristiques de votre groupe, les utilisateurs peuvent se joindre directement au groupe ou demander à y adhérer.",
		'group_tools:cleanup:menu' => "Cacher les éléments du menu latéral",
		'group_tools:cleanup:menu:explain' => "Cacher les liens du menu vers les différents outils de groupe. Les utilisateurs ne pourront avoir accès aux outils de groupe qu’en utilisant les widgets de groupe.",
		'group_tools:cleanup:members' => "Cacher les membres du groupe",
		'group_tools:cleanup:members:explain' => "Sur la page de profil du groupe, une liste des membres du groupe se trouve dans la section en surbrillance. Vous pouvez choisir de cacher cette liste.",
		'group_tools:cleanup:search' => "Cacher la recherche en groupe",
		'group_tools:cleanup:search:explain' => "Sur la page de profil du groupe, il y a une boîte de recherche. Vous pouvez choisir de la cacher.",
		'group_tools:cleanup:featured' => "Montrer les groupes en vedette dans l’encadré latéral",
		'group_tools:cleanup:featured:explain' => "Vous pouvez choisir de montrer une liste de groupes en vedette à la section en surbrillance dans la page de profil du groupe",
		'group_tools:cleanup:featured_sorting' => "Comment trier les groupes en vedette",
		'group_tools:cleanup:featured_sorting:time_created' => "Le plus récent d’abord",
		'group_tools:cleanup:featured_sorting:alphabetical' => "Ordre alphabétique",

		// group default access
		'group_tools:default_access:title' => "Accès par défaut du groupe",
		'group_tools:default_access:description' => "Ici, vous pouvez contrôler ce que devrait être l’accès par défaut du nouveau contenu dans votre groupe.",

		// group notification
		'group_tools:notifications:title' => "Notifications de groupe",
		'group_tools:notifications:description' => "Ce groupe compte %s membres, dont %s ont permis les notifications sur les activités dans ce groupe. Ci-dessous, vous pouvez changer cela pour tous les utilisateurs du groupe.",
		'group_tools:notifications:disclaimer' => "Dans le cas de grands groupes, ceci pourrait prendre du temps.",
		'group_tools:notifications:enable' => "Permettre les notifications pour tous",
		'group_tools:notifications:disable' => "Désactiver les notifications pour tous",

		// group profile widgets
		'group_tools:profile_widgets:title' => "Montrer les widgets de profil de groupe aux non-membres",
		'group_tools:profile_widgets:description' => "Ceci est un groupe fermé. Par défaut, aucun widget n’est montré aux non-membres. Ici, vous pouvez modifier la configuration si vous souhaitez changer cela.",
		'group_tools:profile_widgets:option' => "Permettre aux non-membres de voir les widgets sur la page de profil du groupe :",

		// group mail
		'group_tools:mail:message:from' => "Du groupe",

		'group_tools:mail:title' => "Envoyer un courriel aux membres du groupe",
		'group_tools:mail:form:recipients' => "Nombre de récipiendaires",
		'group_tools:mail:form:members:selection' => "Sélectionner des membres particuliers",

		'group_tools:mail:form:title' => "Objet",
		'group_tools:mail:form:description' => "Corps",
	
		'group_tools:mail:form:js:members' => "Veuillez sélectionner au moins un membre à qui envoyer le message",
		'group_tools:mail:form:js:description' => "Veuillez entrer un message",

		// group invite
		'group_tools:groups:invite:title' => "Inviter des utilisateurs à ce groupe",
		'group_tools:groups:invite' => "Inviter des utilisateurs",

		'group_tools:group:invite:friends:select_all' => "Sélectionner tous les collègues",
		'group_tools:group:invite:friends:deselect_all' => "Désélectionner tous les collègues",

		'group_tools:group:invite:users' => "Trouver des utilisateurs",
		'group_tools:group:invite:users:description' => "Entrer un nom ou nom d’utilisateur d’un membre du site et le sélectionner dans la liste",
		'group_tools:group:invite:users:all' => "Inviter tous les membres du site à ce groupe",

		'group_tools:group:invite:email' => "En utilisant l’adresse de courriel",
		'group_tools:group:invite:email:description' => "Entrer une adresse de courriel valide et la sélectionner dans la liste",

		'group_tools:group:invite:csv' => "En utilisant le téléchargement CSV",
		'group_tools:group:invite:csv:description' => "Vous pouvez télécharger un fichier CSV avec des utilisateurs pour inviter.<br />Le format doit être : nomd’affichage;adresse de courriel. Il ne devrait pas y avoir de ligne d’en-tête.",
	
		'group_tools:group:invite:text' => "Note personnelle (facultatif)",
		'group_tools:group:invite:add:confirm' => "Êtes-vous certain que vous voulez ajouter ces utilisateurs directement?",

		'group_tools:group:invite:resend' => "Réenvoyer des invitations aux utilisateurs qui ont déjà été invités",

		'group_tools:groups:invitation:code:title' => "Invitation de groupe par courriel",
		'group_tools:groups:invitation:code:description' => "Si vous avez reçu par courriel une invitation pour vous joindre à un groupe, vous pouvez entrer le code de l’invitation ici pour accepter l’invitation. Si vous cliquez sur le lien dans le courriel d’invitation, le code sera entré pour vous.",
	
		// group membership requests
		'group_tools:groups:membershipreq:requests' => "Demandes d’adhésion",
		'group_tools:groups:membershipreq:invitations' => "Invitations en suspens",
		'group_tools:groups:membershipreq:invitations:none' => "Aucune invitation en suspens",
		'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Êtes-vous certain que vous voulez révoquer cette invitation?",
	
		// group invitations
		'group_tools:group:invitations:request' => "Demandes d’adhésion en souffrance",
		'group_tools:group:invitations:request:revoke:confirm' => "Êtes-vous certain que vous voulez révoquer votre demande d’adhésion?",
		'group_tools:group:invitations:request:non_found' => "Il n’y a pas de demandes d’adhésion en suspens à l’heure actuelle",
	
		// group listing
		'group_tools:groups:sorting:alphabetical' => "Ordre alphabétique",
		'group_tools:groups:sorting:open' => "Ouvert",
		'group_tools:groups:sorting:closed' => "Fermé",
	
		// actions
		'group_tools:action:error:input' => "Entrée non valide pour effectuer cette action",
		'group_tools:action:error:entities' => "Les GUID donnés n’ont pas abouti aux bonnes entités",
		'group_tools:action:error:entity' => "Le GUID donné n’a pas abouti à une bonne entité",
		'group_tools:action:error:edit' => "Vous n’avez pas accès à l’entité donnée",
		'group_tools:action:error:save' => "Il y a eu une erreur au moment de la sauvegarde des paramètres",
		'group_tools:action:success' => "Les paramètres ont été sauvegardés avec succès",
	
		// admin transfer - action
		'group_tools:action:admin_transfer:error:access' => "Vous n’avez pas le droit de transférer la propriété de ce groupe",
		'group_tools:action:admin_transfer:error:self' => "Vous ne pouvez transférer la propriété à vous-même; vous êtes déjà le propriétaire",
		'group_tools:action:admin_transfer:error:save' => "Une erreur inconnue est survenue pendant la sauvegarde du groupe; veuillez essayer de nouveau",
		'group_tools:action:admin_transfer:success' => "La propriété du groupe a été transférée avec succès à %s",

		// group admins - action
		'group_tools:action:toggle_admin:error:group' => "L’entrée donnée n’aboutit pas à un groupe ou vous ne pouvez modifier ce groupe ou l’utilisateur n’est pas un membre",
		'group_tools:action:toggle_admin:error:remove' => "Une erreur inconnue est survenue pendant l’enlèvement de l’utilisateur en tant qu’administrateur de groupe",
		'group_tools:action:toggle_admin:error:add' => "Une erreur inconnue est survenue pendant l’ajout de l’utilisateur en tant qu’administrateur de groupe",
		'group_tools:action:toggle_admin:success:remove' => "L’utilisateur a été enlevé avec succès en tant qu’administrateur de groupe",
		'group_tools:action:toggle_admin:success:add' => "L’utilisateur a été ajouté avec succès en tant qu’administrateur de groupe",

		// group mail - action
		'group_tools:action:mail:success' => "Message envoyé avec succès",
	
		// group - invite - action
		'group_tools:action:invite:error:invite'=> "Aucun utilisateur n’a été invité (%s déjà invités, %s déjà membres)",
		'group_tools:action:invite:error:add'=> "Aucun utilisateur n’a été invité (%s déjà invités, %s déjà membres)",
		'group_tools:action:invite:success:invite'=> "% utilisateurs invités avec succès (%s déjà invités et %s déjà membres)",
		'group_tools:action:invite:success:add'=> "% utilisateurs ajoutés avec succès (%s déjà invités et %s déjà membres)",

		// group - invite - accept e-mail
		'group_tools:action:groups:email_invitation:error:input' => "Veuillez entrer un code d’invitation",
		'group_tools:action:groups:email_invitation:error:code' => "Le code d’invitation entré n’est plus valide",
		'group_tools:action:groups:email_invitation:error:join' => "Une erreur inconnue est survenue pendant l’adhésion au groupe %s;  vous êtes peut-être déjà membre",
		'group_tools:action:groups:email_invitation:success' => "Vous vous êtes joint au groupe avec succès",

		// group toggle auto join
		'group_tools:action:toggle_auto_join:error:save' => "Une erreur est survenue pendant la sauvegarde des nouveaux paramètres",
		'group_tools:action:toggle_auto_join:success' => "Les nouveaux paramètres ont été sauvegardés avec succès",

		// group fix auto_join
		'group_tools:action:fix_auto_join:success' => "Composition du groupe fixée : %s nouveaux membres, %s étaient déjà membres et %s échecs",

		// group cleanup
		'group_tools:actions:cleanup:success' => "Les paramètres de nettoyage ont été sauvegardés avec succès",

		// group default access
		'group_tools:actions:default_access:success' => "L’accès par défaut pour le groupe a été sauvegardé avec succès",

		// group notifications
		'group_tools:action:notifications:error:toggle' => "Option de bascule invalide",
		'group_tools:action:notifications:success:disable' => "Notifications désactivées avec succès pour chaque membre",
		'group_tools:action:notifications:success:enable' => "Notifications activées avec succès pour chaque membre",
	
		// Widgets
		// Group River Widget
		'widgets:group_river_widget:title' => "Activité de groupe",
		'widgets:group_river_widget:description' => "Montre l’activité d’un groupe dans un widget",

		'widgets:group_river_widget:edit:num_display' => "Nombre d’activités",
		'widgets:group_river_widget:edit:group' => "Sélectionner un groupe",
		'widgets:group_river_widget:edit:no_groups' => "Vous devez être un membre d’au moins un groupe pour utiliser ce widget",

		'widgets:group_river_widget:view:not_configured' => "Ce widget n’est pas encore configuré",

		'widgets:group_river_widget:view:more' => "Activité dans le groupe '%s'",
		'widgets:group_river_widget:view:noactivity' => "Nous n’avons pu trouver aucune activité.",

		// Group Members
		'widgets:group_members:title' => "Membres de groupes",
  		'widgets:group_members:description' => "Montrer les membres de ce groupe",

  		'widgets:group_members:edit:num_display' => "Combien de membres à montrer",
  		'widgets:group_members:view:no_members' => "Aucun membre de groupe trouvé",
  
		// Group Invitations
		'widgets:group_invitations:title' => "Invitations de groupe",
	  	'widgets:group_invitations:description' => "Montre les invitations de groupe en suspens pour l’utilisateur actuel",

		// Discussion
		"widgets:discussion:settings:group_only" => "Ne montre que les discussions de groupes dont vous êtes membre",
		'widgets:discussion:more' => "Voir plus de discussions",
		"widgets:discussion:description" => "Montre les discussions les plus récentes",
  
		// Forum topic widget
		'widgets:group_forum_topics:description' => "Montre les discussions les plus récentes",

		// index_groups
		'widgets:index_groups:description' => "Montrer les groupes les plus récents dans votre collectivité",
		'widgets:index_groups:show_members' => "Montrer le nombre de membres",
		'widgets:index_groups:featured' => "Montrer seulement les groupes en vedette",

		'widgets:index_group:filter:field' => "Filtrer les groupes selon le champ du groupe",
		'widgets:index_group:filter:value' => "avec valeur",
		'widgets:index_group:filter:no_filter' => "Aucun filtre",

		// Featured Groups
		'widgets:featured_groups:description' => "Montre une liste aléatoire de groupes en vedette",
		'widgets:featured_groups:edit:show_random_group' => "Montrer un groupe non en vedette aléatoire",
	  	
		// group_news widget
		"widgets:group_news:title" => "Nouvelles du groupe", 
		"widgets:group_news:description" => "Montrer les 5 blogues les plus récents de différents groupes", 
		"widgets:group_news:no_projects" => "Aucun groupe configuré", 
		"widgets:group_news:no_news" => "Aucun blogue pour ce groupe", 
		"widgets:group_news:settings:project" => "Groupe", 
		"widgets:group_news:settings:no_project" => "Sélectionner un groupe",
		"widgets:group_news:settings:blog_count" => "Nombre maximum de blogues",
		"widgets:group_news:settings:group_icon_size" => "Taille de l’icône de groupe",
		"widgets:group_news:settings:group_icon_size:small" => "Petite",
		"widgets:group_news:settings:group_icon_size:medium" => "Moyenne",

	);
	
	add_translation("fr", $french);
  	