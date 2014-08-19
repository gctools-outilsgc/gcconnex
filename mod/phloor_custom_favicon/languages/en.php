<?php
/*****************************************************************************
 * Phloor Favicon                                                            *
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
$english = array(
	"phloor_custom_favicon" => "phloorFavicon",
	'admin:appearance:phloor_custom_favicon' => 'Favicon',

	'phloor_custom_favicon:title' => "Upload favicon",

	'phloor_custom_favicon:description' => "Upload a custom favicon for your Elgg site. Allowed mimetypes are 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg' and 'image/png'. ",

	'phloor_custom_favicon:save:success' => 'Settings successfully saved.',
	'phloor_custom_favicon:save:failure' => 'Settings could not be saved.',

	'phloor_custom_favicon:form:section:favicon' => 'Favicon',

	'phloor_custom_favicon:image:label' => 'Upload a custom favicon',
	'phloor_custom_favicon:image:description' => 'Select the file you would like to set as favicon. ',

	'phloor_custom_favicon:delete_image:label' => 'Remove favicon',
	'phloor_custom_favicon:delete_image:description' => 'If you tick this box the favicon will be removed. ',

);

add_translation("en", $english);
