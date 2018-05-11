<?php
/**
 * Form body for editing or adding a friend collection
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['collection'] Optionally, the collection to edit
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels
 * Author: GCTools Team
 */
// Set title, form destination
if (isset($vars['collection'])) {
	$title = $vars['collection']->name;
	$highlight = 'default';
} else  {
	$title = "";
	$highlight = 'all';
}

echo "<div class='mbl'><label for='collection_name'>" . elgg_echo("friends:collectionname") . "</label>";
echo elgg_view("input/text", array(
	"name" => "collection_name",
	"id" => "collection_name",
	"value" => $title,
    "required" => "required",
));
echo "</div>";

$members = get_members_of_access_collection($vars['collection']->id, true);
if (!$members) {
	$members = array();
}

echo "<div id='colleague_collection_invite_users' class='mbl'>";
echo "<div><label for='colleague_collection_autocomplete'>" . elgg_echo("group_tools:group:invite:users:description") . "</label></div>";
echo elgg_view("input/colleague_collection_autocomplete", array("name" => "friends_collection", "id" => "colleague_collection", "group_guid" => elgg_get_logged_in_user_guid(), "relationship" => "site", "members" => $members));
echo "</div>";

echo '<div class="elgg-foot">';
if (isset($vars['collection'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'collection_id',
		'value' => $vars['collection']->id,
	));
}
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save'), 'class' => 'btn btn-primary'));
echo '</div>';

?>
