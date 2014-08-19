<?php
/*****************************************************************************
 * Phloor                                                                    *
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
/**
 * get the current phloor version
 */
function phloor_get_version($humanreadable = false) {
    static $phloor_version, $phloor_release;

    $elgg_version = get_version();
    if($elgg_version === false) {
        return false;
    }

    $path = elgg_get_plugins_path() . 'phloor/';
    if (!isset($phloor_version) || !isset($phloor_release)) {
        if (!include($path . "version.php")) {
            return false;
        }
    }
    return (!$humanreadable) ? $phloor_version : $phloor_release;
}


/**
 *
 */
function phloor_boot() {
	/**
	 * Classes
	 */
    $classes_path = elgg_get_plugins_path() . 'phloor/classes/';
    elgg_register_classes($classes_path);

	/**
	 * LIBRARY
	 * register a library of helper functions
	 */
	$lib_path = elgg_get_plugins_path() . 'phloor/lib/phloor/';
	elgg_register_library('phloor-misc-lib',         $lib_path . 'misc.lib.php');
	elgg_register_library('phloor-string-lib',       $lib_path . 'strings.lib.php');
	elgg_register_library('phloor-views-lib',        $lib_path . 'views.lib.php');

	elgg_register_library('phloor-output-lib',       $lib_path . 'output.lib.php');
	elgg_register_library('phloor-image-lib',        $lib_path . 'image.lib.php');
	elgg_register_library('phloor-thumbnails-lib',   $lib_path . 'thumbnails.lib.php');


	elgg_load_library('phloor-string-lib');
	elgg_load_library('phloor-misc-lib');
	elgg_load_library('phloor-views-lib');
	elgg_load_library('phloor-output-lib');

	elgg_load_library('phloor-image-lib');
	elgg_load_library('phloor-thumbnails-lib');

	// load phloor views
	phloor_views_boot();
}