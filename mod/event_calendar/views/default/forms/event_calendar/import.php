<?php

echo '<div class="mbl">';
echo '<h3>' . elgg_echo('event_calendar:import:settings') . '</h3>';
echo '</div>';

// import into which calendar
echo '<div class="mbm">' . elgg_echo('event_calendar:import:type') . ' ';

$options_values = array();

if (event_calendar_can_add()) {
	$options_values[0] = elgg_echo('event_calendar:site_calendar');
}

$groups = elgg_get_logged_in_user_entity()->getGroups(array('limit' => false));
if ($groups) {
	foreach ($groups as $group) {
		if (event_calendar_can_add($group->guid)) {
			$options_values[$group->guid] = elgg_echo('group') . ': ' . $group->name;
		}
	}
}

echo elgg_view('input/select', array(
	'name' => 'container_guid',
	'value' => $vars['group_guid'],
	'options_values' => $options_values
));
echo '</div>';

echo '<div class="mbm">' . elgg_echo('event_calendar:file:upload') . '<br>';
echo elgg_view('input/file', array('name' => 'ical_file'));
echo '</div>';

echo '<div class="mbm">' . elgg_echo('event_calendar:timezone') . '<br>';
echo '<select name="timezone">';
$timezone_identifiers = DateTimeZone::listIdentifiers();
foreach($timezone_identifiers as $value ) {
	if (preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) ) {
		$ex = explode("/", $value);//obtain continent,city
		if ($continent != $ex[0]) {
			if ($continent != "") {
				echo '</optgroup>';
			}
			echo '<optgroup label="'.$ex[0].'">';
		}

		$continent = array_shift($ex);
		$city = implode('/', $ex);

		echo '<option value="'.$value.'"'; if (date_default_timezone_get() == $value) echo " selected=\"yes\" "; echo ">".$city.'</option>';
	}
}
echo '</optgroup></select>';
echo '<br>' . elgg_view('output/longtext', array('value' => elgg_echo('event_calendar:timezone:help'), 'class' => 'elgg-subtext'));
echo '</div>';

echo '<div class="mbl">' . elgg_echo('event_calendar:import:access') . ' ';
echo elgg_view('input/access', array('name' => 'access_id'));
echo '</div>';

echo elgg_view('input/submit', array('value' => elgg_echo('event_calendar:import')));
