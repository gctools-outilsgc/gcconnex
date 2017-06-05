<?php

/**
 * @author Christine Yu
 * Tidbit of the form page that will be appended to forms in relation to new content creation
 */

$display = "";
$display .= "<section class='alert alert-warning'><h3 class='h3'> ".elgg_echo('minor_save:title')." </h3> ".elgg_echo('minor_save:description');

$display .= "<p>";
$display .= elgg_view('input/checkbox', array(
		'name' 		=>	"minor_save",
		'value' 	=>	'yes',
		'default' 	=> 	'no',
		'label' 	=>	elgg_echo('minor_save:checkbox_label'),
		'checked' 	=>	false,
		'id' 		=>	'minor_save',
		'class' 	=>	'chkboxClass',
	));
$display .= "</p>";
$display .= "</section>";


echo $display;

