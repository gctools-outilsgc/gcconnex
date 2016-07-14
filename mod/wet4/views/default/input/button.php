<?php
/**
 * Create a input button
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['src']   Src of an image
 * @uses $vars['class'] Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "elgg-button only-one-click btn btn-default {$vars['class']}";
} else {
	$vars['class'] = "elgg-button";
}

$defaults = array(
	'type' => 'button',
);

$vars = array_merge($defaults, $vars);

switch ($vars['type']) {
	case 'button':
	case 'reset':
	case 'submit':
	case 'image':
    case 'group_search':
		break;
	default:
		$vars['type'] = 'button';
		break;
}

// blank src if trying to access an offsite image. @todo why?
if (isset($vars['src']) && strpos($vars['src'], elgg_get_site_url()) === false) {
	$vars['src'] = "";
}
//Nick I modified the button input to test for group search button so I can put the icon in the button. 
//Existing buttons should not be affected
if($vars['type'] == 'group_search'){
    $button_input ='<button type="submit" '.elgg_format_attributes($vars).'><i class="fa fa-search" aria-hidden="true"></i></button>';
}else{
    $button_input = '<input '.elgg_format_attributes($vars).'>';
}

echo $button_input;
?>


