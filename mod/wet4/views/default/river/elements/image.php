<?php
/**
 * Elgg river image
 *
 * Displayed next to the body of each river item
 *
 * @uses $vars['item']
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */


$subject = $item->getSubjectEntity();
//if the activity happens in a group it shows the group icon
$object = $item->getObjectEntity();
$container = $object->getContainerEntity();
//trying to get the container of a container for comments on content in a group

$subtype_test = $object->getSubtype();
if($subtype_test == 'comment' || $subtype_test =='discussion_reply'){

    //get the container of the container if it's a comment or reply
    $container = $container->getContainerEntity();
    $commentordiscuss = true;

    //$subtype_test2 = $subtype_test->getContainerEntity();
}else{

    $commentordiscuss = false;
}

//makes the widget icons small and the main river icons big :)
if(elgg_get_context() !== 'widgets'){
  if (elgg_in_context('widgets')) {
      if($container || $commentordiscuss){
          echo elgg_view_entity_icon($container, 'medium');

      }else{
          echo elgg_view_entity_icon($subject, 'medium');
      }

	
} else {
    if($container){
        echo elgg_view_entity_icon($container, 'medium');
    }else{
        echo elgg_view_entity_icon($subject, 'medium');
    }
}  
}else{
 if (elgg_in_context('widgets')) {
	echo elgg_view_entity_icon($subject, 'small');
} else {
	echo elgg_view_entity_icon($subject, 'small');
}   
}

