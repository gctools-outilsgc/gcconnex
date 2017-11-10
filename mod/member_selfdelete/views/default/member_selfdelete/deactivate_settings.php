<?php
/*
Puts a section to deactivate user account in their settings
*/

echo elgg_view_module('info',elgg_echo('member_selfdelete:delete:account'),elgg_view('output/url', array('href'=>"selfdelete",'text'=>elgg_echo('member_selfdelete:delete:account'),)));