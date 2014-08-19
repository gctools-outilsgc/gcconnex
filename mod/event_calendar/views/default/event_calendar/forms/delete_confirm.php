<?php

$body = '<p class="description">'.sprintf(elgg_echo('event_calendar:delete_confirm_description'),$vars['title']).'</p>';
                    
$body .= '<form action="'.$vars['url'].'action/event_calendar/manage" method="post" >';
$body .= elgg_view('input/securitytoken');
$body .= elgg_view('input/hidden',array('internalname'=>'event_action', 'value'=>'delete_event'));
$body .= elgg_view('input/hidden',array('internalname'=>'event_id', 'value'=>$vars['event_id']));
$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('event_calendar:submit')));
$body .= '</form>';

echo elgg_view('page_elements/contentwrapper', array('body'=>$body));
?>