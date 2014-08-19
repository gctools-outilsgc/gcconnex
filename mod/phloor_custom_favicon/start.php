<?php
/*****************************************************************************
 * Phloor Favicon                                                            *
 *                                                                           *
 * Copyright (C) 2011 Alois Leitner                                          *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 *****************************************************************************/
?>
<?php
/**
 * Phloor Custom Favicon
 */

elgg_register_event_handler('init', 'system', 'phloor_custom_favicon_init');

function phloor_custom_favicon_init() {
	/**
	 * LIBRARY
	 * register a library of helper functions
	 */
	$lib_path = elgg_get_plugins_path() . 'phloor_custom_favicon/lib/';
	elgg_register_library('phloor-custom-favicon-lib', $lib_path . 'phloor_custom_favicon.lib.php');
	elgg_load_library('phloor-custom-favicon-lib');

	/**
	 * CSS
	 */
	elgg_extend_view('css/elgg',  'phloor_custom_favicon/css/elgg' );
	elgg_extend_view('css/admin', 'phloor_custom_favicon/css/admin');

	/**
	 * Admin menu
	 */
	elgg_register_admin_menu_item('configure', 'phloor_custom_favicon', 'appearance');

	/**
	 * Actions
	 */
	$base = elgg_get_plugins_path() . 'phloor_custom_favicon/actions/phloor_custom_favicon';
	elgg_register_action('phloor_custom_favicon/save', "$base/save.php", 'admin');


	/**
	 * Page handler
	 */
	elgg_register_page_handler('favicon', 'phloor_custom_favicon_page_handler');
	elgg_register_page_handler('favicon.ico', 'phloor_custom_favicon_page_handler');

	/**
	 * Hooks
	 */
	// allow favicon when walled_garden is active
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'phloor_custom_favicon_public_pages');

}

/**
 * Favicon page handler
 *
 * serves the favicon
 *
 * @param unknown_type $_ parameters does not matter and is ignored
 */
function phloor_custom_favicon_page_handler($_) {
	include('favicon.php');
	return true;
}

