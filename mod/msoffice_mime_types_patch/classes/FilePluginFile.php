<?php

/**
 * Extend the FilePluginFile located in mod/file/classes
 * NOTE: This is a temporary fix for the issue reported on: http://trac.elgg.org/ticket/4079.
 * Should be able to remove this temporary fix when Elgg 1.8.5 is released.
 */
class FilePluginFile extends ElggFile {
	
	function detectMimeType($file = null, $default = null) {
		$msoffice_mimetypes = array(
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'application/msword',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'application/excel',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'application/powerpoint',
		);
		if (isset($msoffice_mimetypes[$default])){
			$mime_type = $msoffice_mimetypes[$default];
		} else {
			$mime_type = parent::detectMimeType($file, $default);
		}
		return $mime_type;
	}
}
