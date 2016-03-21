<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View for the organization node entity.
 */
gatekeeper();
$is_admin = elgg_is_admin_logged_in();

$node = $vars['entity'];

$base .= elgg_echo('missions_organization:no_forward_or_back');

// Allows changes to the name and abbreviation of the node.
// Saves to the french variables if the user is in the french site.
$base .= elgg_view_form('missions_organization/change-values-form', array(
		'class' => 'form-horizontal'
), array(
		'entity' => $node
));

// Gets all children of this node.
$options['relationship'] = 'org-related';
$options['relationship_guid'] = $node->guid;
$options['limit'] = 0;
$children_nodes = array_reverse(elgg_get_entities_from_relationship($options));

unset($options);
// Gets the parent of this node.
$options['relationship'] = 'org-related';
$options['relationship_guid'] = $node->guid;
$options['inverse_relationship'] = true;
$options['limit'] = 0;
$parent_nodes = array_reverse(elgg_get_entities_from_relationship($options));

// Displays all children as links which lead to their node.
$child_node_set = '<div style="margin-top:4px;">';
foreach($children_nodes as $child) {
	$temp_name = $child->name;
	if(get_current_language() == 'fr') {
		$temp_name = $child->name_french;
	}
	
	$child_node_set .= elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/missions_organization/set-session-node-guid?nid=' . $child->guid,
			'text' => $temp_name,
			'is_action' => true
	)) . '</br>';
}
if($child_node_set == '<div style="margin-top:4px;">') {
	$child_node_set .= elgg_echo('missions_organization:none');
}
$child_node_set .= '</div></br>';

// Displays all parents as links which lead to their node.
$parent_node_set = '<div style="margin-top:4px;">';
foreach($parent_nodes as $parent) {
	$temp_name = $parent->name;
	if(get_current_language() == 'fr') {
		$temp_name = $parent->name_french;
	}
	
	$parent_node_set .= elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/missions_organization/set-session-node-guid?nid=' . $parent->guid,
			'text' => $temp_name,
			'is_action' => true
	)) . '</br>';
}
if($parent_node_set == '<div style="margin-top:4px;">') {
	$parent_node_set .= elgg_echo('missions_organization:none');
}
$parent_node_set .= '</div></br>';

// Button to change this nodes parent as long as the node is not the root.
if(!$node->root) {
	$change_parent_button = elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'admin/missions_organization/change-parent',
			'text' => elgg_echo('missions_organization:change'),
			'class' => 'elgg-button elgg-button-action'
	));
}

// Button to create a child attached to this node.
$add_child_button = elgg_view('output/url', array(
		'href' => elgg_get_site_url() . 'admin/missions_organization/add-child',
		'text' => elgg_echo('missions_organization:add'),
		'class' => 'elgg-button elgg-button-action'
));

// Button to merge this node with another targeted node.
$merge_button = elgg_view('output/url', array(
		'href' => elgg_get_site_url() . 'admin/missions_organization/merge-node',
		'text' => elgg_echo('missions_organization:merge_this_node'),
		'class' => 'elgg-button elgg-button-action'
));
?>

<?php echo $base; ?>
<div>
	<div style="font-weight:bold;display:inline-block;"><?php echo elgg_echo('missions_organization:parent'); ?></div>
	<div style="display:inline-block;"><?php echo $change_parent_button; ?></div>
	<?php echo $parent_node_set; ?>
</div>
<div>
	<div style="font-weight:bold;display:inline-block;"><?php echo elgg_echo('missions_organization:children'); ?></div>
	<div style="display:inline-block;"><?php echo $add_child_button; ?></div>
	<?php echo $child_node_set; ?>
</div>
</br>
<div>
	<?php echo $merge_button; ?>
</div>
</br>