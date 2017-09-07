<?php
return array(

	// gcconnex

	'groups:latestdiscussion' => 'Dernière discussion',

	/**
	 * Menu items and titles
	 */

	'groups' => "Groupes",
	'group:group' => "ce groupe",
	'groups:owned' => "Groupes dont je suis propriétaire",
	'groups:owned:user' => "Les groupes que %s possède",
	'groups:yours' => "Mes groupes",
	'groups:user' => "Groupes de %s",
	'groups:all' => "Tous les groupes du site",
	'groups:add' => "Créer un nouveau groupe",
	'groups:edit' => "Modifier le groupe",
	'groups:delete' => 'Supprimer le groupe',
	'groups:membershiprequests' => "Gérer les demandes d'adhésion",
	'groups:membershiprequests:pending' => 'Gérer les demandes d\'adhésion au groupe (%s)',
	'groups:invitations' => 'Invitations de groupe',
	'groups:invitations:pending' => 'Invitations de groupe (%s)',

	'groups:icon' => 'Icône de groupe (laisser tel quel ou laisser en blanc)',
	'groups:name' => 'Nom de groupe <strong style="color:red;">*</strong>',
	'groups:username' => 'Nom de groupe abrégé (affiché dans les URL, caractères alphanumériques seulement)',
	'groups:description' => 'Description longue',
	'groups:briefdescription' => 'Description brève',
	'groups:brief:charcount' => ' | Nombre de caractères: ',
	'groups:interests' => 'Intérêts',
	'groups:website' => 'Site Web',
	'groups:members' => 'Membres du groupe',
	'groups:my_status' => 'Mon status',
	'groups:my_status:group_owner' => 'Vous êtes propriétaire de ce groupe',
	'groups:my_status:group_member' => 'Vous êtes dans ce groupe',
	'groups:subscribed' => 'Notifications du groupe activées',
	'groups:unsubscribed' => 'Notifications du groupe inactives',

	'groups:members:title' => 'Les membres de %s',
	'groups:members:more' => "Voir tous les membres",
	'groups:membership' => "Autorisations d'adhésion des membres au groupe ",
	'groups:content_access_mode' => "L'accessibilité du contenu du groupe",
	'groups:content_access_mode:warning' => "Attention: la modification de ce paramètre ne changera pas l'autorisation d'accès au contenu du groupe existant.",
	'groups:content_access_mode:unrestricted' => "Sans restriction - L'accès dépend des réglages au niveau du contenu",
	'groups:content_access_mode:membersonly' => "Membres seulement - Les non-membres ne peuvent pas accéder au contenu du groupe",
	'groups:access' => "Les autorisations d'accès",
	'groups:owner' => "Propriétaire",
	'groups:owner:warning' => "Attention : si vous faites cette modification vous ne serez plus le propriétaire du groupe.",
	'groups:widget:num_display' => 'Nombre de groupes à afficher',
	'groups:widget:membership' => 'Appartenance aux groupes',
	'groups:widgets:description' => 'Afficher les groupes dont vous faites partie dans votre profil',

	'groups:widget:group_activity:title' => 'Activité du groupe',
	'groups:widget:group_activity:description' => 'Voir l\'activité dans un de vos groupes',
	'groups:widget:group_activity:edit:select' => 'Sélectionnez un groupe',
	'groups:widget:group_activity:content:noactivity' => 'Il n\'y a pas d\'activité dans ce groupe',
	'groups:widget:group_activity:content:noselect' => 'Modifiez ce widget pour sélectionner un groupe',

	'groups:noaccess' => "Aucun d'accès au groupe",
	'groups:permissions:error' => 'Vous n\'avez pas les autorisations pour ceci',
	'groups:ingroup' => 'dans le groupe',
	'groups:cantcreate' => 'Vous ne pouvez pas créer un groupe. Seul les administrateurs peuvent.',
	'groups:cantedit' => 'Vous ne pouvez pas modifier ce groupe',
	'groups:saved' => 'Groupe sauvegardé',
	'groups:save_error' => 'Le groupe n\'a pas pu être sauvegardé',
	'groups:featured' => 'Groupes en vedette',
	'groups:makeunfeatured' => 'Retirer les groupes en vedette',
	'groups:makefeatured' => 'Mettre un groupe en vedette',
	'groups:featuredon' => 'Vous avez fait de ce groupe un groupe en vedette.',
	'groups:unfeatured' => 'Vous avez supprimé ce groupe de la liste des groupes en vedette',
	'groups:featured_error' => 'Groupe invalide.',
	'groups:nofeatured' => 'Aucun groupe en vedette',
	'groups:joinrequest' => 'Faire une demande d\'adhésion',
	'groups:join' => 'Devenir membre du groupe',
	'groups:leave' => 'Quitter le groupe',
	'groups:invite' => 'Inviter des collègues',
	'groups:invite:title' => 'Invitez des collègues à ce groupe',
	'groups:inviteto' => "Inviter des collègues à '%s'",
	'groups:nofriends' => "Tous vos collègues ont été invités à faire partie de ce groupe.",
	'groups:nofriendsatall' => 'Vous n\'avez pas de collègue à inviter !',
	'groups:viagroups' => "par l'intermédiaire de groupes",
	'groups:group' => "Groupe",
	'groups:search:tags' => "mot-clic",
	'groups:search:title' => "Rechercher des groupes ayant les mots-clics '%s'",
	'groups:search:none' => "Aucun groupe n’a été trouvé avec ces critères de recherche",
	'groups:search_in_group' => "Rechercher dans ce groupe",
	'groups:acl' => "Groupe : %s",

	'groups:activity' => "L'activité du groupe",
	'groups:enableactivity' => 'Activer le fil d\'activité de groupe',
	'groups:activity:none' => "Il n'y a pas encore d'activité dans le groupe",

	'groups:notfound' => "Le groupe n'a pas été trouvé",
	'groups:notfound:details' => "Le groupe que vous recherchez n'existe pas, ou vous n'avez pas la permission d'y accéder",

	'groups:requests:none' => 'Personne ne demande à rejoindre le groupe en ce moment.',

	'groups:invitations:none' => 'Aucune invitation en attente.',

	'groups:count' => "groupes créés",
	'groups:open' => "groupe ouvert",
	'groups:closed' => "groupe fermé",
	'groups:member' => "membres",
	'groups:searchtag' => "Rechercher des groupes par tag",

	'groups:more' => 'Plus de groupes',
	'groups:none' => 'Aucun groupe',

	/**
	 * Access
	 */	
	'groups:access:private' => 'Fermé - Les utilisateurs doivent être invités',
	'groups:access:public' => 'Ouvert - Tous les utilisateurs peuvent joindre le groupe',
	'groups:access:group' => 'Membres du groupe seulement',
	'groups:closedgroup' => "Ceci est un groupe fermé '.",
	'groups:closedgroup:request' => 'Pour y devenir membre, cliquez sur le lien "Demande d\'adhésion',
	'groups:closedgroup:membersonly' => "Ceci est un groupe fermé. Le contenu de se groupe est  accessible uniquement à ses membres.",
	'groups:opengroup:membersonly' => "Le contenu de ce groupe est accessible uniquement à ses membres.",
	'groups:opengroup:membersonly:join' => 'Pour devenir membre, cliquez sur "Demander de devenir membre".',
	'groups:visibility' => 	'Qui peut voir le groupe?',

	/**
	 * Group tools
	 */
	'groups:lastupdated' => 'Dernière mise à jour le %s par %s',
	'groups:lastcomment' => 'Dernier commentaire %s par %s',

	'admin:groups' => 'Groupes',

	'groups:privategroup' => "Ceci est un groupe fermé. Vous devez procéder à une demande d'adhésion pour vous y joindre",
	'groups:notitle' => 'Les groupes doivent avoir un titre',
	'groups:cantjoin' => 'Impossible de se joindre au groupe',
	'groups:cantleave' => 	'Impossible de quitter le groupe',
	'groups:removeuser' => 'Retirer du groupe',
	'groups:cantremove' => 'Ne peut retirer l\'utilisateur du groupe',
	'groups:removed' => '%s a été retiré du groupe',
	'groups:addedtogroup' => 'Utilisateur ajouté avec succès au groupe',
	'groups:joinrequestnotmade' => "Impossible d'exécuter la demande d'ajout au groupe",
	'groups:joinrequestmade' => "Demande d'ajout au groupe exécutée avec succès",
	'groups:joined' => 'Ajout au groupe exécuté avec succès!',
	'groups:left' => 'Sortie du groupe exécutée avec succès',
	'groups:notowner' => "Désolé, vous n'êtes pas le propriétaire de ce groupe.",
	'groups:notmember' => 'Désolé, vous n\'êtes pas membre de ce groupe.',
	'groups:alreadymember' => 'Vous êtes déjà membre de ce groupe!',
	'groups:userinvited' => "L'utilisateur a été invité.",
	'groups:usernotinvited' => "Il a été impossible d'inviter l'utilisateur.",
	'groups:useralreadyinvited' => "L'utilisateur a déjà été invité",
	'groups:invite:subject' => "%s vous avez été invité à vous joindre à %s!",
	'groups:updated' => "Dernier commentaire",
	'groups:started' => "Débuté par %s",
	'groups:joinrequest:remove:check' => "Êtes-vous certain de vouloir supprimer cette demande d'ajout au groupe?",
	'groups:invite:remove:check' => 'Êtes-vous certain de vouloir supprimé cette invitation?',
	'groups:invite:body' => "Vous êtes invité(e) à vous joindre au groupe '%s'; cliquez ci-dessous pour confirmer : %s",

	'groups:welcome:subject' => "Bienvenue dans le groupe %s!",
	'groups:welcome:body' => "Bonjour %s! Vous êtes maintenant membre du groupe '%s'! Cliquez ci-dessous pour commencer à publier! %s",

	'groups:request:subject' => "%s a demandé de faire partie de %s",
	'groups:request:body' => "Bonjour %s, %s a demandé de faire partie du groupe '%s'; cliquez ci-dessous pour afficher son profil : %s ou cliquez ci-dessous pour confirmer la demande : %s",

	/**
	 * Forum river items
	 */

	'river:create:group:default' => '%s a créé le groupe %s',
	'river:join:group:default' => '%s s’est joint(e) au groupe %s',

	'groups:nowidgets' => "Aucun widget n'a été défini pour ce groupe.",

	'groups:widgets:members:title' => 'Membres du groupe',
	'groups:widgets:members:description' => "Présenter la liste des membres d'un groupe.",
	'groups:widgets:members:label:displaynum' => "Présenter la liste des membres d'un groupe.",
	'groups:widgets:members:label:pleaseedit' => 'Veuillez configurer ce widget.',

	'groups:widgets:entities:title' => "Objets dans le groupe",
	'groups:widgets:entities:description' => "Présenter la liste des objets enregistrés dans ce groupe",
	'groups:widgets:entities:label:displaynum' => "Présenter la liste des objets d'un groupe.",
	'groups:widgets:entities:label:pleaseedit' => 'Veuillez configurer ce widget.',


	'groups:allowhiddengroups' => 'Activer les groupes privés (invisibles) ?',
	'groups:whocancreate' => 'Qui peut créer un nouveau groupe ?',
		
		
	/**
	 * Action messages
	 */	
	'group:deleted' => 'Groupe et contenu du groupe supprimés',
	'group:notdeleted' => 'Il a été impossible de supprimer le groupe',	

	'group:notfound' => 'Impossible de trouver le groupe',
	'groups:deletewarning' => "Êtes-vous certain de vouloir supprimer ce groupe? L'opération ne peut être annulée!",

	'groups:invitekilled' => 'L\'invitation a été supprimée',
	'groups:joinrequestkilled' => "La demande d'ajout au groupe a été supprimée.",
	'groups:error:addedtogroup' => "Impossible d'ajouter %s au groupe",
	'groups:add:alreadymember' => "%s est déjà un membre de ce groupe",
		
	/**
	 * ecml
	 */
	'groups:ecml:discussion' => 'Discussions de groupe',
	'groups:ecml:groupprofile' => 'Les profils de groupe',

);
