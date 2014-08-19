<?php 
/*****************************************************************************
 * Phloor Logo Manager                                                       *
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

// Elgg
$enable_powered_by_elgg  = $vars['entity']->enable_powered_by_elgg;
$enable_elgg_topbar_logo = $vars['entity']->enable_elgg_topbar_logo;


if (strcmp('true', $enable_powered_by_elgg) != 0) {
	$enable_powered_by_elgg = 'false';
}
if (strcmp('true', $enable_elgg_topbar_logo) != 0) {
	$enable_elgg_topbar_logo = 'false';
}

// phloor
$enable_powered_by_phloor = $vars['entity']->enable_powered_by_phloor;
$enable_phloor_topbar_logo = $vars['entity']->enable_phloor_topbar_logo;

if (strcmp('true', $enable_powered_by_phloor) != 0) {
	$enable_powered_by_phloor = 'false';
}
if (strcmp('true', $enable_phloor_topbar_logo) != 0) {
	$enable_phloor_topbar_logo = 'false';
}

?>
<?php 

/**********************
 * ELGG               *
 **********************/
echo elgg_view_title(elgg_echo('phloor_logo_manager:settings:elgg:title'));

$elgg_topbar_logo_url = elgg_get_site_url() . "_graphics/elgg_toolbar_logo.gif";
$elgg_topbar_logo = "<img src=\"{$elgg_topbar_logo_url}\" />";

$elgg_powered_url = elgg_get_site_url() . "_graphics/powered_by_elgg_badge_drk_bckgnd.gif";
$elgg_powered_banner = "<img src=\"{$elgg_powered_url}\" alt=\"Powered by Elgg\" width=\"106\" height=\"15\" />";

// hide phloor/elgg release and version metadata
echo elgg_view('phloor/input/vendors/prettycheckboxes/checklist', array(
	'options' => array(
    	'enable_elgg_topbar_logo'  => array(
        	'name'  => 'params[enable_elgg_topbar_logo]',
        	'value' => $enable_elgg_topbar_logo,
            'label' => elgg_echo('phloor_logo_manager:enable_elgg_topbar_logo'),
            'image' => $elgg_topbar_logo,
        ),
    	'enable_powered_by_elgg' => array(
        	'name'  => 'params[enable_powered_by_elgg]',
        	'value' => $enable_powered_by_elgg,
            'label' => elgg_echo('phloor_logo_manager:enable_powered_by_elgg'),
            'image' => $elgg_powered_banner,
        ),
    ),
));


/**********************
 * Phloor             *
 **********************/
echo elgg_view_title(elgg_echo('phloor_logo_manager:settings:phloor:title'));

$phloor_topbar_logo_url = elgg_get_site_url() . "mod/phloor/graphics/phloor_topbar_logo.gif";
$phloor_topbar_logo = "<img src=\"{$phloor_topbar_logo_url}\" />";

$phloor_powered_url = elgg_get_site_url() . "mod/phloor/graphics/powered_by_phloor_badge_bckgnd.gif";
$phloor_powered_banner = "<img src=\"{$phloor_powered_url}\" alt=\"powered by phloor\" width=\"106\" height=\"15\" />";

// hide phloor/elgg release and version metadata
echo elgg_view('phloor/input/vendors/prettycheckboxes/checklist', array(
	'options' => array(
    	'enable_elgg_topbar_logo'  => array(
        	'name'  => 'params[enable_phloor_topbar_logo]',
        	'value' => $enable_phloor_topbar_logo,
            'label' => elgg_echo('phloor_logo_manager:enable_phloor_topbar_logo'),
            'image' => $phloor_topbar_logo,
        ),
    	'enable_powered_by_phloor' => array(
        	'name'  => 'params[enable_powered_by_phloor]',
        	'value' => $enable_powered_by_phloor,
            'label' => elgg_echo('phloor_logo_manager:enable_powered_by_phloor'),
            'image' => $phloor_powered_banner,
        ),
    ),
));

