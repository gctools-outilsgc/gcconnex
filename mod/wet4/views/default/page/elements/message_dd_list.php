<?php
/*
This view creates a list view for the messages and notification drop down
*/

$items = $vars['items'];
$count = elgg_extract('count', $vars);
$pagination = elgg_extract('pagination', $vars, true);
$position = elgg_extract('position', $vars, 'after');
$no_results = elgg_extract('no_results', $vars, '');

foreach ($items as $item) {
  $item_view = elgg_view_list_item($item, $vars);
  if (!$item_view) {
    continue;
  }


  if ($item instanceof \ElggEntity) {
    $guid = $item->getGUID();
    $type = $item->getType();
    $subtype = $item->getSubtype();

    $li_attrs['id'] = "elgg-$type-$guid";

    $li_attrs['class'][] = "elgg-item-$type";
    if ($subtype) {
            //
      $li_attrs['class'][] = "elgg-item-$type-$subtype clearfix";
    }
  } else if (is_callable(array($item, 'getType'))) {
    $li_attrs['id'] = "item-{$item->getType()}-{$item->id}";
  }

  if(elgg_extract('metadata_name', $vars) == 'fromId'){
      $heading1 = elgg_echo('msg:to');
      $heading2 = elgg_echo('msg:sent');
      $sender = get_entity($item->toId)->name;
      $send_avatar = elgg_view_entity_icon(get_entity($item->toId), 'small');
  } else {
      $heading1 = elgg_echo('msg:from');
      $heading2 = elgg_echo('msg:recieved');
      $sender = get_entity($item->fromId)->name;
      $send_avatar = elgg_view_entity_icon(get_entity($item->fromId), 'small');
  }

  $subject_info = elgg_view('output/url', array(
    'href' => $item->getURL(),
    'text' => $item->title,
    'is_trusted' => true,
  ));

  $name_and_time = '<div class="col-sm-12 clearfix"><div class="col-sm-2">'.$send_avatar.'</div><div class="col-sm-10"><div class="col-sm-12">'.$sender.'</div><div class="col-sm-12">'.elgg_view_friendly_time($item->time_created).'</div></div></div>';
  $message_title = '<div class="col-sm-12 mrgn-tp-sm clearfix message-dd-title">'.$subject_info.'</div>';
  $message_final = $name_and_time . $message_title;
echo elgg_format_element('div',  array('class'=>'list-break message-dd-block mrgn-bttm-sm clearfix',), $message_final);
}
?>
