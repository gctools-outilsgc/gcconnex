<?php

/**
	 * Elgg MyCustomText plugin
	 *
	 * @package ElggMyCustomText
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Untamed
	 * @copyright Untamed 2008-2010
	 * My Custom Text init function; defines what to do when plugin is enabled
	 *
	 */
			function contactform_init()  {
			// Get config
			global $CONFIG;
			elgg_extend_view('css/elgg', 'pages/css');
 elgg_register_library('contact_lib', elgg_get_plugins_path().'contactform/lib/functions.php');
    elgg_load_library('contact_lib');
   $action_path = elgg_get_plugins_path() . 'contactform/actions/contactform';
	elgg_register_action('contactform/delete', "$action_path/delete.php");
                requirements_check2();
			 elgg_register_page_handler('contactform','contactform_page_handler');
			// Add menu link
				//add_menu(elgg_echo('help_menu_item'), $CONFIG->wwwroot . "pg/contactform/");
			elgg_register_menu_item('site', array(
			'name' => 'Help',
            'href' => $CONFIG->wwwroot . "mod/contactform/",
        		'text' => elgg_echo('contactform:help_menu_item'),
        		'priority' => 1000,
     			) );
         }
function contactform_page_handler($page)
			{
				global $CONFIG;
				switch ($page[0])
				{
					default:
						include $CONFIG->pluginspath . 'contactform/index.php';
						break;
				}
							exit;
			}
elgg_register_event_handler('init', 'system', 'contactform_init');
?>