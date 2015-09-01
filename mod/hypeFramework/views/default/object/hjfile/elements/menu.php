<?php

if (elgg_in_context('activity') || elgg_in_context('widgets') || elgg_in_context('print')) {
	return true;
}

$vars['dropdown'] = false;
if (elgg_in_context('table-view')) {
	$vars['class'] = '';
} else {
	$vars['class'] = 'elgg-menu-hz';
}

echo elgg_view('framework/bootstrap/object/elements/menu', $vars);
