<?php
/*
 * find-onboard.php
 *
 * Group search box located in groups module.
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
echo '<div class="col-xs-10">'.elgg_view('input/text', $params).'</div>';

echo elgg_view('input/submit', array('value' => elgg_echo('search:go'), 'class' => 'searchGroups btn btn-primary'));
