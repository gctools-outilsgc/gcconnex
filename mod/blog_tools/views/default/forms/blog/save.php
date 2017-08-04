<?php
/**
 * Edit blog form
 *
 * @package Blog
 */

$blog = get_entity($vars['guid']);
$vars['entity'] = $blog;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/blog/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => elgg_echo('deleteconfirm'),
	));
}

// published blogs do not get the preview button
if (!$vars['guid'] || ($blog && $blog->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'mls elgg-button-action',
	));
}

$icon_remove_input = '';
$icon_label = elgg_echo('blog_tools:label:icon:new');
if ($vars['guid']) {
	$icon_label = elgg_echo('blog_tools:label:icon:exists');
	
	if ($blog->icontime) {
		$icon_remove_input = '<br />';
		$icon_remove_input .= elgg_view('output/img', [
			'src' => $blog->getIconURL(),
			'alt' => $blog->title,
		]);
		$icon_remove_input .= '<br />';
		$icon_remove_input .= elgg_view('input/checkbox', [
			'name' => 'remove_icon',
			'value' => 'yes',
			'label' => elgg_echo('blog_tools:label:icon:remove'),
		]);
	}
}

if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('never');
}

// publication options
$status = "<div class='mbs'>";
$status .= "<label for='blog_status'>" . elgg_echo('status') . "</label>";
$status .= elgg_view('input/select', [
	'name' => 'status',
	'id' => 'blog_status',
	'value' => $vars['status'],
	'options_values' => [
		'draft' => elgg_echo('status:draft'),
		'published' => elgg_echo('status:published')
	],
	'class' => 'mls',
]);
$status .= "</div>";

// advanced publication options
$publication_options = $status;
if (blog_tools_use_advanced_publication_options()) {
	if (!empty($blog)) {
		$publication_date_value = elgg_extract('publication_date', $vars, $blog->publication_date);
		$expiration_date_value = elgg_extract('expiration_date', $vars, $blog->expiration_date);
	} else {
		$publication_date_value = elgg_extract('publication_date', $vars);
		$expiration_date_value = elgg_extract('expiration_date', $vars);
	}
	
	if (empty($publication_date_value)) {
		$publication_date_value = '';
	}
	if (empty($expiration_date_value)) {
		$expiration_date_value = '';
	}
	
	$publication_date = "<div class='mbs'>";
	$publication_date .= "<label for='publication_date'>" . elgg_echo("blog_tools:label:publication_date") . "</label>";
	$publication_date .= elgg_view('input/date', [
		'name' => 'publication_date',
		'value' => $publication_date_value,
	]);
	$publication_date .= "<div class='elgg-subtext'>" . elgg_echo("blog_tools:publication_date:description") . "</div>";
	$publication_date .= "</div>";
	
	$expiration_date = "<div class='mbs'>";
	$expiration_date .= "<label for='expiration_date'>" . elgg_echo("blog_tools:label:expiration_date") . "</label>";
	$expiration_date .= elgg_view('input/date', [
		'name' => 'expiration_date',
		'value' => $expiration_date_value,
	]);
	$expiration_date .= "<div class='elgg-subtext'>" . elgg_echo("blog_tools:expiration_date:description") . "</div>";
	$expiration_date .= "</div>";
	
	$publication_options = elgg_view_module('info', elgg_echo('blog_tools:label:publication_options'), $status . $publication_date . $expiration_date);
}

// show owner
$show_owner_setting = elgg_get_plugin_setting('show_full_owner', 'blog_tools');
if (empty($show_owner_setting)) {
	$show_owner_setting = 'no';
}

if (empty($blog)) {
	$show_owner_value = elgg_extract('show_owner', $vars, $show_owner_setting);
} else {
	$show_owner_value = elgg_extract('show_owner', $vars, $blog->show_owner);
}

if ($show_owner_setting === 'optional') {
	$show_owner_input = elgg_view('input/select', [
		'name' => 'show_owner',
		'id' => 'blog_show_owner',
		'class' => 'mls',
		'value' => $show_owner_value,
		'options_values' => [
			'no' => elgg_echo('option:no'),
			'yes' => elgg_echo('option:yes'),
		],
	]);
} else {
	$show_owner_input = elgg_view('input/hidden', [
		'name' => 'show_owner',
		'id' => 'blog_show_owner',
		'value' => $show_owner_value,
	]);
}

// start drawing the form
echo $draft_warning;

// title
echo "<div>";
echo "<label for='blog_title'>" . elgg_echo('title') . "</label>";
echo elgg_view('input/text', [
	'name' => 'title',
	'id' => 'blog_title',
	'value' => $vars['title'],
]);
echo "</div>";

// exerpt
echo "<div>";
echo "<label for='blog_excerpt'>" . elgg_echo('blog:excerpt') . "</label>";
echo elgg_view('input/text', [
	'name' => 'excerpt',
	'id' => 'blog_excerpt',
	'value' => elgg_html_decode($vars['excerpt']),
]);
echo "</div>";

// icon
echo "<div>";
echo "<label for='blog_icon'>$icon_label</label>";
echo elgg_view('input/file', [
	'name' => 'icon',
	'id' => 'blog_icon',
]);
echo $icon_remove_input;
echo "</div>";

// the blog content
echo "<div>";
echo "<label for='blog_description'>" . elgg_echo('blog:body') . "</label>";
echo elgg_view('input/longtext', [
	'name' => 'description',
	'id' => 'blog_description',
	'value' => $vars['description'],
]);
echo "</div>";

// tags
echo "<div>";
echo "<label for='blog_tags'>" . elgg_echo('tags') . "</label>";
echo elgg_view('input/tags', [
	'name' => 'tags',
	'id' => 'blog_tags',
	'value' => $vars['tags'],
]);
echo "</div>";

// categories
echo elgg_view('input/categories', $vars);

// comments
echo "<div>";
echo "<label for='blog_comments_on'>" . elgg_echo('comments') . "</label>";
echo elgg_view('input/select', [
	'name' => 'comments_on',
	'id' => 'blog_comments_on',
	'class' => 'mls',
	'value' => $vars['comments_on'],
	'options_values' => [
		'On' => elgg_echo('on'),
		'Off' => elgg_echo('off'),
	],
]);
echo "</div>";

// show owner information
if ($show_owner_setting === "optional") {
	echo "<div>";
	echo "<label for='blog_show_owner'>" . elgg_echo('blog_tools:label:show_owner') . "</label>";
	echo $show_owner_input;
	echo "</div>";
} else {
	echo $show_owner_input;
}

// access
echo "<div>";
echo "<label for='blog_access_id'>" . elgg_echo('access') . "</label>";
echo elgg_view('input/access', [
	'name' => 'access_id',
	'id' => 'blog_access_id',
	'class' => 'mls',
	'value' => $vars['access_id'],
	'entity' => $vars['entity'],
	'entity_type' => 'object',
	'entity_subtype' => 'blog',
]);
echo "</div>";

// advanced publication options
echo $publication_options;

// buttons and hidden inputs
echo "<div class='elgg-foot'>";
echo "<div class='elgg-subtext mbm'>";
echo elgg_echo('blog:save_status');
echo "<span class='blog-save-status-time mls'>$saved</span>";
echo "</div>";

echo elgg_view('input/hidden', ['name' => 'guid', 'value' => $vars['guid']]);
echo elgg_view('input/hidden', ['name' => 'container_guid', 'value' => elgg_get_page_owner_guid()]);

echo elgg_view('input/submit', ['value' => elgg_echo('save'), 'name' => 'save']);
echo $preview_button;
echo $delete_link;
echo "</div>";
