<?php

$vars = array(
	'class' => 'mentions-popup hidden',
	'id' => 'ajax-popup',
);

echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);

