<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
gatekeeper();

$node_guid = $_SESSION['organization_node_id'];
$node = get_entity($node_guid);

$title = elgg_echo('missions_organization:change_parent_page');
$content = elgg_echo('missions_organization:changing_parent_to', array($node->name));
$content .= elgg_view_form('missions_organization/change-parent-form', array(
		'class' => 'form-horizontal'
), array(
		'node_guid' => $node_guid
));

echo $content;