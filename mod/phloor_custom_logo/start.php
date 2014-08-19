<?php
/*****************************************************************************
 * Phloor Logo                                                               *
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
 * Phloor Custom Logo
 */

elgg_register_event_handler('init', 'system', 'phloor_custom_logo_init');

function phloor_custom_logo_init() {
    /**
     * LIBRARY
     * register a library of helper functions
     */
    $lib_path = elgg_get_plugins_path() . 'phloor_custom_logo/lib/';
    elgg_register_library('phloor-custom-logo-lib', $lib_path . 'phloor_custom_logo.lib.php');
    elgg_load_library('phloor-custom-logo-lib');

    /**
     * Page handler
     */
    elgg_register_page_handler('logo', 'phloor_custom_logo_page_handler');

    /**
     * CSS
     */
    elgg_extend_view('css/elgg',  'phloor_custom_logo/css/elgg' );
    elgg_extend_view('css/admin', 'phloor_custom_logo/css/admin');

    /**
     * Admin menu
     */
    elgg_register_admin_menu_item('configure', 'phloor_custom_logo', 'appearance');

    /**
     * Actions
     */
    $base = elgg_get_plugins_path() . 'phloor_custom_logo/actions/phloor_custom_logo';
    elgg_register_action('phloor_custom_logo/save', "$base/save.php", 'admin');
}

/**
 * Logo page handler
 *
 * returns the logo
 *
 * @param unknown_type $page
 */
function phloor_custom_logo_page_handler($page) {
    if (!array_key_exists(0, $page)) {
        return false;
    }

    $site = elgg_get_site_entity();
    $params = phloor_custom_logo_prepare_vars($site);

    $logo_file = elgg_get_data_path() . 'logo/' . $params['logo'];

    if (!empty($params['logo']) &&
    is_file($logo_file) &&
    file_exists($logo_file)) {

        // get file contents
        $file_contents = file_get_contents($logo_file);
        header('Expires: ' . date('r',  time() + 7*24*60*60));
        header('Pragma: public');
        header('Cache-Control: public');
        header("Content-Disposition: inline; filename=\"{$params['logo']}\"");
        header("Content-type: {$params['mime']}");
        header("Content-Length: " . strlen($file_contents));

        $split_output = str_split($file_contents, 1024);
        foreach ($split_output as $output) {
            echo $output;
        }

        return true;
    }

    return false;
}

