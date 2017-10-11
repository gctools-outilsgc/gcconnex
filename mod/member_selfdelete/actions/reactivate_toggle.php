<?php
/*
Admin can reacticate account
*/
$user = get_entity(get_input('guid'));

$user->gcdeactivate = false;