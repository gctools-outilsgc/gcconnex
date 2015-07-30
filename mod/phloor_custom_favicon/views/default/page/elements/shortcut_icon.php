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

$site_url = elgg_get_site_url();
$href = "{$site_url}favicon/favicon.ico";

// create the link string ('SHORTCUT' <- is redundant
// http://en.wikipedia.org/wiki/Favicon#Standardization
//<link rel="shortcut icon" type="{$params['mime']}" href="{$params['href']}">
$content = <<<HTML
<link rel="shortcut icon" href="$href" />
HTML;

// display content
echo $content;
