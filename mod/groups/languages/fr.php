<?php
/**
 * Elgg groups plugin language pack
 * 
 * @package ElggGroups
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

return array(

	/**
	* Menu items and titles
	*/
	'groups' => "Groupes",
	'groups:owned' => "Groupes dont vous êtes propriétaire",
	'groups:owned:user' => "Les groupes que %s possède",
	'groups:yours' => "Vos groupes",
	'groups:user' => "Groupes de %s",
	'groups:all' => "Tous les groupes du site",
	'groups:add' => "Créer un nouveau groupe",
	'groups:edit' => "Gérer le groupe",
	'groups:delete' => 'Supprimer le groupe',
	'groups:membershiprequests' => "Gérer les demandes d'adhésion",
	'groups:membershiprequests:pending' => 'Gérer les membres souhaitant se joindre au groupe (%s)',
	'groups:invitations' => 'Invitations de groupe',
	'groups:invitations:pending' => 'Invitations du groupe (%s)',

	'groups:icon' => 'Icône de groupe (laisser tel quel ou laisser en blanc)',
	'groups:name' => 'Nom de groupe <strong style="color:red;">*</strong>',
	'groups:username' => 'Nom de groupe abrégé (affiché dans les URL, caractères alphanumériques seulement)',
	'groups:description' => 'Description Longue',
	'groups:briefdescription' => 'Description brève',
	'groups:brief:charcount' => ' | Nombre de caractères: ',
	'groups:interests' => 'Intérêts',
	'groups:website' => 'Site Web',
	'groups:members' => 'Membres du groupe',
	'groups:my_status' => 'Mon status',
	'groups:my_status:group_owner' => 'Vous possédez ce groupe',
	'groups:my_status:group_member' => 'Vous êtes dans ce groupe',
	'groups:subscribed' => 'Notifications du groupe actif',
	'groups:unsubscribed' => 'Notifications du groupe inactif',

	'groups:members:title' => 'Les membres de %s',
	'groups:members:more' => "Voir tous les membres",
	'groups:membership' => "Autorisations aux membres du groupe ",
	'groups:access' => "Autorisations d'accès",
	'groups:content_access_mode' => "Accessibilité au contenu du groupe",
	'groups:content_access_mode:warning' => "Attention: la modification de ce paramètre ne changera pas l'autorisation d'accès au contenu du groupe existant.",
	'groups:content_access_mode:unrestricted' => "Sans restriction - L'accès dépend des réglages au niveau du contenu",
	'groups:content_access_mode:membersonly' => "Membres seulement - Les non-membres ne peuvent pas accéder au contenu du groupe",
	'groups:owner' => "Propriétaire",
	'groups:owner:warning' => "Attention: si vous changez cette valeur, vous ne serez plus le propriétaire du groupe.",
	'groups:widget:num_display' => 'Nombre de groupes à afficher',
	'groups:widget:membership' => 'Appartenance aux groupes',
	'groups:widgets:description' => 'Afficher les groupes dont vous faites partie dans votre profil',

	'groups:widget:group_activity:title' => 'Activité du Groupe',
	'groups:widget:group_activity:description' => 'Afficher l\'activité dans un de vos groupes',
	'groups:widget:group_activity:edit:select' => 'Sélectionnez un groupe',
	'groups:widget:group_activity:content:noactivity' => 'Il n\'y a pas d\'activité dans ce groupe',
	'groups:widget:group_activity:content:noselect' => 'Editez ce widget pour sélectionner un groupe',

	'groups:noaccess' => "Pas d'accès au groupe",
	'groups:permissions:error' => 'Vous n\'avez pas les autorisations pour çà',
	'groups:ingroup' => 'dans le groupe',
	'groups:cantcreate' => 'Vous ne pouvez créer un groupe. Seul les administrateurs peuvent.',
	'groups:cantedit' => 'Vous ne pouvez pas modifier ce groupe',
	'groups:saved' => 'Groupe enregistré',
	'groups:save_error' => 'Group could not be saved',				// NEEDS TRANSLATION
	'groups:featured' => 'Groupes en vedette',
	'groups:makeunfeatured' => 'Supprimer des groupes en vedette',
	'groups:makefeatured' => 'Mettre un groupe en vedette',
	'groups:featuredon' => 'Vous avez fait de ce groupe un groupe en vedette.',
	'groups:unfeature' => 'Vous avez supprimé ce groupe de la liste des groupes en vedette',
	'groups:featured_error' => 'Groupe invalide.',
	'groups:nofeatured' => 'Pas de groupes à la une',
	'groups:joinrequest' => 'Demander de devenir membre',
	'groups:join' => 'Devenir membre du groupe',
	'groups:leave' => 'Quitter le groupe',
	'groups:invite' => 'Inviter des collègues',
	'groups:invite:title' => 'Invitez des amis à ce groupe',
	'groups:inviteto' => "Inviter des collègues à '%s'",
	'groups:nofriends' => "Tous vos collègues ont été invités à faire partie de ce groupe.",
	'groups:nofriendsatall' => 'Vous n\'avez pas d\'amis à inviter !',
	'groups:viagroups' => "par l'intermédiaire de groupes",
	'groups:group' => "Groupe",
	'groups:notfound' => "Groupe introuvable",
	'groups:notfound:details' => "Le groupe demandé est inexistant ou vous n'y avez pas accès",
	'groups:search:tags' => "tag",
	'groups:search:title' => "Rechercher des groupes ayant les mots-clés '%s'",
	'groups:search:none' => "Aucun groupe n’a été trouvé avec ces critères de recherche",
	'groups:search_in_group' => "Rechercher dans ce groupe",
	'groups:acl' => "Group: %s",

	'discussion:topic:notify:summary' => 'Nouveau sujet de discussion appelé %s',
	'discussion:topic:notify:subject' => 'Nouveau sujet de discussion: %s',
	'discussion:topic:notify:body' =>
