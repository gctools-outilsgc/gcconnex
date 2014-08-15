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

$french = array(

	/**
	* Menu items and titles
	*/
	'groups' => "Groupes",
	'groups:owned' => "Groupes dont vous êtes propriétaire",
	'groups:owned:user' => 'Groups %s owns', //translate
	'groups:yours' => "Vos groupes",
	'groups:user' => "Groupes de %s",
	'groups:all' => "Tous les groupes du site",
	'groups:add' => "Créer un nouveau groupe",
	'groups:edit' => "Gérer le groupe",
	'groups:delete' => 'Supprimer le groupe',
	'groups:membershiprequests' => "Gérer les demandes d'adhésion",
	'groups:invitations' => 'Invitations de groupe',

	'groups:icon' => 'Icône de groupe (laisser tel quel ou laisser en blanc)',
	'groups:name' => 'Nom de groupe',
	'groups:username' => 'Nom de groupe abrégé (affiché dans les URL, caractères alphanumériques seulement)',
	'groups:description' => 'Description',
	'groups:briefdescription' => 'Description brève',
	'groups:interests' => 'Intérêts',
	'groups:website' => 'Site Web',
	'groups:members' => 'Membres du groupe',
	'groups:members:title' => 'Members of %s', //translate
	'groups:members:more' => "Voir tous les membres",
	'groups:membership' => "Autorisations aux membres du groupe ",
	'groups:access' => "Autorisations d'accès",
	'groups:owner' => "Propriétaire",
	'groups:widget:num_display' => 'Nombre de groupes à afficher',
	'groups:widget:membership' => 'Appartenance aux groupes',
	'groups:widgets:description' => 'Afficher les groupes dont vous faites partie dans votre profil',
	'groups:noaccess' => "Pas d'accès au groupe",
	'groups:cantedit' => 'Vous ne pouvez pas modifier ce groupe',
	'groups:saved' => 'Groupe enregistré',
	'groups:featured' => 'Groupes en vedette',
	'groups:makeunfeatured' => 'Supprimer des groupes en vedette',
	'groups:makefeatured' => 'Mettre un groupe en vedette',
	'groups:featuredon' => 'Vous avez fait de ce groupe un groupe en vedette.',
	'groups:unfeature' => 'Vous avez supprimé ce groupe de la liste des groupes en vedette',
	'groups:featured_error' => 'Invalid group.', //translate
	'groups:joinrequest' => 'Demander de devenir membre',
	'groups:join' => 'Devenir membre du groupe',
	'groups:leave' => 'Quitter le groupe',
	'groups:invite' => 'Inviter des collègues',
	'groups:invite:title' => 'Invite friends to this group', //translate
	'groups:inviteto' => "Inviter des collègues à '%s'",
	'groups:nofriends' => "Tous vos collègues ont été invités à faire partie de ce groupe.",
	'groups:nofriendsatall' => 'You have no friends to invite!', //translate
	'groups:viagroups' => "par l'intermédiaire de groupes",
	'groups:group' => "Groupe",
	'groups:notfound' => "Groupe introuvable",
	'groups:notfound:details' => "Le groupe demandé est inexistant ou vous n'y avez pas accès",
	'groups:requests:none' => "Il n'y a actuellement aucune demande d'adhésion en attente.",
	'groups:search:tags' => "tag",
	'groups:search:title' => "Rechercher des groupes ayant les mots-clés '%s'",
	'groups:search:none' => "Aucun groupe n’a été trouvé avec ces critères de recherche",
	'groups:search_in_group' => "Rechercher dans ce groupe",
	'groups:acl' => "Group: %s",
	'groups:permissions:error' => 'You do not have the permissions for this',
	'groups:ingroup' => 'in the group',

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

	'groups:notfound' => "Group not found", //translate
	'groups:notfound:details' => "The requested group either does not exist or you do not have access to it", //translate

	'groups:requests:none' => 'There are no current membership requests.', //translate

	'groups:invitations:none' => "Il n’y a aucune invitation pour l’instant.", //translate

	'item:object:groupforumtopic' => "Sujets de discussion",

	'groupforumtopic:new' => "Nouvel article de discussion",

	'groups:count' => "groupes créés",
	'groups:open' => "groupe ouvert",
	'groups:closed' => "groupe fermé",
	'groups:member' => "membres",
	'groups:searchtag' => "Recherche de groupes par mot-clé",

	'groups:more' => 'Plus de groupes', //translate
	'groups:none' => 'Aucun groupe',

	/*
	* Access
	*/
	'groups:access:private' => 'Fermé - Les utilisateurs doivent être invités',
	'groups:access:public' => 'Ouvert - Tout utilisateur peut participer',
	'groups:access:group' => 'Membres du groupe seulement',
	'groups:closedgroup' => "Ce groupe est fermé. Pour y être ajouté, cliquez sur le lien de menu 'demande d'ajout au groupe'.",
	'groups:closedgroup:request' => 'To ask to be added, click the "request membership" menu link.', //translate
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

	'discussion:reply:deleted' => 'Réponse de discussion a été supprimé.',
	'discussion:reply:error:notdeleted' => 'Impossible de supprimer la réponse de discussion',

	'reply:this' => 'Reply to this', //translate

	'group:replies' => 'Réponses',
	'groups:forum' => 'Discussion de groupe',
	'groups:forum:created' => 'Created %s with %d comments', //translate
	'groups:forum:created:single' => 'Created %s with %d reply', //translate
	'groups:addtopic' => 'Ajouter un sujet',
	'groups:forumlatest' => 'Dernière discussion',
	'groups:latestdiscussion' => 'Dernière discussion',
	'groups:newest' => 'La plus récente',
	'groups:popular' => 'Populaire',
	'groupspost:success' => 'Votre commentaire a été publié avec succès',
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
	'groupstopic:deleted' => 'Le sujet a été supprimé.',
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
	'groups:cantremove' => 'Cannot remove user from group', //translate
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

	'river:create:group:default' => '%s a créé le groupe %s', //translate
	'river:join:group:default' => '%s s’est joint(e) au groupe %s',
	'river:create:object:groupforumtopic' => '%s added a new discussion topic %s', //translate
	'river:reply:object:groupforumtopic' => '%s a répondu dans le fil de discussion %s', //translate

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

	'groups:allowhiddengroups' => 'Do you want to allow private (invisible) groups?', //translate

	/**
	* Action messages
	*/
	'group:deleted' => 'Groupe et contenu du groupe supprimés',
	'group:notdeleted' => 'Il a été impossible de supprimer le groupe',

	'group:notfound' => 'Could not find the group', //translate
	'grouppost:deleted' => 'Publication du groupe supprimée avec succès',
	'grouppost:notdeleted' => 'Il a été impossible de supprimer le groupe',
	'groupstopic:deleted' => 'Sujet supprimé',
	'groupstopic:notdeleted' => 'Sujet non supprimé',
	'grouptopic:blank' => "Il n'y a pas de sujet de discussion",
	'grouptopic:notfound' => 'Could not find the topic', //translate
	'grouppost:nopost' => 'Empty post', //translate
	'groups:deletewarning' => "Êtes-vous certain de vouloir supprimer ce groupe? L'opération ne peut être annulée!",

	'groups:invitekilled' => 'The invite has been deleted.', //translate
	'groups:joinrequestkilled' => "La demande d'ajout au groupe a été supprimée.",

	// ecml
	'groups:ecml:discussion' => 'Group Discussions', //translate
	'groups:ecml:groupprofile' => 'Group profiles', //translate
);

add_translation("fr",$french);