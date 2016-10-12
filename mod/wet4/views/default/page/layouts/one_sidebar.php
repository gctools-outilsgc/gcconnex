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

//$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
//if (isset($vars['class'])) {
//    $class = "$class {$vars['class']}";
//}

?>

<div class="<?php //echo $class; ?> row">
	<?php
        /*
        echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
        */

    if(elgg_instanceof(elgg_get_page_owner_entity(), 'group')){
        //echo '<div>Hello I am a cover photo or something</div>';
        //$group = elgg_extract('entity', $vars);
        elgg_push_context('groups');
        echo elgg_view('groups/profile/summary');
        elgg_pop_context('groups');
    }
    //main section
    ?>
    <section class="col-md-8 mrgn-bttm-md" id="wb-cont">
        <!--<div class=" clearfix">-->
		<?php

			//echo elgg_get_context();
			echo elgg_view('page/layouts/elements/header', $vars);
            // This basically moves the "page menu" element to the tabs on pages where the side bar links are now tabs :)
			if((elgg_get_context() == 'friends' || elgg_get_context() == 'messages' || elgg_get_context() == 'settings')){

            echo elgg_view_menu('page', array('sort_by' => 'priority'));
            //echo elgg_view_menu('page', array('sort_by' => 'name'));
            
            }
			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
                if(elgg_get_context() != 'group_profile'){
                    if(elgg_is_logged_in()){
                        $buttons = elgg_view_menu('title', array(
                           'sort_by' => 'priority',
                           'class' => 'list-inline pull-right',
                            'item_class' => 'btn btn-primary btn-md',
                            ));

                        $buttons2 = elgg_view_menu('title2', array(
                           'sort_by' => 'priority',
                           'class' => 'list-inline pull-right',
                            'item_class' => 'btn btn-default btn-md mrgn-rght-md',
                            ));

                        echo '<div class="clearfix">';
                        echo $buttons;
                        echo $buttons2;
                        echo '</div>';
                    }
                }
				echo $vars['content'];
			}

			echo elgg_view('page/layouts/elements/footer', $vars);
        ?>
       <!-- </div>-->
	</section>

    <?php //sidebar ?>
	<section class="col-md-4 pull-right">
		<?php

			// by moving sidebar below main content.
			// On smaller screens, blocks are stacked in left to right order: content, sidebar.
			echo elgg_view('page/elements/sidebar', $vars);
		?>
    </section>
</div>
