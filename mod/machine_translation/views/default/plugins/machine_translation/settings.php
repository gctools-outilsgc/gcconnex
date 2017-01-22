<?php



echo "<div>";
echo elgg_echo("machine:setting:url");
echo elgg_view("input/text", array(
	'name' => 'params[apiurl]',
	'value' => $vars['entity']->apiurl,
	));
echo "</div>";
