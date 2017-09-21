<?php

$entity = elgg_extract('entity', $vars);

$title = $entity->title;

$status = ($entity->status) ? 'patent' : 'application';
$subtitle[] = elgg_echo('linkedin:patent:status', array(elgg_echo("linkedin:patent:status:$status")));

if ($patent->number) {
	$subtitle[] = elgg_echo("linkedin:patent:number:$status", array($entity->number));
}
if ($entity->date) {
	$date = date("j F Y", $entity->date);
	$subtitle[] = elgg_echo("linkedin:patent:date:$status", array($date));
}
if ($entity->office) {
	$subtitle[] = elgg_echo('linkedin:patent:office', array(strtoupper($entity->office)));
}
if ($entity->inventors) {
	$subtitle[] = elgg_echo('linkedin:patent:inventors', array(implode(', ', $entity->inventors)));
}

$description = elgg_view('output/longtext', array(
	'value' => $entity->description
		));

if ($entity->address) {
	$description .= elgg_view_icon('bookmark') . elgg_view('output/url', array(
				'text' => elgg_echo('linkedin:patent:url'),
				'href' => $entity->address,
				'target' => 'blank'
	));
}


echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => implode('<br />', $subtitle),
	'content' => $description,
));
