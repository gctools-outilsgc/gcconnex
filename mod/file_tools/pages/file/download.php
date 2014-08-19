<?php

	$zip_dir = elgg_get_config("dataroot") . 'file_tools/zip_temp/';
	
	if(!file_exists($zip_dir)) {
		mkdir($zip_dir, 0755, true);
	}
	
	$zip_filename = tempnam($zip_dir, "download_");
	
	$file_guids = get_input("file_guids");
	$folder_guids = get_input("folder_guids");
	
	if(!empty($file_guids) || !empty($folder_guids)) {
		$zip = new ZipArchive();
		
		if($zip->open($zip_filename, ZIPARCHIVE::CREATE) !== true) {
		    register_error(elgg_echo("file:downloadfailed"));
		    forward(REFERER);
		}
		
		// add files to the zip
		if(!empty($file_guids)){
			foreach($file_guids as $file_guid){
				if($file = get_entity($file_guid)){
					// check if the name exists in the zip
					if($zip->statName($file->originalfilename) === false){
						// doesn't exist, so add
						$zip->addFile($file->getFilenameOnFilestore(), $file->originalfilename);
					} else {
						// file name exists, so create a new one
						$ext_pos = strrpos($file->originalfilename, ".");
						$file_name = substr($file->originalfilename, 0, $ext_pos) . "_" . $file->getGUID() . substr($file->originalfilename, $ext_pos);
						
						$zip->addFile($file->getFilenameOnFilestore(), $file_name);
					}
				}
			}
		}
		
		// add folder (and their content) to the zip
		if(!empty($folder_guids)){
			foreach($folder_guids as $folder_guid){
				if($folder = get_entity($folder_guid)){
					file_tools_add_folder_to_zip($zip, $folder);
				}
			}
		}
		
		// done adding content, so save the zip
		$zip->close();
		
		if(file_exists($zip_filename)) {
			// output the correct headers
			header('Pragma: public');
			header('Content-type: application/zip');
			header('Content-Disposition: attachment; filename="folder_contents.zip"');
			header('Content-Length: ' . filesize($zip_filename));
			
			ob_clean();
			flush();
			readfile($zip_filename);
			
			unlink($zip_filename);
		} else {
		    register_error(elgg_echo("file:downloadfailed"));
		    forward(REFERER);
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
		forward(REFERER);
	}
	