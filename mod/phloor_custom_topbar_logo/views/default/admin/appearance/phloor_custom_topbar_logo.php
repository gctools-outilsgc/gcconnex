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

// only admins are allowed to see the page
admin_gatekeeper();

$site_url = elgg_get_site_url();
$time     = time();

$title = elgg_view_title(elgg_echo('phloor_custom_topbar_logo:title'));
$description = elgg_echo('phloor_custom_topbar_logo:description');
$form = elgg_view('input/form',array(
	'action' => "{$site_url}action/phloor_custom_topbar_logo/save",
	'body' => elgg_view('forms/phloor_custom_topbar_logo/save', array()),
	'method' => 'post',
	'enctype' => 'multipart/form-data',
));

$image = "";
// if topbar_logo is set -> display it!
if (phloor_custom_topbar_logo_topbar_logo_has_image()) {
	$image = <<<___HTML
<img class="phloor-custom-topbar-logo" src="{$site_url}topbarlogo/$time" alt="Topbar Logo" />
___HTML;
}

echo <<<___HTML
{$title}
<p>{$description}</p>
$image
<div id="phloor-custom-topbar-logo-form">
{$form}
</div>
___HTML;
