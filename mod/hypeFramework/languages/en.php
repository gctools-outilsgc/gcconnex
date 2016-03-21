<?php

$english = array(

	'item:object:hjfile' => 'File',

	'hj:framework:input:required' => 'Required Field',

	'hj:framework:error:plugin_order' => '%s can not be activated. Please check your plugin order and ensure that it\'s below hypeFramework in the plugin list',
	'hj:framework:geocode:error' => 'There was a problem with geocoding the location field. The item will not appear on maps or other interfaces that rely on coordinates',
	'hj:framework:list:empty' => 'There are no items to show',
	'hj:framework:list:limit' => 'Show',

	'hj:framework:ajax:loading' => 'Loading...',
	'hj:framework:ajax:saving' => 'Saving...',
	'hj:framework:ajax:deleting' => 'Deleting...',

	'hj:framework:list:empty' => 'There are currently no items to display',

	'hj:framework:sort:ascending' => 'Sort ascending',
	'hj:framework:sort:descending' => 'Sort descending',
	'hj:framework:grid:sort:column' => 'Sort this column',

	'hj:framework:error:cannotcreateentity' => 'Unable to save this item',
	'hj:framework:submit:success' => 'Item was successfully saved',

	'hj:framework:input:validation:success' => 'Complete',
	'hj:framework:input:validation:error:requiredfieldisempty' => '%s can not be empty',
	'hj:framework:form:validation:error' => 'One or more fields are incomplete',
	
	'hj:framework:filter:keywords' => 'Keywords...',

	'hj:framework:edit:object' => 'Edit %s',

	'hj:framework:delete:error:notentity' => 'An item you are trying to delete does not exist',
	'hj:framework:delete:success' => 'Item successfully removed',
	'hj:framework:delete:error:unknown' => 'An unknown error occured',
	
	'hj:framework:success:accessidset' => 'Visibility level was successfully changed',
	'hj:framework:error:cantsetaccess' => 'Can not change the visibility level',
	
	'hj:framework:bookmark:create' => 'Bookmark',
	'hj:framework:bookmark:remove' => 'Remove Bookmark',
	'hj:framework:bookmark:create:error' => 'Item can not be bookmarked',
	'hj:framework:bookmark:create:success' => 'Item successfully bookmarked',
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


add_translation("en", $english);
?>
