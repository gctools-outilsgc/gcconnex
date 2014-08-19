<?php
/*****************************************************************************
 * Phloor News                                                               *
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

$entity = elgg_extract('entity', $vars, NULL);

$theme = $entity->theme;

// LINK COLOR
$link_color = glee_get_link_color();
echo elgg_view('phloor/output/form-item', array(
	'name'        => 'params[link_color]',
	'view'        =>  'phloor/input/vendors/colorpicker/color',
	'value'       => $link_color,
    'description' => elgg_echo("glee:form:link_color:description"),
    'label'       => elgg_echo("glee:form:link_color:label"),
));

// LINK COLOR
$themes = glee_get_themes(); // [name => array(css_name, css_file)]

$options = array_keys($themes); // retrieve all theme names

$options_values = array();
foreach($options as $name) {
    $options_values[$name] = $name;
}

$theme_dropdown = elgg_view('input/dropdown', array(
	'name'    => 'params[theme]',
    'value'   => $theme,
    'options_values' => $options_values,
));

echo elgg_view('phloor/output/form-item', array(
	'input'       => $theme_dropdown,
	'name'        => 'params[theme]',
    'description' => elgg_echo("glee:form:theme:description"),
    'label'       => elgg_echo("glee:form:theme:label"),
));

