<?php
/**
 * Group tag-based search form body
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels
 * Author: GCTools Team
 */
$tag_string = elgg_echo('groups:search:tags');

$params = array(
	'name' => 'tag',
	'class' => 'elgg-input-search mbm',
	'value' => $tag_string,
	'onclick' => "if (this.value=='$tag_string') { this.value='' }",
    'id'=>'tagSearch'
);
echo '<label for="tagSearch" class="wb-inv">'.elgg_echo('wet:searchHead').'</label>';
echo elgg_view('input/text', $params);

echo elgg_view('input/submit', array('value' => elgg_echo('search:go')));
