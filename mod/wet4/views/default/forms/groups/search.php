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
    'placeholder'=>'I do not work :3',
);
echo '<i class="fa fa-search fa-lg pull-left group-tab-menu-search-icon"></i><label for="qSearch" class="wb-inv">'.elgg_echo('wet:searchHead').'</label>';
echo elgg_view('input/text', $params);

echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['entity']->getGUID(),
));

echo elgg_view('input/submit', array('value' => elgg_echo('search:go'), 'class'=>'pull-left',));
