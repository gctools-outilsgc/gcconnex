<?php
/**
 * Elgg bookmark widget edit view
 *
 * @package Bookmarks
 */

// set default value
if (!isset($vars['entity']->num_display)) {
	$vars['entity']->num_display = 4;
}
$widget = $vars["entity"];
$widgetId = $widget->getGUID();
$params = array(
	'name' => 'params[num_display]',
	'value' => $vars['entity']->num_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
    'id' => 'bookmark-' .$widgetId,
);
$dropdown = elgg_view('input/select', $params);

?>
<div>


        <?php echo '<label for="bookmark-'.$widgetId.'">'.elgg_echo('bookmarks:numbertodisplay').'</label>'; ?>:

	<?php echo $dropdown; ?>
</div>
