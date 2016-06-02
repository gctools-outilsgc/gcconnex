<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$show_delete_tree = $vars['entity']->show_delete_tree;
if (empty($show_delete_tree)) {
    $show_delete_tree = 'NO';
}
?>

<div>
	<?php echo elgg_echo('missions_organization:settings:delete_tree'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[show_delete_tree]',
    			'options' => array('YES','NO'),
    			'value' => $show_delete_tree
		));
	?>
</div>