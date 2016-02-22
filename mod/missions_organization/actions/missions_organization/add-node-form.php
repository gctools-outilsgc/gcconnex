<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action for adding a node to the tree.
 * All nodes must be added as a child to another node.
 */
 
// User input
$name_english = get_input('org_name_english');
$abbr_english = get_input('org_abbr_english');
$name_french = get_input('org_name_french');
$abbr_french = get_input('org_abbr_french');
 
// Hidden inputs to build the relationship between parent and child.
$relation = get_input('hidden_relation');
$guid = get_input('hidden_guid');

// A search to make sure that the abbreviation does not already exist in the tree.
$options['type'] = 'object';
$options['subtype'] = 'orgnode';
$options['metadata_name_value_pairs'] = array(
		array('name' => 'abbr', 'value' => $abbr_english),
		array('name' => 'abbr_french', 'value' => $abbr_french),
		array('name' => 'abbr', 'value' => $abbr_french),
		array('name' => 'abbr_french', 'value' => $abbr_english),
);
$options['metadata_name_value_pairs_operator'] = 'OR';
$options['metadata_case_sensitive'] = false;
$nodes_match = elgg_get_entities_from_metadata($options);

$err = '';
if(empty($nodes_match)) {
	$orgnode = new ElggObject();
    $orgnode->subtype = 'orgnode';
    $orgnode->title = $name;
    $orgnode->name = $name_english;
    $orgnode->abbr = $abbr_english;
    $orgnode->name_french = $name_french;
    $orgnode->abbr_french = $abbr_french;
    $orgnode->save();
    
    add_entity_relationship($guid, 'org-related', $orgnode->guid);
    
    $_SESSION['organization_node_id'] = $orgnode->guid;
    forward(elgg_get_site_url() . 'admin/missions_organization/node-view');
}
else {
	register_error(elgg_echo('missions_organization:abbreviation_in_use'));
	forward(REFERER);
}
