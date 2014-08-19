<?php

	/**
	 * Elgg MyCustomText plugin
	 *
	 * @package ElggMyCustomText
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Untamed
	 * @copyright Untamed 2008-2010
	 */

	// Get the Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
		//Link text php file to body and display page
		//$body = elgg_view('mytext');
		$title = elgg_echo("help_menu_item");

		$content = elgg_view_title($title);
		$content.= elgg_view('help');

		$body = elgg_view_layout('one_sidebar', array(
   				'content' => $content,
   				'sidebar' => $sidebar,
   				
				));
		//page_draw($title, $body);
		echo elgg_view_page($title, $body);
?>