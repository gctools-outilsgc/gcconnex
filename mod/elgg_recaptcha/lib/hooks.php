<?php

namespace Beck24\ReCaptcha;

function view_hook($h, $t, $r, $p) {
	if (elgg_get_viewtype() != 'default') {
		return $r;
	}
	
	if (strpos($t, 'forms/') !== 0) {
		return $r;
	}
	
	$actions = get_recaptcha_actions();
	
	$formname = substr($t, 6);
	
	if (in_array($formname, $actions)) {
		$r .= elgg_view('input/recaptcha', array(
			'form' => '.elgg-form-' . str_replace('_', '-', str_replace('/', '-', $formname))
		));
	}
	
	return $r;
}


function action_hook($h, $t, $r, $p) {
	$actions = get_recaptcha_actions();
	
	if (is_array($actions) && in_array($t, $actions)) {
		if (!validate_recaptcha()) {
			elgg_make_sticky_form($t);
			register_error(elgg_echo('elgg_recaptcha:message:fail'));
			
			// workaround for https://github.com/Elgg/Elgg/issues/8960
			elgg_unregister_plugin_hook_handler('forward', 'system', 'uservalidationbyemail_after_registration_url');
			forward(REFERER);
		}
	}
}