<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which constructs the organization tree from the GEDs CSV file
 */
elgg_make_sticky_form('orguploadfill');
$upload_form = elgg_get_sticky_values('orguploadfill');

$data_path = $upload_form['organization_upload'];

$header = null;
$org_data = array();
$org_data_french = array();
$count = 0;
$key = '';

// Opens and processes the given file in order to extract the organization structure column
if(($handle = fopen($data_path, 'r')) !== false) {
	while(($row = fgetcsv($handle)) !== false) {
        if(!$header) {
            $header = $row;
            $key = array_search('Organization Structure (EN)', $header);
            $key_french = array_search('Organization Structure (FR)', $header);
        }
        else {
            $org_data[$count] = utf8_encode($row[$key]);
            $org_data_french[$count] = utf8_encode($row[$key_french]);
            $count++;
        }
    }
    fclose($handle);
}

// Eliminate identical data.
$org_data = array_unique($org_data);
$org_data_french = array_unique($org_data_french);

//$my_log = fopen("mod/missions_organization/organization_tree_log.txt", "w");

// Loop through every row loaded from the csv file.
$count = 1;
foreach($org_data as $key => $org_path) {
    $node_array = explode(':', $org_path);
    $node_array_french = explode(':', $org_data_french[$key]);
    
    $node_parent_guid = '';
    
    // Loops through every node in the organization found in the row.
    foreach($node_array as $key => $node) {
    	// Extracts the node name and a list of abbreviations.
        $blast_radius = explode('(', $node);
        $node_name = trim($blast_radius[0]);
        $node_abbr = $blast_radius[1];
        $node_abbr_array = explode(',', $node_abbr);
        
        $blast_radius_french = explode('(', $node_array_french[$key]);
        $node_name_french = trim($blast_radius_french[0]);
        $node_abbr_french = $blast_radius_french[1];
        $node_abbr_array_french = explode(',', $node_abbr_french);
        
        // Separates the node's abbreviation and the node's parent's abbreviation from the rest of the ancestors.
        $node_self_temp = explode('=', $node_abbr_array[0]);
        $node_self_abbr = $node_self_temp[1];
        /*$node_parent_temp = explode('=', $node_abbr_array[1]);
        $node_parent_abbr = $node_parent_temp[1];
        if(strtolower($node_self_abbr) == strtolower($node_parent_abbr)) {
        	$node_parent_temp = explode('=', $node_abbr_array[2]);
        	$node_parent_abbr = $node_parent_temp[2];
        }*/
        
        $node_self_temp_french = explode('=', $node_abbr_array_french[0]);
        $node_self_abbr_french = $node_self_temp_french[1];
        
        // Checks to see if the node already exists within the system.
        $options['type'] = 'object';
        $options['subtype'] = 'orgnode';
        $options['metadata_name_value_pairs'] = array(
        		array('name' => 'abbr', 'operand' => '=', 'value' => $node_self_abbr),
        		array('name' => 'name', 'operand' => '=', 'value' => $node_name),
        		array('name' => 'parent_guid', 'operand' => '=', 'value' => $node_parent_guid)
        );
    	$options['metadata_name_value_pairs_operator'] = 'AND';
        $options['metadata_case_sensitive'] = false;
        $entities_self = elgg_get_entities_from_metadata($options);
		$entities_self = array_filter($entities_self);
        
        // If the node does not exist then create the new node.
        if(count($entities_self) == 0) {
        	// Find the parent of this node.
            /*$options['type'] = 'object';
            $options['subtype'] = 'orgnode';
            $options['metadata_name_value_pairs'] = array(array('name' => 'abbr', 'value' => $node_parent_abbr));
            $options['metadata_case_sensitive'] = false;
            $entities_parent = elgg_get_entities_from_metadata($options);*/
            
            $orgnode = new ElggObject();
            $orgnode->subtype = 'orgnode';
            $orgnode->title = $node_name;
    		$orgnode->access_id = ACCESS_LOGGED_IN;
    		$orgnode->owner_guid = elgg_get_site_entity()->guid;
            $orgnode->name = $node_name;
            $orgnode->abbr = $node_self_abbr;
            $orgnode->name_french = $node_name_french;
            $orgnode->abbr_french = $node_self_abbr_french;
            $orgnode->parent_guid = $node_parent_guid;
            
            $orgnode->root = false;
            if(strcasecmp($node_name, 'canada') == 0 && strcasecmp($node_self_abbr, 'gc') == 0) {
            	$orgnode->root = true;
            }
            
            $orgnode->save();
            
            if($node_parent_guid != '') {
            	add_entity_relationship($node_parent_guid, 'org-related', $orgnode->guid);
            }
            
            $node_parent_guid = $orgnode->guid;
            
            /*$parent_log_string = "NULL\n";
            if(count($entities_parent) == 1) {
                add_entity_relationship($entities_parent[0]->guid, 'org-related', $orgnode->guid);
                $parent_log_string = $entities_parent[0]->name . " (" . $entities_parent[0]->guid . ")\n";
            }
            
            $to_file = $count . ": " . $orgnode->name . " (" . $orgnode->guid . ") --- " . $parent_log_string;
            $fval = fwrite($my_log, $to_file);
            $count++;*/
        }
        else if(count($entities_self) == 1) {
        	if($node_parent_guid != '') {
        		$parent_count = count(mo_node_immediate_parent($entities_self[0]->guid));
        		if(check_entity_relationship($node_parent_guid, 'org-related', $entities_self[0]->guid) === false && $parent_count == 0) {
        			add_entity_relationship($node_parent_guid, 'org-related', $entities_self[0]->guid);
        		}
        	}
            
            $node_parent_guid = $entities_self[0]->guid;
        	
        	// Find the parent of this node.
        	/*$options['type'] = 'object';
        	$options['subtype'] = 'orgnode';
        	$options['metadata_name_value_pairs'] = array(array('name' => 'abbr', 'value' => $node_parent_abbr));
        	$options['metadata_case_sensitive'] = false;
        	$entities_parent = elgg_get_entities_from_metadata($options);
        	
        	$parent_log_string = "NULL\n";
        	if(count($entities_parent) == 1) {
        		if(check_entity_relationship($entities_parent[0]->guid, 'org-related', $entities_self[0]->guid) === false) {
        			$parent_count = count(mo_node_immediate_parent($current_id));
        			if($parent_count == 0) {
	        			add_entity_relationship($entities_parent[0]->guid, 'org-related', $entities_self[0]->guid);
	        			$parent_log_string = $entities_parent[0]->name . " (" . $entities_parent[0]->guid . ")\n";
        			}
        		}
        	}
        	
        	$to_file = $count . "*: " . $orgnode->name . " (" . $orgnode->guid . ") --- " . $parent_log_string;
        	$fval = fwrite($my_log, $to_file);
        	$count++;*/
        }
        else {
        	/*$to_file = $count . "!: " . $node_self_abbr . " count = " . count($entities_self) . "\n";
        	$fval = fwrite($my_log, $to_file);
        	$count++;*/
        }
    }
}

//fclose($my_log);

forward(REFERER);