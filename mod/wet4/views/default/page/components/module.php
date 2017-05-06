<?php

/**
 * module.php
 * Elgg module element
 *
 * @uses $vars['type']         The type of module (main, info, popup, aside, etc.)
 * @uses $vars['title']        Optional title text (do not pass header with this option)
 * @uses $vars['header']       Optional HTML content of the header
 * @uses $vars['body']         HTML content of the body
 * @uses $vars['footer']       Optional HTML content of the footer
 * @uses $vars['class']        Optional additional class for module
 * @uses $vars['id']           Optional id for module
 * @uses $vars['show_inner']   Optional flag to leave out inner div (default: false)
 *
 * @package wet4
 * @author GCTools Team

 2015/10/14-
 Added conditional check to see what page the module is loaded on and what type of module it is
 */


//check which page module will be rendering on for styling
$checkPage = elgg_get_context();
//echo $checkPage;
$type = elgg_extract('type', $vars, false);
$title = elgg_extract('title', $vars, '');
$body = elgg_extract('body', $vars, '');
$footer = elgg_extract('footer', $vars, '');
$show_inner = elgg_extract('show_inner', $vars, false);
$item_class = elgg_extract('item_class', $vars, '');

$attrs = [
	'id' => elgg_extract('id', $vars),
	'class' => (array) elgg_extract('class', $vars, []),
    //'item_class' => (array) elgg_extract('item_class', $vars, []),
    'aria-grabbed' => elgg_extract('aria-grabbed', $vars), //this is for accessible drag and drop
    'draggable' => elgg_extract('draggable', $vars),
    'tabindex' => elgg_extract('tabindex', $vars),

];

/**
 *
 * Check which page and type of module are being rendered
 * If in tab on group profile, dont have normal style
 *
 */

if( $type == 'GPmod'){

    if ($type) {
        $attrs['class'][] = "elgg-module-$type";
    }


    $body = elgg_format_element('div', ['class' => 'clearfix'], $body);
    if ($footer) {
        $footer = elgg_format_element('div', ['class' => 'text-center panel-footer clearfix'], $footer);
    }

    $contents = $header . $body . $footer;
    if ($show_inner) {
        $contents = elgg_format_element('div', ['class' => 'elgg-inner'], $contents);
    }

    echo elgg_format_element('div', $attrs, $contents);

} else if ($checkPage =='gallery'){
    // check to see if the page is a photo gallery to style the photo stuff :)

        $attrs['class'][] = 'panel panel-custom hght-inhrt ';
    if ($type) {
        $attrs['class'][] = "elgg-module-$type";
    }

    $header = elgg_extract('header', $vars);
    if ($title) {
        $header = elgg_format_element('h4', ['class' => ''], $title);
    }

    if ($header !== null) {
        $header = elgg_format_element('div', ['class' => 'panel-heading'], $header);
    }
    $body = elgg_format_element('div', ['class' => 'panel-body-gallery  clearfix'], $body);
    if ($footer) {
        $footer = elgg_format_element('div', ['class' => 'panel-body-gallery'], $footer);
    }

    $contents =  $body  .$footer ;
    if ($show_inner) {
        $contents = elgg_format_element('div', ['class' => 'elgg-inner'], $contents);
    }

    echo elgg_format_element('div', $attrs, $contents);


}else if(($type == 'tidypics-album-wet' && elgg_in_context('profile')) || ($type == 'tidypics-album-wet' && elgg_in_context('group_profile'))){ //Normal Style Below

    if($checkPage =='custom_index_widgets'){
        $attrs['class'][] = 'panel panel-default custom-index-panel';
    }else{
        $attrs['class'][] = 'panel panel-default TEST';
    }


    if ($type) {
        $attrs['class'][] = "elgg-module-$type";
    }

    $header = elgg_extract('header', $vars);
    if ($title) {
        //$header = elgg_format_element('h2', ['class' => 'panel-title'], gc_explode_translation($title,get_current_language()));
        $header = elgg_format_element('h3', ['class' => 'panel-title'], $title);
    }

    if ($header !== null) {
       // $header = elgg_format_element('div', ['class' => 'panel-heading'], $header);
        $header = elgg_format_element('header', ['class' => 'panel-heading'], $header);
    }
    $body = elgg_format_element('div', ['class' => 'panel-body clearfix'], $body);
    if ($footer) {
        $footer = elgg_format_element('div', ['class' => 'panel-footer text-right'], $footer);
    }

    $contents = $header . $body . $footer;
    if ($show_inner) {
        $contents = elgg_format_element('div', ['class' => 'elgg-inner'], $contents);
    }

    echo elgg_format_element('div', $attrs, $contents);
    //echo $checkPage;

} else { //Normal Style Below

    if($checkPage =='custom_index_widgets'){
        $attrs['class'][] = 'panel panel-default custom-index-panel';
    }else{
        $attrs['class'][] = 'panel panel-default TEST';
    }


    if ($type) {
        $attrs['class'][] = "elgg-module-$type";
    }

    $header = elgg_extract('header', $vars);
    if ($title) {
        //$header = elgg_format_element('h2', ['class' => 'panel-title'], gc_explode_translation($title,get_current_language()));
        $header = elgg_format_element('h2', ['class' => 'panel-title'], $title);
    }

    if ($header !== null) {
       // $header = elgg_format_element('div', ['class' => 'panel-heading'], $header);
        $header = elgg_format_element('header', ['class' => 'panel-heading'], $header);
    }
    $body = elgg_format_element('div', ['class' => 'panel-body clearfix'], $body);
    if ($footer) {
        $footer = elgg_format_element('div', ['class' => 'panel-footer text-right'], $footer);
    }

    $contents = $header . $body . $footer;
    if ($show_inner) {
        $contents = elgg_format_element('div', ['class' => 'elgg-inner'], $contents);
    }

    echo elgg_format_element('div', $attrs, $contents);
    //echo $checkPage;

}
