<?php
/**
 * Extended TinyMCE - a wysiwyg editor
 *
 */

elgg_register_event_handler('init', 'system', 'extended_tinymce_init');

function extended_tinymce_init() {
	elgg_extend_view('css/elgg', 'extended_tinymce/css');
	elgg_extend_view('css/admin', 'extended_tinymce/css');

	elgg_register_js('extended_tinymce', 'mod/extended_tinymce/vendor/tinymce/jscripts/tiny_mce/tiny_mce.js');
	elgg_register_js('elgg.extended_tinymce', elgg_get_simplecache_url('js', 'extended_tinymce'));
        elgg_register_simplecache_view('js/extended_tinymce');

	elgg_extend_view('input/longtext', 'extended_tinymce/init');

	elgg_extend_view('embed/custom_insert_js', 'extended_tinymce/embed_custom_insert_js');

	elgg_register_plugin_hook_handler('register', 'menu:longtext', 'extended_tinymce_longtext_menu');

        // extend allowed styles for tinymce editor as filtered by htmlawed
        elgg_register_plugin_hook_handler('allowed_styles', 'htmlawed', 'extended_tinymce_allowed_styles');
}

function extended_tinymce_longtext_menu($hook, $type, $items, $vars) {

	$items[] = ElggMenuItem::factory(array(
		'name' => 'extended_tinymce_toggler',
		'link_class' => 'extended_tinymce-toggle-editor elgg-longtext-control',
		'href' => "#{$vars['id']}",
		'text' => elgg_echo('extended_tinymce:remove'),
	));

	return $items;
}

function extended_tinymce_allowed_styles($hook, $type, $items, $vars) {

        $allowed_styles = array(
                'color', 'cursor', 'text-align', 'vertical-align', 'font-size', 'font-family',
                'font-weight', 'font-style', 'border', 'border-top', 'background-color',
                'border-bottom', 'border-left', 'border-right',
                'margin', 'margin-top', 'margin-bottom', 'margin-left',
                'margin-right', 'padding', 'float', 'text-decoration'
        );

        return $allowed_styles;
}

function extended_tinymce_get_site_language() {

        if ($site_language = elgg_get_config('language')) {
                $path = elgg_get_plugins_path() . "extended_tinymce/vendor/tinymce/jscripts/tiny_mce/langs";
                if (file_exists("$path/$site_language.js")) {
                        return $site_language;
                }
        }

        return 'en';
}
