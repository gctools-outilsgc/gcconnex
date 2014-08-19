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

// get site entity
$site = elgg_get_site_entity();	

// get the saved parameters
$params = phloor_custom_logo_prepare_vars($site);

// get site name
$site_name = htmlentities($site->name);
//get site url
$href = elgg_get_site_url();

$content = '';

// if any logo related variable is empty.. show just the site name
if (empty($params['logo']) || empty($params['time']) || empty($params['mime'])) {
	$content = <<<___HTML
<h1><a class="elgg-heading-site" href="{$href}">{$site_name}</a></h1>
___HTML;
} 
// otherwise if logo is set, show the logo
else {
	$logo_url = "{$vars['url']}logo/{$params['time']}.png";
	$site_name = htmlentities($site_name);

	$content = <<<___HTML
<div><a href="{$href}">
<img id="phloor-site-logo" class="phloor-custom-logo" src="{$logo_url}" alt="{$site_name}" />
</a></div>
___HTML;

}

echo $content;
