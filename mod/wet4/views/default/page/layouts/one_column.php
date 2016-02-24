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

?>
<!--<div class="<?php //echo $class; ?> row">
	<div class="elgg-main">-->
<section id="wb-cont">
	<?php
	if($params['event_page'] == true){
		echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
		echo elgg_view('page/layouts/elements/header', $vars);
}else{
    if(elgg_in_context('messages')){
        echo elgg_view('page/layouts/elements/header', $vars);
        echo elgg_view_menu('page', array('sort_by' => 'priority'));
        echo elgg_view_menu('title', array('sort_by' => 'priority', 'class' => 'list-unstyled text-right', 'item_class' => 'btn btn-primary'));
    } else {
        echo $vars['title'];
}
}
		

		echo $vars['content'];
		
		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
    ?>
</section>
	<!--</div>
</div>-->