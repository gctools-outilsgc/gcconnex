<?php
$lang = get_current_language();
$group = elgg_get_page_owner_entity();
//TODO: Add link to GCmessage
$description = gc_explode_translation($group->description,$lang);
$format_description = '<div><b>'. elgg_echo('description').':</b></div>' . elgg_get_excerpt($description, 300);
$link_to_about = elgg_view('output/url', array(
	'text' => elgg_echo('group:more_button'),
	'href' => '/groups/about/' .$group->guid,
	'class' => 'btn btn-primary text-center center-block',
));

$profile_fields = elgg_get_config('group');
	foreach ($profile_fields as $key => $valtype) {
		$options = array('value' => $group->$key, 'list_class' => 'mrgn-bttm-sm',);
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
			$tags .= elgg_view("output/$valtype", $options);
		}
	}
	//check to see if tags have been made
	//dont list tag header if no tags
	if(!$tags){
	} else {
		if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') === false && strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') === false)
			$format_tags = '<div class="hidden-xs">'.$tags.'</div>';
	}

$mem = ($group->isPublicMembership()) ? elgg_echo('groups:open') : elgg_echo('groups:closed');
$access_list = elgg_format_element('li', ['class' => 'd-flex'], '<div class="info-title">'.elgg_echo('access').': </div><div>'. $mem.'</div>');
$info_list = elgg_format_element('ul', ['class'=> 'mrgn-tp-md mrgn-bttm-0 list-unstyled group-info-list'], $access_list);
$content = elgg_format_element('div', [], $info_list . $format_description . '<div class="mrgn-tp-md">' .$format_tags. '</div>');

echo elgg_view('page/components/module', array(
	'title' => elgg_echo('group:info'),
	'body' => $content,
	'footer' => $link_to_about,
));