<?php
/*****************************************************************************
 * Phloor Topbar Logo                                                        *
 *                                                                           *
 * Copyright (C) 2012 Alois Leitner                                          *
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

$english = array(
	"phloor_custom_topbar_logo" => "phloorTopbarLogo",
	'admin:appearance:phloor_custom_topbar_logo' => 'Topbar logo',

	'phloor_custom_topbar_logo:title' => "Upload logo",

	'phloor_custom_topbar_logo:description' => "Upload a custom topbar logo for your site. Allowed mimetypes are 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg' and 'image/png'. ",

	'phloor_custom_topbar_logo:save:success' => 'Settings successfully saved.',
	'phloor_custom_topbar_logo:save:failure' => 'Settings could not be saved.',

	'phloor_custom_topbar_logo:form:section:topbar_logo' => 'Topbar logo',

	'phloor_custom_topbar_logo:image:label' => 'Upload your topbar logo',
	'phloor_custom_topbar_logo:image:description' => 'Select the file you would like to set as topbar logo. In order to fit into the topbar section consider the height and width of the image. ',

	'phloor_custom_topbar_logo:delete_image:label' => 'Remove topbar logo',
	'phloor_custom_topbar_logo:delete_image:description' => 'If you tick this box the topbar logo will be removed. ',

);

add_translation("en", $english);
