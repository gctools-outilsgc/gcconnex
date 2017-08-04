<?php 

return array(
	'file_tools' => "Outils pour les Fichiers",

	'file_tools:file:actions' => "Actions",

	'file_tools:list:sort:type' => "Type",
	'file_tools:list:sort:time_created' => "Date de création",
	'file_tools:list:sort:asc' => "Ascendant",
	'file_tools:list:sort:desc' => "Descendant",
	'file_tools:show_more' => 'Afficher plus de fichiers',

	// object name
	'item:object:folder' => "Dossier de fichiers",

	// menu items
	'file_tools:menu:mine' => "Vos dossiers",
	'file_tools:menu:user' => "Dossiers de %s",
	'file_tools:menu:group' => "Dossiers du groupe",
	
	// group tool option
	'file_tools:group_tool_option:structure_management' => "Permettre aux membres de gérer les dossiers",
	
	// views

	// object
	'file_tools:object:files' => "%s fichier(s) dans ce dossier",
	'file_tools:object:no_files' => "Aucun fichier dans ce dossier",

	// input - folder select
	'file_tools:input:folder_select:main' => "Dossier principal",

	// list
	'file_tools:list:title' => "Lister les dossiers de fichiers",
	
	'file_tools:list:folder:main' => "Dossier principal",
	'file_tools:list:files:none' => "Aucun fichier dans ce dossier",
	'file_tools:list:select_all' => "Tout sélectionner",
	'file_tools:list:deselect_all' => "Tout désélectionner",
	'file_tools:list:download_selected' => "Télécharger la sélection",
	'file_tools:list:delete_selected' => "Supprimer la sélection",
	'file_tools:list:alert:not_all_deleted' => "Tous les fichiers n'ont pas pu être supprimés",
	'file_tools:list:alert:none_selected' => "Aucun élément sélectionné",
	

	'file_tools:list:tree:info' => "Le saviez-vous ?",
	'file_tools:list:tree:info:1' => "Vous pouvez cliquer et déplacer les dossiers pour les organiser !",
	'file_tools:list:tree:info:2' => "Vous pouvez double-cliquer sur un dossier pour ouvrir tous ses sous-dossiers !",
	'file_tools:list:tree:info:3' => "Vous pouvez réorganiser les dossiers en les faisant glisser sur leur nouvel emplacement dans l'arborescence !",
	'file_tools:list:tree:info:4' => "Vous pouvez déplacer des dossiers avec leurs sous-dossiers-!",
	'file_tools:list:tree:info:5' => "Lorsque supprimez un dossier, vous pouvez choisir de supprimer ou non les fichiers qu'il contient !",
	'file_tools:list:tree:info:6' => "Lorsque vous supprimez un dossier, tous ses sous-dossiers sont également supprimés !",
	'file_tools:list:tree:info:7' => "Le message affiché ici est aléatoire !",
	'file_tools:list:tree:info:8' => "Lorsque vous supprimez un dossier, mais pas ses fichiers, ceux-ci apparaîtront dans le Dossier principal !",
	'file_tools:list:tree:info:9' => "Un dossier nouvellement créé peut être ajouté directement dans le bon sous-dossier !",
	'file_tools:list:tree:info:10' => "Lorsque vous envoyez ou modifiez un fichier, vous pouvez choisir dans quel dossier il doit apparaître !",
	'file_tools:list:tree:info:11' => "Le déplacement par cliquer-déplacer ne fonctionne que dans l'affichage sous forme de liste, et pas dans la galerie !",
	'file_tools:list:tree:info:12' => "Vous pouvez modifier le niveau d'accès de tous les sous-dossiers et même (en option: si vous le souhaitez) de tous les fichiers lorsque vous modifiez un dossier !",

	'file_tools:list:files:options:sort_title' => "Trier",
	'file_tools:list:files:options:view_title' => "Affichage",

	'file_tools:usersettings:time' => "Affichage de la date",
	'file_tools:usersettings:time:description' => "Modifier la manière dont la date des fichiers/dossiers est affichée ",
	'file_tools:usersettings:time:default' => "Affichage par défaut de la date",
	'file_tools:usersettings:time:date' => "Date",
	'file_tools:usersettings:time:days' => "il y a X jours",
	
	// new/edit
	'file_tools:new:title' => "Nouveau dossier de fichiers",
	'file_tools:edit:title' => "Modifier le dossier de fichier",
	'file_tools:forms:edit:title' => "Titre",
	'file_tools:forms:edit:description' => "Description",
	'file_tools:forms:edit:parent' => "Sélectionner le dossier parent",
	'file_tools:forms:edit:change_children_access' => "Modifier le niveau d'accès sur tous les sous-dossiers",
	'file_tools:forms:edit:change_files_access' => "Modifier le niveau d'accès sur tous fichiers de ce dossier (et tous les sous-dossiers si sélectionnés)",
	'file_tools:forms:browse' => "Ajouter un fichier",
	'file_tools:forms:empty_queue' => "Vider la liste des fichiers à envoyer",

	'file_tools:folder:delete:confirm_files' => "Voulez-vous aussi supprimer tous les fichiers présents dans les (sous-)dossier(s) supprimé(s) ?",

	// upload
	'file_tools:upload:tabs:single' => "Un seul fichier",
	'file_tools:upload:tabs:multi' => "Plusieurs fichiers",
	'file_tools:upload:tabs:zip' => "Fichier ZIP",
	'file_tools:upload:form:choose' => "Choisir le fichier",
	'file_tools:upload:form:info' => "Cliquez sur \"Ajouter un fichier\" pour ajouter un fichier à la sélection, puis cliquez sur \"Enregistrer\" pour envoyer les fichiers sélectionnés",
	'file_tools:upload:form:zip:info' => "Vous pouvez charger un fichier ZIP. Il sera extrait et chaque fichier sera importé séparemment. S'il y a des dossiers dans le ZIP, chaque fichier sera importé dans son propre dossier. Les types de fichier non autorisés ne seront pas importés.",
	
	// actions
	// edit
	'file_tools:action:edit:error:input' => "Données d'entrée invalides pour créer/modifier un dossier de fichiers",
	'file_tools:action:edit:error:owner' => "Impossible de trouver la propriétaire de ce dossier de fichiers",
	'file_tools:action:edit:error:folder' => "Aucun dossier à créer/modifier",
	'file_tools:action:edit:error:parent_guid' => "Le dossier parent est invalide, le dossier parent ne peut pas être le dossier lui-même",
	'file_tools:action:edit:error:save' => "Une erreur inconnue est survenue lors de l'enregistrement du dossier de fichiers",
	'file_tools:action:edit:success' => "Le dossier de fichiers a bien été créé/modifié",

	'file_tools:action:move:parent_error' => "Impossible de publier le dossier à l'intérieur de soi-même.",
	
	// delete
	'file_tools:actions:delete:error:input' => "Données d'entrée invalides pour supprimer un dossier de fichiers",
	'file_tools:actions:delete:error:entity' => "Le GUID fourni n'a pas pu être trouvé",
	'file_tools:actions:delete:error:subtype' => "Le GUID fourni n'est pas celui d'un dossier de fichiers",
	'file_tools:actions:delete:error:delete' => "Une erreur inconnue est survenue lors de la suppression du dossier de fichiers",
	'file_tools:actions:delete:success' => "Le dossier a bien été supprimé",

	//errors
	'file_tools:error:pageowner' => "Erreur lors de la récupération du propriétaire de la page (page owner).",
	'file_tools:error:nofilesextracted' => "Aucun format de fichier autorisé n'a été trouvé dans l'archive ZIP.",
	'file_tools:error:cantopenfile' => "Le fichier ZIP n'a pas pu être ouvert (vérifiez s'il s'agit bien d'un fichier au format .zip).",
	'file_tools:error:nozipfilefound' => "Le fichier envoyé n'est pas un fichier ZIP.",
	'file_tools:error:nofilefound' => "Choisissez un fichier à envoyer.",

	//messages
	'file_tools:error:fileuploadsuccess' => "Le fichier ZIP a bien été chargé et extrait.",
	
	// move
	'file_tools:action:move:success:file' => "Le fichier a bien été déplacé",
	'file_tools:action:move:success:folder' => "Le dossier a bien été déplacé",
	
	// buld delete
	'file_tools:action:bulk_delete:success:files' => "%s fichiers ont bien été supprimés",
	'file_tools:action:bulk_delete:error:files' => "Une erreur est survenue lors de la suppression de certains fichiers",
	'file_tools:action:bulk_delete:success:folders' => "%s dossiers ont bien été supprimés",
	'file_tools:action:bulk_delete:error:folders' => "Une erreur est survenue lors de la suppression de certains dossiers",
	
	// reorder
	'file_tools:action:folder:reorder:success' => "Les dossiers ont bien été réorganisés",
	
	//settings
	'file_tools:settings:allowed_extensions' => "Extensions autorisées (séparées par des virgules)",
	'file_tools:settings:user_folder_structure' => "Utiliser les dossiers",
	'file_tools:settings:sort:default' => "Tri par défaut dans les dossiers",
	'file_tools:settings:list_length' => 'Nombre de fichiers affichés dans le listing',
	'file_tools:settings:list_length:unlimited' => 'Illimité',

	'file:type:application' => "Application",
	'file:type:text' => "Texte",

	// widgets
	// file tree
	'widgets:file_tree:title' => "Dossiers",
	'widgets:file_tree:description' => "Afficher vos dossier de fichiers",
	
	'widgets:file_tree:edit:select' => "Sélectionner le(s) dossier(s) à afficher",
	'widgets:file_tree:edit:show_content' => "Afficher le contenu du/des dossier(s)",
	'widgets:file_tree:no_folders' => "Aucun dossier(s) configuré(s)",
	'widgets:file_tree:no_files' => "Aucun fichier(s) configuré(s)",
	'widgets:file_tree:more' => "Plus de dossiers de fichiers",

	'widget:file:edit:show_only_featured' => "Ne montrer que les fichiers mis en Une",
	
	'widget:file_tools:show_file' => "Mettre en Une ce fichier (widget)",
	'widget:file_tools:hide_file' => "Enlever de la Une ce fichier (widget)",

	'widgets:file_tools:more_files' => "Plus de fichiers",
	
	// Group files
	'widgets:group_files:description' => "Afficher les fichiers récents du groupes",
	
	// index_file
	'widgets:index_file:description' => "Afficher les fichiers récents de votre communauté",
	
);

