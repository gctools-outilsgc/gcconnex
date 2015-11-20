<?php
register_elgg_event_handler('init','system','contactform_init');

function contactform_init() 
{
	global $CONFIG;
	//add_menu(elgg_echo('contactform:menu'), $CONFIG->wwwroot . "mod/contactform");
    elgg_register_menu_item('site', array(
			'name' => 'Help',
        		'href' => $CONFIG->wwwroot . "mod/contactform",
        		'text' => elgg_echo('contactform:help_menu_item'),
        		'priority' => 1000,
     			) );	
    elgg_register_library('contact_lib', elgg_get_plugins_path().'contactform/lib/functions.php');
    
    elgg_load_library('contact_lib');
    requirements_check2();
    
    	$action_path = elgg_get_plugins_path() . 'contactform/actions/contactform';
	elgg_register_action('contactform/delete', "$action_path/delete.php");
}
		
	

?>