'%s a ajouté un nouveau sujet de discussion au groupe %s:

Titre: %s

%s

Afficher et répondre au sujet de discussion:
%s
',

	
	'discussion:reply:notify:summary' => 'Nouvelle réponse au sujet: %s',
	'discussion:reply:notify:subject' => 'Nouvelle réponse au sujet: %s',
	'discussion:reply:notify:body' =>
'%s a répondu au sujet de discussion %s dans le groupe %s:

%s

Voir et répondre à la discussion :
%s
',


	'discussion:notification:topic:subject' => 'Nouvelle discussion de groupe', //translate
	'groups:notification' =>
		'%s a ajouté un nouveau sujet de discussion à %s:

		%s
		%s

		Afficher et répondre à la discussion:
		%s
	',

	'discussion:notification:reply:body' =>
'%s a répondu à la question de discussion %s dans le groupe %s:

%s

Afficher et répondre à la discussion:
%s
', //translate
	
	'groups:activity' => "L'activité du Groupe",
	'groups:enableactivity' => 'Activer activité de groupe',
	'groups:activity:none' => "Il n'y a pas encore de l'activité de groupe",

	'groups:notfound' =>  "Le groupe n'a pas été trouvé",
	'groups:notfound:details' => "Le groupe que vous recherchez n'existe pas, ou alors vous n'avez pas la permission d'y accéder",

	'groups:requests:none' => "Il n'y a actuellement aucune demande d'adhésion en attente.",

	'groups:invitations:none' =>  'Il n\'y a pas d\'invitations en attente.',

	'item:object:groupforumtopic' => "Sujets de discussion",
	'item:object:discussion_reply' => "Réponses à la discussion",

	'groupforumtopic:new' => "Nouvel article de discussion",

	'groups:count' => "groupes créés",
	'groups:open' => "groupe ouvert",
	'groups:closed' => "groupe fermé",
	'groups:member' => "membres",
	'groups:searchtag' => "Recherche de groupes par mot-clé",

	'groups:more' => 'Plus de groupes',
	'groups:none' => 'Aucun groupe',

	/*
	* Access
	*/
	'groups:access:private' => 'Fermé - Les utilisateurs doivent être invités',
	'groups:access:public' => 'Ouvert - Tout utilisateur peut participer',
	'groups:access:group' => 'Membres du groupe seulement',
	'groups:closedgroup' => "Ce groupe est fermé. Pour y être ajouté, cliquez sur le lien de menu 'demande d'ajout au groupe'.",
	'groups:closedgroup:request' => 'Pour être membre, clicker sur "Demande d\'adhésion" sur le menu.',
	'groups:closedgroup:membersonly' => "Les inscriptions à ce groupe sont fermées et son contenu est accessible uniquement aux membres.",
	'groups:opengroup:membersonly' => "Le contenu de ce groupe est accessible uniquement à ses membres.",
	'groups:opengroup:membersonly:join' => 'Pour faire partie des membres, cliquez sur le lien du menu "Rejoindre le groupe".',
	'groups:visibility' => 'Qui peut voir le groupe?',

	/*
	Group tools
	*/
	'groups:enablepages' => 'Activer les pages de groupe',
	'groups:enableforum' => 'Activer la discussion de groupe',
	'groups:enablefiles' => 'Activer les fichiers de groupe',
	'groups:yes' => 'oui',
	'groups:no' => 'non',
	'group:created' => '%s a été créé avec %d articles',
	'groups:lastupdated' => 'Dernière mise à jour le %s par %s',
	'groups:lastcomment' => 'Last comment %s by %s', //translate
	'groups:pages' => 'Pages de groupe',
	'groups:files' => 'Fichiers de groupe',

	/*
	Group discussion
	*/
	'discussion' => 'Discussion',
	'discussion:add' => 'Ajouter le sujet de discussion',
	'discussion:latest' => 'Dernière discussion',
	'discussion:group' => 'Discussion de groupe',
	'discussion:none' => 'Pas de discussion',
	'discussion:reply:title' => 'Répondre par %s',

	'discussion:topic:created' => 'Le sujet de discussion a été créé.',
	'discussion:topic:updated' => 'Le sujet de discussion a été mis à jour.',
	'discussion:topic:deleted' => 'Sujet de discussion a été supprimé.',

	'discussion:topic:notfound' => 'Sujet de discussion introuvable',
	'discussion:error:notsaved' => "Impossible d'enregistrer ce sujet",
	'discussion:error:missing' => 'Le titre et le message sont des champs obligatoires',
	'discussion:error:permissions' => "Vous n'avez pas d'autorisations d'effectuer cette action",
	'discussion:error:notdeleted' => 'Impossible de supprimer sujet de discussion',

	'discussion:reply:edit' => 'Modifier la réponse',
	'discussion:reply:deleted' => 'Réponse de discussion a été supprimé.',
	'discussion:reply:error:notfound' => 'La réponse à cette discussion n\'a pas été trouvée',
	'discussion:reply:error:notfound_fallback' => "Désolé, le message spécifié n'a pu être trouvé. Vous avez été redirigé vers le sujet de discussion original.",
	'discussion:reply:error:notdeleted' => 'Impossible de supprimer la réponse de discussion',

	'discussion:search:title' => 'Répondre au sujet: %s',
	
	'admin:groups' => 'Groupes',

	'reply:this' => 'Répondre à çà',

	'group:replies' => 'Réponses',
	'groups:forum:created' => 'Créé %s avec %d commentaires',
	'groups:forum:created:single' => 'Créé %s avec %d réponse',
	'groups:forum' => 'Discussion de groupe',
	'groups:addtopic' => 'Ajouter un sujet',
	'groups:forumlatest' => 'Dernière discussion',
	'groups:latestdiscussion' => 'Dernière discussion',
	'groups:newest' => 'La plus récente',
	'groups:popular' => 'Populaire',
	'groupspost:success' => 'Votre commentaire a été publié avec succès',
	'groupspost:failure' => 'Il y a eu un problème lors de la publication de votre réponse',
	'groups:alldiscussion' => 'Dernière discussion',
	'groups:edittopic' => 'Modifier un sujet',
	'groups:topicmessage' => 'Message relatif au sujet',
	'groups:topicstatus' => 'État du sujet',
	'groups:reply' => 'Publier un commentaire',
	'groups:topic' => 'Sujet',
	'groups:posts' => 'Articles',
	'groups:lastperson' => 'Dernière personne',
	'groups:when' => 'Quand',
	'grouptopic:notcreated' => "Aucun sujet n'a été créé.",
	'groups:topicopen' => 'Ouvert',
	'groups:topicclosed' => 'Fermé',
	'groups:topicresolved' => 'Résolu',
	'grouptopic:created' => 'Votre sujet a été créé.',
	'groups:topicsticky' => 'Difficile',
	'groups:topicisclosed' => 'Ce sujet est fermé.',
	'groups:topiccloseddesc' => 'Ce sujet est maintenant fermé. Les commentaires ne sont plus acceptés.',
	'grouptopic:error' => 'Impossible de créer votre sujet de discussion de groupe. Veuillez réessayer ou communiquer avec un administrateur système.',
	'groups:forumpost:edited' => "Vous avez modifié l'article de discussion avec succès.",
	'groups:forumpost:error' => "Un problème est survenu dans la modification de l'article de discussion.",

	'groups:privategroup' => "Ce groupe est privé; demande d'ajout en cours",
	'groups:notitle' => 'Les groupes doivent avoir un titre',
	'groups:cantjoin' => 'Impossible de se joindre au groupe',
	'groups:cantleave' => 'Impossible de quitter le groupe',
	'groups:removeuser' => 'Retirer du groupe',
	'groups:cantremove' => 'Ne peut retirer l\'utilisateur du groupe',
	'groups:removed' => '%s a été retiré du groupe',
	'groups:addedtogroup' => 'Utilisateur ajouté avec succès au groupe',
	'groups:joinrequestnotmade' => "Impossible d'exécuter la demande d'ajout au groupe",
	'groups:joinrequestmade' => "Demande d'ajout au groupe exécutée avec succès",
	'groups:joined' => 'Ajout au groupe exécuté avec succès!',
	'groups:left' => 'Sortie du groupe exécutée avec succès',
	'groups:notowner' => "Désolé, vous n'êtes pas le propriétaire de ce groupe.",
	'groups:notmember' => 'Sorry, you are not a member of this group.', //translate
	'groups:alreadymember' => 'Vous êtes déjà membre de ce groupe!',
	'groups:userinvited' => "L'utilisateur a été invité.",
	'groups:usernotinvited' => "Il a été impossible d'inviter l'utilisateur.",
	'groups:useralreadyinvited' => "L'utilisateur a déjà été invité",
	'groups:invite:subject' => "%s vous avez été invité à vous joindre à %s!",
	'groups:updated' => "Dernier commentaire",
	'groups:started' => "Démarré par",
	'groups:joinrequest:remove:check' => "Êtes-vous certain de vouloir supprimer cette demande d'ajout au groupe?",
	'groups:invite:remove:check' => 'Are you sure you want to remove this invite?', //translate
	'groups:invite:body' => "Bonjour %s,

