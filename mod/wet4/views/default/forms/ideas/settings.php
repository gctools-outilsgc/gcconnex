<?php
/**
 * Edit / add an idea
 *
 * @package ideas
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()

$description = elgg_extract('ideas_description', $vars, '');
$question = elgg_extract('ideas_question', $vars, elgg_echo('ideas:search'));

$group_guid = elgg_get_page_owner_guid();

?>

<div>
    <label for="ideas_description"><?php echo elgg_echo('description'); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'ideas_description', 'id' => 'ideas_description', 'value' => $description)); ?>
</div>

<div class="elgg-foot">
	<?php

	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $group_guid));

	echo elgg_view('input/submit', array('value' => elgg_echo("save"), 'class' => 'btn btn-primary mrgn-tp-md'));

	?>
</div>