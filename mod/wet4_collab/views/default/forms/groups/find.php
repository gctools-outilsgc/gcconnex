<?php
/*
* GC_MODIFICATION
* Description: Added accessible labels
* Author: GCTools Team
*/

echo '<label for="tagSearch" class="wb-inv">'.elgg_echo('wet:searchHead').'</label>';
echo elgg_view('input/text', array(
    'id' => 'tagSearch',
	'name' => 'tag',
	'class' => 'elgg-input-search mbm',
	'placeholder' => elgg_echo('wet:searchgctools'),
	'required' => true
));
echo elgg_view('input/submit', array('value' => '<span class="glyphicon-search glyphicon"></span> ' . elgg_echo('search')));
