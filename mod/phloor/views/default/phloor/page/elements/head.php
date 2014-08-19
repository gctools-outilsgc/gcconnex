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

// show phloor version and release metadata
$hide_phloor_metadata = elgg_get_plugin_setting('hide_phloor_metadata', 'phloor');
if(strcmp('true', $hide_phloor_metadata) != 0) {	
	$phloor_version = phloor_get_version();
	$phloor_release = phloor_get_version(true);
	
	echo "<meta name=\"PhloorRelease\" content=\"{$phloor_version}\" />";
	echo "<meta name=\"PhloorVersion\" content=\"{$phloor_release}\" />";
}
