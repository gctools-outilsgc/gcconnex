<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
global $CONFIG;
admin_gatekeeper();
$content = elgg_view_title("MSOffice Mime Types Patch");
$content .= elgg_view_form("msoffice_mime_types_patch/fixit");
// Format page
$body = elgg_view_layout('one_column', array(
	'content' => $content,
));
// Draw it
echo elgg_view_page("MSOffice Mime Types Patch", $body);
?>