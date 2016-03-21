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

$content .= elgg_view_entity($node);

echo $content;