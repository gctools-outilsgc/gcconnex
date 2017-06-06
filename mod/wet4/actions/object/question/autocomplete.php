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
      'name' => 'title3',
      'value' => '%'.$name.'%',
      'operand' => 'LIKE',
      'case_sensitive' => false
    )
);

$questions = elgg_get_entities_from_metadata($params);
if($questions){
  //$content .= '<p><b>Based on your question, we have found similar questions already asked.</b></p>';
  $content .= '<ul class="list-unstyled mrgn-bttm-0 suggestion-list">';
  foreach($questions as $q){
    if($q->getMarkedAnswer()){
      $check = '<span class="fa fa-check" style="color:#047177"><span class="wb-inv">'.elgg_echo('Answered').'</span></span>';
    }
    $content .= '<a target="_blank" href="'.$q->getURL().'"><li>'.$check.gc_explode_translation($q->title3,$lang).'</li></a>';
  }
  $content .= '</ul>';
}

//return question
echo json_encode([
    'question' => $content,
]);
?>
