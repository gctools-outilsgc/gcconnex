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
    elgg_register_page_handler('download_full_discussion', 'download_full_discussion');
}


function download_full_discussion($page){
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
