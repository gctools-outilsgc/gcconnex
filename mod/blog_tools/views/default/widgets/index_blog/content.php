<?php

$widget = elgg_extract('entity', $vars);

// get widget settings
$count = (int) $widget->blog_count;
if ($count < 1) {
	$count = 8;
}

// get view mode
$view_mode = $widget->view_mode;

// backup context and set
switch($view_mode){
	case 'slider':
		elgg_push_context('slider');
		break;
	case 'preview':
		elgg_push_context('preview');
		break;
	case 'simple':
		elgg_push_context('simple');
		break;
	default:
		elgg_push_context('listing');
		break;
}

$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'limit' => $count,
	'full_view' => false,
	'pagination' => false,
	'metadata_name_value_pairs' => [],
];

// only show published blogs to non admins
if (!elgg_is_admin_logged_in()) {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'status',
		'value' => 'published',
	];
}

// limit to featured blogs?
if ($widget->show_featured == 'yes') {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'featured',
		'value' => true,
	];
}

$blogs = elgg_list_entities_from_metadata($options);

// restore context
elgg_pop_context();

if (empty($blogs)) {
	echo elgg_echo('blog:noblogs');
	return;
}

if ($view_mode !== 'slider') {
	echo $blogs;
	return;
}

// blog container
$container_attr = [
	'id' => "blog_tools_widget_items_container_{$widget->getGUID()}",
	 'class' => 'blog_tools_widget_items_container',
];
echo elgg_format_element('div', $container_attr, $blogs);

// navigator
$blog_entities = elgg_get_entities_from_metadata($options);

$navigator_attr = [
	'id' => "blog_tools_widget_items_navigator_{$widget->getGUID()}",
	'class' => 'elgg-widget-more blog_tools_widget_items_navigator',
];

$spans = [];
foreach ($blog_entities as $key => $blog) {
	$spans[] = elgg_format_element('span', ['rel' => $blog->getGUID()], ($key + 1));
}
echo elgg_format_element('div', $navigator_attr, implode('', $spans));

?>
<script type='text/javascript'>
	function rotateBlogItems<?php echo $widget->getGUID(); ?>(){
		if ($('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> .active').next().length === 0) {
			$('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?>>span:first').click();
		} else {
			$('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> .active').next().click();
		}
	}

	$(document).ready(function(){
		$('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?>>span:first').addClass('active');
		var active = $('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?>>span:first').attr('rel');

		$('#blog_tools_widget_items_container_<?php echo $widget->getGUID(); ?> #elgg-object-' + active).show();

		$('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> span').click(function(){
			$('#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> span.active').removeClass('active');
			$(this).addClass('active');

			$('#blog_tools_widget_items_container_<?php echo $widget->getGUID(); ?> .elgg-item').hide();
			var active = $(this).attr('rel');
			$('#blog_tools_widget_items_container_<?php echo $widget->getGUID(); ?> #elgg-object-' + active).show();
		});
		
		setInterval (rotateBlogItems<?php echo $widget->getGUID(); ?>, 10000);
	});
</script>
