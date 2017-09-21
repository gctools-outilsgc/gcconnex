<?php

namespace Beck24\ReCaptcha;

/**
 * input/recaptcha
 *
 * render a recaptcha challenge
 *
 * @uses $vars['theme'] Optional the theme to render: light | dark
 * @uses $vars['size']	Optional size of the captcha: compact | normal
 * @uses $vars['type']  Optional the type of recaptcha: image | audio
 * @uses $vars['form']  Optional the jquery selector for a form
 */

elgg_require_js('elgg_recaptcha/render');

if (elgg_is_xhr()) {
// allow getting the script if the form is loaded by ajax
	$require = <<<REQUIRE
<script>
require(['elgg_recaptcha/render']);
</script>
REQUIRE;
	
echo $require;
}

$key = get_public_key();
$options = array(
	'class' => 'g-recaptcha',
	'data-sitekey' => $key,
	'data-theme' => get_recaptcha_theme(),
	'data-size' => get_recaptcha_size(),
	'data-type' => get_recaptcha_type()
);

if ($vars['theme']) {
	$options['data-theme'] = $vars['theme'];
}

if ($vars['size']) {
	$options['data-size'] = $vars['size'];
}

if ($vars['type']) {
	$options['data-type'] = $vars['type'];
}

if ($vars['form']) {
	$options['data-form'] = $vars['form'];
}

$attributes = elgg_format_attributes($options);

$nojs = <<<NOJS
<div style="width: 302px; height: 482px;" class="g-recaptcha g-recaptcha-nojs" data-form="{$vars['form']}">
    <div style="width: 302px; height: 422px; position: relative;">
		<div style="width: 302px; height: 422px; position: absolute;">
			<iframe src="https://www.google.com/recaptcha/api/fallback?k={$key}"
					frameborder="0" scrolling="no"
					style="width: 302px; height:422px; border-style: none;">
			</iframe>
		</div>
	</div>
	<div style="width: 300px; height: 60px; border-style: none;
		 bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
		 background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
        <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                  class="g-recaptcha-response"
                  style="width: 250px; height: 40px; border: 1px solid #c1c1c1;
				  margin: 10px 25px; padding: 0px; resize: none;" >
        </textarea>
	</div>
</div>
NOJS;

$use_js = "<div class=\"g-recaptcha-wrapper\"><div {$attributes}></div><noscript>{$nojs}</noscript></div>";

$nojs = "<div class=\"g-recaptcha-wrapper\">{$nojs}</div>";

$browser = get_browser(false);
$platform = get_platform(false);

if (elgg_get_plugin_setting($platform . '_' . $browser, PLUGIN_ID)) {
	echo $nojs;
	return;
}

echo $use_js;