<?php
/*
* Community picker
*/

//Communities of practice
$community_array = array(
    'atip'=> elgg_echo('gctags:community:atip'),
    'communications'=> elgg_echo('gctags:community:communications'),
    'evaluators'=> elgg_echo('gctags:community:evaluators'),
    'financial'=> elgg_echo('gctags:community:financial'),
    'hr'=> elgg_echo('gctags:community:hr'),
    'im'=> elgg_echo('gctags:community:im'),
    'it'=> elgg_echo('gctags:community:it'),
    'auditors'=> elgg_echo('gctags:community:auditors'),
    'matmanagement'=> elgg_echo('gctags:community:matmanagement'),
    'policy'=> elgg_echo('gctags:community:policy'),
    'procurement'=> elgg_echo('gctags:community:procurement'),
    'realproperty'=> elgg_echo('gctags:community:realproperty'),
    'regulators'=> elgg_echo('gctags:community:regulators'),
    'security'=> elgg_echo('gctags:community:security'),
    'service'=> elgg_echo('gctags:community:service'),
    'science'=> elgg_echo('gctags:community:science'), 
);
//Class audience-select is used with selectize.js
$communities_input = elgg_view('input/select', array(
    'name' => 'audience',
    'id' => 'audience',
    'options_values' => $community_array,
    'multiple' => 'multiple',
    'class' => 'audience-select',
));
echo elgg_format_element('label', array('for' => 'audience'), elgg_echo('gctags:label:community'));
echo $communities_input;