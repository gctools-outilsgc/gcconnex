<?php
/**
 * Elgg gsa plugin settings.
 *
 * @package gsa
 */



$elgg_mb_username = $vars['entity']->elgg_mb_username;
if (!$elgg_mb_username) {
    $elgg_mb_username = '';
}

$elgg_mb_password = $vars['entity']->elgg_mb_password;
if (!$elgg_mb_password) {
    $elgg_mb_password = '';
}

$elgg_mb_agentstring = $vars['entity']->elgg_mb_agentstring;
if (!$elgg_mb_agentstring) {
    $elgg_mb_agentstring = '';
}


?>

<div>
    <label>Elgg Username</label>
    <?php echo elgg_view("input/text",
        array("name" => "params[elgg_mb_username]",
            "value" => $vars['entity']->elgg_mb_username,
            "placeholder" => "username" )); ?>
</div>
<div>
    <label>Elgg Password</label>
    <?php echo elgg_view("input/text",
        array("name" => "params[elgg_mb_password]",
            "type" => "password",
            "value" => $vars['entity']->elgg_mb_password,
            "placeholder" => "password" )); ?>
</div>

<div>
    <label>GCConnex host filter</label>
    <?php echo elgg_view("input/text",
        array("name" => "params[elgg_mb_agentstring]",
            "value" => $vars['entity']->elgg_mb_agentstring,
            "placeholder" => "agent-string" )); ?>
</div>


