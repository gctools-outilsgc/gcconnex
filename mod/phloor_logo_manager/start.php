<?php
/*****************************************************************************
 * Phloor Logo Manager                                                       *
 *                                                                           *
 * Copyright (C) 2011, 2012 Alois Leitner                                    *
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

elgg_register_event_handler('init',      'system', 'phloor_logo_manager_init');
elgg_register_event_handler('ready',     'system', 'phloor_logo_manager_ready',     999);
elgg_register_event_handler('pagesetup', 'system', 'phloor_logo_manager_pagesetup', 999);
/**
 *
 */
function phloor_logo_manager_init() {

    run_function_once('phloor_logo_manager_run_function_once');

    /**
     * Extend views
     */
    // add optional logo to footer
    elgg_extend_view('page/elements/footer',  'phloor_logo_manager/page/elements/footer');
}

function phloor_logo_manager_run_function_once() {
    /**
     * Default plugin settings
     */
    elgg_set_plugin_setting('enable_powered_by_elgg',    'true',  'phloor_logo_manager');
    elgg_set_plugin_setting('enable_powered_by_phloor',  'false', 'phloor_logo_manager');
    elgg_set_plugin_setting('enable_elgg_topbar_logo',   'true',  'phloor_logo_manager');
    elgg_set_plugin_setting('enable_phloor_topbar_logo', 'false', 'phloor_logo_manager');
}

function phloor_logo_manager_ready() {
    // just do something if admin is logged in
    if(elgg_is_admin_logged_in()) {

        
        // link to admin section of phloorLogo
        if(elgg_is_active_plugin('phloor_custom_logo')) {
            // unregister the menu item created by 'Logo for 1.8'
            elgg_unregister_menu_item('page', 'appearance:phloor_custom_logo');
            // register new logo settings link
            elgg_register_menu_item('page', array(
				'name' => 'appearance:phloor_custom_logo',
				'href' => "admin/appearance/phloor_custom_logo",
				'text' => elgg_echo("admin:appearance:phloor_custom_logo"),
				'context' => 'admin',
				'priority' => 100,
				'section' => 'logo',
            ));
        }

        // link to admin section of phloorFavicon
        if(elgg_is_active_plugin('phloor_custom_favicon')) {
            // unregister the menu item created by 'Favicon for 1.8'
            elgg_unregister_menu_item('page', 'appearance:phloor_custom_favicon');
            // register new favicon settings link            
            elgg_register_menu_item('page', array(
				'name' => 'appearance:phloor_custom_favicon',
				'href' => "admin/appearance/phloor_custom_favicon",
				'text' => elgg_echo("admin:appearance:phloor_custom_favicon"),
				'context' => 'admin',
				'priority' => 200,
				'section' => 'logo',
            ));
        }
        
         // link to admin section of phloorFavicon
        if(elgg_is_active_plugin('phloor_custom_topbar_logo')) {
            // unregister the menu item created by 'Topbar Logo for 1.8'
            elgg_unregister_menu_item('page', 'appearance:phloor_custom_topbar_logo');
            // register new topbar logo settings link
            elgg_register_menu_item('page', array(
				'name' => 'appearance:phloor_custom_topbar_logo',
				'href' => "admin/appearance/phloor_custom_topbar_logo",
				'text' => elgg_echo("admin:appearance:phloor_custom_topbar_logo"),
				'context' => 'admin',
				'priority' => 300,
				'section' => 'logo',
            ));
        }

        // "more" for internal "phloor_logo_manager" plugin settings
        elgg_register_menu_item('page', array(
			'name' => 'appearance:phloor_logo_manager',
			'href' => "admin/plugin_settings/phloor_logo_manager",
			'text' => elgg_echo("more"),
			'context' => 'admin',
			'priority' => 400,
			'section' => 'logo',
        ));
    }
}

/**
 * Unregister/register logos
 */
function phloor_logo_manager_pagesetup() {
    /**
     *  unregister elgg-logo
     */
    $enable_elgg_topbar_logo = elgg_get_plugin_setting('enable_elgg_topbar_logo', 'phloor_logo_manager');
    if(!(strcmp('true', $enable_elgg_topbar_logo) == 0)) {
        elgg_unregister_menu_item('topbar', 'elgg_logo');
    }

    /**
     *  add logo to topbar
     */
    $enable_phloor_topbar_logo = elgg_get_plugin_setting('enable_phloor_topbar_logo', 'phloor_logo_manager');
    if(strcmp('true', $enable_phloor_topbar_logo) == 0) {
        $phloor_topbar_logo_url = elgg_get_site_url() . 'mod/phloor/graphics/phloor_topbar_logo.gif';
        elgg_register_menu_item('topbar', array(
			'name' => 'phloor_logo',
			'href' => 'http://phloor.13net.at/',
			'text' => "<img src=\"$phloor_topbar_logo_url\" alt=\"phloor logo\" width=\"20\" height=\"20\" />",
			'priority' => 1,
		    'link_class' => 'phloor-topbar-logo',
			'section' => 'aaa',
        ));
    }
}