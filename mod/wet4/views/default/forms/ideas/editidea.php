<?php
/**
 * Edit / add an idea
 *
 * @package ideas
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()

$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);

$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
?>

<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php
	if (elgg_is_admin_logged_in()) {
		echo $title;
	} else {
		echo $title;
	}
    ?>
</div>
<div>
    <label for="description"><?php echo elgg_echo('description'); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'id' => 'description', 'value' => $desc)); ?>
</div>

<div>
	<label for="tags"><?php echo elgg_echo('tags'); ?></label>
    <?php echo elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $tags)); ?>
</div>
<?php
	$categories = elgg_view('input/categories', $vars);
	if ($categories) {
		echo $categories;
	}
?>

<div class="elgg-foot mtl">
	<?php

	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

	if ($guid) {
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
	}

	echo elgg_view('input/submit', array('value' => elgg_echo("save"), 'class' => 'btn btn-primary'));

	?>
</div>