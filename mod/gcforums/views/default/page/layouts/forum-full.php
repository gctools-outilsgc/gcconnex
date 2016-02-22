<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Creates a layout which contains the body of the page, its title and a bar at the top with multiple tabs.
 * These tabs are created with the file under missions/views/default/page/elements/tab.
 */
$class = 'elgg-layout elgg-layout-one-tabbar clearfix';
if (isset($vars['class'])) {
    $class = "$class {$vars['class']}";
}
?>

<div class="<?php echo $class; ?>">
	<div>
		<h1> <?php echo $vars['title']; ?> </h1>
	</div>

	<div class="elgg-main elgg-body">
		<?php
// echo $nav;
if (isset($vars['content'])) {
    echo $vars['content'];
}
?>
	</div>
</div>