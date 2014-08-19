<?php
/**
 * Deletion of a Tidypics image by GUID provided (if image entry does not get properly displayed on site and delete button can not be reached)
 *
 * iionly@gmx.de
 */

$title = elgg_echo('tidypics:delete_image');
$content = '<p>' . elgg_echo('tidypics:delete_image_blurb') . '</p>';
$content .= '<label>' . elgg_echo('tidypics:delete_image_id') . '</label>';
$content .= elgg_view('input/text', array('name' => 'guid'));

echo elgg_view_module('inline', $title, $content);

echo elgg_view('input/submit', array('value' => elgg_echo("delete")));