<?php
/**
 * ideas search and add form
 *
 */
$group = elgg_get_page_owner_entity();

if (!$description = $group->ideas_description) $description = '';

$question = elgg_echo('ideas:search');

echo elgg_view('output/longtext', array('value' => $description));

echo '<h3 class="mvm">' . $question . '</h3>';

echo elgg_view('input/text', array(
	'name' => 'body',
	'class' => 'mbm',
	'id' => 'ideas-textarea',
));

?>

<div id="ideas-characters-remaining">
	<span>140</span> <?php echo elgg_echo('ideas:charleft'); ?>
</div>
<div id="ideas-search-response"></div>