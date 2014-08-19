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
$french = array(
	"phloor_custom_favicon" => "phloorFavicon",
	'admin:appearance:phloor_custom_favicon' => "Favicon",

	'phloor_custom_favicon:title' => "Téléchargement favicon",

	'phloor_custom_favicon:description' => "Téléchargement d'une coutume favicon pour votre site. Admis mimetypes sont 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg' et 'image/png'. ",

	'phloor_custom_favicon:save:success' => "Paramètres enregistrés avec succès.",
	'phloor_custom_favicon:save:failure' => "Paramètres pourrait ne pas être sauvegardées.",

	'phloor_custom_favicon:form:section:favicon' => "Favicon",

	'phloor_custom_favicon:image:label' => "Téléchargement d'une coutume favicon",
	'phloor_custom_favicon:image:description' => "Sélectionnez le fichier que vous souhaitez définir comme site favicon. Afin de s'intégrer dans la section en-tête envisager la hauteur et la largeur de l'image.",

	'phloor_custom_favicon:delete_image:label' => "Supprimez favicon",
	'phloor_custom_favicon:delete_image:description' => "Si vous cochez cette case, le favicon seront supprimés.",

);

add_translation("fr", $french);
