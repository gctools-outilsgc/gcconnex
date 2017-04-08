<?php
	/***
	 * event_calendar_ical - ical import/export for event_calendar in Elgg
	 * Heavily based on the 1.7 plugin by Julien Crestin
	 * http://community.elgg.org/plugins/796431/0.5/ical-importexport-events
	 * 
	***/

 require_once 'lib/hooks.php';

function ec_ical_init() {
  // Register Libraries
  elgg_register_library('event_calendar_ical:utilities', elgg_get_plugins_path() . 'event_calendar_ical/vendors/iCalUtilityFunctions.class.php');
  //Old vendor reference 
  elgg_register_library('event_calendar_ical:creator', elgg_get_plugins_path() . 'event_calendar_ical/vendors/iCalcreator.class.php');
  //elgg_register_library('event_calendar_ical:creator', elgg_get_plugins_path() . 'event_calendar_ical/vendors/icc/iCalcreator.php');

  
  // Register actions
  elgg_register_action("event_calendar_ical/import", elgg_get_plugins_path() . "event_calendar_ical/actions/event_calendar_ical/import.php");
  elgg_register_action('event_calendar_ical/export', elgg_get_plugins_path() . "event_calendar_ical/actions/event_calendar_ical/export.php");
  
  //elgg_register_plugin_hook_handler('register', 'menu:extras', 'ec_ical_extras_menu');
  elgg_register_plugin_hook_handler('register', 'menu:entity', 'ec_ical_entity_menu');
  elgg_register_plugin_hook_handler('route', 'event_calendar', 'ec_ical_event_calendar_router');
  
  elgg_register_event_handler('pagesetup', 'system', 'ec_ical_pagesetup');
}


function ec_ical_pagesetup() {
  $use_titlemenu = get_input('ical_calendar_title_menu', false);
  if ($use_titlemenu) {
	$filter = get_input('ical_calendar_filter', false);
	$date = get_input('ical_date', false);
	$interval = get_input('ical_interval', false);
	$group_guid = get_input('ical_group_guid', false);
		
	$export_url = elgg_get_site_url() . 'event_calendar/ical/export?method=ical';
	$import_url = elgg_get_site_url() . 'event_calendar/ical/import?method=ical';
	$urlsuffix = '';	
	
	if ($filter) {
	  $urlsuffix .= "&filter={$filter}";
	}
		
	if ($date) {
	  $urlsuffix .= "&date={$date}";
	}
		
	if ($interval) {
	  $urlsuffix .= "&interval={$interval}";
	}
		
	if ($group_guid !== false) {
	  $urlsuffix .= "&group_guid={$group_guid}";
	}
		
	$export = new ElggMenuItem('ical_export', elgg_echo('event_calendar_ical:export'), $export_url . $urlsuffix);
	$export->setLinkClass('elgg-button elgg-button-action');
	
	$import = new ElggMenuItem('ical_import', elgg_echo('event_calendar_ical:import'), $import_url . $urlsuffix);
	$import->setLinkClass('elgg-button elgg-button-action');
	
	elgg_register_menu_item('title', $export);
	elgg_register_menu_item('title', $import);
  }
}

register_elgg_event_handler('init','system','ec_ical_init');
