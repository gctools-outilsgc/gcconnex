<?php
global $CONFIG;
$db_prefix = elgg_get_config('dbprefix');

$name = sanitize_string(get_input('name'));
$lang = get_current_language();

$params['type'] = 'object';
$params['limit'] = 8;

$join = "JOIN {$db_prefix}objects_entity ge ON e.guid = ge.guid";
$params['joins'] = array($join);
$fields = array('title');
$where = "ge.title LIKE '%$name%'";
$params['wheres'] = array($where);

$params['subtype'] = 'question';

$questions = elgg_get_entities($params);


//if found place in list
if($questions){
  $content .= '<ul class="list-unstyled mrgn-bttm-0 suggestion-list">';
  foreach($questions as $q){
    if($q->getMarkedAnswer()){
      $check = '<span class="fa fa-check" style="color:#047177"><span class="wb-inv">'.elgg_echo('question:suggestion:answered').'</span></span>';
    }
    $content .= '<a target="_blank" href="'.$q->getURL().'"><li>'.$check.gc_explode_translation($q->title,$lang).'</li></a>';
  }
  $content .= '</ul>';
}

//return questions
echo json_encode([
    'question' => $content,
]);
?>
