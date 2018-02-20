<?php
/*
* GC_MODIFICATION
* Description: Added view all link
* Author: GCTools Team
*/
	$num_items = $vars['entity']->num_items;
	if (!isset($num_items)) $num_items = 10;
	elgg_set_context('custom_index_widgets wire');

	echo '<div class="pam">' . elgg_view('output/url', [
		'text' => elgg_echo('thewire:post'),
		'href' => 'ajax/view/thewire/add',
		'class' => 'elgg-lightbox btn btn-primary btn-block',
		'data-colorbox-opts' => json_encode([
			'width' => '650px',
			'height' => '375px',
		])
	]) . '</div>';

	$widget_datas = elgg_list_entities(array(
		'type'=>'object',
		'subtype'=>'thewire',
		'limit'=>$num_items,
		'full_view' => false,
		'list_type_toggle' => false,
		'pagination' => false));

	echo $widget_datas;

$all_link = elgg_view('output/url', array(
	'href' => 'thewire/all',
	'text' => elgg_echo('View The Wire') . $groupCount,
	'is_trusted' => true,
));
echo "<div class='text-right mrgn-tp-sm'>$all_link</div>";

?>
