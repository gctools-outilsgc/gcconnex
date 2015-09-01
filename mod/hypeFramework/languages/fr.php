<?php

$french = array(

	'item:object:hjfile' => 'Fichier',

	'hj:framework:input:required' => 'Champ obligatoire',

	'hj:framework:error:plugin_order' => '%s can not be activated. Please check your plugin order and ensure that it\'s below hypeFramework in the plugin list',
	'hj:framework:geocode:error' => 'There was a problem with geocoding the location field. The item will not appear on maps or other interfaces that rely on coordinates',
	'hj:framework:list:empty' => "Il n'y a aucun élément à représenter",
	'hj:framework:list:limit' => 'Show',

	'hj:framework:ajax:loading' => 'Chargement ...',
	'hj:framework:ajax:saving' => 'Sauvegarde en cours ...',
	'hj:framework:ajax:deleting' => 'Suppression ...',

	'hj:framework:list:empty' => "Il n'y a aucun élément à représenter",

	'hj:framework:sort:ascending' => 'Tri ascendant',
	'hj:framework:sort:descending' => "Trier décroissant",
	'hj:framework:grid:sort:column' => "Trier cette colonne",

	'hj:framework:error:cannotcreateentity' => "Impossible d'enregistrer cet objet",
	'hj:framework:submit:success' => "L'article a été sauvegardé avec succès",

	'hj:framework:input:validation:success' => 'complet',
	'hj:framework:input:validation:error:requiredfieldisempty' => "%s ne peut pas être vide",
	'hj:framework:form:validation:error' => "Un ou plusieurs champs sont incomplets",
	
	'hj:framework:filter:keywords' => "Mots-clés ...",

	'hj:framework:edit:object' => 'Modifier %s',

	'hj:framework:delete:error:notentity' => "Un élément que vous tentez de supprimer ne existe pas",
	'hj:framework:delete:success' => "Élément supprimé avec succès",
	'hj:framework:delete:error:unknown' => "Une erreur inconnue se est produite",
	
	'hj:framework:success:accessidset' => "Niveau de visibilité a été modifié avec succès",
	'hj:framework:error:cantsetaccess' => "Vous ne pouvez pas modifier le niveau de visibilité",
	
	'hj:framework:bookmark:create' => 'Signet',
	'hj:framework:bookmark:remove' => 'Supprimer le signet',
	'hj:framework:bookmark:create:error' => 'Élément ne peut pas être en signet',
	'hj:framework:bookmark:create:success' => 'Élément signet succès',
	'hj:framework:bookmark:remove:error' => 'Bookmark can not be removed',
	'hj:framework:bookmark:remove:success' => 'Bookmark successfully removed',

	'hj:framework:subscription:create' => 'Follow',
	'hj:framework:subscription:remove' => 'Unfollow',
	'hj:framework:subscription:create:error' => 'You can\'t follow this item',
	'hj:framework:subscription:create:success' => 'You are now following this item',
	'hj:framework:subscription:remove:error' => 'Can not unfollow this item',
	'hj:framework:subscription:remove:success' => 'You are no longer following this item',

	'edit:plugin:hypeframework:params[interface_ajax]' => 'Enable AJAX Interface',
	'edit:plugin:hypeframework:params[interface_location]' => 'Enable Location Interface',
	'edit:plugin:hypeframework:params[files_keep_originals]' => 'Preserve original size image files',

	'hj:framework:settings:hint:interface_ajax' => 'AJAX interface provides some interactive functionalities, that allow users to perform actions and refresh UI elements without having to reload the entire page',
	'hj:framework:settings:hint:interface_location' => 'Location interface allows to geocode and cache coordinates whenever "location" metadata is attached to an entity. This maybe helpful, when other plugins relying on geo-coordiates are enabled',
	'hj:framework:settings:hint:files_keep_originals' => 'By default, images uploaded via hypeframework will be downsampled to master icon dimensions (default is proportionally to 550px at longer side)',

	'hj:framework:notification:full_link' => 'You can view this item %s',
	'hj:framework:notification:link' => 'here',

	'hj:framework:input:file:add' => 'Add file',
	'hj:framework:filedrop:filetypenotallowed' => 'You can not upload files of this type',
	'hj:framework:filedrop:browsernotsupported' => 'Your browser does not support drag&drop functionality. Please select each file manually, or switch to Chrome/Mozilla',
	'hj:framework:filedrop:instructions' => 'Drop images here to upload',
	'hj:framework:filedrop:fallback' => 'Upload images one by one',

	'hj:framework:entity:created' => '%s',

	'hj:framework:create:file' => 'Upload a new file',
	'hj:framework:download' => 'Download',
	'edit:object:hjfile:upload' => 'Upload a file',
	'edit:object:hjfile:title' => 'Title',
	'edit:object:hjfile:description' => 'Description',
	'edit:object:hjfile:tags' => 'Tags',
	'edit:object:hjfile:access_id' => 'Visibility',
	
		);


add_translation("fr", $french);
?>
