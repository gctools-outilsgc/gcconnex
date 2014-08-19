<?php	

/*
** Rename Friends
**
** @author Matt Beckett, matt@clever-name.com
** @copyright Matt Beckett 2011
** @link http://clever-name.com
** @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
**
*/

function rename_friends_init()
{
	// Load the language file
	register_translations(elgg_get_plugins_path() . "rename_friends/languages/");
	
	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg','rename_friends/css');
	
}

  
// Initialise this plugin
elgg_register_event_handler('init','system','rename_friends_init');


?>
