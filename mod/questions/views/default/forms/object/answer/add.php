<?php

$vars['entity'] = new ElggAnswer();
$vars['entity']->container_guid = $vars['container_guid'];

echo elgg_view('forms/object/answer/edit', $vars);
