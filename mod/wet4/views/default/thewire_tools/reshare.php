<?php
/**
 * Ajax wrapper view to show a wire add form
 */

$reshare_guid = (int) get_input("reshare_guid");
$reshare = get_entity($reshare_guid);
if (!empty($reshare) && !(elgg_instanceof($reshare, "object") || elgg_instanceof($reshare, "group"))) {
	unset($reshare);
}

//echo elgg_view_entity($reshare, $vars);

echo "<div id='thewire-tools-reshare-wrapper' class='ui-front'>";

echo elgg_view_title(elgg_echo("thewire_tools:reshare"));

elgg_push_context("thewire");

echo elgg_view_form("thewire/add", array(), array("reshare" => $reshare));

elgg_pop_context();

echo "</div>";