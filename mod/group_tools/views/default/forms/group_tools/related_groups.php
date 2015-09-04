<?php

$group = elgg_extract("entity", $vars);

echo "<div id='group-tools-related-groups-form'>";
echo elgg_view("input/autocomplete", array("name" => "guid", "match_on" => "groups", "placeholder" => elgg_echo("group_tools:related_groups:form:placeholder")));
echo elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
echo elgg_view("input/submit", array("value" => elgg_echo("add")));
echo "<div class='elgg-subtext'>" . elgg_echo("group_tools:related_groups:form:description") . "</div>";
echo "</div>";
