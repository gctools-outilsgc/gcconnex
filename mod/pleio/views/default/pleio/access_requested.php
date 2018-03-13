<?php
elgg_load_css('elgg.walled_garden');
elgg_load_js('elgg.walled_garden');

/**
 * Walled garden login
 */

$resourceOwner = elgg_extract("resourceOwner", $vars);

$title = elgg_get_site_entity()->name;
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
        <?php if (ModPleio\Helpers::emailInWhitelist($resourceOwner["email"])): ?>
            <h2><?php echo elgg_echo("pleio:validate_access"); ?></h2>
        <?php else: ?>
            <h2><?php echo elgg_echo("pleio:access_requested"); ?></h2>
        <?php endif; ?>

        <?php if (ModPleio\Helpers::emailInWhitelist($resourceOwner["email"])): ?>
            <p><?php echo elgg_echo("pleio:access_requested:check_email"); ?></p>
        <?php else: ?>
            <p><?php echo elgg_echo("pleio:access_requested:wait_for_approval"); ?></p>
        <?php endif; ?>
        <?php echo elgg_view("output/url", ["class" => "elgg-button elgg-button-submit", "href" => $CONFIG->pleio->url . "action/logout", "text" => elgg_echo("logout")]); ?>
    </div>
</div>
