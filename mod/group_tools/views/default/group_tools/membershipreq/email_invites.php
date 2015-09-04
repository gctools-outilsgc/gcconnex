<?php

$emails = elgg_extract("emails", $vars);
$group = elgg_extract("entity", $vars);

if (!empty($emails)) {
	$content = "<ul class='elgg-list'>";

	foreach ($emails as $annotation) {

		list(,$email) = explode("|", $annotation->value);

		$email_title = elgg_view("output/email", array("value" => $email));

		$url = "action/group_tools/revoke_email_invitation?annotation_id=" . $annotation->id . "&group_guid=" . $group->getGUID();
		$delete_button = elgg_view("output/url", array(
			"href" => $url,
			"confirm" => elgg_echo("group_tools:groups:membershipreq:invitations:revoke:confirm"),
			"text" => elgg_echo("group_tools:revoke"),
			"class" => "elgg-button elgg-button-delete mlm",
		));

		$body = "<h4>$email_title</h4>";

		$content .= "<li class='elgg-item'>";
		$content .= elgg_view_image_block("", $body, array("image_alt" => $delete_button));
		$content .= "</li>";
	}

	$content .= "</ul>";
	
	// pagination
	$content .= elgg_view("navigation/pagination", $vars);
} else {
	$content = elgg_view("output/longtext", array("value" => elgg_echo("group_tools:groups:membershipreq:email_invitations:none")));
}

echo $content;