<?php
/**
 * Group river view. Displays quick information on a group for the river
 */
$lang = get_current_language();
$object = $vars['item']->getObjectEntity();
$thumbnail = elgg_view_entity_icon($object);
// Member count may slow thins down
// $num_members = $object->getMembers(array('count' => true));
$member_status = ($object->isPublicMembership()) ? elgg_echo('groups:open') : elgg_echo('groups:closed');
$title = elgg_format_element('a', ['href' => $object->getURL(), 'class' => 'h5 text-dark'], gc_explode_translation($object->name, $lang));

$meta_info = elgg_format_element('div', [], '<div class="text-muted"><span class="ml-3">'.$member_status.'</span></div>');

$body = elgg_format_element('div', ['class'=> 'p-2 pbm'], '<div>'.$title.'</div>' .$meta_info);

//TODO grab the group cover photo is it exists
echo <<<HTML
<div class="border rounded river-group-object">
  <div class="river-group-cover w-100" style="height: 50px;"></div>
  <div class="d-flex pl-4 pr-4 pb-4">
    <span class="river-group-avatar">$thumbnail</span>
    $body
  </div>
</div>
HTML;
