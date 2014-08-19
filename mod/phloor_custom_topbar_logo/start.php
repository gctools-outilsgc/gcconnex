<?php
/*****************************************************************************
 * Phloor topbar_logo                                                            *
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
 * Phloor Custom topbar_logo
 */

elgg_register_event_handler('init',      'system', 'phloor_custom_topbar_logo_init');
elgg_register_event_handler('pagesetup', 'system', 'phloor_custom_topbar_logo_pagesetup');

function phloor_custom_topbar_logo_init() {
	/**
	 * LIBRARY
	 * register a library of helper functions
	 */
	$lib_path = elgg_get_plugins_path() . 'phloor_custom_topbar_logo/lib/';
	elgg_register_library('phloor-custom-topbar_logo-lib', $lib_path . 'phloor_custom_topbar_logo.lib.php');
	elgg_load_library('phloor-custom-topbar_logo-lib');

	/**
	 * Page handler
	 */
	elgg_register_page_handler('topbarlogo', 'phloor_custom_topbar_logo_page_handler');

	/**
	 * CSS
	 */
	elgg_extend_view('css/elgg',  'phloor_custom_topbar_logo/css/elgg' );
	elgg_extend_view('css/admin', 'phloor_custom_topbar_logo/css/admin');

	/**
	 * Admin menu
	 */
	elgg_register_admin_menu_item('configure', 'phloor_custom_topbar_logo', 'appearance');

	/**
	 * Actions
	 */
	$base = elgg_get_plugins_path() . 'phloor_custom_topbar_logo/actions/phloor_custom_topbar_logo';
	elgg_register_action('phloor_custom_topbar_logo/save', "$base/save.php", 'admin');

    /**
	 * Hooks
	 */
	// allow topbar logo when walled_garden is active
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'phloor_custom_topbar_logo_public_pages');
}

/**
 * Favicon page handler
 *
 * serves the favicon
 *
 * @param unknown_type $_ parameters does not matter and is ignored
 */
function phloor_custom_topbar_logo_page_handler($_) {
	include('topbarlogo.php');
	return true;
}

/**
 * Unregister/register logos
 */
function phloor_custom_topbar_logo_pagesetup() {
    if (phloor_custom_topbar_logo_topbar_logo_has_image()) {
    	$title = elgg_get_site_entity()->name;
        $topbar_logo_url = elgg_get_site_url() . "topbarlogo/logo.png";

    	$topbar_logo = "<img src=\"$topbar_logo_url\" title=\"$title\" alt=\"Topbar Icon\" />";

        elgg_register_menu_item('topbar', array(
			'name' => 'phloor_custom_topbar_logo',
			'href' => elgg_get_site_url(),
			'text' => $topbar_logo,
			'priority' => 1,
		    'link_class' => 'phloor-custom-topbar-logo',
			'section' => 'aaa',
        ));
    }
}
