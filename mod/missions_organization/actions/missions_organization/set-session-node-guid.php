<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to update which node the user is currently looking at.
 */
$_SESSION['organization_node_id'] = get_input('nid');
forward(elgg_get_site_url() . 'admin/missions_organization/node-view');