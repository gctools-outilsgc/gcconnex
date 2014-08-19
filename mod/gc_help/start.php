<?php

	/**
	 * Elgg MyCustomText plugin
	 *
	 * @package ElggMyCustomText
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Untamed
	 * @copyright Untamed 2008-2010
	 */

	/**
	 * My Custom Text init function; defines what to do when plugin is enabled
	 *
	 */
		function gc_help_init() {

			// Get config
			global $CONFIG;

			elgg_extend_view('css/elgg', 'pages/css');


			 elgg_register_page_handler('gc_help','gc_help_page_handler');
				
			// Add menu link
				//add_menu(elgg_echo('help_menu_item'), $CONFIG->wwwroot . "pg/gc_help/");
			elgg_register_menu_item('site', array(
			'name' => 'Help',
        		'href' => $CONFIG->wwwroot . "pg/gc_help/",
        		'text' => elgg_echo('help_menu_item'),
        		'priority' => 1000,
     			) );	
			}

			function gc_help_page_handler($page)
			{
				global $CONFIG;
				switch ($page[0])
				{
					default:
						include $CONFIG->pluginspath . 'gc_help/index.php';
						break;	
				}
							exit;
			}

				
				//Startup stuff... links to mycustomtext_init function
		elgg_register_event_handler('init', 'system', 'gc_help_init');
?>