<?php
//Nick - This form appears on the modal popup when users want to opt-in for missions



echo elgg_view('page/elements/edit_opt-in', array());

echo elgg_view('input/submit', array('value'=>elgg_echo('missions:optin:continue'), 'class'=>'btn-primary center-block btn-lg',));
?>