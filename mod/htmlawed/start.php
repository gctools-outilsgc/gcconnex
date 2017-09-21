<?php
/**
 * Elgg htmLawed tag filtering.
 *
 * http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/
 *
 * @package ElgghtmLawed
 */


elgg_register_event_handler('init', 'system', 'htmlawed_init');

/**
 * Initialize the htmlawed plugin
 */
function htmlawed_init() {
	elgg_register_plugin_hook_handler('validate', 'input', 'htmlawed_filter_tags', 1);

	$lib = elgg_get_plugins_path() . "htmlawed/vendors/htmLawed/htmLawed.php";
	elgg_register_library('htmlawed', $lib);
	
	elgg_register_plugin_hook_handler('unit_test', 'system', 'htmlawed_test');
}

/**
 * htmLawed filtering of data
 *
 * Called on the 'validate', 'input' plugin hook
 *
 * Triggers the 'config', 'htmlawed' plugin hook so that plugins can change
 * htmlawed's configuration. For information on configuraton options, see
 * http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s2.2
 *
 * @param string $hook   Hook name
 * @param string $type   The type of hook
 * @param mixed  $result Data to filter
 * @param array  $params Not used
 * @return mixed
 */
function htmlawed_filter_tags($hook, $type, $result, $params = null) {
	$var = $result;

	elgg_load_library('htmlawed');

	$htmlawed_config = array(
		// seems to handle about everything we need.
		'safe' => true,

		// remove comments/CDATA instead of converting to text
		'comment' => 1,
		'cdata' => 1,

		'deny_attribute' => 'on*',			// using a class whitelist configuration, most classes are still filtered
		'hook_tag' => 'htmlawed_tag_post_processor',

		'schemes' => '*:http,https,ftp,news,mailto,rtsp,teamspeak,gopher,mms,callto',
		// apparent this doesn't work.
		// 'style:color,cursor,text-align,font-size,font-weight,font-style,border,margin,padding,float'
	);

	// add nofollow to all links on output
	if (!elgg_in_context('input')) {
		$htmlawed_config['anti_link_spam'] = array('/./', '');
	}

	$htmlawed_config = elgg_trigger_plugin_hook('config', 'htmlawed', null, $htmlawed_config);

	if (!is_array($var)) {
		$result = htmLawed($var, $htmlawed_config);
	} else {
		array_walk_recursive($var, 'htmLawedArray', $htmlawed_config);
		$result = $var;
	}

	return $result;
}

/**
 * wrapper function for htmlawed for handling arrays
 */
function htmLawedArray(&$v, $k, $htmlawed_config) {
	$v = htmLawed($v, $htmlawed_config);
}


/*
 * GC_MODIFICATION
 * Description: Added a css class whitelist to replace the blanket ban on them
 * 		-> $allowed_classes variable - related lines
 * Author: Ilia Salem
 * Date: Apr 29 2016, Nov 29 2016
 * Pull request: #542  (for the classes added to whitelist)
 */

/**
 * Post processor for tags in htmlawed
 * 
 * This runs after htmlawed has filtered. It runs for each tag and filters out
 * style attributes we don't want.
 *
 * This function triggers the 'allowed_styles', 'htmlawed' plugin hook.
 *
 * @param string $element    The tag element name
 * @param array  $attributes An array of attributes
 * @return string
 */
function htmlawed_tag_post_processor($element, $attributes = false) {
    if ($attributes === false) {
        // This is a closing tag. Prevent further processing to avoid inserting a duplicate tag
        return "</${element}>";
    }

	// this list should be coordinated with the WYSIWYG editor used (tinymce, ckeditor, etc.)
	$allowed_styles = array(
		'color', 'cursor', 'text-align', 'vertical-align', 'font-size',
		'font-weight', 'font-style', 'border', 'border-top', 'background-color',
		'border-bottom', 'border-left', 'border-right',
		'margin', 'margin-top', 'margin-bottom', 'margin-left',
		'margin-right',	'padding', 'float', 'text-decoration'
	);

	$allowed_classes = array(
		'table', 'row', 'wb-tables', 'table-striped', 'table-hover', 'bordered', 'btn', 'btn-default', 'btn-primary', 'btn-danger', 'btn-info', 'btn-success', 'btn-warning', 'btn-lg', 'btn-sm', 'btn-xs'
	);

	$params = array('tag' => $element);
	$allowed_styles = elgg_trigger_plugin_hook('allowed_styles', 'htmlawed', $params, $allowed_styles);
	$allowed_classes = elgg_trigger_plugin_hook('allowed_classes', 'htmlawed', $params, $allowed_classes);

	// must return something.
	$string = '';

	foreach ($attributes as $attr => $value) {
		if ($attr == 'style') {
			$styles = explode(';', $value);

			$style_str = '';
			foreach ($styles as $style) {
				if (!trim($style)) {
					continue;
				}
				list($style_attr, $style_value) = explode(':', trim($style));
				$style_attr = trim($style_attr);
				$style_value = trim($style_value);

				if (in_array($style_attr, $allowed_styles)) {
					$style_str .= "$style_attr: $style_value; ";
				}
			}

			if ($style_str) {
				$style_str = trim($style_str);
				$string .= " style=\"$style_str\"";
			}

		}
		/*  GC_MODIFICATION - css class whitelist processing START */
		else if ($attr == 'class') {
			$classes = explode(' ', $value);

			$class_str = '';
			foreach ($classes as $class) {
				if (!trim($class)) {
					continue;
				}

				if (in_array($class, $allowed_classes)) {
					$class_str .= "$class ";
				}
			}

			if ($class_str) {
				$class_str = trim($class_str);
				$string .= " class=\"$class_str\"";
			}
		}/*  GC_MODIFICATION - css class whitelist processing END */
		else {
			$string .= " $attr=\"$value\"";
		}
	}

	// Some WYSIWYG editors do not like tags like <p > so only add a space if needed.
	if ($string = trim($string)) {
		$string = " $string";
	}

	$r = "<$element$string>";
	return $r;
}

/**
 * Runs unit tests for htmlawed
 *
 * @return array
 */
function htmlawed_test($hook, $type, $value, $params) {
    $value[] = dirname(__FILE__) . '/tests/tags.php';
    return $value;
}
