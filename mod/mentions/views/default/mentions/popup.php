<?php

elgg_require_js('mentions/autocomplete');

$vars = array(
	'class' => 'mentions-popup hidden',
	'id' => 'mentions-popup',
);

echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);

