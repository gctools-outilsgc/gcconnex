<?php

$french = array(

	'forums:jmp_menu' => 'Carrefour d\'emploi',
	'forums:jmp_url' => '/forum/group/42',
	'edit:object:hjforum:disable_posting' => "Désactiver l'affichage dans ce forum",

	'c_hj:forum:new:hjforum' => 'New sub-forum / Nouveau sous-forum',
	'c_hj:forum:new:hjforumtopic' => 'New forum topic / Nouveau sujet',
	'c_hj:forum:new:hjforumpost' => 'New forum post / Nouveau post sur le forum',

	'c_hj:forum:body:hjforumtopic' => "
	%s has started a new forum topic <strong>%s</strong> located in [ <i>%s</i> ] with the following content:%s
	You can view this item %s.

	<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a lancé un nouveau sujet sur le forum <strong>%s</strong> dans [ <i>%s</i> ] avec le contenu suivant :%s
	Vous pouvez consulter cet article %s.
	",

	'c_hj:forum:body:hjforum' => "
	%s has started a new sub-forum <strong>%s</strong> located in [ <i>%s</i> ] with the following content:%s
	You can view this item %s.

	<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a lancé un nouveau sous-forum sur le forum <strong>%s</strong> dans [ <i>%s</i> ] avec le contenu suivant :%s
	Vous pouvez consulter cet article %s.
	",

	'c_hj:forum:body:hjforumpost' => "
	%s has started a new forum post <strong>%s</strong> located in [ <i>%s</i> ] with the following content:%s
	You can view this item %s.

	<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a lancé un nouveau post sur le forum <strong>%s</strong> dans [ <i>%s</i> ] avec le contenu suivant :%s
	Vous pouvez consulter cet article %s.
	",

	'hj:forum:nocategories' => "Vous n’avez pas encore créé de catégories. Veuillez en créer à l’aide du formulaire ci-dessous",
	'c_hj:forum:nocategories' => "S'il n'y a pas de catégories, les forums ne seront pas affichés. S'il vous plaît, créer une nouvelle catégorie en sélectionnant la « Nouvelle catégorie de forums »",
	
	// Form Elements
	'edit:object:hjforum:cover' => "Image de couverture",
	'edit:object:hjforum:title' =>  "Sujet du forum",
	'edit:object:hjforum:description' => "Description",
	'edit:object:hjforum:access_id' => "Visibilité",
	'edit:object:hjforum:category' => "Catégorie",
	'edit:object:hjforum:enable_subcategories' => "Autoriser les sous-catégories",

	'edit:object:hjforumtopic:cover' => "Couverture",
	'edit:object:hjforumtopic:icon' => "Icône",
	'edit:object:hjforumtopic:title' => "Titre",
	'edit:object:hjforumtopic:description' => "Description",
	'edit:object:hjforumtopic:category' => "Catégorie",
	'edit:object:hjforumtopic:access_id' => "Visibilité",
	

	'hj:forum:tablecol:forum' => '',
	'hj:forum:tablecol:topics' => "Sujets",
	'hj:forum:tablecol:posts' => "Messages",
	'hj:forum:tablecol:last_post' => "Dernier poste",

	'river:in:forum' => ' dans %s',
	'river:create:object:hjforum' => "%s a créé un nouveau forum | %s",
	'river:create:object:hjforumtopic' => "%s a commencé un nouveau sujet sur le forum | %s",
	'river:create:object:hjforumpost' => '%s posté une réponse au sujet %s',
	
	'edit:object:hjforumcategory:title' => "Nom de la catégorie",
	'edit:object:hjforumcategory:description' => "Brève description",

	'edit:object:hjforumpost:description' =>  "Description",
	
	'hj:forum:notsetup' => "Ce forum n’a pas encore été configuré",

	'hj:forum:create:forum' =>  "Nouveau forum",
	'hj:forum:create:subforum' => "Nouveau sous-forum",
	'hj:forum:create:topic' => "Nouveau sujet",
	'hj:forum:create:post' => "Nouvelle réponse",
	'hj:forum:create:post:quote' => "Citation et réponse",
	'hj:forum:create:category' => "Nouvelle catégorie de forums",

	'hj:forum:dashboard:site' => "Forums à l’échelle du site",
	'hj:forum:dashboard:groups' => "Forums de groupe",
	'hj:forum:dashboard:bookmarks' => "Sujets du forum marqués d’un signet",
	'hj:forum:dashboard:subscriptions' => "Abonnements à des forums",

	'hj:forum:dashboard:tabs:site' => "Forums à l’échelle du site",
	'hj:forum:dashboard:tabs:groups' => "Forums de groupes",
	'hj:forum:dashboard:tabs:bookmarks' => "Signets",
	'hj:forum:dashboard:tabs:subscriptions' => "Abonnement",

	'edit:plugin:hypeforum:params[categories_top]' => "Autoriser des catégories pour les sites de niveau supérieur et regrouper les forums",
	'edit:plugin:hypeforum:hint:categories_top' => "L’activation de cette option vous permettra de créer de multiples catégories de niveau supérieur, et les forums seront regroupés par catégorie",

	'edit:plugin:hypeforum:params[categories]' => "Autoriser les catégories pour les sujets et les forums établis",
	'edit:plugin:hypeforum:hint:categories' => "L’activation de cette option vous permettra de jumeler des catégories avec des forums individuels; les sous-forums et les sujets seront regroupés par catégorie",

	'edit:plugin:hypeforum:params[subforums]' =>  "Autoriser les sous-forums",

	'edit:plugin:hypeforum:hint:subforums' => "L’activation de cette option vous permettra de créer des forums dans les forums; par défaut, les éléments seront classés dans l’ordre suivant : sous-forums suivis des sujets délicats, suivis des sujets ordinaires, puis des derniers messages",

	'edit:plugin:hypeforum:params[forum_cover]' => "Autoriser les images de couverture pour les forums",
	'edit:plugin:hypeforum:hint:forum_cover' => "Si l’option est activée, les auteurs des forums pourront ajouter des images de couverture, qui seront utilisées comme icônes et affichées comme image de couverture dans l’affichage complet du forum",
	
	'edit:plugin:hypeforum:params[forum_sticky]' =>  "Autoriser les sujets délicats",
	'edit:plugin:hypeforum:hint:forum_sticky' => "Dans l’ordre par défaut de la liste, les sujets délicats seront affichés en premier; ils seront aussi identifiés par une icône",

	'edit:plugin:hypeforum:params[forum_topic_cover]' =>  "Autoriser les images de couverture pour les sujets",
	'edit:plugin:hypeforum:hint:forum_topic_cover' =>  "Si l’option est activée, les auteurs des sujets pourront ajouter des images de couverture à leurs sujets",

	'edit:plugin:hypeforum:params[forum_topic_icon]' => "Autoriser les icônes de sujets",
	'edit:plugin:hypeforum:hint:forum_topic_icon' => "Si l’option est activée, les auteurs des sujets pourront choisir une icône pour leur sujet (voir les options ci-dessous pour une liste d’icônes)",

	'edit:plugin:hypeforum:params[forum_topic_icon_types]' => "Liste des types d’icônes de sujets",
	'edit:plugin:hypeforum:topic_icon_hint' => "Séparés par une virgule. Les icônes doivent être chargées dans mod/hypeForum/graphics/forumtopic/",

	'edit:plugin:hypeforum:params[forum_forum_river]' => "Ajouter de nouveaux forums au volet",
	'edit:plugin:hypeforum:hint:forum_forum_river' => "Ajouter des renseignements au sujet des nouveaux forums dans le volet d’activités",

	'edit:plugin:hypeforum:params[forum_topic_river]' => "Ajouter de nouveaux sujets à la rivière",
	'edit:plugin:hypeforum:hint:forum_forum_river' => "Ajouter des renseignements sur les nouveaux sujets de forum dans le volet d’activités",

	'edit:plugin:hypeforum:params[forum_post_river]' => "Ajouter de nouveaux messages au volet",
	'edit:plugin:hypeforum:hint:forum_forum_river' => "Ajouter des renseignements sur les nouvelles publications dans les forums dans le volet d’activités",

	'edit:plugin:hypeforum:params[forum_subscriptions]' => "Permettre l’abonnement aux notifications",
	'edit:plugin:hypeforum:hint:forum_subscriptions' =>     "L’activation de cette option permettra aux utilisateurs de s’abonner ou de se désabonner pour recevoir des notifications sur un sujet du forum",


	'edit:plugin:hypeforum:params[forum_bookmarks]' => "Autoriser les signets",
	'edit:plugin:hypeforum:hint:forum_bookmarks' => "L’activation de cette option permettra aux utilisateurs de marquer des sujets du forum d’un signet et de les afficher dans un onglet séparé du tableau de bord",

	'edit:plugin:hypeforum:params[forum_group_forums]' => "Autoriser le regroupement des forums",
	'edit:plugin:hypeforum:hint:forum_group_forums' => "Ajouter des fonctions de forum aux groupes",

	'edit:plugin:hypeforum:params[forum_user_signature]' => "Autoriser les signatures des utilisateurs dans les messages sur les forums",
	'edit:plugin:hypeforum:hint:forum_user_signature' => "Permettre aux utilisateurs de créer une signature automatique et de la joindre à toutes leurs publications; un forum permettant d’ajouter une signature sera disponible dans utilisateurs\paramètres des outils",
	
	'hj:forum:filter' => "Filtrer les forums",

	'hj:forum:quote:author' => "%s a écrit:",

	'hj:forum:groups:notamember' => "Vous n’avez encore joint aucun groupe",

	'hj:forum:groupoption:enableforum' => "Autoriser le regroupement des forums",
	'hj:forum:group' => "Forums de groupe",

	'hj:forum:dashboard:group' => "%s",

	'edit:object:hjforum:sticky' => "Sujet épinglé",
	'hj:forum:sticky' => "sujet épinglé",

	'hj:forum:new:hjforum' => "Un nouveau sous-forum",
	'hj:forum:new:hjforumtopic' => "Un nouveau sujet de forum",
	'hj:forum:new:hjforumpost' => "Un nouveau message sur un forum",

	'hj:forum:user:settings' => "Paramètres du forum",

	'edit:plugin:user:hypeforum:params[hypeforum_signature]' => "Ajouter une signature à mes publications dans le forum :",

	'hj:forum:bookmark:create' => "Marquer d’un signet",
	'hj:forum:bookmark:remove' => "Retirer le signet",
	'hj:forum:bookmark:create:error' => "L’élément ne peut pas être marqué d’un signet",
	'hj:forum:bookmark:create:success' => "L’élément a été marqué d’un signet",
	'hj:forum:bookmark:remove:error' => "Le signet ne peut pas être retiré",
	'hj:forum:bookmark:remove:success' => "Le signet a été retiré avec succès",

	'hj:forum:subscription:create' => "S’abonner",
	'hj:forum:subscription:remove' =>  "Se désabonner",
	'hj:forum:subscription:create:error' => "Vous pouvez/ne pouvez pas vous abonner à cet élément",
	'hj:forum:subscription:create:success' => "Vous êtes maintenant abonné à cet élément",
	'hj:forum:subscription:remove:error' => "Vous ne pouvez pas vous désabonner de cet élément",
	'hj:forum:subscription:remove:success' => "Vous n’êtes plus abonné à cet élément"	
	
);


add_translation("fr", $french);
?>