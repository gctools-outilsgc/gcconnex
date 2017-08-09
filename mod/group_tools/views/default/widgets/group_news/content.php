<?php
/**
 * content of the group news widget
 */

$widget = elgg_extract('entity', $vars);

$configured_projects = [];

for ($i = 1; $i < 6; $i++) {
	$metadata_name = "project_{$i}";
	$guid = (int) $widget->$metadata_name;
	
	$group = get_entity($guid);
	if (!($group instanceof ElggGroup)) {
		continue;
	}
	
	$configured_projects[] = $group;
}

if (empty($configured_projects)) {
	echo elgg_echo('widgets:group_news:no_projects');
	return;
}

if (elgg_is_xhr()) {
	echo elgg_format_element('script', ['type' => 'text/javascript'], "require(['group_tools/group_news']);");
} else {
	elgg_require_js('group_tools/group_news');
}

$blog_count = sanitise_int($widget->blog_count);
if ($blog_count < 1) {
	$blog_count = 5;
}

$group_icon_size = $widget->group_icon_size;
if ($group_icon_size !== 'small') {
	$group_icon_size = 'medium';
}

echo '<div class="widget_group_news_container">';
foreach ($configured_projects as $key => $group) {
	
	$body = elgg_format_element('h3', [], $group->name);
	$icon = elgg_view_entity_icon($group, $group_icon_size);
	
	$group_news = elgg_get_entities([
		'type' => 'object',
		'subtype' => 'blog',
		'container_guid' => $group->getGUID(),
		'limit' => $blog_count,
	]);
	if (!empty($group_news)) {
		$body .= '<ul>';
		foreach ($group_news as $news) {
			$body .= elgg_format_element('li', [], elgg_view('output/url', [
				'text' => $news->title,
				'href' => $news->getURL(),
				'is_trusted' => true,
			]));
		}
		$body .= '</ul>';
	} else {
		$body .= elgg_echo('widgets:group_news:no_news');
	}
	
	$class = 'widget_group_news_' . ($key + 1) . '_' . $group->getGUID();
	if ($key !== 0) {
		$class .= ' hidden';
	}
	echo elgg_view_image_block($icon, $body, ['class' => $class]);
}

echo '</div>';

$configured_projects = array_values($configured_projects);

echo '<div class="widget_group_news_navigator">';
foreach ($configured_projects as $key => $group) {
	$class = '';
	if ($key == 0) {
		$class = 'active';
	}
	
	echo elgg_format_element('span', [
		'rel' => 'widget_group_news_' . ($key + 1) . '_' . $group->getGUID(),
		'class' => $class
	], ($key + 1));
}
echo '</div>';
