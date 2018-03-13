<?php
global $CONFIG;

elgg_load_css('elgg.walled_garden');
elgg_load_js('elgg.walled_garden');

$title = elgg_get_site_entity()->name;
$resourceOwner = elgg_extract("resourceOwner", $vars);

$subtitle = elgg_extract("title", $vars);
$description = elgg_extract("description", $vars);

$welcome = elgg_echo('walled_garden:welcome');
$welcome .= ': <br/>' . $title;

$menu = elgg_view_menu('walled_garden', array(
    'sort_by' => 'priority',
    'class' => 'elgg-menu-general elgg-menu-hz',
));
?>
<div class="elgg-col elgg-col-1of2">
    <div class="elgg-inner">
        <h1 class="elgg-heading-walledgarden">
            <?php echo $welcome; ?>
        </h1>
        <?php echo $menu; ?>
    </div>
</div>
<div class="elgg-col elgg-col-1of2">
    <div class="elgg-inner">
        <h2><?php echo $subtitle; ?></h2>
        <p><?php echo $description; ?></p>
        <p><b><?php echo elgg_echo("name"); ?></b><br><?php echo $resourceOwner["name"]; ?></p>
        <p><b><?php echo elgg_echo("email"); ?></b><br><?php echo $resourceOwner["email"]; ?></p>
        <?php echo elgg_view_form("pleio/request_access"); ?>
        <?php echo elgg_view("output/url", ["class" => "elgg-button elgg-button-submit", "href" => $CONFIG->pleio->url . "action/logout", "text" => elgg_echo("logout")]); ?>
    </div>
</div>
