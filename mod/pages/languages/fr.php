<?php
/**
 * Pages languages
 *
 * @package ElggPages
 */

$french = array(

	/**
	 * Menu items and titles
	 */

	'pages' => "Pages",
	'pages:owner' => "Pages du %s",
	'pages:friends' => "Pages de collègues",
	'pages:all' => "Toutes les pages du site",
	'pages:add' => "Ajouter une page",

	'pages:group' => "Pages de groupe",
	'groups:enablepages' => 'Activer pages de groupe',

	'pages:edit' => "Modifier cette page",
	'pages:delete' => "Supprimer cette page",
	'pages:history' => "Historique",
	'pages:view' => "Afficher la page",
	'pages:revision' => "Revision",
	'pages:current_revision' => "La Version Courante",
	'pages:revert' => "Revenir",

	'pages:navigation' => "Navigation",
	'pages:new' => "Une nouvelle page",
	'pages:notification' =>
'%s added a new page:

%s
%s

View and comment on the new page:
%s
',
	'item:object:page_top' => 'Pages de niveau supérieur',
	'item:object:page' => 'Pages',
	'pages:nogroup' => "Ce groupe n'a pas encore de pages",
	'pages:more' => 'Plus de pages',
	'pages:none' => 'Aucune page créée pour le moment',

	/**
	* River
	**/

	'river:create:object:page' => '%s a créé une page %s',
	'river:create:object:page_top' => '%s a créé une page %s',
	'river:update:object:page' => '%s a modifié cette page %s',
	'river:update:object:page_top' => '%s a modifié cette page %s',
	'river:comment:object:page' => '%s a commenté une page intitulée %s',
	'river:comment:object:page_top' => '%s a commenté une page intitulée%s',

	/**
	 * Form fields
	 */

	'pages:title' => 'Titre de la page',
	'pages:description' => 'Texte de la page',
	'pages:tags' => 'Étiquettes',
	'pages:parent_guid' => 'Page parent',
	'pages:access_id' => 'Accès en lecture seule',
	'pages:write_access_id' => 'Accès en écriture',

	/**
	 * Status and error messages
	 */
	'pages:noaccess' => "Pas d'accès à la page",
	'pages:cantedit' => 'Vous ne pouvez pas modifier cette page',
	'pages:saved' => 'Page enregistrée',
	'pages:notsaved' => "Cette page n'a pas pu être sauvé.",
	'pages:error:no_title' => 'Vous devez spécifier un titre pour cette page.',
	'pages:delete:success' => 'La page a été supprimée.',
	'pages:delete:failure' => "Cette page n'a pas pu être supprimé.",
	'pages:revision:delete:success' => 'The page revision was successfully deleted.',
	'pages:revision:delete:failure' => 'The page revision could not be deleted.',
	'pages:revision:not_found' => 'Cannot find this revision.',

	/**
	 * Page
	 */
	'pages:strapline' => 'Dernière mise à jour à %s par %s',

	/**
	 * History
	 */
	'pages:revision:subtitle' => 'Dernière mise à jour à %s par %s',

	/**
	 * Widget
	 **/

	'pages:num' => 'Nombre de pages à afficher',
	'pages:widget:description' => "C'est une liste de vos pages.",

	/**
	 * Submenu items
	 */
	'pages:label:view' => "Afficher la page",
	'pages:label:edit' => "Modifier la page",
	'pages:label:history' => "Historique de la page",

	/**
	 * Sidebar items
	 */
	'pages:sidebar:this' => "Cette page",
	'pages:sidebar:children' => "Sous-pages",
	'pages:sidebar:parent' => "Parent",

	'pages:newchild' => "Créer une sous-page",
	'pages:backtoparent' => "Retour à '%s'",
);

add_translation("fr", $french);