Vous êtes invité(e) à vous joindre au groupe '%s'; cliquez ci-dessous pour confirmer :

%s",

	'groups:welcome:subject' => "Bienvenue dans le groupe %s!",
	'groups:welcome:body' => "Bonjour %s!

Vous êtes maintenant membre du groupe '%s'! Cliquez ci-dessous pour commencer à publier!

%s",

	'groups:request:subject' => "%s a demandé de faire partie de %s",
	'groups:request:body' => "Bonjour %s,

%s a demandé de faire partie du groupe '%s'; cliquez ci-dessous pour afficher son profil :

%s

ou cliquez ci-dessous pour confirmer la demande :

%s",

	/*
	Forum river items
	*/
	'groups:river:member' => 'fait maintenant partie de',
	'groupforum:river:updated' => '%s a mis à jour',
	'groupforum:river:update' => 'ce sujet de discussion',
	'groupforum:river:created' => '%s a créé',
	'groupforum:river:create' => 'un nouveau sujet de discussion intitulé',
	'groupforum:river:posted' => '%s a publié un nouveau commentaire',
	'groupforum:river:annotate:create' => 'sur ce sujet de discussion',
	'groupforum:river:postedtopic' => '%s a démarré un nouveau sujet de discussion intitulé',
	'groups:river:member' => '%s fait maintenant partie de',

	'river:create:group:default' => '%s a créé le groupe %s',
	'river:join:group:default' => '%s s’est joint(e) au groupe %s',
	'river:create:object:groupforumtopic' => '%s a ajouté un nouveau sujet de discussion %s',
	'river:reply:object:groupforumtopic' => '%s a répondu sur le sujet de discussion %s',
	'river:reply:view' => 'afficher la réponse',

	'groups:nowidgets' => "Aucun widget n'a été défini pour ce groupe.",

	'groups:widgets:members:title' => 'Membres du groupe',
	'groups:widgets:members:description' => "Présente la liste des membres d'un groupe.",
	'groups:widgets:members:label:displaynum' => "Présente la liste des membres d'un groupe.",
	'groups:widgets:members:label:pleaseedit' => 'Veuillez configurer ce widget.',

	'groups:widgets:entities:title' => "Objets dans le groupe",
	'groups:widgets:entities:description' => "Présente la liste des objets enregistrés dans ce groupe",
	'groups:widgets:entities:label:displaynum' => "Présente la liste des objets d'un groupe.",
	'groups:widgets:entities:label:pleaseedit' => 'Veuillez configurer ce widget.',

	'groups:forumtopic:edited' => 'Sujet de discussion de groupe mis à jour avec succès.',

	'groups:allowhiddengroups' => 'Voulez-vous permettre les groupes privés (invisibles) ?',
	'groups:whocancreate' => 'Qui peut créer un nouveau groupe ?',

	/**
	* Action messages
	*/
	'group:deleted' => 'Groupe et contenu du groupe supprimés',
	'group:notdeleted' => 'Il a été impossible de supprimer le groupe',

	'group:notfound' => 'Impossible de trouver le groupe',
	'grouppost:deleted' => 'Publication du groupe supprimée avec succès',
	'grouppost:notdeleted' => 'Il a été impossible de supprimer le groupe',
	'groupstopic:deleted' => 'Sujet supprimé',
	'groupstopic:notdeleted' => 'Sujet non supprimé',
	'grouptopic:blank' => "Il n'y a pas de sujet de discussion",
	'grouptopic:notfound' => 'Le sujet n\'a pu être trouvé',
	'grouppost:nopost' => 'Pas d\'articles',
	'groups:deletewarning' => "Êtes-vous certain de vouloir supprimer ce groupe? L'opération ne peut être annulée!",

	'groups:invitekilled' => 'L\'invitation a été supprimée',
	'groups:joinrequestkilled' => "La demande d'ajout au groupe a été supprimée.",
	'groups:error:addedtogroup' => "Impossible d'ajouter %s au groupe",
	'groups:add:alreadymember' => "%s est déjà un membre de ce groupe",

	// ecml
	'groups:ecml:discussion' => 'Discussions de groupe',
	'groups:ecml:groupprofile' => 'Les profils de groupe',
);
