<?php 

	$french = array(
		'file_tools' => "Outils de fichier",
		'file_tools:file:actions' => 'Actions',
		'file_tools:list:sort:type' => 'Type',
		'file_tools:list:sort:time_created' =>  'Heure de création',
		'file_tools:list:sort:asc' =>  'Croissant',
		'file_tools:list:sort:desc' =>  'Décroissant',
	
		// object name
		'item:object:folder' => "Dossier de fichiers",
	
		// menu items
		'file_tools:menu:mine' => "Vos dossiers",
		'file_tools:menu:user' => "Les dossiers de %s",
		'file_tools:menu:group' => "Dossiers de fichiers de groupe",

		
		// group tool option
		'file_tools:group_tool_option:structure_management' => "Autoriser la gestion des dossiers par les membres",
		
		// views
	
		// object
		'file_tools:object:files' => "%s fichier(s) dans ce dossier",
		'file_tools:object:no_files' => "Aucun fichier dans ce dossier",
		
		// input - folder select		
		'file_tools:input:folder_select:main' => "Dossier principal",
		
		// list		
		'file_tools:list:title' => "Lister les dossiers de fichiers",		
		'file_tools:list:folder:main' => "Dossier principal",
		'file_tools:list:files:none' => "Aucun fichier trouvé dans ce dossier",
		'file_tools:list:select_all' => 'Sélectionner tout',
		'file_tools:list:deselect_all' => 'Désélectionner tout',
		'file_tools:list:download_selected' => 'Télécharger les fichiers sélectionnés',
		'file_tools:list:delete_selected' => 'Supprimer les fichiers sélectionnés',
		'file_tools:list:alert:not_all_deleted' => 'Tous les fichiers n\'ont pu être supprimés',
		'file_tools:list:alert:none_selected' => 'Aucun élément sélectionné',				
		'file_tools:list:tree:info' => "Saviez-vous que?",
		'file_tools:list:tree:info:1' => "Pour organiser les fichiers, vous pouvez les glisser-déplacer dans les dossiers.",
		'file_tools:list:tree:info:2' => "Vous pouvez double cliquer sur n'importe quel dossier pour agrandir tous ses sous-dossiers.",
		'file_tools:list:tree:info:3' => "Vous pouvez réorganiser les dossiers en les faisant glisser vers leur nouvel emplacement dans l'arbre.",
		'file_tools:list:tree:info:4' => "Vous pouvez déplacer des structures de dossiers complètes.",
		'file_tools:list:tree:info:5' => "Si vous supprimez un dossier, vous pouvez choisir de supprimer tous les fichiers.",
		'file_tools:list:tree:info:6' => "Lorsque vous supprimez un dossier, tous les sous-dossiers seront également supprimés.",
		'file_tools:list:tree:info:7' => "Ce message est aléatoire.",
		'file_tools:list:tree:info:8' => "Lorsque vous supprimez un dossier, mais pas les fichiers, ces derniers s'afficheront dans le dossier de premier niveau.",
		'file_tools:list:tree:info:9' => "Un dossier nouvellement ajouté peut être placé directement dans le bon sous-dossier.",
		'file_tools:list:tree:info:10' => "Lors du téléversement ou de la modification d'un fichier, vous pouvez choisir dans quel dossier il devrait s'afficher.",
		'file_tools:list:tree:info:11' => "Vous pouvez déplacer des fichiers seulement dans l'affichage de la liste (pas dans l'affichage de la galerie).",
		'file_tools:list:tree:info:12' => "Vous pouvez mettre à jour le niveau d'accès de tous les sous-dossiers et même de tous les fichiers lors de la modification d'un dossier.",		
		'file_tools:list:files:options:sort_title' => 'Trier',
		'file_tools:list:files:options:view_title' => 'Afficher',		
		'file_tools:usersettings:time' => 'Affichage de l’heure',
		'file_tools:usersettings:time:description' => 'Modifier la façon dont l’heure du dossier est affichée',
		'file_tools:usersettings:time:default' => 'Affichage de l’heure par défaut',
		'file_tools:usersettings:time:date' => 'Date',
		'file_tools:usersettings:time:days' => 'Il y a X jours',
		
		// new/edit		
		'file_tools:new:title' => "Nouveau dossier de fichiers",
		'file_tools:edit:title' => "Modifier le dossier de fichiers",
		'file_tools:forms:edit:title' => "Titre",
		'file_tools:forms:edit:description' => "Description",
		'file_tools:forms:edit:parent' => "Sélectionner un dossier parent",
		'file_tools:forms:edit:change_children_access' => "Mettre à jour l'accès à tous les sous-dossiers",
		'file_tools:forms:edit:change_files_access' => "Mettre à jour l'accès à tous les fichiers dans ce dossier (et à tous les sous-dossiers sélectionnés)",
		'file_tools:forms:browse' => 'Parcourir',
		'file_tools:forms:empty_queue' => "Vider la file d’attente",		
		'file_tools:folder:delete:confirm_files' => "Voulez-vous également supprimer tous les fichiers qui se trouvent dans les dossiers ou sous-dossiers?",
		
		// upload		
		'file_tools:upload:new' => 'Téléverser un fichier zip',
		'file_tools:upload:tabs:single' => "Fichier unique",
		'file_tools:upload:tabs:multi' => "Fichiers multiples", 
		'file_tools:upload:tabs:zip' => "Fichier zip",
		'file_tools:upload:form:choose' => 'Sélectionner un fichier',
		'file_tools:upload:form:info' => 'Cliquer sur Parcourir pour téléverser des fichiers (multiples)',
		'file_tools:upload:form:zip:info' => "Vous pouvez téléverser un fichier zip. Il sera extrait et chaque fichier sera importé séparément. De plus, si vous avez des dossiers dans votre fichier zip, ils seront importés dans chaque dossier précis. Les types de fichiers non autorisés seront ignorés.",
		
		// actions		
		// edit		
		'file_tools:action:edit:error:input' => "Entrée erronée pour la création ou la modification d'un dossier de fichiers",
		'file_tools:action:edit:error:owner' => "Impossible de trouver le propriétaire du dossier de fichiers.",
		'file_tools:action:edit:error:folder' => "Aucun fichier à créer/à modifier",
		'file_tools:action:edit:error:parent_guid' => "Dossier parent invalide. Le dossier parent ne peut être le dossier lui-même.",
		'file_tools:action:edit:error:save' => "Une erreur inconnue s'est produite lors de la sauvegarde du dossier de fichiers.",
		'file_tools:action:edit:success' => "Création/modification du dossier de fichiers réussie",		
		'file_tools:action:move:parent_error' => "Vous ne pouvez déplacer le dossier dans le dossier du même nom.",
		
		// delete		
		'file_tools:actions:delete:error:input' => "Entrée erronée pour la suppression d'un dossier de fichiers",
		'file_tools:actions:delete:error:entity' => "Impossible de trouver le GUID donné.",
		'file_tools:actions:delete:error:subtype' => "Le GUID donné n'est pas un dossier de fichiers.",
		'file_tools:actions:delete:error:delete' => "Une erreur inconnue s'est produite lors de la suppression du dossier de fichiers.",
		'file_tools:actions:delete:success' => "Suppression du dossier de fichiers réussie.",
		
		//errors		
		'file_tools:error:pageowner' => 'Erreur lors de la récupération du propriétaire de la page.',
		'file_tools:error:nofilesextracted' => 'Aucun fichier autorisé n\'a été trouvé pour l\'extraction.',
		'file_tools:error:cantopenfile' => 'Le fichier zip n\'a pu être ouvert (vérifier si le fichier téléversé est un fichier .zip).',
		'file_tools:error:nozipfilefound' => 'Le fichier téléversé n\'est pas un fichier .zip.',
		'file_tools:error:nofilefound' => 'Sélectionner un fichier à téléverser.',
		
		//messages		
		'file_tools:error:fileuploadsuccess' => 'Téléversement et extraction du fichier zip réussis.',
		
		// move		
		'file_tools:action:move:success:file' => "Déplacement du fichier réussi.",
		'file_tools:action:move:success:folder' => "Déplacement du dossier réussi.",
		
		// buld delete		
		'file_tools:action:bulk_delete:success:files' => "Suppression de %s fichier(s) réussie",
		'file_tools:action:bulk_delete:error:files' => "Une erreur s'est produite lors de la suppression de certains fichiers.",
		'file_tools:action:bulk_delete:success:folders' => "Suppression de %s dossier(s) réussie",
		'file_tools:action:bulk_delete:error:folders' => "Une erreur s'est produite lors de la suppression de certains dossiers.",
		
		// reorder		
		'file_tools:action:folder:reorder:success' => "Réorganisation du dossier ou de l'ensemble des dossiers réussie",
		
		//settings		
		'file_tools:settings:allowed_extensions' => 'Extensions autorisées (séparées par des virgules)',
		'file_tools:settings:user_folder_structure' => 'Utiliser la structure de dossiers',
		'file_tools:settings:sort:default' => 'Options de tri de dossiers par défaut',		
		'file:type:application' => 'Application',
		'file:type:text' => 'Texte',
		
		// widgets		
		// file tree		
		'widgets:file_tree:title' => "Dossiers",
		'widgets:file_tree:description' => "Afficher vos dossiers de fichiers",		
		'widgets:file_tree:edit:select' => "Sélectionner le ou les dossiers à afficher",
		'widgets:file_tree:edit:show_content' => "Afficher le contenu du ou des dossier(s)",
		'widgets:file_tree:no_folders' => "Il n’y a aucun dossier configuré",
		'widgets:file_tree:no_files' => "Il n’y a aucun fichier configuré",
		'widgets:file_tree:more' =>  "Plus de dossiers de fichiers",		
		'widget:file:edit:show_only_featured' => 'Afficher seulement les fichiers en vedette',		
		'widget:file_tools:show_file' => 'Mettre le fichier en vedette',
		'widget:file_tools:hide_file' => 'Ne plus mettre le fichier en vedette',	
		'widgets:file_tools:more_files' => 'Plus de fichiers',
		
		// Group files		
		'widgets:group_files:description' => "Afficher les fichiers de groupes les plus récents",
		
		// index_file		
		'widgets:index_file:description' => "Afficher les fichiers les plus récents sur GCconnex",

	);
	
	add_translation("fr", $french);
	