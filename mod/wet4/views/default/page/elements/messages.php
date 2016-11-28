<?php
/**
 * messages.php
 * Elgg global system message list
 * Lists all system messages
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['object'] The array of message registers
 *
 * GC_MODIFICATION
 * Description: The aria-live attribute will tell a screen reader to read this content when content appears in it. Ideally whenever an ajax system message pops up screen readers will get feedback, as well the screen reader will read this content first when the system message is created on page load.
 * Author: Nick github.com/piet0024
 */

 //we can change it from assertive to polite if it is well ... too assertive :3
echo '<ul class="elgg-system-messages custom-message list-unstyled" aria-live="assertive" >';

// hidden li so we validate
echo '<li class="hidden wb-invisible"></li>';

if (isset($vars['object']) && is_array($vars['object']) && sizeof($vars['object']) > 0) {
    $num=0;
    foreach ($vars['object'] as $type => $list ) {
        if($num==0){

            if($type=='error')
            {
                echo '<div class="alert alert-'.$type.' clearfix" >'; //elgg-system-messages custom-message
            }else
            {
                echo '<div class="elgg-system-messages clearfix custom-message alert alert-'.$type.' ">'; 
            }
            echo '<ul class="list-unstyled" >';
            echo '<a class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>';
        }
		foreach ($list as $message) {
            $num=$num+1;
			echo '<li class="col-sm-11" onclick=" event.stopPropagation();">'; //this stops users from clicking system alert
			echo '<span role="alert">'.elgg_autop($message) .'</span>';
			echo '</li>';
		}
	}
    if($num>0){
        echo '</ul>';
        echo '</div>';
    }
}

echo '</ul>';
