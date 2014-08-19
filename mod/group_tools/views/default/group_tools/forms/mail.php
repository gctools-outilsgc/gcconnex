<?php 

	$group = $vars["entity"];
	$members = $vars["members"];
	
	$friendpicker_value = array();
	if(!empty($members)){
		foreach($members as $member){
			$friendpicker_value[] = $member->getGUID();
		}
	}
	
	$form_data = "<label>" . elgg_echo("group_tools:mail:form:recipients") . ": <span id='group_tools_mail_recipients_count'>" . count($friendpicker_value) . "</span></label>";
	$form_data .= "<br />";
	$form_data .= "<a href='javascript:void(0);' onclick='$(\"#group_tools_mail_member_selection\").toggle();'>" . elgg_echo("group_tools:mail:form:members:selection") . "</a>";
	
	$form_data .= "<div id='group_tools_mail_member_selection'>";
	$form_data .= elgg_view("input/friendspicker", array("entities" => $members, "value" => $friendpicker_value, "highlight" => "all", "name" => "user_guids"));
	$form_data .= "</div>";
	
	$form_data .= "<div id='group_tools_mail_member_options'>";
	$form_data .= elgg_view("input/button", array("class" => "elgg-button-action", "value" => elgg_echo("group_tools:clear_selection"), "onclick" => "elgg.group_tools.mail_clear_members();"));
	$form_data .= elgg_view("input/button", array("class" => "elgg-button-action", "value" => elgg_echo("group_tools:all_members"), "onclick" => "elgg.group_tools.mail_all_members();"));
	$form_data .= "<br />";
	$form_data .= "</div>";
	
	$form_data .= "<div>";
	$form_data .= "<label>" . elgg_echo("group_tools:mail:form:title") . "</label>";
	$form_data .= elgg_view("input/text", array("name" => "title"));
	$form_data .= "</div>";
	
	$form_data .= "<div>";
	$form_data .= "<label>" . elgg_echo("group_tools:mail:form:description") . "</label>";
	$form_data .= elgg_view("input/longtext", array("name" => "description"));
	$form_data .= "</div>";
	
	$form_data .= "<div class='elgg-foot'>";
	$form_data .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
	$form_data .= elgg_view("input/submit", array("value" => elgg_echo("send")));
	$form_data .= "</div>";

	$form = elgg_view("input/form", array("body" => $form_data,
											"action" => $vars["url"] . "action/group_tools/mail",
											"id" => "group_tools_mail_form",
											"class" => "elgg-form-alt"));
	
	echo $form;
