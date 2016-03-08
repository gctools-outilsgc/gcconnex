<?php
/**
 * Elgg global system message list
 * Lists all system messages
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['object'] The array of message registers
 */

echo '<ul class="elgg-system-messages custom-message list-unstyled">';

// hidden li so we validate
echo '<li class="hidden wb-invisible"></li>';

if (isset($vars['object']) && is_array($vars['object']) && sizeof($vars['object']) > 0) {
    $num=0;
    foreach ($vars['object'] as $type => $list ) {
        if($num==0){
            
             //alert-dismissible" role="alert">';
            
            if($type=='error')
            {
                echo '<div class="alert alert-'.$type.' clearfix">'; //elgg-system-messages custom-message
                echo elgg_echo('wet:errmess');
            }else
            {
                echo '<div class="elgg-system-messages clearfix custom-message alert alert-'.$type.'">'; //
            }
            echo '<ul class="list-unstyled">';
            echo '<a class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>';
        }
		foreach ($list as $message) {
            $num=$num+1;
			echo '<li class="col-sm-11"';
			echo elgg_autop($message);
			echo '</li>';
		}
	}
    if($num>0){
        echo '</ul>';
        echo '</div>';
    }
}

echo '</ul>';
