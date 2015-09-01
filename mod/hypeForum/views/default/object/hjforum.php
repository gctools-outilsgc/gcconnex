<?php

$full = elgg_extract('full_view', $vars, false);

if ($full) {
	echo elgg_view('object/hjforum/full', $vars);
} else {
	echo elgg_view('object/hjforum/summary', $vars);
}