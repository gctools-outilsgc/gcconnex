<?php

namespace AU\SubGroups;

echo elgg_view('output/longtext', array(
	'value' => elgg_echo('au_subgroups:transfer:help'),
	'class' => 'elgg-subtext'
));

echo elgg_view('input/text', array(
	'name' => 'au-subgroups-search',
	'value' => '',
	'placeholder' => elgg_echo('au_subgroups:search:text'),
	'class' => 'au-subgroups-search'
));

echo '<div class="au-subgroups-search-results clearfix">';
echo elgg_view('au_subgroups/search_results');
echo '</div>';
