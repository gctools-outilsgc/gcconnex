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

// Loop through every row loaded from the csv file.
foreach($org_data as $key => $org_path) {
    $node_array = explode(':', $org_path);
    $node_array_french = explode(':', $org_data_french[$key]);
    
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
        $node_parent_temp = explode('=', $node_abbr_array[1]);
        $node_parent_abbr = $node_parent_temp[1];
        
        $node_self_temp_french = explode('=', $node_abbr_array_french[0]);
        $node_self_abbr_french = $node_self_temp_french[1];
        
        // Checks to see if the node already exists within the system.
        $options['type'] = 'object';
        $options['subtype'] = 'orgnode';
        $options['metadata_name_value_pairs'] = array(
        		array('name' => 'abbr', 'value' => $node_self_abbr),
        		array('name' => 'name', 'value' => $node_name)
        );
        $options['metadata_case_sensitive'] = false;
        $entities_self = elgg_get_entities_from_metadata($options);
        
        // If the node does not exist then create the new node.
        if(empty($entities_self[0])) {
        	// Find the parent of this node.
            $options['type'] = 'object';
            $options['subtype'] = 'orgnode';
            $options['metadata_name_value_pairs'] = array(array('name' => 'abbr', 'value' => $node_parent_abbr));
            $options['metadata_case_sensitive'] = false;
            $entities_parent = elgg_get_entities_from_metadata($options);
            
            $orgnode = new ElggObject();
            $orgnode->subtype = 'orgnode';
            $orgnode->title = $node_name;
    		$orgnode->access_id = ACCESS_LOGGED_IN;
            $orgnode->name = $node_name;
            $orgnode->abbr = $node_self_abbr;
            $orgnode->name_french = $node_name_french;
            $orgnode->abbr_french = $node_self_abbr_french;
            
            $orgnode->root = false;
            if(strcasecmp($node_name, 'canada') == 0 && strcasecmp($node_self_abbr, 'gc') == 0) {
            	$orgnode->root = true;
            }
            
            $orgnode->save();
            
            $parent_guid = '';
            if(!empty($entities_parent[0])) {
                add_entity_relationship($entities_parent[0]->guid, 'org-related', $orgnode->guid);
            }
        }
    }
}

forward(REFERER);