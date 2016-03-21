<?php

$endpoint = get_input('endpoint');

switch ($endpoint) {
	default :
	case 'pageshell' : // output an entire page without encoding its elements
		return false;
		break;

	case 'content' : // output only page content
		echo json_encode(array(
			'content' => $vars['content']
		));
		break;

	case 'layout' : // output encoded layout
		$vars['nav'] = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
		$vars['sidebar'] = elgg_view('page/elements/sidebar', $vars);
		$vars['sidebar_alt'] = elgg_view('page/elements/sidebar_alt', $vars);
		echo json_encode(elgg_clean_vars($vars));
		break;

	case 'list' : // output encoded contents of a specific list by its id
		global $XHR_GLOBAL;
		$list_id = get_input('list_id', false);
		if ($list_id) {
			$output['lists'][$list_id] = $XHR_GLOBAL['lists'][$list_id];
		}
		echo json_encode($output);
		break;

	case 'xhr_global' : // output encoded contents of a global xhr variable
		global $XHR_GLOBAL;
		echo json_encode($XHR_GLOBAL);
		break;
}