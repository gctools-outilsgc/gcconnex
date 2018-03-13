<?php
$plugin = $vars["entity"];

echo "<h3 class='mtm mbm'>" . elgg_echo("pleio:settings:authorization") . "</h3>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:auth") . "<br />";
echo elgg_view("input/radio", array(
    "id" => "auth",
    "name" => "params[auth]",
    "value" => $plugin->auth,
    "options" => array(
        elgg_echo("pleio:settings:oauth") => 'oauth',
        elgg_echo("pleio:settings:oidc") => 'oidc'
    )
));
echo "</label>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:auth_url") . "<br />";
echo elgg_view("input/text", array(
    "id" => "auth_url",
    "name" => "params[auth_url]",
    "value" => $plugin->auth_url
));
echo "</label>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:auth_client") . "<br />";
echo elgg_view("input/text", array(
    "id" => "auth_client",
    "name" => "params[auth_client]",
    "value" => $plugin->auth_client
));
echo "</label>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:auth_secret") . "<br />";
echo elgg_view("input/text", array(
    "id" => "auth_secret",
    "name" => "params[auth_secret]",
    "value" => $plugin->auth_secret
));
echo "</label>";
echo "</p>";


echo "<h3 class='mtm mbm'>" . elgg_echo("pleio:settings:idp") . "</h3>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:idp_id") . "<br />";
echo elgg_view("input/text", array(
    "name" => "params[idp_id]",
    "value" => $plugin->idp_id
));
echo "</label>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:idp_name") . "<br />";
echo elgg_view("input/text", array(
    "name" => "params[idp_name]",
    "value" => $plugin->idp_name
));
echo "</label>";
echo "</p>";


echo "<h3 class='mtm mbm'>" . elgg_echo("pleio:settings:additional_settings") . "</h3>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:login_credentials") . "<br />";
echo elgg_view("input/dropdown", array(
    "name" => "params[login_credentials]",
    "options_values" => [
        "no" => elgg_echo("option:no"),
        "yes" => elgg_echo("option:yes")
    ],
    "value" => $plugin->login_credentials
));
echo "</label>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:notifications_for_access_request") . "<br />";
echo elgg_view("input/dropdown", array(
    "name" => "params[notifications_for_access_request]",
    "options_values" => [
        "yes" => elgg_echo("option:yes"),
        "no" => elgg_echo("option:no")
    ],
    "value" => $plugin->notifications_for_access_request
));
echo "</label>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:domain_whitelist") . "<br />";
echo elgg_view("input/text", array(
    "name" => "params[domain_whitelist]",
    "value" => $plugin->domain_whitelist
));
echo "</label>";
echo "<span class=\"elgg-subtext\">" . elgg_echo("pleio:settings:domain_whitelist:explanation") . "</span>";
echo "</p>";

echo "<p>";
echo "<label>" . elgg_echo("pleio:settings:walled_garden_description") . "<br />";
echo elgg_view("input/longtext", array(
    "name" => "params[walled_garden_description]",
    "value" => $plugin->walled_garden_description ? $plugin->walled_garden_description : elgg_echo("pleio:walled_garden_description")
));
echo "</label>";
echo "</p>";

echo "<script>
    if( $('#auth [type=radio]:checked').val() == '' ){
        $('#auth_url').attr('disabled', 'disabled').addClass('elgg-state-disabled');
        $('#auth_client').attr('disabled', 'disabled').addClass('elgg-state-disabled');
        $('#auth_secret').attr('disabled', 'disabled').addClass('elgg-state-disabled');
    }

    $('#auth [type=radio]').change(function(){
        console.log($(this).val());
        if( $(this).val() != '' ){
            $('#auth_url').removeAttr('disabled').removeClass('elgg-state-disabled');
            $('#auth_client').removeAttr('disabled').removeClass('elgg-state-disabled');
            $('#auth_secret').removeAttr('disabled').removeClass('elgg-state-disabled');
        }
    });
    </script>";