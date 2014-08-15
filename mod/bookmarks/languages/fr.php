<?php
/**
* Bookmarks English language file
*/

$french = array(

	/**
	* Menu items and titles
	*/
	'bookmarks' => "Signets",
	'bookmarks:add' => "Définir un signet",
	'bookmarks:edit' => "Modifier signet",
	'bookmarks:read' => "Signets définis",
	'bookmarks:owner' => "Signets de '%s'",
	'bookmarks:friends' => "Signets de collègues",
	'bookmarks:everyone' => "Tous les signets de site",
	'bookmarks:this' => "Mettre en signet",
	'bookmarks:this:group' => "Signet dans %s",
	'bookmarks:bookmarklet' => "Obtenir l'applisignet",
	'bookmarks:bookmarklet:group' => "Obtenir l'applisignet de groupe",
	'bookmarks:inbox' => "Boîte de réception de signets",
	'bookmarks:morebookmarks' => "Plus signets",
	'bookmarks:more' => "Plus",
	'bookmarks:shareditem' => "Signet défini",
	'bookmarks:with' => "Partager avec",
	'bookmarks:new' => "Nouveau signet",
	'bookmarks:via' => "au moyen de signets",
	'bookmarks:address' => "Adresse de la ressource à mettre en signet",
	'bookmarks:none' => 'Pas de signets',

	'bookmarks:notification' =>
'%s a ajouté un nouveau signet:

%s - %s
%s

Voir et commenter le nouveau signet:
%s
',

	'bookmarks:delete:confirm' => "Êtes-vous certain de vouloir supprimer cette ressource?",

	'bookmarks:numbertodisplay' => 'Nombre de signets à afficher',

	'bookmarks:shared' => "Mis en signet",
	'bookmarks:visit' => "Se rendre sur la ressource",
	'bookmarks:recent' => "Signets récents",

	'river:create:object:bookmarks' => '%s mis en signet %s',
	'river:comment:object:bookmarks' => '%s a commenté un signet %s',
	'bookmarks:river:created' => '%s a créé un signet',
	'bookmarks:river:annotate' => "a publié un commentaire sur l'élément de ce signet",
	'bookmarks:river:item' => 'un élément',

	'item:object:bookmarks' => 'Éléments mis en signet',

	'bookmarks:group' => 'signets de groupe',
	'bookmarks:enablebookmarks' => 'Activer les signets de groupe',
	'bookmarks:nogroup' => "Ce groupe n'a pas encore de signets",
	'bookmarks:more' => 'Plus signets',

	'bookmarks:no_title' => 'No title',

	/**
	 * Widget and bookmarklet
	 */
	'bookmarks:widget:description' => "Ce widget est conçu pour votre tableau de bord. Il affichera les deniers éléments dans votre boîte de réception de signets.",

	'bookmarks:bookmarklet:description' => "L'applisignet vous permet de partager avec vos collègues les ressources que vous trouvez dans le Web ou de simplement définir des signets pour vous-même. Pour l'utiliser, vous n'avez qu'à faire glisser le bouton suivant sur la barre de liens de votre navigateur :",

	'bookmarks:bookmarklet:descriptionie' => "Si vous employez Internet Explorer, vous devez cliquer avec le bouton droit de la souris sur l'icône de l'applisignet et choisir 'Ajouter aux favoris', puis Liens.",

	'bookmarks:bookmarklet:description:conclusion' => "Vous pourrez ensuite enregistrer toute page que vous consultez en cliquant sur l'icône.",

	/**
	* Status messages
	*/

	'bookmarks:save:success' => "L'élément a été mis en signet.",
	'bookmarks:delete:success' => "Le signet a été supprimé.",

	/**
	* Error messages
	*/

	'bookmarks:save:failed' => "Impossible d'enregistrer le signet. Veuillez réessayer.",
	'bookmarks:save:invalid' => "L'adresse du signet n'est pas valide et ne peut pas être enregistré.",
	'bookmarks:delete:failed' => "Impossible de supprimer le signet. Veuillez réessayer.",

	/**
	 * Email
	 */
		
		'bookmarks:share:email:subject' => "%s a partagé un signet avec vous.",
		'bookmarks:share:email:body' => "%s a partagé un signet avec vous. Le signet '%s' a été ajouté à votre boîte de réception de signets.
		
Vous pouvez voir votre boîte de réception de signets à l'adresse suivante:

%s",

);

add_translation("fr",$french);