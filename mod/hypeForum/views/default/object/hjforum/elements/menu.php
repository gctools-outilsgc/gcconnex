<?php

if (elgg_in_context('activity') || elgg_in_context('widgets') || elgg_in_context('print')) {
	return true;
}

$vars['dropdown'] = false;
$vars['class'] = '';

echo elgg_view('framework/bootstrap/object/elements/menu', $vars);
