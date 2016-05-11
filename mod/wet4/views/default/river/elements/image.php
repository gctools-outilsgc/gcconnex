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
if($subtype_test == 'comment' || $subtype_test =='discussion_reply' || $subtype_test == 'image'){

    //get the container of the container if it's a comment or reply
    $container = $container->getContainerEntity();
    $commentordiscuss = true;

    //$subtype_test2 = $subtype_test->getContainerEntity();
}else{

    $commentordiscuss = false;
}

//makes the widget icons small and the main river icons big :)
if(elgg_get_context() !== 'widgets'){
    if(elgg_in_context('group_activity_tab')){ //Nick - Show creator of the content when viewing the group activity tab
        echo elgg_view_entity_icon($subject, 'medium');
    }
  if (elgg_in_context('widgets')) {
      if($container || $commentordiscuss){
          echo elgg_view_entity_icon($container, 'medium');

      }else{
          echo elgg_view_entity_icon($subject, 'medium');
      }

	
} else {
    if($container && $subtype_test && !elgg_in_context('group_activity_tab')){//happens in group
        echo elgg_view_entity_icon($container, 'medium');
        //echo $subtype_test;
    }else if($container && !elgg_in_context('group_activity_tab')){
        //if user joins group show their photo, not group owner's image
        echo elgg_view_entity_icon($subject, 'medium');
    }else if(!elgg_in_context('group_activity_tab')){ // Nick - do not show additional avatars on group activity tab
        echo elgg_view_entity_icon($subject, 'medium');
    }
}
} else{
 if (elgg_in_context('widgets')) {
     echo elgg_view_entity_icon($subject, 'medium');
} else if(elgg_in_context('group_activity_tab')){
 
 }else {
	echo elgg_view_entity_icon($subject, 'medium');
}   
}

