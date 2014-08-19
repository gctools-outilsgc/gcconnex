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

/**
 * Default attributes
 * 
 * @return array with default values
 */
function phloor_custom_logo_default_vars() {
	$defaults = array(
		'logo'   => '',
		'mime'   => '',
	    'time' => time(),
	    'delete' => 'no',
	);
	
	return $defaults;
}

/**
 * Load vars from post or get requests and returns them as array
 * 
 * @return array with values from the request
 */
function phloor_custom_logo_get_input_vars() {
	$input_var_prefix = 'phloor_custom_logo_';
	
	// get default values
	$defaults = phloor_custom_logo_default_vars();
	
	$params = array();
	foreach($defaults as $key => $default_value) {
		$var_name = $input_var_prefix . $key;
		
		if($key == 'logo') {
			// read logo from files
			$params['logo'] = $_FILES[$var_name];
		}
		else {
			$params[$key] = get_input($var_name, $default_value);
		}
	}
	
	return $params;
}

/**
 * Load vars from given site into and returns them as array
 * 
 * @return array with stored values
 */
function phloor_custom_logo_prepare_vars(ElggSite $site) {
	// get default values
	$defaults = phloor_custom_logo_default_vars();

	$params = array();
	// decode settings if existing
	if(isset($site->phloor_custom_logo_settings)) {
		$params = json_decode($site->phloor_custom_logo_settings, true);
	}
	// merge default with given params
	$vars = array_merge($defaults,  $params);
	
	return $vars;
}

/**
 * Load vars from given site into and returns them as array
 * 
 * @return array with stored values
 */
function phloor_custom_logo_save_vars($site, $params = array()) {	
	// get default values
	$defaults = phloor_custom_logo_default_vars();
	// merge with params	
	$vars = array_merge($defaults, $params);
	// check variables
	if(!phloor_custom_logo_check_vars($vars)) {
		return false;
	}
	
	// store as an  json encoded attribute of the site entity
	$site->phloor_custom_logo_settings = json_encode($vars);
	
	// save site and return status
	return $site->save();
}

function phloor_custom_logo_check_vars(&$params) {
	if ($params['delete'] == 'yes') {
		$params['logo'] = '';
	}
	unset($params['delete']);
		
	$logo_dir = elgg_get_data_path() . 'logo';
	// create data directory if not exists
	if (!file_exists($logo_dir)) {
		if(!mkdir($logo_dir)) {
			register_error(elgg_echo('phloor_custom_logo:couldnotcreatelogodir'));
			return false;
		}
		
		system_message(elgg_echo('phloor_custom_logo:logodircreated'));
	}
	
	if (isset($params['logo']) && !empty($params['logo']) && $params['logo']['error'] != 4) {
		$mime = array(	
			'image/gif'   => 'gif',
			'image/jpg'   => 'jpeg',
			'image/jpeg'  => 'jpeg',
			'image/pjpeg' => 'jpeg',
			'image/png'   => 'png',
		);  
		
		if (!array_key_exists($params['logo']['type'], $mime)) {
			register_error(elgg_echo('phloor_custom_logo:logo_mime_type_not_supported', array(
				$params['logo']['type'],
			)));
			return false;
		}
		if ($params['logo']['error'] != 0) {
			register_error(elgg_echo('phloor_custom_logo:upload_error', array(
				$params['logo']['error'],
			)));
			return false;
		}
		
		$tmp_filename = $params['logo']['tmp_name'];
		$params['mime'] = $params['logo']['type'];
		$params['logo'] = 'logo.' . $mime[$params['mime']];
		
		// move the file to the data directory
		$move = move_uploaded_file($tmp_filename, $logo_dir . '/' . $params['logo']);
		// report errors if that did not succeed
		if(!$move) {
			register_error(elgg_echo('phloor_custom_logo:coultnotmoveuploadedfile'));
			return false;
		}
	}
	
	return true;
}

