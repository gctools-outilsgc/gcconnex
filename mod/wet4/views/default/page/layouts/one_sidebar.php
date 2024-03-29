<?php
/**
 * one_sidebar.php
 *
 * Layout for main column with one sidebar
 *
 * @package wet4
 * @author GCTools Team
 *
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is added to the sidebar
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 * @uses $vars['class']   Additional class to apply to layout
 *
 * Modified by the GCTools Team - Sept 6 2017
 */


?>
<div class="clear row">

<?php

    $context = elgg_get_context();
    
    /// forums will take up the whole width of the screen, while others will take up only a portion
    echo ($context === 'gcforums') ? '<section class="col-md-12 mrgn-bttm-md" id="wb-cont">' : ($context === 'discussion' ? '<section class="col-md-8 mrgn-bttm-md" style="width: 100%" id="wb-cont">' : '<section class="col-md-8 mrgn-bttm-md" id="wb-cont">');

	echo elgg_view('page/layouts/elements/header', $vars);

    // This basically moves the "page menu" element to the tabs on pages where the side bar links are now tabs :)
	if ($context == 'friends' || $context == 'messages' || $context == 'settings')
        echo elgg_view_menu('page', array('sort_by' => 'priority'));

    // @todo deprecated so remove in Elgg 2.0
	if (isset($vars['area1'])) echo $vars['area1'];

	if (isset($vars['content'])) {

        echo $vars['content'];

	}

    echo elgg_view('page/layouts/elements/footer', $vars);
?>
    </section>
<?php
    if ($context == 'discussion') {
        return;
    }
?>
    <section class="col-md-4 pull-right">

<?php // On smaller screens, blocks are stacked in left to right order: content, sidebar.
    echo elgg_view('page/elements/sidebar', $vars);
?>

	</section>
</div>
