<?php

/**
 * @author Christine Yu
 * Tidbit of the form page that will be appended to forms in relation to new content creation
 */

$display = "";
$display .= "<section class='alert alert-danger'><h3 class='h3'> New content creation will send out notification unless you check out the Minor save </h3> Praesent volutpat vel risus ac lacinia. Sed sed orci nisl. Vivamus sagittis mi lorem, et tempor neque gravida ut. Praesent placerat magna at leo tempus, sed sollicitudin lacus maximus. Nullam ornare lorem finibus neque suscipit, tristique luctus lectus pulvinar. Vivamus ac dui porttitor, cursus risus eget, tristique nisl. Pellentesque tempus metus bibendum varius aliquet. Pellentesque lobortis leo nec condimentum pulvinar.";

$display .= "<p>";
$display .= elgg_view('input/checkbox', array(
		'name' 		=>	"minor_save",
		'value' 	=>	'yes',
		'default' 	=> 	'no',
		'label' 	=>	'Minor Save',
		'checked' 	=>	false,
		'id' 		=>	'minor_save',
		'class' 	=>	'chkboxClass',
	));
$display .= "</p>";
$display .= "</section>";


echo $display;

