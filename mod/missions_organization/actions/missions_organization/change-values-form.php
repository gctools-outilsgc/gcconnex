<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Action to change the node's name and abbreviation.
 */
$node = get_entity(get_input('hidden_guid'));

$name_english = get_input('org_name_english');
$abbr_english = get_input('org_abbr_english');
$name_french = get_input('org_name_french');
$abbr_french = get_input('org_abbr_french');

$node->name_french = $name_french;
$node->abbr_french = $abbr_french;
$node->name = $name_english;
$node->abbr = $abbr_english;

$node->save();

forward(REFERER);