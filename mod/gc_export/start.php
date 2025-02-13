<?php
/**
 * Group deletion process mod for the Elgg groups plugin
 *
 * @package ElggGroups
 */

elgg_register_event_handler('init', 'system', 'gcexport_init');

require_once(dirname(__FILE__) . "/lib/hooks.php");

function gcexport_init() {
    elgg_register_plugin_hook_handler("register", "menu:entity", "discussion_menu_entity_hook");
    elgg_register_event_handler('pagesetup', 'system', 'group_email_list_setup_menu');
    elgg_register_page_handler('download_full_discussion', 'download_full_discussion');
    elgg_register_page_handler('download_group_emails', 'download_group_emails');
}


function download_full_discussion($page){
	if (!is_numeric($page[0]))
		return 0;
	$guid = $page[0];
	$topic = get_entity($guid);
	$title = html_entity_decode(gc_explode_translation($topic->title, 'en')) . " | " . html_entity_decode(gc_explode_translation($topic->title, 'fr'));
	if ( html_entity_decode(gc_explode_translation($topic->title, 'en')) == html_entity_decode(gc_explode_translation($topic->title, 'fr')) )
		$title = html_entity_decode(gc_explode_translation($topic->title, 'en'));
	$OP = get_entity($topic->owner_guid);
	$topic_timestamp = date('c', $topic->time_created);
	$replies = elgg_get_entities(array(
		"type" => "object",
		"subtype" => "discussion_reply",
		"container_guid" => $topic->getGUID(),
		"preload_owners" => true,
		"count" => false,
		"offset" => 0,
		"limit" => 0,
		"reverse_order_by" => true,
	));
	$description["en"] = html_entity_decode(gc_explode_translation($topic->description, 'en'));
	$description["fr"] = html_entity_decode(gc_explode_translation($topic->description, 'fr'));

	$file = "<h1>Discussion Posts and All Replies | Messages de discussion et toutes les réponses</h1>";

	$file .= "<h2>Discussion Title | Titre de la discussion</h2> $title <br />\n";
	$file .= "<h2>Discussion Number | Numéro de la discussion</h2> $guid <br />\n";
	$file .= "<h2>Posted by | Publication faite par</h2> {$OP->username}, {$OP->email} - $topic_timestamp <br />\n";
	$file .= "<hr /><h2>Post | Message publié</h2>\n";

	if ( $description['en'] == $description['fr'] )
		$file .= "{$description['en']}<br />\n";
	else {
		$file .= "<h3>English</h3>\n <div style='border-bottom: dashed 2px'>{$description['en']}</div><br />\n";
		$file .= "<h3>Français</h3>\n {$description['fr']} <br />\n";
	}

	$file .= "<hr /><h2>Replies | Réponses</h2>\n";

	foreach ($replies as $reply) {
		$user = get_entity($reply->owner_guid);
		$reply_timestamp = date('c', $reply->time_created);
		$reply_text = html_entity_decode($reply->description);
		$file .= "<h3>{$user->username}, {$user->email} - $reply_timestamp</h3> <div style='border-bottom: dashed 2px'> $reply_text </div><br />\n";
	}

	$mime = "application/octet-stream";
	header("Pragma: public");

	header("Content-type: $mime");
	header("Content-Disposition: attachment; filename=\"$guid.html\"");
	flush();
	echo $file;
	exit;

	return 1;
}


function group_email_list_setup_menu() {
	$page_owner = elgg_get_page_owner_entity();

	if (elgg_in_context('groups')) {
		if ($page_owner instanceof ElggGroup) {
			if (elgg_is_logged_in() && $page_owner->canEdit()) {
				$url = elgg_get_site_url() . "download_group_emails/{$page_owner->getGUID()}";
				elgg_register_menu_item('group_ddb', array(
					'name' => 'email_export',
					'text' => elgg_echo('decommission:email_list'),
					'href' => $url,
					"priority" => 500,
				));
			}
		}
	}
}

function download_group_emails($page){
	if (!is_numeric($page[0]))
		return 0;
	gatekeeper();

	if (!get_entity($page[0])->canEdit()) {
		register_error(elgg_echo('decommission:notgroupadmin'));
		forward(REFERER);
	}

	$group_guid = $page[0];

	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT u.email AS email FROM  {$dbprefix}entity_relationships r, {$dbprefix}users_entity u WHERE r.guid_one = u.guid AND r.relationship = 'member' AND r.guid_two = $group_guid";

	$user_emails = get_data($query);

	$list = "";
	foreach ($user_emails as $email) {
		$list .= "$email->email <br />\n";
	}
	echo $list;

	return 1;
}