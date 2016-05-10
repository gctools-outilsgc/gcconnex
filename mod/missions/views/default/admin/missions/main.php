<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Admin tool page for completing, cancelling, reopening, or deleting missions.
 */
gatekeeper();

$title = elgg_echo('missions:admin_tool_page');
$content .= elgg_view_form('missions/admin-form', array(
		'class' => 'form-horizontal'
));

echo $content;