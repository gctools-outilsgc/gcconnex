<?php



/**
 * Checks if a view had been extended with specific view.
 *
 * @param string $view           The view that was extended.
 * @param string $view_extension This view that was added to $view
 *
 * @return bool
 * @since 1.8-12.01.15b
 */
function phloor_is_view_extended($view, $view_extension) {
	global $CONFIG;

	if (!isset($CONFIG->views)) {
		return FALSE;
	}

	if (!isset($CONFIG->views->extensions)) {
		return FALSE;
	}

	if (!isset($CONFIG->views->extensions[$view])) {
		return FALSE;
	}

	$priority = array_search($view_extension, $CONFIG->views->extensions[$view]);
	if ($priority === FALSE) {
		return FALSE;
	}

	return TRUE;
}


function phloor_views_boot() {
    global $CONFIG;

    /**
     * phloor JS
     */
    elgg_register_js('phloor-lib', 'mod/phloor/js/lib/phloorlib.js', 'head');
    elgg_load_js('phloor-lib');

    /**
     * External JS
     */
    $js_url = 'mod/phloor/vendors/';
    elgg_register_js('jquery-masonry',        $js_url.'masonry/jquery.masonry.min.js',               'head');
    elgg_register_js('jquery-infinitescroll', $js_url.'infinitescroll/jquery.infinitescroll.min.js', 'footer');
    elgg_register_js('jquery-qtip-js',        $js_url.'qtip2/jquery.qtip.min.js',                    'footer');
    elgg_register_js('jquery-colorpicker-js', $js_url.'colorpicker/js/colorpicker.js',               'footer');

    /**
     * External CSS
     */
    $css_url = 'mod/phloor/vendors/';
    elgg_register_css('jquery-qtip-css',              $css_url.'qtip2/jquery.qtip.min.css');
    elgg_register_css('jquery-fluid960gs-layout-css', $css_url.'fluid960gs/css/layout.css');
    elgg_register_css('jquery-colorpicker-css',       $css_url.'colorpicker/css/colorpicker.css');

    /**
     * CSS
     */
    elgg_extend_view('css/elgg', 'phloor/css/elgg');

    elgg_extend_view('css/elgg',  'phloor/css/elements/icons');
    elgg_extend_view('css/admin', 'phloor/css/elements/icons');

    /**
     * Extend views
     */
    // add meta data to head
    elgg_extend_view('page/elements/head', 'phloor/page/elements/head');


    // add options to default icon sizes config
    $icon_sizes = elgg_get_config('icon_sizes');
    $phloor_icon_sizes = array(
    //'pixel ' => array('w' => 1, 'h' => 1,   'square' => TRUE, 'upscale' => TRUE),
	//'teeny-weeny ' => array('w' => 8, 'h' => 8, 'square' => TRUE, 'upscale' => TRUE),
		'thumb '       => array('w' => 60, 'h' => 60, 'square' => TRUE, 'upscale' => TRUE),
    );
    elgg_set_config('icon_sizes', array_merge($phloor_icon_sizes, $icon_sizes));

}

//elgg_register_event_handler('init', 'system', 'phloor_views_boot', 2); <-- called in phloor_boot
