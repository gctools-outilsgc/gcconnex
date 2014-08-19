<?php

/**
 * Unvalidatedemailchange plugin
 * (c) iionly 2012
 * Contact: iionly@gmx.de
 * Website: https://github.com/iionly
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

$user_guid = $vars['user_guid'];
$username =  $vars['user_name'];
$action = "action/unvalidatedemailchange/change_user_email/?user_guid=$user_guid";

$body = "<div style=\"width:600px;\"><label>".elgg_echo('unvalidatedemailchange:new_user_email',array($username))."</label>";
$body .= elgg_view('input/text', array('name' => 'new_email'))."<br><br>";
$body .= elgg_view('input/submit', array('value' => elgg_echo('unvalidatedemailchange:change_email'))).'</div>';

echo elgg_view('input/form', array('action' => $action, 'body' => $body));
