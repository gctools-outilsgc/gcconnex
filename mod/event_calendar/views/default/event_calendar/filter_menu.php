<?php

// generate a list of filter tabs

$filter_context = $vars['filter'];
$url_start = "event_calendar/list/{$vars['start_date']}/{$vars['mode']}";

$tabs = array(
	'all' => array(
		'text' => elgg_echo('event_calendar:show_all'),
		'href' => "$url_start/all",
		'selected' => ($filter_context == 'all'),
		'priority' => 100,
	),
);

if (elgg_is_logged_in()) {
	$tabs ['mine'] = array(
		'text' => elgg_echo('event_calendar:show_mine'),
		'href' => "$url_start/mine",
		'selected' => ($filter_context == 'mine'),
		'priority' => 200,
	);
	$tabs['friend'] = array(
		'text' => elgg_echo('friends:filterby'),
		'href' =>  "$url_start/friends",
		'selected' => ($filter_context == 'friends'),
		'priority' => 300,
	);
}

$tab_rendered = array();

$event_calendar_spots_display = elgg_get_plugin_setting('spots_display', 'event_calendar');
if ($event_calendar_spots_display == "yes") {
	$tabs['open'] = array(
		'text' => elgg_echo('event_calendar:show_open'),
		'href' => "$url_start/open",
		'selected' => ($filter_context == 'open'),
		'priority' => 400,
	);
} else {
	$tab_rendered['open'] = '';
}

foreach ($tabs as $name => $tab) {
	if ($tab['selected']) {
		$state_selected = ' class="elgg-state-selected"';
	} else {
		$state_selected = '';
	}
	$tab_rendered[$name] = '<li'.$state_selected.'><a href="'.elgg_normalize_url($tab['href']).'">'.$tab['text'].'</a></li>';
}

$menu 	= <<<__MENU
<ul class="elgg-menu elgg-menu-filter elgg-menu-hz elgg-menu-filter-default">
	{$tab_rendered['all']}
	{$tab_rendered['mine']}
	{$tab_rendered['friend']}
	{$tab_rendered['open']}
</ul>
__MENU;

echo $menu;

$event_calendar_region_display = elgg_get_plugin_setting('region_display', 'event_calendar');
if ($event_calendar_region_display == 'yes') {
	elgg_load_js("elgg.event_calendar");
	$url_start .= "/$filter_context";
	echo elgg_view('event_calendar/region_select', array('url_start' => $url_start, 'region' => $vars['region']));
}
