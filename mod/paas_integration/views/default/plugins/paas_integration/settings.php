<?php
$plugin = $vars["entity"];

echo "<p>";
echo "<label>" . elgg_echo("PaaS Endpoint") . "<br />";
echo elgg_view("input/text", array(
    "id" => "graphql_client",
    "name" => "params[graphql_client]",
    "value" => $plugin->graphql_client
));
echo "</label>";
echo "</p>";

echo '<fieldset class="dev-settings">';
echo '<legend>Developer Settings</legend>';

echo "<p>";
echo "<label>" . elgg_echo("Elgg Dev url") . "<br />";
echo elgg_view("input/text", array(
    "id" => "dev_url",
    "name" => "params[dev_url]",
    "value" => $plugin->dev_url,
));
echo "</label>";
echo "</p>";
echo '</fieldset>';
?>

<style>
.dev-settings {
    border: 1px solid black;
    padding: 10px;
    margin: 10px; 
}
</style>