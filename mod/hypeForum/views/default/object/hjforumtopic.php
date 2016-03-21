<?php

$full = elgg_extract('full_view', $vars, false);

if ($full) {
	echo elgg_view('object/hjforumtopic/full', $vars);
} else {
	echo elgg_view('object/hjforumtopic/summary', $vars);
}