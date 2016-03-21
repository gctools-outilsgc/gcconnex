<?php
/**
 * User blog widget edit view
 */

// set default value
if (!isset($vars['entity']->num_display)) {
	$vars['entity']->num_display = 4;
}

$params = array(
	'name' => 'params[num_display]',
	'value' => $vars['entity']->num_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
    'id' => 'blog-params[num_display]',
);
$dropdown = elgg_view('input/select', $params);

?>
<div>
    <label for="blog-params[num_display]">
        <?php echo elgg_echo('blog:numbertodisplay'); ?>:
    </label>
	<?php echo $dropdown; ?>
</div>
