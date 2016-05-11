<?php

echo'<section class="panel panel-default mrgn-tp-xl">
	<header class="panel-heading">
	<h3 class="panel-title">Additional info</h3>
	</header>
	<div class="panel-body"><p>';
$count = event_calendar_get_users_for_event($vars['entity']->guid, 0, 0, true);
		if ($count == 1) {
			//$calendar_text = '<i class="fa fa-calendar fa-lg icon-unsel"><span class="wb-inv"></span></i> (1)';
            $calendar_text = elgg_echo('event_calendar:personal_event_calendars_link_one');
		} else {
			$calendar_text = elgg_echo('event_calendar:personal_event_calendars_link', array($count));
			//$number = $count;
			//$calendar_text = '<i class="fa fa-calendar fa-lg icon-unsel"><span class="wb-inv"></span></i> ('. $number.')';
		}

		echo '<a href="../../../event_calendar/display_users/'.$vars["entity"]->guid.'"> '.$calendar_text.' </a><br><br>';

echo '<b>Organizer:</b> '.$vars['entity']->contact.'<br>';
echo '<b>Email:</b> '.$vars['entity']->contact_email.'<br>';
echo '<b>Phone:</b> '.$vars['entity']->contact_phone.'<br>';
echo '<b>Fees:</b> '.$vars['entity']->fees.'<br>';
echo '<b>Language:</b> '.$vars['entity']->language.'<br>';

	echo'</p></div>
</section>';



