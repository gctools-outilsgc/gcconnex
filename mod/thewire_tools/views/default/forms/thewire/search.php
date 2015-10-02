<?php

echo elgg_view("input/text", array("name" => "q", "value" => $vars["query"]));
echo elgg_view("input/submit", array("value" => elgg_echo("search")));
	