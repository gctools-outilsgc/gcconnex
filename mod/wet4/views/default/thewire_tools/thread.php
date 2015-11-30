<?php
/**
 * View conversation thread
 */

$thread_id = get_input('thread_id');

$title = elgg_echo('thewire:thread');

//elgg_push_breadcrumb(elgg_echo('thewire'), 'thewire/all');
//elgg_push_breadcrumb($title);

$content = elgg_list_entities_from_metadata(array(
	"metadata_name" => "wire_thread",
	"metadata_value" => $thread_id,
	"type" => "object",
	"subtype" => "thewire",
	"limit" => max(20, elgg_get_config('default_limit')),
	'preload_owners' => true,
    'order_by' => 'time_created asc',
));

$body = elgg_view_layout('one_column', array(

	'content' => $content,
	'title' => false,
));
echo '<div class="replyContainer">' . $body . '</div>';

//echo elgg_view_page($title, $body);
