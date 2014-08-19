<?php 

	$english = array(
		'file_tools' => "File Tools",
	
		'file_tools:file:actions' => 'Actions',
	
		'file_tools:list:sort:type' => 'Type',
		'file_tools:list:sort:time_created' => 'Time created',
		'file_tools:list:sort:asc' => 'Ascending',
		'file_tools:list:sort:desc' => 'Descending',
	
		// object name
		'item:object:folder' => "File Folder",
	
		// menu items
		'file_tools:menu:mine' => "Your folders",
		'file_tools:menu:user' => "%s's folders",
		'file_tools:menu:group' => "Group file folders",
		
		// group tool option
		'file_tools:group_tool_option:structure_management' => "Allow management of folders by members",
		
		// views
	
		// object
		'file_tools:object:files' => "%s file(s) in this folder",
		'file_tools:object:no_files' => "No files in this folder",
	
		// input - folder select
		'file_tools:input:folder_select:main' => "Main folder",
	
		// list
		'file_tools:list:title' => "List file folders",
		
		'file_tools:list:folder:main' => "Main folder",
		'file_tools:list:files:none' => "No files found in this folder",
		'file_tools:list:select_all' => 'Select all',
		'file_tools:list:deselect_all' => 'Deselect all',
		'file_tools:list:download_selected' => 'Download selected',
		'file_tools:list:delete_selected' => 'Delete selected',
		'file_tools:list:alert:not_all_deleted' => 'Not all files could be deleted',
		'file_tools:list:alert:none_selected' => 'No items selected',
		
	
		'file_tools:list:tree:info' => "Did you know?",
		'file_tools:list:tree:info:1' => "You can drag and drop files on to the folders to organize them!",
		'file_tools:list:tree:info:2' => "You can double click on any folder to expand all of its subfolders!",
		'file_tools:list:tree:info:3' => "You can reorder folders by dragging them to their new place in the tree!",
		'file_tools:list:tree:info:4' => "You can move complete folder structures!",
		'file_tools:list:tree:info:5' => "If you delete a folder, you can optionally choose to delete all files!",
		'file_tools:list:tree:info:6' => "When you delete a folder, all subfolders will also be deleted!",
		'file_tools:list:tree:info:7' => "This message is random!",
		'file_tools:list:tree:info:8' => "When you remove a folder, but not it's files, the files will appear at the top level folder!",
		'file_tools:list:tree:info:9' => "A newly added folder can be placed directly in the correct subfolder!",
		'file_tools:list:tree:info:10' => "When uploading or editing a file you can choose in which folder it should appear!",
		'file_tools:list:tree:info:11' => "Dragging of files is only available in the list view, not in the gallery view!",
		'file_tools:list:tree:info:12' => "You can update the access level on all subfolders and even (optional) on all files when editing a folder!",
	
		'file_tools:list:files:options:sort_title' => 'Sorting',
		'file_tools:list:files:options:view_title' => 'View',
	
		'file_tools:usersettings:time' => 'Time display',
		'file_tools:usersettings:time:description' => 'Change the way the file/folder time is displayed ',
		'file_tools:usersettings:time:default' => 'Default time display',
		'file_tools:usersettings:time:date' => 'Date',
		'file_tools:usersettings:time:days' => 'Days ago',
		
		// new/edit
		'file_tools:new:title' => "New file folder",
		'file_tools:edit:title' => "Edit file folder",
		'file_tools:forms:edit:title' => "Title",
		'file_tools:forms:edit:description' => "Description",
		'file_tools:forms:edit:parent' => "Select a parent folder",
		'file_tools:forms:edit:change_children_access' => "Update access on all subfolders",
		'file_tools:forms:edit:change_files_access' => "Update access on all files in this folder (and all subfolders if selected)",
		'file_tools:forms:browse' => 'Browse..',
		'file_tools:forms:empty_queue' => 'Empty queue',
	
		'file_tools:folder:delete:confirm_files' => "Do you also wish to delete all files in the removed (sub)folders",
	
		// upload
		'file_tools:upload:tabs:single' => "Single file",
		'file_tools:upload:tabs:multi' => "Multi file",
		'file_tools:upload:tabs:zip' => "Zip file",
		'file_tools:upload:form:choose' => 'Choose file',
		'file_tools:upload:form:info' => 'Click browse to upload (multiple) files',
		'file_tools:upload:form:zip:info' => "You can upload a zip file. It will be extracted and each file will be separately imported. Also if you have folders in your zip they will be imported into each specific folder. File types that are not allowed will be skipped.",
		
		// actions
		// edit
		'file_tools:action:edit:error:input' => "Incorrect input to create/edit a file folder",
		'file_tools:action:edit:error:owner' => "Could not find the owner of the file folder",
		'file_tools:action:edit:error:folder' => "No folder to create/edit",
		'file_tools:action:edit:error:parent_guid' => "Invalid parent folder, the parent folder can't be the folder itself",
		'file_tools:action:edit:error:save' => "Unknown error occured while saving the file folder",
		'file_tools:action:edit:success' => "File folder successfully created/edited",
	
		'file_tools:action:move:parent_error' => "Can\'t drop the folder in itself.",
		
		// delete
		'file_tools:actions:delete:error:input' => "Invalid input to delete a file folder",
		'file_tools:actions:delete:error:entity' => "The given GUID could not be found",
		'file_tools:actions:delete:error:subtype' => "The given GUID is not a file folder",
		'file_tools:actions:delete:error:delete' => "An unknown error occured while deleting the file folder",
		'file_tools:actions:delete:success' => "The file folder was deleted successfully",
	
		//errors
		'file_tools:error:pageowner' => 'Error retrieving page owner.',
		'file_tools:error:nofilesextracted' => 'There were no allowed files found to extract.',
		'file_tools:error:cantopenfile' => 'Zip file couldn\'t be opened (check if the uploaded file is a .zip file).',
		'file_tools:error:nozipfilefound' => 'Uploaded file is not a .zip file.',
		'file_tools:error:nofilefound' => 'Choose a file to upload.',
	
		//messages
		'file_tools:error:fileuploadsuccess' => 'Zip file uploaded and extracted successfully.',
		
		// move
		'file_tools:action:move:success:file' => "The file was moved successfully",
		'file_tools:action:move:success:folder' => "The folder was moved successfully",
		
		// buld delete
		'file_tools:action:bulk_delete:success:files' => "Successfully removed %s files",
		'file_tools:action:bulk_delete:error:files' => "There was an error while removing some files",
		'file_tools:action:bulk_delete:success:folders' => "Successfully removed %s folders",
		'file_tools:action:bulk_delete:error:folders' => "There was an error while removing some folders",
		
		// reorder
		'file_tools:action:folder:reorder:success' => "Successfully reordered the folder(s)",
		
		//settings
		'file_tools:settings:allowed_extensions' => 'Allowed extensions (comma seperated)',
		'file_tools:settings:user_folder_structure' => 'Use folder structure',
		'file_tools:settings:sort:default' => 'Default folder sorting options',
	
		'file:type:application' => 'Application',
		'file:type:text' => 'Text',

		// widgets
		// file tree
		'widgets:file_tree:title' => "Folders",
		'widgets:file_tree:description' => "Showcase your File folders",
		
		'widgets:file_tree:edit:select' => "Select which folder(s) to display",
		'widgets:file_tree:edit:show_content' => "Show the content of the folder(s)",
		'widgets:file_tree:no_folders' => "No folders configured",
		'widgets:file_tree:no_files' => "No files configured",
		'widgets:file_tree:more' => "More file folders",
	
		'widget:file:edit:show_only_featured' => 'Show only featured files',
		
		'widget:file_tools:show_file' => 'Feature file (widget)',
		'widget:file_tools:hide_file' => 'Unfeature file',
	
		'widgets:file_tools:more_files' => 'More files',
		
		// Group files
		'widgets:group_files:description' => "Show the latest group files",
		
		// index_file
		'widgets:index_file:description' => "Show the latest files on your community",
	
	);
	
	add_translation("en", $english);
	