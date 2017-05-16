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

echo "<div class=\"mtm\"><label for='collection_name'>" . elgg_echo("friends:collectionname") . "</label><br/>";
echo elgg_view("input/text", array(
		"name" => "collection_name",
		"id" => "collection_name",
		"value" => $title,
    'required '=> "required",
	));
echo "</div>";

echo "<div>";
if ($vars['collection_members']) {
	echo elgg_echo("friends:collectionfriends") . "<br />";
	foreach ($vars['collection_members'] as $mem) {
		echo elgg_view_entity_icon($mem, 'tiny');
		echo $mem->name;
	}
}
echo "</div>";

$members = get_members_of_access_collection($vars['collection']->id, true);
if (!$members) {
	$members = array();
}

echo "<div><label for='friends_collection'>" . elgg_echo("friends:addfriends") . "</label>";
echo elgg_view('input/friendspicker', array(
	'entities' => $vars['friends'],
	'name' => 'friends_collection',
	'id' => 'friends_collection',
	'highlight' => $highlight,
    'value' => $members
));
echo "</div>";

echo '<div class="elgg-foot">';
if (isset($vars['collection'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'collection_id',
		'value' => $vars['collection']->id,
	));
}
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save'), 'class' => 'btn btn-primary mrgn-tp-md'));
echo '</div>';

?>
