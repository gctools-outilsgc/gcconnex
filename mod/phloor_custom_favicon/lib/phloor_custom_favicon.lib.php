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
?>
<?php

/**
 * Default attributes
 *
 * @return array with default values
 */
function phloor_custom_favicon_default_vars() {
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
function phloor_custom_favicon_get_input_vars() {
	$defaults = phloor_custom_favicon_default_vars();

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
function phloor_custom_favicon_save_vars($favicon, $params = array()) {
	// get default values
	$defaults = phloor_custom_favicon_default_vars();

	// merge with params
	$vars = array_merge($defaults, $params);

    // check for the image
    if(!phloor_elgg_image_check_vars($favicon, $vars)) {
        return false;
    }

    // check variables
    if(!phloor_custom_favicon_check_vars($favicon, $vars)) {
        return false;
    }

    // adopt variables
    foreach($vars as $key => $value) {
        $favicon->$key = $value;
    }

	// save site and return status
	return $favicon->save();
}

function phloor_custom_favicon_check_vars($favicon, &$params) {

	return true;
}

function phloor_custom_favicon_public_pages($hook, $handler, $return, $params) {
	$pages = array('favicon', 'favicon/favicon.ico');
	return array_merge($pages, $return);
}


function phloor_custom_favicon_instanceof($favicon) {
    return elgg_instanceof($favicon, 'object', 'phloor_favicon', 'PhloorFavicon');
}

function phloor_custom_favicon_favicon_exists() {
    $entities = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'phloor_favicon',
        'offset' => 0,
        'limit' => 1,
    ));

    if(count($entities) != 1) {
        return false;
    }

    $favicon = $entities[0];

    if(!phloor_custom_favicon_instanceof($favicon)) {
        return false;
    }

    return true;
}

function phloor_custom_favicon_get_favicon() {
    if(!phloor_custom_favicon_favicon_exists()) {
        return null;
    }

    $entities = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'phloor_favicon',
        'offset' => 0,
        'limit' => 1,
    ));

    return $entities[0];
}

function phloor_custom_favicon_favicon_has_image() {
    if(!phloor_custom_favicon_favicon_exists()) {
        return false;
    }

    $favicon = phloor_custom_favicon_get_favicon();

    return $favicon->hasImage();
}

