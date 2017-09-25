<?php

return array(
	'elgg_recaptcha:message:fail' => "Invalid reCaptcha validation",
	
	// settings
	'elgg_recaptcha:setting:public_key' => "Site key",
	'elgg_recaptcha:setting:public_key:help' => "Register for your keys here: %s",
	'elgg_recaptcha:setting:private_key' => "Secret key",
	'elgg_recaptcha:setting:private_key:help' => "Register for your keys here: %s",
	'elgg_recaptcha:setting:theme' => "Theme",
	'elgg_recaptcha:theme:option:light' => "Light",
	'elgg_recaptcha:theme:option:dark' => "Dark",
	'elgg_recaptcha:setting:size' => "Size",
	'elgg_recaptcha:size:option:normal' => "Normal",
	'elgg_recaptcha:size:option:compact' => "Compact",
	'elgg_recaptcha:setting:recaptcha_type' => "Type",
	'elgg_recaptcha:recaptcha_type:option:image' => "Image",
	'elgg_recaptcha:recaptcha_type:option:audio' => "Audio",
	'elgg_recaptcha:setting:recaptcha_actions' => "Protected Actions",
	'elgg_recaptcha:setting:recaptcha_actions:help' => "Check the box to protect an action with recaptcha. Note that this only works for form/action pairs that follow the elgg naming pattern (eg. register).  Some actions do not have forms, protecting an action that has no associated form will make that action unusable.",
	
	'elgg_recaptcha:settings:title:nojs' => "Disable JS Rendering",
	'elgg_recaptcha:settings:nojs:help' => "While recaptcha works most of the time on most browsers it appears to have trouble in some (mobile Firefox for example).  If you experience issues on a specific platform/browser check the box that corresponds to it to use a more compatible (though slightly less user friendly) version of the recaptcha.  Your current platform is <strong>%s</strong> and your current browser is <strong>%s</strong>",
);
