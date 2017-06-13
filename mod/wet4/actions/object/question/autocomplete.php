<?php
global $CONFIG;
$db_prefix = elgg_get_config('dbprefix');

$name = get_input('name');
$owner = get_input('owner');
$lang = get_current_language();

$params = array(
  "type" => "object",
  'subtype' => "question",
  'metadata_name_value_pairs' => array(
      'name' => 'title',
      'value' => '%'.$name.'%',
      'operand' => 'LIKE',
      'case_sensitive' => false
    )
);

//find questions based on Similiar titles
$questions = elgg_get_entities_from_metadata($params);

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
