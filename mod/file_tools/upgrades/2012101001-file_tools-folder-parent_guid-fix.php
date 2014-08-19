<?php

	/**
	 * This upgrade will fix all folders which have themselfs as parent_guid.
	 * All theres parent_guids will be reset to 0 (main level)
	 * 
	 */

	// prepare some variables
	$dbprefix = elgg_get_config("dbprefix");
	$folder_subtype_id = get_subtype_id("object", FILE_TOOLS_SUBTYPE);
	$parent_guid_id = add_metastring("parent_guid");
	$zero_metadata_id = add_metastring(0);
	
	// check if the folder subtype exists in your database
	if (!empty($folder_subtype_id)) {
		
		// create a (temp) table with metadata id's that need fixing
		$query = "CREATE TABLE file_tools_fix";
		$query .= " AS (SELECT md.id";
		$query .= " FROM " . $dbprefix . "metadata md";
		$query .= " JOIN " . $dbprefix . "entities e ON md.entity_guid = e.guid";
		$query .= " JOIN " . $dbprefix . "metastrings msv ON md.value_id = msv.id";
		$query .= " WHERE e.type = 'object' AND e.subtype = " . $folder_subtype_id;
		$query .= " AND md.name_id = " . $parent_guid_id . " AND msv.string = md.entity_guid)";
		
		update_data($query);
		
		// the update query
		$query = " UPDATE " . $dbprefix . "metadata";
		$query .= " SET value_id = " . $zero_metadata_id;
		$query .= " WHERE id IN (SELECT id FROM file_tools_fix)";
		
		// execute the update query
		update_data($query);
		
		// cleanup the temp table
		$query = "DROP TABLE file_tools_fix";
		
		update_data($query);
	}
	