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

//elgg_register_event_handler('plugins_boot',  'system', 'phloor_plugins_boot', 1);
elgg_register_event_handler('init',  'system', 'phloor_plugins_boot', 1);

/**
 *
 */
function phloor_plugins_boot() {
	/**
	 * LIBRARY
	 * register a library of helper functions
	 */
	$lib_path = elgg_get_plugins_path() . 'phloor/lib/';
	elgg_register_library('phloor-lib', $lib_path . 'phloor.lib.php');
	elgg_load_library('phloor-lib');

	phloor_boot();
}

