<?php
/*****************************************************************************
 * Phloor Topbar Logo                                                        *
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

/**
 * Default attributes
 *
 * @return array with default values
 */
function phloor_custom_topbar_logo_default_vars() {
	$defaults = array(
		'image'   => '',
		'mime'   => '',
	    'time' => time(),
	    'delete_image' => 'false',
	    'access_id' => ACCESS_PUBLIC,
	);

	return $defaults;
}

/**
 * Load vars from post or get requests and returns them as array
 *
 * @return array with values from the request
 */
function phloor_custom_topbar_logo_get_input_vars() {
	$defaults = phloor_custom_topbar_logo_default_vars();

	$params = array();
	foreach($defaults as $key => $default_value) {
		if(strcmp('image', $key) == 0) {
			$params['image'] = $_FILES['image'];
		}
		else {
			$params[$key] = get_input($key, $default_value);
		}
	}

	return $params;
}

/**
 * Load vars from given site into and returns them as array
 *
 * @return array with stored values
 */
function phloor_custom_topbar_logo_save_vars($topbar_logo, $params = array()) {
	// get default values
	$defaults = phloor_custom_topbar_logo_default_vars();

	// merge with params
	$vars = array_merge($defaults, $params);

    // check for the image
    if(!phloor_elgg_image_check_vars($topbar_logo, $vars)) {
        return false;
    }

    // check variables
    if(!phloor_custom_topbar_logo_check_vars($topbar_logo, $vars)) {
        return false;
    }

    // adopt variables
    foreach($vars as $key => $value) {
        $topbar_logo->$key = $value;
    }

	// save site and return status
	return $topbar_logo->save();
}

function phloor_custom_topbar_logo_check_vars($topbar_logo, &$params) {

	return true;
}

function phloor_custom_topbar_logo_public_pages($hook, $handler, $return, $params) {
	$pages = array('topbarlogo', 'topbarlogo/logo.png');
	return array_merge($pages, $return);
}


function phloor_custom_topbar_logo_instanceof($topbar_logo) {
    return elgg_instanceof($topbar_logo, 'object', 'phloor_topbar_logo', 'PhloorTopbarLogo');
}

function phloor_custom_topbar_logo_topbar_logo_exists() {
    $entities = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'phloor_topbar_logo',
        'offset' => 0,
        'limit' => 1,
    ));

    if(count($entities) != 1) {
        return false;
    }

    $topbar_logo = $entities[0];

    if(!phloor_custom_topbar_logo_instanceof($topbar_logo)) {
        return false;
    }

    return true;
}

function phloor_custom_topbar_logo_get_topbar_logo() {
    if(!phloor_custom_topbar_logo_topbar_logo_exists()) {
        return null;
    }

    $entities = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'phloor_topbar_logo',
        'offset' => 0,
        'limit' => 1,
    ));

    return $entities[0];
}

function phloor_custom_topbar_logo_topbar_logo_has_image() {
    if(!phloor_custom_topbar_logo_topbar_logo_exists()) {
        return false;
    }

    $topbar_logo = phloor_custom_topbar_logo_get_topbar_logo();

    return $topbar_logo->hasImage();
}

