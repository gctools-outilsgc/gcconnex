<?php

namespace Beck24\ReCaptcha;

/**
 * get the public key for recaptcha
 * 
 * @staticvar type $publickey
 * @return string
 */
function get_public_key() {
	static $publickey;
	if ($publickey) {
		return $publickey;
	}

	$publickey = elgg_get_plugin_setting('public_key', PLUGIN_ID);
	return $publickey;
}

/**
 * get the private key for recaptcha
 * 
 * @staticvar type $privatekey
 * @return string
 */
function get_private_key() {
	static $privatekey;
	if ($privatekey) {
		return $privatekey;
	}

	$privatekey = elgg_get_plugin_setting('private_key', PLUGIN_ID);
	return $privatekey;
}

/**
 * get the recaptcha theme
 * 
 * @staticvar type $recaptcha_theme
 * @return string
 */
function get_recaptcha_theme() {
	static $theme;
	if ($theme) {
		return $theme;
	}

	$theme = elgg_get_plugin_setting('theme', PLUGIN_ID);
	if (!in_array($theme, array('dark', 'light'))) {
		$theme = "light"; // set default	
	}

	return $theme;
}

/**
 * get the recaptcha size
 * 
 * @staticvar type $size
 * @return string
 */
function get_recaptcha_size() {
	static $size;
	if ($size) {
		return $size;
	}

	$size = elgg_get_plugin_setting('size', PLUGIN_ID);
	if (!in_array($size, array('normal', 'compact'))) {
		$size = "normal"; // set default	
	}

	return $size;
}

/**
 * get the recaptcha type
 * 
 * @staticvar type $type
 * @return string
 */
function get_recaptcha_type() {
	static $type;
	if ($type) {
		return $type;
	}

	$type = elgg_get_plugin_setting('recaptcha_type', PLUGIN_ID);
	if (!in_array($type, array('image', 'audio'))) {
		$type = "image"; // set default	
	}

	return $type;
}

/**
 * Validate a submitted recaptcha
 * 
 * @return boolean
 */
function validate_recaptcha() {
	require_once dirname(__DIR__) . '/vendor/autoload.php';

	$privatekey = get_private_key();
	$recaptcha = new \ReCaptcha\ReCaptcha($privatekey);
	$resp = $recaptcha->verify(get_input('g-recaptcha-response'), get_ip());
	
	return $resp->isSuccess();
}

/**
 * get the ip address
 * 
 * @return string
 */
function get_ip() {
	if (getenv('HTTP_CLIENT_IP')) {
		$ip_address = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip_address = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_X_FORWARDED')) {
		$ip_address = getenv('HTTP_X_FORWARDED');
	} elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ip_address = getenv('HTTP_FORWARDED_FOR');
	} elseif (getenv('HTTP_FORWARDED')) {
		$ip_address = getenv('HTTP_FORWARDED');
	} else {
		$ip_address = $_SERVER['REMOTE_ADDR'];
	}

	return $ip_address;
}

/**
 * return an array of action names to protect
 * 
 * @return array
 */
function get_recaptcha_actions() {
	static $actions;
	if (is_array($actions)) {
		return $actions;
	}
	
	$list = elgg_get_plugin_setting('recaptcha_actions', PLUGIN_ID);
	if (!$list) {
		$actions = array();
	}
	else {
		$actions = explode(',', $list);
	}
	
	$actions = elgg_trigger_plugin_hook('recaptcha', 'actions', $actions, $actions);
	return $actions;
}