<?php 

	$french = array(
		
		'widgets:twitter_search:embed_code:help' => "Créez un widget sur Twitter.com et placez votre code intégré ici",
		'widgets:twitter_widget:name' => "Twitter Widget",
		'widgets:twitter_search:embed_code' => "Twitter Widget Intégrer Code",
		'widgets:twitter_widget:type' => "Type de widget",

		// special access level			
					
		'LOGGED_OUT' => "Utilisateurs dont la session est fermée",
		'access:admin_only' => "Administrateurs seulement",
					
		// admin menu items			
					
		'admin:widgets' => "Widgets",
		'admin:widgets:manage' => "Gérer",
		'admin:widgets:manage:index' => "Gérer l'index",
		'admin:statistics:widgets' => "Utilisation des widgets",
					
		// widget edit wrapper			
					
		'widget_manager:widgets:edit:custom_title' => "Titre personnalisé",
		'widget_manager:widgets:edit:custom_url' => "Lien du titre personnalisé",
		'widget_manager:widgets:edit:hide_header' => "Masquer l'en-tête",
		'widget_manager:widgets:edit:custom_class' => "Classe CSS personnalisée",
		'widget_manager:widgets:edit:disable_widget_content_style' => "Aucun style de widget",
					
		// group			
					
		'widget_manager:groups:enable_widget_manager' => "Activer la gestion des widgets",
					
		// admin settings			
					
		'widget_manager:settings:index' => "Index",
		'widget_manager:settings:group' => "Groupe",			
		'widget_manager:settings:custom_index' => "Utiliser l'index personnalisé du gestionnaire de widgets?",
		'widget_manager:settings:custom_index:non_loggedin' => "Seulement les utilisateurs dont la session est fermée",
		'widget_manager:settings:custom_index:loggedin' => "Seulement les utilisateurs dont la session est ouverte",
		'widget_manager:settings:custom_index:all' => "Tous les utilisateurs",		
		'widget_manager:settings:widget_layout' => "Choisir la disposition des widgets",
		'widget_manager:settings:widget_layout:33|33|33' => "Disposition par défaut (33 % par colonne)",
		'widget_manager:settings:widget_layout:50|25|25' => "Colonne élargie à gauche (50 %, 25 %, 25 %)",
		'widget_manager:settings:widget_layout:25|50|25' => "Colonne élargie au centre (25 %, 50 %, 25 %)",
		'widget_manager:settings:widget_layout:25|25|50' => "Colonne élargie à droite (25 %, 25 %, 50 %)",
		'widget_manager:settings:widget_layout:75|25' => "Sur deux colonnes (75 %, 25 %)",
		'widget_manager:settings:widget_layout:60|40' => "Sur deux colonnes (60 %, 40 %)",
		'widget_manager:settings:widget_layout:50|50' => "Sur deux colonnes (50 %, 50 %)",
		'widget_manager:settings:widget_layout:40|60' => "Sur deux colonnes (40 %, 60 %)",
		'widget_manager:settings:widget_layout:25|75' => "Sur deux colonnes (25 %, 75 %)",
		'widget_manager:settings:widget_layout:100' => "Sur une seule colonne (100 %)",
		'widget_manager:settings:index_top_row' => "Afficher une rangée en haut de la page de l'index",
		'widget_manager:settings:index_top_row:none' => "Aucune rangée du haut",
		'widget_manager:settings:index_top_row:full_row' => "Rangée pleine largeur",
		'widget_manager:settings:index_top_row:two_column_left' => "Deux colonnes alignées à gauche",			
		'widget_manager:settings:disable_free_html_filter' => "Désactiver le filtrage HTML pour les widgets en HTML libre figurant dans l'index (ADMINISTRATEURS SEULEMENT)",			
		'widget_manager:settings:group:enable' => "Activer le gestionnaire des widgets pour les groupes",
		'widget_manager:settings:group:option_default_enabled' => "La gestion par défaut des widgets pour les groupes est activée",
		'widget_manager:settings:group:option_admin_only' => "Seul un administrateur peut activer les widgets de groupe",						
		'widget_manager:settings:multi_dashboard' => "Tableaux de bord multiples",
		'widget_manager:settings:multi_dashboard:enable' => "Autoriser l'utilisation de tableaux de bord multiples",
		'widget_manager:settings:group:enable:forced' => "Oui, laisser toujours cette option activée",
		'widget_manager:settings:group:force_tool_widgets' => "Appliquer les widgets de la trousse d'outils de groupe",
		'widget_manager:settings:group:force_tool_widgets:confirm' => "Êtes-vous sûr? Cette action ajoutera/supprimera tous les widgets propres à une option de la trousse d'outils pour tous les groupes (si la gestion des widgets est activée).",			
		'widget_manager:settings:dashboard' => "Tableau de bord",
		'widget_manager:settings:dashboard:dashboard_widget_layout' => "Disposition des widgets dans le tableau de bord",
		'widget_manager:settings:dashboard:dashboard_widget_layout:info' => "Cet agencement des widgets ne s'applique qu'au tableau de bord par défaut et non aux tableaux de bords supplémentaires créés au moyen de l'option « Autoriser les tableaux de bord multiples »",
		'widget_manager:settings:extra_contexts' => "Contextes additionnels pour les widgets",
		'widget_manager:settings:extra_contexts:add' => "Nouvelle page",
		'widget_manager:settings:extra_contexts:description' => "Entrez le nom du mutateur de page (page handler) de la nouvelle page dont la mise en page sera semblable à celle de la page d'index. Vous pouvez ajouter autant de pages que vous en avez besoin. Assurez-vous de ne pas ajouter un mutateur de page déjà utilisé. Vous pouvez aussi configurer la disposition des colonnes dans cette page et désigner des utilisateurs qui n'ont pas le rôle d'administrateur comme gestionnaire de page en inscrivant leur nom d'utilisateur. Vous pouvez désigner plusieurs gestionnaire en séparant les noms d'utilisateur par une virgule.",
		'widget_manager:settings:extra_contexts:page' => "Page",
		'widget_manager:settings:extra_contexts:layout' => 	"Disposition",
		'widget_manager:settings:extra_contexts:top_row' => "Rangée supplémentaire en haut",
		'widget_manager:settings:extra_contexts:manager' => "Gestionnaire",
		'widget_manager:settings:extra_contexts' => "Contextes additionnels pour les widgets",
		'widget_manager:settings:extra_contexts:add' => "Nouvelle page",


		// views
		// settings
		'widget_manager:forms:settings:no_widgets' => "Aucun widgets à ajouter",
		'widget_manager:forms:settings:can_add' => "Ajout possible",
		'widget_manager:forms:settings:hide' => "Masquer",
					
		// lightbox			
					
		'widget_manager:button:add' => "Ajouter un widget",
		'widget_manager:widgets:lightbox:title:dashboard' => "Ajouter des widgets à votre tableau de bord personnel",
		'widget_manager:widgets:lightbox:title:profile' => "Ajouter des widgets à votre profil public",
		'widget_manager:widgets:lightbox:title:index' => "Ajouter des widgets à l'index",
		'widget_manager:widgets:lightbox:title:groups' => "Ajouter des widgets au profil du groupe",
		'widget_manager:widgets:lightbox:title:admin' => "Ajouter des widgets à votre tableau de bord d'administrateur",
					
		// multi dashboard			
					
		'widget_manager:multi_dashboard:add' => "Nouvel onglet",
		'widget_manager:multi_dashboard:extras' => "Ajouter en tant qu’onglet du tableau de bord",
					
		// multi dashboard - edit			
					
		'widget_manager:multi_dashboard:new' => "Créer un nouveau tableau de bord",
		'widget_manager:multi_dashboard:edit' => "Modifier le tableau de bord : %s",			
		'widget_manager:multi_dashboard:types:title' => "Sélectionnez un type de tableau de bord",
		'widget_manager:multi_dashboard:types:widgets' => "Widgets",
		'widget_manager:multi_dashboard:types:iframe' => "iFrame",			
		'widget_manager:multi_dashboard:num_columns:title' => "Nombre de colonnes",
		'widget_manager:multi_dashboard:iframe_url:title' => "Adresse URL de l'iFrame",
		'widget_manager:multi_dashboard:iframe_url:description' => "Remarque : Vérifiez que l'adresse URL commence par http:// ou https://. Tous les sites ne supportent pas nécessairement l'utilisation des iFrames",
		'widget_manager:multi_dashboard:iframe_height:title' => "hauteur de l'iFrame",			
		'widget_manager:multi_dashboard:required' => "Les champs marqués d’un * sont obligatoires",
					
		// actions			
		// manage			
					
		'widget_manager:action:manage:error:context' => "Contexte invalide pour la sauvegarde de la configuration du widget",
		'widget_manager:action:manage:error:save_setting' => "Une erreur s'est produite lors de la sauvegarde du paramètre  %s du widget %s",
		'widget_manager:action:manage:success' => "Le configuration du widget a été sauvegardée avec succès",
					
		//// multi dashboard - edit			
					
		'widget_manager:actions:multi_dashboard:edit:error:input' => "Entrée invalide, veuillez inscrire un titre",
		'widget_manager:actions:multi_dashboard:edit:success' => "Le tableau de bord a été créé ou modifié avec succès",
					
		// multi dashboard - delete			
					
		'widget_manager:actions:multi_dashboard:delete:error:delete' => "Suppression du tableau de bord %s impossible",
		'widget_manager:actions:multi_dashboard:delete:success' => "Suppression du tableau de bord %s réussie",
					
		// multi dashboard - drop			
					
		'widget_manager:actions:multi_dashboard:drop:success' => "Le widget a bien été transposé dans le nouveau tableau de bord",
					
		// multi dashboard - reorder			
					
		'widget_manager:actions:multi_dashboard:reorder:error:order' => "Veuillez préciser un nouvel ordre de disposition",
		'widget_manager:actions:multi_dashboard:reorder:success' => "La réoganisation du tableau de bord a été effectuée avec succès",
					
		// widgets			
					
		'widget_manager:widgets:edit:advanced' => "Avancé",
		'widget_manager:widgets:fix' => "Épingler ce widget sur le tableau de bord ou la page du profil",
					
		// index_login			
					
		'widget_manager:widgets:index_login:description' => "Afficher une fenêtre d'ouverture de session",
		'widget_manager:widgets:index_login:welcome' => "Bienvenue, <b>%s</b>, dans la communauté <b>%s</b>",
					
		// index_members			
					
		'widget_manager:widgets:index_members:name' => 	"Membres",
		'widget_manager:widgets:index_members:description' => "Ce widget sert à afficher la liste des membres de votre site",
		'widget_manager:widgets:index_members:user_icon' => "Rendre l'icône de profil obligatoire pour les utilisateurs",
		'widget_manager:widgets:index_members:no_result' => "Aucun utilisateur n'a été trouvé",
					
		// index_memebers_online			
					
		'widget_manager:widgets:index_members_online:name' => "Membres en ligne",
		'widget_manager:widgets:index_members_online:description' => "Ce widget sert à afficher la liste des membres de votre site qui sont en ligne",
		'widget_manager:widgets:index_members_online:member_count' => "Nombre de membres à afficher",
		'widget_manager:widgets:index_members_online:user_icon' => "Rendre l'icône de profil obligatoire pour les utilisateurs",
		'widget_manager:widgets:index_members_online:no_result' => "Aucun utilisateur n'a été trouvé",
					
		// index_bookmarks			
					
		'widget_manager:widgets:index_bookmarks:description' => "Ce widget sert à afficher les derniers signets sur le site de votre communauté",
					
		// index_activity			
					
		'widget_manager:widgets:index_activity:description' => "Ce widget sert à afficher les dernières activités sur votre site",
					
		// image_slider			
					
		'widget_manager:widgets:image_slider:name' => "Diaporama",
		'widget_manager:widgets:image_slider:description' => "Ce widget sert à afficher un diaporama d'images",
		'widget_manager:widgets:image_slider:slider_type' => "Type de diaporama",
		'widget_manager:widgets:image_slider:slider_type:s3slider' => "s3Slider",
		'widget_manager:widgets:image_slider:slider_type:flexslider' => "FlexSlider",
		'widget_manager:widgets:image_slider:seconds_per_slide' => "Temps d'affichage de chaque diapositive en secondes",
		'widget_manager:widgets:image_slider:slider_height' => "Hauteur de la diapositive (pixels)",
		'widget_manager:widgets:image_slider:overlay_color' => "Couleur de la couche (hex)",
		'widget_manager:widgets:image_slider:title' => "Diapositive",
		'widget_manager:widgets:image_slider:label:url' => "Adresse URL de l'image",
		'widget_manager:widgets:image_slider:label:text' => "Texte",
		'widget_manager:widgets:image_slider:label:link' => 	"Lien",
		'widget_manager:widgets:image_slider:label:direction' => "Orientation",
		'widget_manager:widgets:image_slider:direction:top' => "En haut",
		'widget_manager:widgets:image_slider:direction:right' => "À droite",
		'widget_manager:widgets:image_slider:direction:bottom' => "En bas",
		'widget_manager:widgets:image_slider:direction:left' => "À gauche",			
		'widget_manager:filter_widgets' => "Filtrer les widgets",			
		'widget_manager:settings:group:enable:yes' => "Oui, les gérer par l'option outils de groupe",
		'widget_manager:settings:group:enable:forced' => "Oui, laisser cette option toujours activée",
		'widget_manager:settings:group:force_tool_widgets' => "Appliquer les widgets de la trousse d'outils de groupe",
		'widget_manager:settings:group:force_tool_widgets:confirm' => "Êtes-vous sûr? Cette action ajoutera/supprimera tous les widgets propres à une option de la trousse d'outils pour tous les groupes (si la gestion des widgets est activée).",			
		'widget_manager:settings:dashboard:dashboard_widget_layout' => "Disposition des widgets dans le tableau de bord",
		'widget_manager:settings:dashboard:dashboard_widget_layout:info' => "Cet agencement des widgets ne s'applique qu'au tableau de bord par défaut et non aux tableaux de bords supplémentaires créés au moyen de l'option « Autoriser les tableaux de bord multiples »",
		'widget_manager:settings:multi_dashboard' => "Tableaux de bord multiples",
		'widget_manager:settings:multi_dashboard:enable' => "Autoriser les tableaux de bord multiples",			
		'widget_manager:settings:extra_contexts' => "Contextes additionnels pour les widgets",
		'widget_manager:settings:extra_contexts:add' => "Nouvelle page",
		'widget_manager:settings:extra_contexts:description' => "Entrez le nom du mutateur de page (page handler) de la nouvelle page dont la mise en page sera semblable à celle de la page index. Vous pouvez ajouter autant de pages que vous en avez besoin. Assurez-vous de ne pas ajouter un mutateur de page déjà utilisé. Vous pouvez aussi configurer la disposition des colonnes sur cette page et définir des utilisateurs qui n'ont pas le rôle d'administrateur comme gestionnaire de page en inscrivant leur nom d'utilisateur. Vous pouvez désigner plusieurs gestionnaire en séparant les noms d'utilisateur par une virgule.",
		'widget_manager:settings:extra_contexts:page' => "Page",
		'widget_manager:settings:extra_contexts:layout' => "Disposition",
		'widget_manager:settings:extra_contexts:top_row' => "Rangée supplémentaire en haut",
		'widget_manager:settings:extra_contexts:manager' => "Gestionnaire",

	);

	add_translation("fr", $french);

	$twitter_search = array(
		// twitter_search
		'widgets:twitter_search:name' => "Recherche sur Twitter",
		'widgets:twitter_search:description' => "Ce widget permet d'afficher une fenêtre de recherche personnalisée sur Twitter",			
		'widgets:twitter_search:query' => "Recherche",
		'widgets:twitter_search:query:help' => "Essayer une recherche avancée",
		'widgets:twitter_search:title' => "Titre du widget title (facultatif)",
		'widgets:twitter_search:subtitle' => "Sous-titre du widget (facultatif)",
		'widgets:twitter_search:height' => "Hauteur du widget (pixels)",
		'widgets:twitter_search:background' => "Définir une couleur d'arrière-plan personnalisée (HEX eq 4690d6)",
		'widgets:twitter_search:not_configured' => "Ce widget n'est pas encore configuré",

	);
	add_translation("fr", $twitter_search);
	
	$content_by_tag = array(
		// content_by_tag
'widgets:content_by_tag:name' => "Contenu trié par mot-clé",
'widgets:content_by_tag:description' => "Ce widget permet de trouver du contenu à l'aide de mots-clés",
			
'widgets:content_by_tag:owner_guids' => "Limiter la recherche au contenu produit par les auteurs suivants",
'widgets:content_by_tag:owner_guids:description' => "Rechercher l'utilisateur qui est l'auteur du contenu. Laissez le champ vide si vous ne souhaitez pas limiter la recherche en fonction de l'auteur.",
'widgets:content_by_tag:container_guids' => "N'afficher que le contenu produit par les groupes suivants",
'widgets:content_by_tag:container_guids:description' => "Rechercher un groupe dans lequel le contenu a été placé. Laissez le champ vide si vous ne souhaitez pas limiter la recherche en fonction des groupes.",
'widgets:content_by_tag:group_only' => "N'afficher que le contenu produit par ce groupe",
'widgets:content_by_tag:entities' => "Entités à afficher",
'widgets:content_by_tag:tags' => "Mots-clés (séparés par des virgules)",
'widgets:content_by_tag:tags_option' => "Utilisation des mots-clés",
'widgets:content_by_tag:tags_option:and' => "ET",
'widgets:content_by_tag:tags_option:or' => "OU",
'widgets:content_by_tag:excluded_tags' => "Mots-clés exclus",
'widgets:content_by_tag:display_option' => "Affichage du contenu",
'widgets:content_by_tag:display_option:normal' => "Normal",
'widgets:content_by_tag:display_option:simple' => "Simple",
'widgets:content_by_tag:display_option:slim' => "Sur une seule ligne",
'widgets:content_by_tag:highlight_first' => "Nombre d'éléments en surbrillance (affichage sur une seule ligne seulement)",
'widgets:content_by_tag:show_search_link' => "Afficher le lien de la recherche",
'widgets:content_by_tag:show_search_link:disclaimer' => "Les résultats de la recherche peuvent être différents du contenu apparaîssant dans le widget",
'widgets:content_by_tag:show_avatar' => "Afficher l'avatar des utilisateurs",
'widgets:content_by_tag:show_timestamp'	=> "Afficher l'horodatage du contenu",


	);
	add_translation("fr", $content_by_tag);
	
	$rss = array(
		// RSS widget (based on SimplePie)
		'widgets:rss:title' => "Fil RSS",
		'widgets:rss:description' => "Afficher un fil RSS (à partir de SimplePie)",
		'widgets:rss:error:notset' => "Aucune adresse URL de fil RSS indiquée",			
		'widgets:rss:settings:rss_count' => "Nombre de fils RSS à afficher",
		'widgets:rss:settings:rssfeed' => "Adresse URL du fil RSS",
		'widgets:rss:settings:show_feed_title' => "Afficher le titre du fil",
		'widgets:rss:settings:excerpt' => "Affichier un extrait",
		'widgets:rss:settings:show_item_icon' => "Afficher l'icône de l'élément (le cas échéant)",
		'widgets:rss:settings:post_date' => "Afficher la date de publication",
		'widgets:rss:settings:post_date:option:friendly' => "Afficher l'heure en format texte",
		'widgets:rss:settings:post_date:option:date' => "Afficher la date",

	);
	add_translation("fr", $rss);
	
	$free_html = array(
		// Free HTML
		'widgets:free_html:title' => "HTML libre",
		'widgets:free_html:description' => "Ajouter votre propre contenu en HTML",
		'widgets:free_html:settings:html_content' => "Veuillez inscrire le contenu en HTML à afficher",
		'widgets:free_html:no_content' => "Ce widget n'est pas encore configuré",

		// objects
		// 'item:object:multi_dashboard' => "Multi Dashboard",

	// admin menu items
		'admin:widgets' => "Widgets",
		'admin:widgets:manage' => "Gérer",
		'admin:widgets:manage:index' => "Gérer l'index",
		'admin:statistics:widgets' => "Utilisation des widgets",


	// widget edit wrapper
		'widget_manager:widgets:edit:custom_title' => "Titre personnalisé",
		'widget_manager:widgets:edit:custom_url' => "Lien du titre personnalisé",
		'widget_manager:widgets:edit:custom_more_title' => 'Plus de texte personnalisé',
		'widget_manager:widgets:edit:custom_more_url' => 'Plus de lien personnalisé',
		'widget_manager:widgets:edit:hide_header' => "Masquer l'en-tête",
		'widget_manager:widgets:edit:custom_class' => "Classe CSS personnalisée",
		'widget_manager:widgets:edit:disable_widget_content_style' => "Aucun style de widgets",
		'widget_manager:widgets:edit:fixed_height' => 'Ajuster la hauteur du widget (en pixel)',
		'widget_manager:widgets:edit:collapse_disable' => "Désactiver la possibilité de réduire",
		'widget_manager:widgets:edit:collapse_state' => "Apparence par défaut des éléments réduits",


			// group
		'widget_manager:groups:enable_widget_manager' => "Activer la gestion des widgets",

			// admin settings
		'widget_manager:settings:index' => "Index",
		'widget_manager:settings:group' => "Groupe",
		'widget_manager:settings:custom_index' => "Utiliser l'index personnalisé du gestionnaire des widgets?",
		'widget_manager:settings:custom_index:non_loggedin' => "Seulement les utilisateurs dont la session n'est pas ouverte",
		'widget_manager:settings:custom_index:loggedin' => "Seulement les utilisateurs dont la session est ouvertes",
		'widget_manager:settings:custom_index:all' => "Tous les utilisateurs",
		'widget_manager:settings:widget_layout' => "Choisir la disposition des widgets",
		'widget_manager:settings:widget_layout:75|25' => "Sur deux colonnes (75 %, 25 %)",
		'widget_manager:settings:widget_layout:60|40' => "Sur deux colonnes (60 %, 40 %)",
		'widget_manager:settings:widget_layout:50|50' => "Sur deux colonnes (50 %, 50 %)",
		'widget_manager:settings:widget_layout:40|60' => "Sur deux colonnes (40 %, 60 %)",
		'widget_manager:settings:widget_layout:25|75' => "Sur deux colonnes (25 %, 75 %)",
		'widget_manager:settings:widget_layout:100' => "Sur une seule colonne (100 %)",				
		'widget_manager:settings:index_top_row' => "Afficher une rangée en haut de la page de l'index",
		'widget_manager:settings:index_top_row:none' => "Aucune rangée en haut",
		'widget_manager:settings:index_top_row:full_row' => "Rangée pleine largeur",
		'widget_manager:settings:index_top_row:two_column_left' => "Sur deux colonnes, alignées à gauche",				
		'widget_manager:settings:disable_free_html_filter' => "Désactiver le filtre HTML pour les widgets en HTML libre figurant dans l'index (ADMINISTRATEUR SEULEMENT)",				
		'widget_manager:settings:group:enable' => "Activer le gestionnaire de wigdet pour les groupes",
		'widget_manager:settings:group:option_default_enabled' => "La gestion par défaut des widgets pour les groupes est activée",
		'widget_manager:settings:group:enable:forced' => "Oui, laisser toujours cette option activée",
		'widget_manager:settings:group:option_default_enabled' => "La gestion par défaut des widgets pour les groupes  est activée",
		'widget_manager:settings:group:option_admin_only' => "Seul un administrateur peut activer les widgets de groupe",
		'widget_manager:settings:group:force_tool_widgets' => 'Appliquer les widgets de la trousse d\'outils de groupe',
		'widget_manager:settings:group:force_tool_widgets:confirm' => "Êtes-vous sûr? Cette action ajoutera/supprimera tous les widgets propres à une option de la trousse d'outils pour tous les groupes (si la gestion des widgets est activée).",				
		'widget_manager:settings:dashboard' => "Tableau de bord",
		'widget_manager:settings:multi_dashboard:enable' => "Autoriser l'utilisation de tableaux de bord multiples",
		'widget_manager:settings:dashboard:dashboard_widget_layout' => "Disposition des widgets dans le tableau de bord",
		'widget_manager:settings:dashboard:dashboard_widget_layout:info' => "Cet agencement des widgets ne s'applique qu'au tableau de bord par défaut et non aux tableaux de bords supplémentaires créés au moyen de l'option « Autoriser les tableaux de bord multiples »",				
		'widget_manager:settings:extra_contexts' => "Contextes additionnels pour les widgets",
		'widget_manager:settings:extra_contexts:add' => "Nouvelle page",
		'widget_manager:settings:extra_contexts:description' => "Entrez le nom du mutateur de page (page handler) de la nouvelle page dont la mise en page sera semblable à celle de la page index. Vous pouvez ajouter autant de pages que vous en avez besoin. Assurez-vous de ne pas ajouter un mutateur de page déjà utilisé. Vous pouvez aussi configurer la disposition des colonnes sur cette page et définir des utilisateurs qui n'ont pas le rôle d'administrateur comme gestionnaire de page en inscrivant leur nom d'utilisateur. Vous pouvez désigner plusieurs gestionnaire en séparant les noms d'utilisateur par une virgule.",
		'widget_manager:settings:extra_contexts:page' => "Page",
		'widget_manager:settings:extra_contexts:layout' => 	"Disposition",
		'widget_manager:settings:extra_contexts:top_row' => "Rangée supplémentaire en haut",
		'widget_manager:settings:extra_contexts:manager' => "Gestionnaire",


	// views
	// settings
		'widget_manager:forms:settings:no_widgets' => "Il n'y a aucun widget à gérer",
		'widget_manager:forms:settings:can_add' => "Le widget peut être ajouté",
					
		// lightbox			
					
		'widget_manager:button:add' => "Ajouter un widget",
		'widget_manager:widgets:lightbox:title:dashboard' => "Ajouter des widgets à votre tableau de bord personnel",
		'widget_manager:widgets:lightbox:title:profile' => "Ajouter des widgets à votre profil public",
		'widget_manager:widgets:lightbox:title:index' => "Ajouter des widgets à l'index",
		'widget_manager:widgets:lightbox:title:groups' => "Ajouter des widgets au profil du groupe",
		'widget_manager:widgets:lightbox:title:admin' => "Ajouter des widgets à votre tableau de bord administrateur",
					
		// multi dashboard			
					
		'widget_manager:multi_dashboard:add' => "Nouvel onglet",
		'widget_manager:multi_dashboard:extras' => "Ajouter en tant qu’onglet du tableau de bord",
					
		// multi dashboard - edit			
					
		'widget_manager:multi_dashboard:new' => "Créer un nouveau tableau de bord",
		'widget_manager:multi_dashboard:edit' => "Modifier le tableau de bord : %s",		
		'widget_manager:multi_dashboard:types:title' => "Sélectionnez un type de tableau de bord",
		'widget_manager:multi_dashboard:types:widgets' => "Widgets",
		'widget_manager:multi_dashboard:types:iframe' => "iFrame",		
		'widget_manager:multi_dashboard:num_columns:title' => "Nombre de colonnes",
		'widget_manager:multi_dashboard:iframe_url:title' => "Adresse URL de l'iFrame",
		'widget_manager:multi_dashboard:iframe_url:description' => "Note : Vérifiez que l'adresse URL commence par http:// ou https://. Tous les sites ne supportent pas l'utilisation des iFrames",
		'widget_manager:multi_dashboard:iframe_height:title' => "hauteur de l'iFrame",			
		'widget_manager:multi_dashboard:required' => "Les éléments marqués d'un * sont obligatoires",
					
		// actions			
		// manage			
					
		'widget_manager:action:manage:error:context' => "Contexte invalide pour la sauvegarde de la configuration du widget",
		'widget_manager:action:manage:error:save_setting' => "Une erreur s'est produite lors de la sauvergarde du paramètre %s du widget %s",
		'widget_manager:action:manage:success' => "Sauvegarde de la configuration du widget réussie",
					
		// multi dashboard - edit			
					
		'widget_manager:actions:multi_dashboard:edit:error:input' => "Entrée invalide, veuillez inscrire un titre",
		'widget_manager:actions:multi_dashboard:edit:success' => "Le tableau de bord a été créé ou modifié avec succès",
					
		// multi dashboard - delete			
					
		'widget_manager:actions:multi_dashboard:delete:error:delete' => "Le tableau de bord %s n'a pas pu être supprimé",
		'widget_manager:actions:multi_dashboard:delete:success' => "Le tableau de bord %s a été supprimé avec succès",
					
		// multi dashboard - drop			
					
		'widget_manager:actions:multi_dashboard:drop:success' => "Le widget a été transposé avec succès dans le nouveau tableau de bord",
					
		// multi dashboard - reorder			
					
		'widget_manager:actions:multi_dashboard:reorder:error:order' => "Veuillez préciser un nouvel ordre de disposition",
		'widget_manager:actions:multi_dashboard:reorder:success' => "La réoganisation du tableau de bord a été effectuée avec succès",
					
		// force tool widgets			
					
		'widget_manager:action:force_tool_widgets:error:not_enabled' => "La gestion des widgets pour les groupes n'est pas activée",
		'widget_manager:action:force_tool_widgets:succes' => "Les widgets propres à la trousse d'outil ont été appliqué aux groupes %s",
					
		// widgets			
					
		'widget_manager:widgets:edit:advanced' => "Avancé",
		'widget_manager:widgets:fix' => "Épingler ce widget sur le tableau de bord ou la page du profil",
					
		// index_login			
					
		'widget_manager:widgets:index_login:description' => "Afficher une fenêtre d'ouverture de session",
		'widget_manager:widgets:index_login:welcome' => "Bienvenue, <b>%s</b>, dans la communauté <b>%s</b>",
					
		// index_members			
					
		'widget_manager:widgets:index_members:name' => 	"Membres",
		'widget_manager:widgets:index_members:description' => "Ce widget sert à afficher la liste des membres de votre site",
		'widget_manager:widgets:index_members:user_icon' => "Rendre l'icône de profil obligatoire pour les utilisateurs",
		'widget_manager:widgets:index_members:no_result' => "Aucun utilisateur n'a été trouvé",
					
		// index_memebers_online			
					
		'widget_manager:widgets:index_members_online:name' => "Membres en lignes",
		'widget_manager:widgets:index_members_online:description' => "Ce widget sert à afficher la liste des membres de votre site qui sont en ligne ",
		'widget_manager:widgets:index_members_online:member_count' => "Nombre de membres à afficher",
		'widget_manager:widgets:index_members_online:user_icon' => "Rendre l'icône de profil obligatoire pour les utilisateurs",
		'widget_manager:widgets:index_members_online:no_result' => "Aucun utilisateur n'a été trouvé",
					
		// index_bookmarks			
					
		'widget_manager:widgets:index_bookmarks:description' => "Ce widget sert à afficher les derniers signets sur le site de votre communauté",
					
		// index_activity			
					
		'widget_manager:widgets:index_activity:description' => "Ce widget sert à afficher les dernières activités sur votre site", 
					
		// image_slider			
					
		'widget_manager:widgets:image_slider:name' => "Diaporame",
		'widget_manager:widgets:image_slider:description' => "Ce widget sert à afficher un diaporama d'images",
		'widget_manager:widgets:image_slider:slider_type' => "Type de diaporamal",
		'widget_manager:widgets:image_slider:slider_type:s3slider' => "s3Slider",
		'widget_manager:widgets:image_slider:slider_type:flexslider' => "FlexSlider",
		'widget_manager:widgets:image_slider:seconds_per_slide' => "Temps d'affichage de chaque diapositive en secondes",
		'widget_manager:widgets:image_slider:slider_height' => "Hauteur de la diapositive (pixels)",
		'widget_manager:widgets:image_slider:overlay_color' => "Couleur de la couche (hex)",
		'widget_manager:widgets:image_slider:title' => "Diaporama",
		'widget_manager:widgets:image_slider:label:url' => "Adresse URL de l'image",
		'widget_manager:widgets:image_slider:label:text' => "Texte",
		'widget_manager:widgets:image_slider:label:link' => "Lien",
		'widget_manager:widgets:image_slider:label:direction' => "Orientation",
	
	);
	add_translation("fr", $free_html);
	
	$tagcloud = array(
		'widgets:tagcloud:description' => "Afficher un nuage de mots-clés en fonction de l’ensemble du contenu du site, du groupe ou de l’utilisateur",
		'widgets:tagcloud:no_data' => "Aucun donnée disponible pour l'affichage du nuage de mots-clés",

	);
	add_translation("fr", $tagcloud);
	
	$entity_statistics = array(
		// entity_statistics widget
		"widgets:entity_statistics:title" => "Statistics", 
		"widgets:entity_statistics:description" => "Shows site statistics", 
		"widgets:entity_statistics:settings:selected_entities" => "Select the entities you wish to show", 
	
	);
	add_translation("fr", $entity_statistics);
	
	$messages = array(
		// messages widget
		'widgets:messages:description' => "Ce widget sert à afficher vos derniers messages",
		'widgets:messages:not_logged_in' => "Vous devez ouvrir une session pour utiliser ce widget",
		'widgets:messages:settings:only_unread' => "Ne montrer que les messages non lus",

	);
	add_translation("fr", $messages);
	
	$favorites = array(
		'widgets:favorites:title' => "Page favorites de la communauté", 
		'widgets:favorites:description' => "Ce widget sert à afficher vos pages Web préférées de la communauté",				 
		'widgets:favorites:delete:success' => "Favori enlevé", 
		'widgets:favorites:delete:failed' => "La suppression du favori a échoué", 
		'widgets:favorites:save:success' => "Le favori a été créé", 
		'widgets:favorites:save:failed' => "La création du favori à échoué", 
		'widgets:favorites:toggle:missing_input' => "Entrée manquante pour effectuer cette action", 
		'widgets:favorites:content:more_info' => "Ajoutez les pages Web de votre communauté qui sont vos préférées à ce widget en cliquant sur l’icône en forme d’étoile sur le menu latéral.", 				
		'widgets:favorites:menu:add' => "Ajouter cette page à votre widget des favoris", 
		'widgets:favorites:menu:remove' => "Enlever cette page de votre widget des favoris",

			
			);
		add_translation("fr", $favorites);

		$likes = array(
			// likes widget
		'widgets:likes:title' => "Mentions « J'aime »",
		'widgets:likes:description' => "Ce widget sert à afficher des renseignements sur le contenu aimé",
		'widgets:likes:settings:interval' => "Intervalle",
		'widgets:likes:settings:interval:week' => "Le semaine dernière",
		'widgets:likes:settings:interval:month' => "Le mois dernier",
		'widgets:likes:settings:interval:3month' => "Dans les trois derniers mois",
		'widgets:likes:settings:interval:halfyear' => "Dans les six derniers mois",
		'widgets:likes:settings:interval:year' => "Au cours de la dernière année",
		'widgets:likes:settings:interval:unlimited' => "Aucun filtre",
		'widgets:likes:settings:like_type' => "Type de contenu",
		'widgets:likes:settings:like_type:user_likes' => "Contenu que vous avez récemment aimé",
		'widgets:likes:settings:like_type:most_liked ' => "Contenu ayant reçu le plus de mentions « J'aime »",
		'widgets:likes:settings:like_type:recently_liked ' => "Contenu ayant reçu la mention « J'aime » récemment",


		);

		add_translation("fr", $likes);

		$user_search = array(
			// user search widget
		'widgets:user_search:title' => "Recherche d'utilisateurs",
		'widgets:user_search:description' => "Rechercher tous les utilisateurs de votre site (y compris les utilisateurs désactivés ou non validés)",

		);
		add_translation("fr", $user_search);
		$iframe = array(
			// iframe widget
		'widgets:iframe:title' => "iFrame",
		'widgets:iframe:description' => "Afficher une adresse URL dans un iframe",
		'widgets:iframe:settings:iframe_url' => "Inscrire l'adresse URL du iframe",
		'widgets:iframe:settings:iframe_height' => "Inscrire la hauteur (optionnelle) de l'iframe (pixels)",

		);
		add_translation("fr", $iframe);

