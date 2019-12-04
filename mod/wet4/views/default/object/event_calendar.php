<?php

/**
 * Elgg event_calendar object view
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

elgg_load_library('elgg:event_calendar');
$lang = get_current_language();

$event = $vars['entity'];
$full = elgg_extract('full_view', $vars, false);
$tags = elgg_view('output/tags', array('tags' => $event->tags));
if ($full) {

	//Identify available content
$title_json = json_decode($event->title);
$description_json = json_decode($event->description);
if( $description_json->en && $description_json->fr ){
	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>		
		<span id="indicator_language_en" onclick="change_en('.mtm', '.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
	
		<?php
	}else{
		?>		
		<span id="indicator_language_fr" onclick="change_fr('.mtm','.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
			
		<?php	
	}
	echo'</div>';
}

	$owner = $event->getOwnerEntity();
	$owner_icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = elgg_view('output/url', array(
		'href' => "event_calendar/owner/$owner->username",
		'text' => $owner->name,
		'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));
	$date = elgg_view_friendly_time($event->time_created);
	// The "on" status changes for comments, so best to check for !Off
	if ($event->comments_on != 'Off') {
		$comments_count = $event->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
				'href' => $event->getURL() . '#event-comments',
				'text' => $text,
				'is_trusted' => true,
			));
		} else {
			$comments_link = '';
		}
	} else {
		$comments_link = '';
	}
	$subtitle = "$author_text $date $comments_link";

	$body = '';
	if ($event->web_conference) {
		$body .= '<br>';
		$body .= elgg_view('event_calendar/conference_button', array('event' => $event));
	}
	$event_items = event_calendar_get_formatted_full_items($event);
	$body .= '<br>';

	foreach($event_items as $item) {
		$value = $item->value;
		if (!empty($value)) {
			$body .= '<div class="mts">';
			$body .= '<label>' . $item->title.': </label>';
			$body .= $item->value . '</div>';
		}
	}

	$body .= '<a href="'.elgg_get_site_url().'event_calendar/display_users/'.$vars["entity"]->guid.'"> '.elgg_echo('event_calendar:personal_event_calendars_link').'</a><br><br>';

	$body .= '<div class="mtm">' . gc_explode_translation($event->description, $lang) . '</div>';

	$metadata = elgg_view_menu('entity', array(
		'entity' => $event,
		'handler' => 'event_calendar',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz list-inline',
	));

	$format_full_subtitle = elgg_format_element('div', ['class' => 'd-flex mrgn-tp-md mrgn-bttm-md'], $owner_icon . '<div class="mrgn-lft-sm">' .$subtitle. '</div>');
	$format_full_event = elgg_format_element('div', ['class' => 'panel-body'], $body . $tags . $format_full_subtitle . $metadata);
	echo elgg_format_element('div', ['class' => 'panel'], $format_full_event);
  	echo '<div id="group-replies" class="elgg-comments clearfix">';

	if (elgg_get_plugin_setting('add_to_group_calendar', 'event_calendar') == 'yes') {
		echo elgg_view('event_calendar/forms/add_to_group', array('event' => $event));
	}

} else {

	$title_link = elgg_view('output/url', array(
		"text" => gc_explode_translation($event->title, $lang),
		"href" => $event->getURL(),
	));

	$subtitle = "$event->venue";

	$time_bit = event_calendar_get_formatted_time($event);
	$extras = array($time_bit);
	if ($event->brief_description) {
		$extras[] = $event->brief_description;
	}

	if ($event_calendar_venue_view = elgg_get_plugin_setting('venue_view', 'event_calendar') == 'yes') {
		$extras[] = $event->venue;
	}
	if ($extras) {
		$info = "<p>".implode("<br>",$extras)."</p>";
	} else {
		$info = '';
	}

	if (elgg_in_context('widgets')) {
		$metadata = '';
	} else {
		$metadata = elgg_view_menu('entity', array(
			'entity' => $event,
			'handler' => 'event_calendar',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz list-inline',
		));
	}
	
	$format_title = elgg_format_element('h3', ['class' => 'mrgn-tp-0 mrgn-bttm-md'], $title_link);
	$format_subtitle = elgg_format_element('div', ['class' => 'd-flex mrgn-tp-md'], $owner_icon . '<div class="mrgn-lft-sm">' . $subtitle . '</div>');
	$format_panel_body = elgg_format_element('div', ['class' => 'panel-body'], $format_title . $format_subtitle . '<div class="mrgn-tp-md">' .$metadata.'</div>');
	echo elgg_format_element('div', ['class' => 'panel'], $format_panel_body);
}
