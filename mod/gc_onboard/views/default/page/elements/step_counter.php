<?php

/**
 * Creates a step counter that tracks user's progress as they go through modules.
 *
 * step_counter description.
 *
 * @version 1.0
 * @author Nick
 */

 //Nick - Get how many steps in total and what the current step is.
$total_steps = elgg_extract('total_steps', $vars);
$current_step = elgg_extract('current_step', $vars);

$screen_reader = elgg_format_element('div', array('class'=>'wb-invisible'), elgg_echo('onboard:steps:sr', array($current_step, $total_steps)));
$additional_class = elgg_extract('class', $vars);

//Nick - Loop through the steps and create li with the step number
for($i =1; $i <= $total_steps; $i++){
    if($current_step == $i){
        $step_list_classes ='step-list-item current-step';
    }else{
        $step_list_classes = 'step-list-item';
    }
    $steps .= elgg_format_element('li',array('class'=>$step_list_classes,), $i);
}
//Nick - Format the ul 
$step_list = elgg_format_element('ul', array('class'=>'step-counter list-unstyled ' . $additional_class, 'aria-hidden' => "true",), $steps);
echo $screen_reader;
echo $step_list;