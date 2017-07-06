<?php 
	
/**
 * Community page widgets
 */

 	$widget = $vars['entity'];
	$object_type = 'event_calendar';

	$widget->title = ( get_current_language() == "fr" ) ? $widget->widget_title_fr : $widget->widget_title_en;
	
	require_once($CONFIG->pluginspath.'event_calendar/models/model.php');

	if( !function_exists('getLastDayOfMonth') ){
		function getLastDayOfMonth($month, $year) {
			return idate('d', mktime(0, 0, 0, ($month + 1), 0, $year));
		}
	}

	$num_items = $widget->num_items;
	if( !isset($num_items) ) $num_items = 10;

	$widget_groups = $widget->widget_groups;
	if( !isset($widget_groups) ) $widget_groups = 0;
	    
	$mode = $widget->mode;
	if( !isset($mode) ) $mode = "month";

	$site_categories = elgg_get_site_entity()->categories;
	$widget_categories = $widget->widget_categories;
	$widget_context_mode = $widget->widget_context_mode;
	if( !isset($widget_context_mode) ) $widget_context_mode = 'search';

	elgg_set_context($widget_context_mode);

	$original_start_date = date('Y-m-d');
	$day = 60*60*24;
	$week = 7*$day;
	$month = 31*$day;

	if( $mode == "day" ){
		$start_date = $original_start_date;
		$end_date = $start_date;
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date)+$day-1;
	} else if( $mode == "week" ){
		$start_ts = strtotime($original_start_date);
		$start_ts -= date("w", $start_ts)*$day;
		$end_ts = $start_ts + 6*$day;
		
		$start_date = date('Y-m-d', $start_ts);
		$end_date = date('Y-m-d', $end_ts);
	} else if( $mode == "month" ){
		$start_ts = strtotime($original_start_date);
		$month = date('m', $start_ts);
		$year = date('Y', $start_ts);
		$start_date = $year.'-'.$month.'-1';
		$end_date = $year.'-'.$month.'-'.getLastDayOfMonth($month, $year);
	} else {
		$start_date = $original_start_date;
	}

	if ($event_calendar_first_date && ($start_date < $event_calendar_first_date)) {
		$start_date = $event_calendar_first_date;
	}

	if ($event_calendar_last_date && ($end_date > $event_calendar_last_date)) {
		$end_date = $event_calendar_last_date;
	}

	$start_ts = strtotime($start_date);

	if( $mode == "day" ){
		$end_ts = strtotime($end_date)+$day-1;
	} else if( $mode == "week" ){
		$end_ts = $start_ts + (6 * $day);
	} else if( $mode == "month" ){
		$end_ts = strtotime($end_date);
	} else {
		$end_ts = $start_ts + (90 * $day);
	}

	if(count($widget_groups) == 1 && $widget_groups[0] == 0){

		$events = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => $object_type,
			'metadata_name_value_pair' => array( 
				array('name' => 'start_date', 'value' => time(),  'operand' => '>='),
				array('name' => 'start_date', 'value' => $end_ts,  'operand' => '<')
			),
			'limit' => $num_items,
			'order_by_metadata' => array('name' => 'start_date', 'direction' => 'asc')
		));

		$options = array(
			'list_class' => 'elgg-list-entity',
			'full_view' => false,
			'pagination' => true,
			'list_type' => 'listing',
			'list_type_toggle' => false,
			'limit' => $num_items
		);
		$widget_datas = elgg_view_entity_list($events, $options);

	} else {

		$count = event_calendar_get_events_between($start_ts, $end_ts, true, $num_items, 0, $widget_groups, '-');
		$events = event_calendar_get_events_between($start_ts, $end_ts, false, $num_items, 0, $widget_groups, '-');
		
		$events_array = array();
		if (is_array($events) && sizeof($events) > 0) {
			foreach($events as $event) {
				$events_array[] = $event['event'];
			}
		}

		$options = array(
			'list_class' => 'elgg-list-entity',
			'full_view' => false,
			'pagination' => true,
			'list_type' => 'listing',
			'list_type_toggle' => false,
			'limit' => $num_items
		);
		$widget_datas = elgg_view_entity_list($events_array, $options);
	}

	echo $widget_datas;
?>
