<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
*/

$site_url = elgg_get_site_url();

?>

<div id="container">
  <div id="topnav">
    <div class="active-links">
      <div id="session">
        <?php if (get_context() != 'login'){ ?>
        <strong><a href="<?php echo $site_url; ?>login"><?php echo elgg_echo('login'); ?></a></strong>
        &nbsp;|&nbsp;
        <strong><a href="<?php echo $site_url; ?>register">  <?php echo elgg_echo('register'); ?></a></strong>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
