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

        $alt = '<div class=" mrgn-tp-sm col-xs-1 text-right">' . $delete_button . '</div>';

		$body = "<h4 class=' mrgn-tp-sm col-xs-11'>$email_title</h4>";

		$content .= "<div class='clearfix mrgn-tp-sm'>";
		//$content .= elgg_view_image_block("", $body . $alt);
        $content .= $body . $alt;
		$content .= "</div>";
	}

	$content .= "</ul>";
	
	// pagination
	$content .= elgg_view("navigation/pagination", $vars);
} else {
	$content = elgg_view("output/longtext", array("value" => elgg_echo("group_tools:groups:membershipreq:email_invitations:none")));
}

echo $content;