<?php
/**
 * Group search form
 *
 * @uses $vars['entity'] ElggGroup
 */

$params = array(
    //Nick- Right now this hooks up to the GSA with the name so we may need to change this? We just need to change the name. 
    //Nick - This search box won't actually do anything :|
	'name' => 'q',
	'class' => 'elgg-input-search mbm pull-left group-tab-menu-search-box',
    'id' => 'qSearch',
    'placeholder'=>elgg_echo('wet:search_in_group'),
);
echo '<label for="qSearch" class="wb-inv">'.elgg_echo('wet:searchHead').'</label>';
echo elgg_view('input/text', $params);

echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['entity']->getGUID(),
));
//Nick - created a new type "group_search" for buttons to put the search icon in the submit button
echo elgg_view('input/button', array('value' => elgg_echo('wet:searchHead'), 'class'=>'pull-left group-search-button', 'type'=>'group_search'));
