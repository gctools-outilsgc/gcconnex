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

// only admins are allowed to see the page
admin_gatekeeper();

// get site entity
$site = elgg_get_site_entity();

// get site name
$site_name = htmlentities($site->name);

// prepare variables
$params = phloor_custom_logo_prepare_vars($site);

$title = elgg_view_title(elgg_echo('phloor_custom_logo:title')); 
$description = elgg_echo('phloor_custom_logo:description'); 
$form = elgg_view('input/form',array(	
	'action' => $vars['url'] . 'action/phloor_custom_logo/save',
	'body' => elgg_view('forms/phloor_custom_logo/save', array(
		'logo' => $params['logo'],
	)),
	'method' => 'post',
	'enctype' => 'multipart/form-data',

));

$img = '';	
if (!empty($params['logo'])) {
	$logo_ext = array_pop(explode('/', $params['mime']));
	$logo_url = "{$vars['url']}logo/{$params['time']}.$logo_ext";	
	$img = <<<___HTML
<img class="phloor_custom_logo" src="{$logo_url}" alt="{$site_name}" />
___HTML;
}

echo <<<___HTML
{$title}
<p>{$description}</p>
<p>{$img}</p>
<div id="phloor-custom-logo-form">
{$form}
</div>
___HTML;

?>