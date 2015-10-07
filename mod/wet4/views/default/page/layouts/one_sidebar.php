<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is added to the sidebar
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

?>

<div class="<?php echo $class; ?>">
	<?php
        /*
        echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
        */
    ?>
    
    <section class="col-md-8" id="wb-cont">
        <div class=" panel panel-custom clearfix">
		<?php
			
			
			echo elgg_view('page/layouts/elements/header', $vars);
			
			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
			
			echo elgg_view('page/layouts/elements/footer', $vars);
		?>
        </div>
	</section>
	<section class="col-md-4">
		<?php
			
			// by moving sidebar below main content.
			// On smaller screens, blocks are stacked in left to right order: content, sidebar.
			echo elgg_view('page/elements/sidebar', $vars);
		?>
    </section>
</div>
