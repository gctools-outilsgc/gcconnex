<?php
/**
 * Mail group members
 */
$group = $vars["entity"];
$members = $vars["members"];

$friendpicker_value = array();
if (!empty($members)) {
	foreach ($members as $member) {
		$friendpicker_value[] = $member->getGUID();
	}
}

$form_data = "<label>" . elgg_echo("group_tools:mail:form:recipients") . ": <span id='group_tools_mail_recipients_count'>" . count($friendpicker_value) . "</span></label>";
$form_data .= "<br />";
$form_data .= elgg_view("output/url", array(
	"text" => elgg_echo("group_tools:mail:form:members:selection"),
	"href" => "#group_tools_mail_member_selection",
	"rel" => "toggle"
));

$form_data .= "<div id='group_tools_mail_member_selection' class='mrgn-tp-sm' style='display:none'>";
$form_data .= elgg_view("input/friendspicker", array("entities" => $members, "value" => $friendpicker_value, "highlight" => "all", "name" => "user_guids"));
$form_data .= "</div></div></div></div>";

$form = "<div id='group_tools_mail_member_options' class='mrgn-tp-md mrgn-bttm-md'>";
$form .= elgg_view("input/button", array("class" => "elgg-button-action mrs", "value" => elgg_echo("group_tools:clear_selection"), "onclick" => "elgg.group_tools.mail_clear_members();"));
$form .= elgg_view("input/button", array("class" => "elgg-button-action mrs", "value" => elgg_echo("group_tools:all_members"), "onclick" => "elgg.group_tools.mail_all_members();"));
$form .= "<br />";
$form .= "</div>";

$form .= "<div>";
$form .= "<label for='subject'>" . elgg_echo("group_tools:mail:form:title") . "</label>";
$form .= elgg_view("input/text", array("name" => "title", 'id' => 'subject', 'class' => 'mrgn-bttm-sm'));
$form .= "</div>";

$form .= "<div>";
$form .= "<label>" . elgg_echo("group_tools:mail:form:description") . "</label>";
$form .= elgg_view("input/longtext", array("name" => "description"));
$form .= "</div>";

$form .= "<div class='elgg-foot'>";
$form .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
$form .= elgg_view("input/submit", array("value" => elgg_echo("send"), 'class' => 'mrgn-tp-md btn btn-primary'));
$form .= "</div>";

echo $form_data;
echo elgg_format_element('section',['class' => ''], $form);