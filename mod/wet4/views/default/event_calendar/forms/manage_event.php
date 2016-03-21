<?php

/**
 * Elgg manage event view
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

elgg_extend_view('metatags','event_calendar/metatags');
	 
$body = elgg_view('event_calendar/forms/manage_event_content',$vars);

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('event_calendar:submit')));
$form = elgg_view('input/form',array('action'=>$vars['url'].'action/event_calendar/manage','body'=>$body));

print elgg_view('page_elements/contentwrapper',array('body'=>$form));
?>