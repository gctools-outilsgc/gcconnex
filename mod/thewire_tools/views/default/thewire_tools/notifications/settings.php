<?php

$user = elgg_extract("user", $vars);

$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();

$notification_settings = thewire_tools_get_notification_settings($user->getGUID());

$content = "<tr>";

$content .= "<td class='namefield'>";
$content .= elgg_view("output/longtext", array("value" => elgg_echo("thewire_tools:settings:description")));
$content .= "</td>";

$i = 0;
foreach ($NOTIFICATION_HANDLERS as $method) {
	
	$checkbox_settings = array(
		"id" => "thewire_tools_" . $method . "_checkbox",
		"name" => "thewire_tools_" . $method,
		"value" => $method,
		"onclick" => "adjust" . $method . "('thewire_tools_" . $method . "')"
	);
	
	if (in_array($method, $notification_settings)) {
		$checkbox_settings["checked"] = true;
	}
	
	if ($i > 0) {
		$content .= "<td class='spacercolumn'>&nbsp;</td>";
	}
	
	$content .= "<td class='" . $method . "togglefield'>";
	$content .= elgg_view("output/url", array(
		"border" => "0",
		"id" => "thewire_tools_" . $method,
		"class" => $method . "toggleOff",
		"onclick" => "adjust" . $method . "_alt('thewire_tools_" . $method . "')",
		"text" => elgg_view("input/checkbox", $checkbox_settings)
	));
	$content .= "</td>";

	$i++;
}

$content .= "<td>&nbsp;</td>";
$content .= "</tr>";

echo "<table id='thewire-tools-notification-settings' class='hidden'>";
echo $content;
echo "</table>";
?>
<script type="text/javascript">
	var cs_content = $('#thewire-tools-notification-settings tr:first').html();

	$('#notificationstable tr:last').after("<tr>" + cs_content + "</tr>");
	$('#thewire-tools-notification-settings').remove();
</script>