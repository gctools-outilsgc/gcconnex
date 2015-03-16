<?php
/**
 * Group deletion process mod for the Elgg groups plugin
 *
 * @package ElggGroups
 */

elgg_register_event_handler('init', 'system', 'groups_delete_init');


/**
 * Initialize the groups plugin.
 */
function groups_delete_init() {

// regiser actions
elgg_register_action("groups/delete", dirname(__FILE__) . "/actions/groups/delete.php");

// page handler for the delete page
elgg_register_page_handler('delete-group', 'delete_group_page_handler');

}


function delete_group_page_handler ($page){
	global $vars;

	//$group = get_entity($guid);
	$title = elgg_echo('group_deletion:title', array('group'));

	$content = elgg_echo( 'group_deletion:page-content' )
	. "<form id='group-deletion-form' action='" . elgg_get_site_url() . "action/groups/delete' enctype=\"multipart/form-data\" method=\"post\" class=\"elgg-form\"> <br />"
	. elgg_view("input/hidden", array("name" => "PHPSESSID", "value" => session_id()))
	. elgg_view('input/securitytoken')
	. elgg_view("input/hidden", array("name" => "guid", "value" => $page[0]) )
	. elgg_view("input/hidden", array("name" => "delete", "value" => 1 ) )
	. elgg_view("input/submit", array("value" => elgg_echo("group_deletion:submit")) )
	. "</form>";

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);

	return true;
}


?>