
<?php
/**
 * Elgg one-column layout
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 */



//$class = 'elgg-layout elgg-layout-one-column clearfix';
//if (isset($vars['class'])) {
//    $class = "$class {$vars['class']}";
//}
echo $vars['title'];
if(elgg_get_context() =='contactform'){

	echo'<section class="alert alert-warning">
	
	<h3> <a href="https://gcconnex.gc.ca/pages/view/19984549/gcconnex-updates-march-21-2016-mise-a-jour-de-gcconnnex-21-mars-2016">'.elgg_echo('contactform:update:alert').'</a></h3>
</section>';
};
?>

<div class="<?php echo $class; ?>row">
	<?php

		//echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

		//echo elgg_view('page/layouts/elements/header', $vars);

    echo '<section class="col-md-6">';

		echo $vars['content'];
        echo '</section>';
        echo '<section class="col-md-6">';

        echo $vars['sidebar'];
        echo '</section>';


		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
	?>

</div>