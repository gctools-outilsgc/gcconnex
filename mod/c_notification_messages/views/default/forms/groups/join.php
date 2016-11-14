<?php

$group_guid = get_input('group_guid');

echo "<label>" . elgg_echo("groups:join:justification:explanation") . "</label>";
echo elgg_view('input/plaintext', array(
    'name' => 'justification'
));

echo elgg_view('input/hidden', array(
    'name' => 'group_guid',
    'value' => $group_guid
));

echo elgg_view('input/submit', array(
    'name' => 'submit',
    'value' => 'Request'
));