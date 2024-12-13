<?php
/**
 * Wrapper for site pages content area
 *
 * @uses $vars['content']
 */

// before page load, check to see which language 
?>

<script>

var cookie_language = document.cookie;
var cookie_var = cookie_language.split(';');
var selected_language = '';

for (var i = 0; i < cookie_var.length; i++) {
	var cookie_variable = (cookie_var[i]).replace(/ /g, "")
	var curr_lang = cookie_variable.split('=');

	if (curr_lang[0] == 'lang')
		selected_language = curr_lang[1];
}

/* terms, faq, privacy, about
 * termes, qfp, confidentialite, a_propos
 */

var en_list = ["decomm-en"];
var fr_list = ["decomm-fr"];
var pathname = (window.location.pathname).replace(/\//g, "");

// if english is selected
if (selected_language == 'en') {
	if (en_list.indexOf(pathname) < 0 && fr_list.indexOf(pathname) > -1) {
		var fr_index = fr_list.indexOf(pathname);
		var site_root = elgg.config.wwwroot;
		window.location.href = site_root + en_list[fr_index];
	}

// if french is selected
} else if (selected_language == 'fr') {
	if (fr_list.indexOf(pathname) < 0 && en_list.indexOf(pathname) > -1) {
		var en_index = en_list.indexOf(pathname);
		var site_root = elgg.config.wwwroot;
		window.location.href = site_root + fr_list[en_index];
	}

// if undefined, default to english
} else {
	if (en_list.indexOf(pathname) < 0 && fr_list.indexOf(pathname) > -1) {
		var fr_index = fr_list.indexOf(pathname);
		var site_root = elgg.config.wwwroot;
		window.location.href = site_root + en_list[fr_index];
	}
}
</script>

<?php

echo $vars['content'];

echo '<div class="mtm">';
echo elgg_view('output/url', array(
	'text' => elgg_echo('back'),
	'href' => $_SERVER['HTTP_REFERER'],
	'class' => 'float-alt'
));
echo '</div>';