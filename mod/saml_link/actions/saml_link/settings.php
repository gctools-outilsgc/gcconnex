<?php
$id = get_input('entityID');

$ent = get_entity($id);

$ent->delete();

system_message("Account link was deleted");
    forward(REFERER);
?>
