<?php
$site = elgg_get_site_entity();

$welcome = elgg_echo("pleio:walled_garden", [$site->name]);

$menu = elgg_view_menu('walled_garden', array(
    'sort_by' => 'priority',
    'class' => 'elgg-menu-general elgg-menu-hz',
));

$description = elgg_get_plugin_setting("walled_garden_description", "pleio");
if (!$description) {
    $description = elgg_echo("pleio:walled_garden_description");
}

$login_box = elgg_view('core/account/login_box', array(
    "module" => "walledgarden-login",
    "description" => $description
));

echo <<<HTML
<div class="elgg-col elgg-col-1of2">
    <div class="elgg-inner">
        <h1 class="elgg-heading-walledgarden">
            $welcome
        </h1>
        $menu
    </div>
</div>
<div class="elgg-col elgg-col-1of2">
    <div class="elgg-inner">
        $login_box
    </div>
</div>
HTML;
