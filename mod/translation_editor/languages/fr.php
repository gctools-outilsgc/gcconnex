<?php

$language = array (
		//'translation_editor' => "Translation Editor",
	
		// global
  'translation_editor:language' => 'Langage',
  'translation_editor:disabled' => 'Indisponible',
	
		// menu
  'translation_editor:menu:title' => 'Editeur de traduction',
	
		// views
		// language selector
		'translation_editor:language_selector:title' => 'Sélectionner le langage que vous souhaitez édité',
		'translation_editor:language_selector:add_language' => 'Ajout d\'un nouveau langage',
		'translation_editor:language_selector:remove_language:confirm' => 'Etes-vous sûr de vouloir enlever ce langage ? Vous pouvez toujours l\'ajouter à nouveau !',
		'translation_editor:language_selector:site_language' => 'Langage du site',
	
		// plugins list
		'translation_editor:plugin_list:title' => 'Sélectionner un composant à traduire',
		'translation_editor:plugin_list:plugin' => 'Nom du plugin',
		'translation_editor:plugin_list:total' => 'Total des Clés',
		'translation_editor:plugin_list:exists' => 'Traduit',
		'translation_editor:plugin_list:custom' => 'Personnalisation',
		'translation_editor:plugin_list:percentage' => 'Pourcentage de complètement',

		'translation_editor:plugin_list:merge' => 'Fusionner au fichier langage PHP',
		'translation_editor:plugin_list:delete' => 'Effacer une traduction',
		'translation_editor:plugin_list:delete:confirm' => 'Etes-vous sûr de vouloir effacer ce langage ? Vous ne pourrez pas revenir sur votre choix !',
	
		// search
		'translation_editor:search' => 'Cherche des résultats',
		'translation_editor:forms:search:default' => 'Trouver une traduction',
		'translation_editor:search_results:no_results' => 'Aucune traduction trouvé',
	
		// custom key
		'translation_editor:custom_keys:title' => 'Ajout d\'une clé langage personnalisé',
		'translation_editor:custom_keys:key' => 'Clé',
		'translation_editor:custom_keys:translation' => 'Traduction,',
		'translation_editor:custom_keys:translation_info' => 'Les nouvelles clés seront toujours créées tant que que traduction anglaise. Après la création vous pouvez les traduire dans un autre langage.',
	
		'translation_editor:plugin_edit:title' => 'Editer la traduction pour le plugin',
		'translation_editor:plugin_edit:show' => 'Montrer',
		'translation_editor:plugin_edit:show:missing' => 'Manque',
		'translation_editor:plugin_edit:show:equal' => 'égal',
		'translation_editor:plugin_edit:show:all' => 'Tous',
		'translation_editor:plugin_edit:show:custom' => 'Personnalisé',
		'translation_editor:plugin_edit:show:params' => 'Paramètres manquant',
	
		// actions
		'translation_editor:action:translate:error:input' => 'Une entrée incorrecte revient à ajouter une traduction',
		'translation_editor:action:translate:no_changed_values' => 'Aucune traduction n\'a besoin d\'être ajouté',
		'translation_editor:action:translate:error:write' => 'Erreur pendant l\'écriture des traductions',
		'translation_editor:action:translate:error:not_authorized' => 'Vous n\'êtes pas autorisé à traduire',
		'translation_editor:action:translate:success' => 'Les traduction ont été sauvegardée avec succès',
	
		'translation_editor:action:make_translation_editor' => 'Faire un fichier traduction',
		'translation_editor:action:make_translation_editor:success' => 'Fichier traduction fait avec succès',
		'translation_editor:action:make_translation_editor:error' => 'Erreur pendant la fabrication du fichier traduction de l\'utilisateur',
		'translation_editor:action:unmake_translation_editor' => 'Défaire le fichier traduction',
		'translation_editor:action:unmake_translation_editor:success' => 'Fichier traduction enlevé avec succès',
		'translation_editor:action:unmake_translation_editor:error' => 'Erreur pendant retirement du role du fichier de traduction',
	
		'translation_editor:action:delete:error:input' => 'Entrée incorrecte pour effacer la traduction',
		'translation_editor:action:delete:error:delete' => 'Erreur durant l\'effacement de la traduction',
		'translation_editor:action:delete:success' => 'Traduction effacé avec succès',
	
		'translation_editor:action:add_language:success' => 'Langage ajouté avec succès',
		'translation_editor:action:delete_language:success' => 'Langage enlevé avec succès',
	
		'translation_editor:action:add_custom_key:success' => 'La clé personnalisé ajoutée avec succès',
		'translation_editor:action:add_custom_key:file_error' => 'Erreur lors de la sauvegarde de la clé personnalisé dans le fichier',
		'translation_editor:action:add_custom_key:exists' => 'Impossible d\'ajouter cet clé, car elle existe déjà. Entrer une clé unique.',
		'translation_editor:action:add_custom_key:invalid_chars' => 'Une clé contient des caractères invalides. Seuls les caractères a-z, 0-9 les virgules "," et souligné "_" sont admis.',
		'translation_editor:action:add_custom_key:key_numeric' => 'Une clé ne peut contenir que des chiffres',
		'translation_editor:action:add_custom_key:missing_input' => 'Entrée invalide. Merci d\'entrer une clé (anglaise) et une traduction par défault',
);
add_translation("fr", $language);
?>