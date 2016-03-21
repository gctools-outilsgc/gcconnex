<?php
/**
 * ideas search and add form
 *
 */
$group = elgg_get_page_owner_entity();

if (!$description = $group->ideas_description) $description = '';

$question = elgg_echo('ideas:search');

echo elgg_view('output/longtext', array('value' => $description));

echo '<label for="ideas-textarea" class="mvm">' . $question . '</label>';
// GCchange - Ilia: encased text box in a div to prevent it from overflowing the available space in the central column.
echo "<div style='width:97%;'>". elgg_view('input/text', array(
	'name' => 'body',
	'class' => 'mbm',
	'id' => 'ideas-textarea',
))  ."</div>";

?>

<div id="ideas-characters-remaining" class="mrgn-bttm-sm">
	<span>140</span> <?php echo elgg_echo('ideas:charleft'); ?>
</div>
<div id="ideas-search-response" class="mrgn-bttm-sm"></div>