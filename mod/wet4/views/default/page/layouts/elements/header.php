<?php
/**
 * Header for layouts
 *
 * @uses $vars['title']  Title
 * @uses $vars['header'] Optional override for the header
 
 2015/10/15-
 Removed page header from group profile page
 Styled buttons
 */

//check what page we are on
$checkPage = elgg_get_context();

//echo $checkPage;

if (isset($vars['header'])) {
	echo '<div class="elgg-head clearfix">';
	echo $vars['header'];
	echo '</div>';
	return;
}

$title = elgg_extract('title', $vars, '');

/*$buttons = elgg_view_menu('title', array(
	'sort_by' => 'priority',
	'class' => 'list-inline pull-right',
    'item_class' => 'mrgn-rght-sm mrgn-tp-sm btn btn-custom',
));*/

if ($title || $buttons) {

	 
    
    //do not display main heading on discussion page
    if($checkPage == 'group_profile'){
	   
    } else {
        // @todo .elgg-heading-main supports action buttons - maybe rename class name?
        if(elgg_get_page_owner_entity()){
            if(elgg_get_page_owner_entity()->getType() == 'group'){
                echo elgg_view('groups/profile/summaryBlock', $vars);
                elgg_push_context('groupSubPage');
                echo elgg_view('groups/profile/tab_menu');
                elgg_pop_context();
            }
        }
	  echo $buttons;   
        echo elgg_view_title($vars['title'], array('class' => 'elgg-heading-main mrgn-lft-sm'));
      
    }

}
