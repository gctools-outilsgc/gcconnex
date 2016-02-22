<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to change a nodes parent.
 */
$subject_guid = get_input('hidden_subject_guid');
$target_abbr = get_input('target_org_abbr');

$parents = get_entity_relationships($subject_guid, true);

if($target_abbr == '') {
	register_error(elgg_echo('missions_organization:error:abbreviation_needs_input'));
	forward(REFERER);
}

$temp_name = 'abbr';
if(get_current_language() == 'fr') {
	$temp_name = 'abbr_french';
}

// Searches for the given abbreviation.
$options['type'] = 'object';
$options['subtype'] = 'orgnode';
$options['metadata_name_value_pairs'] = array(
		array('name' => $temp_name, 'value' => $target_abbr)
);
$options['metadata_case_sensitive'] = false;
$targets = elgg_get_entities_from_metadata($options);

// Error for when there are multiple instances of the same abbreviation.
if(count($targets) > 1) {
	$err = elgg_echo('missions_organization:following_have_the_same_abbreviation') . '\n';
	foreach($targets as $target) {
		$err .= $target->name . '\n';
	}
	register_error($err);
	forward(REFERER);
}
// Error for when there is not instance of the abbreviation.
elseif(count($targets) == 0) {
	register_error(elgg_echo('missions_organization:no_such_abbreviation_exists'));
	forward(REFERER);
}
// There is only one viable target with the given abbreviation.
else {
	if($targets[0]) {
		delete_relationship($parents[0]->id);
		
		add_entity_relationship($targets[0]->guid, 'org-related', $subject_guid);

		$_SESSION['organization_node_id'] = $targets[0]->guid;
		forward(elgg_get_site_url() . 'admin/missions_organization/node-view');
	}
}