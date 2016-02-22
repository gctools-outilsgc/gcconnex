<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
gatekeeper();
	
$title = elgg_echo('missions_organization:main_page');
//$content = elgg_view_title($title);
$content .= elgg_view_form('missions_organization/upload-form', array('class' => 'form-horizontal')) . '</br>';
	
// Button to wipe out the organization tree.
$content .= elgg_view('output/confirmlink', array(
 		'href' => elgg_get_site_url() . 'action/missions_organization/delete-all',
 		'text' => elgg_echo('missions_organization:delete_all'),
 		'is_action' => true,
		'class' => 'elgg-button elgg-button-action',
		'confirm' => elgg_echo('missions_organization:extreme_danger_warning')
)) . '</br></br>';

// Search for the organization tree root.
$options['type'] = 'object';
$options['subtype'] = 'orgnode';
$options['metadata_name_value_pairs'] = array(
		array('name' => 'root', 'value' => true)
);
$options['metadata_case_sensitive'] = false;
$entities_parent = elgg_get_entities_from_metadata($options);

// Button to navigate to the organization tree root.
if($entities_parent[0]) {
	$content .= elgg_view('output/url', array(
	 		'href' => elgg_get_site_url() . 'action/missions_organization/set-session-node-guid?nid=' . $entities_parent[0]->guid,
	 		'text' => elgg_echo('missions_organization:tree_root'),
			'class' => 'elgg-button elgg-button-action',
			'is_action' => true
	)) . '</br>';
}
	
echo $content;