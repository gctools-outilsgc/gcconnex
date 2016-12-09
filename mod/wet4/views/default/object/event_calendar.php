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

if ($full) {

	//Identify available content
	if(($event->long_description2) && ($event->long_description)){
		echo'<div id="change_language" class="change_language">';
		if (get_current_language() == 'fr'){

			?>			
			<span id="indicator_language_en" onclick="change_en('.mtm');"><span id="en_content" class="testClass hidden" ><?php echo $event->long_description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $event->long_description2;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			<?php

		}else{
					
			?>			
			<span id="indicator_language_fr" onclick="change_fr('.mtm');"><span id="en_content" class="testClass hidden" ><?php echo $event->long_description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $event->long_description2;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
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

	if (!$event->long_description3) {
		if ($event->long_description){
			$body .= '<div class="mtm">' . $event->long_description . '</div>';
		}
	} else if ($event->description) {
		$body .= '<div class="mtm">' . $event->description . '</div>';
	}else{
		$body .= '<div class="mtm">' . gc_explode_translation($event->long_description3, $lang) . '</div>';
	} 

	$metadata = elgg_view_menu('entity', array(
		'entity' => $event,
		'handler' => 'event_calendar',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz list-inline',
	));

	$params = array(
		'entity' => $event,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
        'entity' => $event,
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));

	if (elgg_get_plugin_setting('add_to_group_calendar', 'event_calendar') == 'yes') {
		echo elgg_view('event_calendar/forms/add_to_group', array('event' => $event));
	}

} else {

	// identify available content
/*	if(($event->long_description2) && ($event->long_description)){
			
		echo'<span class="col-md-1 col-md-offset-11"><i class="fa fa-language fa-lg mrgn-rght-sm"></i>' . '<span class="wb-inv">Content available in both language</span></span>';	
	}*/

	$time_bit = event_calendar_get_formatted_time($event);
	$icon = '<img src="'.elgg_view("icon/object/event_calendar/small").'" />';
	$extras = array($time_bit);
	if ($event->description) {
		$extras[] = $event->description;
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

	$params = array(
		'entity' => $event,
		'metadata' => $metadata,
		'subtitle' => $info,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $list_body);
}
