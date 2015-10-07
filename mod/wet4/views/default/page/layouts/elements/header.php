<?php
/**
 * Header for layouts
 *
 * @uses $vars['title']  Title
 * @uses $vars['header'] Optional override for the header
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

$buttons = elgg_view_menu('title', array(
	'sort_by' => 'priority',
	'class' => 'list-inline pull-right',
    'item_class' => 'btn btn-default btn-custom mrgn-rght-sm mrgn-tp-sm',
));

if ($title || $buttons) {
	echo '<div class="elgg-head clearfix">';
	// @todo .elgg-heading-main supports action buttons - maybe rename class name?
	echo $buttons;
    
    //do not display main heading on discussion page
    if($checkPage != 'discussion'){
	   echo elgg_view_title($vars['title'], array('class' => 'elgg-heading-main mrgn-lft-sm'));
    }
	echo '</div>';
}
