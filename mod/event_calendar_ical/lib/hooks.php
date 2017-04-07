<?php

/**
 * set some inputs to generate ical links
 * and reroute some things on event_calendar pagehandler
 */
function ec_ical_event_calendar_router($hook, $type, $return, $params) {
  set_input('ical_calendar_title_menu', true);
  
  switch($return['segments'][0]) {
	case 'list':
	  if ($return['segments'][3] == 'mine') {
		set_input('ical_calendar_filter', 'mine');
	  }
	  elseif ($return['segments'][3] == 'friends') {
		set_input('ical_calendar_filter', 'friends');
	  }
	  else {
		set_input('ical_calendar_filter', 'all');
	  }
	  set_input('ical_date', $return['segments'][1]);
	  set_input('ical_interval', $return['segments'][2]);
	  set_input('ical_region', $return['segments'][4]);
	  break;
	  
	case 'group':
		if ($return['segments'][4] == 'mine') {
		  set_input('ical_calendar_filter', 'mine');
		}
		elseif ($return['segments'][4] == 'friends') {
		  set_input('ical_calendar_filter', 'friends');
		}
		else {
		  set_input('ical_calendar_type', 'all');
		}
		set_input('ical_date', $return['segments'][2]);
		set_input('ical_interval', $return['segments'][3]);
		set_input('ical_group_guid', $return['segments'][1]);
		set_input('ical_region', $return['segments'][5]);
	  break;
	  
	case 'ical':
		elgg_load_library('elgg:event_calendar');
	  
		set_input('action_type', $return['segments'][1]);
	  
		if (include(elgg_get_plugins_path() . 'event_calendar_ical/pages/export.php')) {
			return true;
		}
		  
	  break;
  }
}

function ec_ical_entity_menu($hook, $type, $return, $params) {
  if (elgg_instanceof($params['entity'], 'object', 'event_calendar')) {
	$url = elgg_get_site_url() . 'action/event_calendar_ical/export?filter=' . $params['entity']->getGUID();
	
	$item = new ElggMenuItem(
			'ical_export',
			elgg_view('output/img', array('src' => elgg_get_site_url() . 'mod/event_calendar/images/ics.png')),
			elgg_add_action_tokens_to_url($url)
			);
	$item->setPriority(1000);
	
	$return[] = $item;
	return $return;
  }
}

/**
 * replace ical extras link with our own
 */
function ec_ical_extras_menu($hook, $type, $return, $params) {
  if (!empty($return)) {
	foreach ($return as $key => $item) {
	  if ($item->getName() == 'ical') {
		$filter = get_input('ical_calendar_filter', false);
		$date = get_input('ical_date', false);
		$interval = get_input('ical_interval', false);
		$group_guid = get_input('ical_group_guid', false);
		
		// it's our link, lets modify it
		$text = elgg_view('output/img', array('src' => 'mod/event_calendar/images/ics.png'));
		$url = elgg_get_site_url() . 'event_calendar/ical/export?method=ical';
		
		if ($filter) {
		  $url .= "&filter={$filter}";
		}
		
		if ($date) {
		  $url .= "&date={$date}";
		}
		
		if ($interval) {
		  $url .= "&interval={$interval}";
		}
		
		if ($group_guid !== false) {
		  $url .= "&group_guid={$group_guid}";
		}
		
		$ical = new ElggMenuItem('ical', $text, $url);
		$ical->setTooltip(elgg_echo('event_calendar_ical:tooltip'));
		$ical->setPriority($item->getPriority());
		
		// replace original with our own
		$return[$key] = $ical;
	  }
	}
  }
  return $return;
}