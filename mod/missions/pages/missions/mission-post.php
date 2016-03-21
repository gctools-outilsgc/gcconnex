<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page for posting missions.
 */

// This sends users who are not logged in back to the gcconnex login page
gatekeeper();

// Selects the last section of the current URI.
$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$last_segment = array_pop($exploded_uri);

$highlight_one = false;
$highlight_two = false;
$highlight_three = false;

$form_choice = '';
// The last segment of the url informs the form choice and the tab context.
switch($last_segment) {
	case 'step-two':
		if ($_SESSION['tab_context'] == 'firstpost') {
			$_SESSION['tab_context'] = 'secondpost';
		}
		$highlight_two = true;
		$form_choice = elgg_view_form('missions/post-mission-second-form', array('class' => 'form-horizontal'));
		break;
	case 'step-three':
		if ($_SESSION['tab_context'] == 'secondpost') {
			$_SESSION['tab_context'] = 'thirdpost';
		}
		$highlight_three = true;
		$form_choice = elgg_view_form('missions/post-mission-third-form', array('class' => 'form-horizontal'));
		break;
	default:
		if ($_SESSION['tab_context'] == '') {
			$_SESSION['tab_context'] = 'firstpost';
		}
		$highlight_one = true;
		$form_choice = elgg_view_form('missions/post-mission-first-form', array('class' => 'form-horizontal'));
}

// Decides which tabs are enabled and disabled.
$tab_two_is_disabled = '';
$tab_three_is_disabled = '';
switch($_SESSION['tab_context']) {
	case 'firstpost':
		$tab_two_is_disabled = 'link-disabled';
		$tab_three_is_disabled = 'link-disabled';
		break;
	case 'secondpost':
		$tab_three_is_disabled = 'link-disabled';
		break;
}

$navigation_tabs = array(
		array(
				'text' => elgg_echo('missions:step_one'),
				'href' => elgg_get_site_url() . 'missions/mission-post/step-one',
				'selected' => $highlight_one
		),
		array(
				'text' => elgg_echo('missions:step_two'),
				'href' => elgg_get_site_url() . 'missions/mission-post/step-two',
				'selected' => $highlight_two,
				'class' => $tab_two_is_disabled
		),
		array(
				'text' => elgg_echo('missions:step_three'),
				'href' => elgg_get_site_url() . 'missions/mission-post/step-three',
				'selected' => $highlight_three,
				'class' => $tab_three_is_disabled
		)
);

$title = elgg_echo('missions:create_opportunity');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);
$content .= elgg_view('navigation/tabs', array(
		'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default mission-tab',
		'tabs' => $navigation_tabs
));
$content .= $form_choice;

echo elgg_view_page($title, $content);